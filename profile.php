<?php 

session_start();

if (isset($_SESSION['ID'])) {
	
	require 'includes/post.inc.php';
	require 'includes/db-function.inc.php';
	require 'includes/db.inc.php';
	require 'includes/user.inc.php';
	
	$ID =    $_SESSION['ID'];
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	$dob =   $_SESSION['dob'];
	$gdr =   $_SESSION['gdr'];
	$email = $_SESSION['email'];
	$phone = $_SESSION['phone'];
	$uname = $_SESSION['uname'];
	
	$ID2 = $prof_img = "";
	
	$is_self = true; // to check if that profile belong to the loged in user or not
	
	if ((isset($_GET['id']) && ! empty($_GET['id'])) ||
	    (isset($_GET['ID']) && ! empty($_GET['ID']))) {
		
		if (isset($_GET['id'])) {
			$ID2 = $_GET['id'];
		} else {
			$ID2 = $_GET['ID'];
		}
		
		if ($ID2 != $ID) {
		
			$is_self = false;

			$sql = "Select * From users Where ID = $ID2";

			$results = $conn->query($sql);
			if ($results->num_rows == 1) {

				$row = $results->fetch_assoc();

				$fname = $row['fname'];
				$lname = $row['lname'];
				$dob =   $row['dob'];
				$gdr =   $row['gdr'];
				$email = $row['email'];
				$phone = $row['phone'];
				$uname = $row['uname'];
			} else {
				header("Location: index.php");
				exit();
			}
		}
	}
	
	if ($is_self) {
		$prof_img = get_prof_img($ID);
	} else {
		$prof_img = get_prof_img($ID2);
	}
	
} else {
	session_unset();
	session_destroy();
	header("Location: login.php");
	exit();
}

?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="styles/profile-style.css"/>
<link rel="stylesheet" href="styles/post-style.css"/>
<link rel="stylesheet" href="styles/comment-style.css"/>
<link rel="stylesheet" href="styles/user-style.css"/>
<section id="container">
	<div id="prof-info">
		<div id="prof-img" onmouseover="showUploadNewProfile();" onmouseleave="hideUploadNewProfile();">
			
			<?php echo "<img src='prof_imgs/$prof_img' alt='$fname $lname'/>"; ?>
			
			<div id="prof-img-upload">
				<div><span>upload new image</span></div>
			</div>
		</div>
		
		<div id="prof-info-info">
			<div id="prof-name">
				
				<?php echo"<h1>$fname $lname</h1>"; ?>
				
			</div>
			
			<?php
			
			if (! $is_self) {
				
				echo '<div id="prof-action">
					<form action="includes/user-actions.inc.php" method="POST" target="_self">';
				
				$sql1 = "Select * From friends
						Where (uID1=$ID And uID2=$ID2)
						Or (uID1=$ID2 And uID2=$ID)";
				
				$results1 = $conn->query($sql1);
				
				$sql2 = "Select * From friend_requests
						Where (uID1=$ID And uID2=$ID2)";
				
				$results2 = $conn->query($sql2);
				
				$sql3 = "Select * From friend_requests
						Where (uID1=$ID2 And uID2=$ID)";
				
				$results3 = $conn->query($sql3);
				
				if ($results1->num_rows == 1) {
					
					echo '<button type="submit" name="submit" value="remove-friend">
						<span class="fa fa-check"></span> Friend
					</button>';
				} else if ($results2->num_rows == 1) {
					
					echo '<button type="submit" name="submit" value="cancel-friend-request">
						Cancel Friend request
					</button>';
				} else if ($results3->num_rows == 1) {
					
					echo '<button type="submit" name="submit" value="accept-friend-request">
						Accept friend request
					</button>';
					
					echo '<button type="submit" name="submit" value="refuse-friend-request">
						Refuse friend request
					</button>';
				} else {
					echo '<button type="submit" name="submit" value="add-friend">
						Add Friend
					</button>';
				}
				
				echo "<button type='submit' name='submit' value='follow'>
						<span class='fa fa-check'></span> Followed
					</button>
					<button type='submit' name='submit' value='block'>
						Block
					</button>
					<input type='text' name='ID2' value='$ID2' style='display:none;'/>
				</form>
			</div>";
				
			}
			
			?>
					
					
		</div>
	</div>
	
	<div id="prof-content-container">
		<div id="prof-nav">
			<ul id="prof-nav-menu">
				<li><a class="selected-tab" name="prof-posts" onclick="selectTab(this)">Posts</a></li>
				<li><a name="prof-friends" onclick="selectTab(this)">Friends</a></li>
				<li><a name="prof-about" onclick="selectTab(this)">About</a></li>
			</ul>
		</div>

		<div id="prof-content-wrapper">
			<div id="prof-posts" class="prof-content">
				<?php
				
				//loading posts here...
				
				if (empty($ID2)) {
					$ID2 = $ID;
				}
				
				$sql = "Select * From posts Where uID=$ID2";
				
				$posts = $conn->query($sql);
				
				if ($posts->num_rows > 0) {
					
					while ($row = $posts->fetch_assoc()) {
						
						$poID   = $row['poID'];
						$poimg  = $row['poimg'];
						$potext = $row['potext'];
						$potime = $row['potime'];
						
						$sql = "Select * From likes Where poID=$poID";
						$likes = $conn->query($sql);
						
						$sql = "Select * From shares Where poID1=$poID";
						$shares = $conn->query($sql);
						
						$sql = "Select * From comments Where poID=$poID";
						$comments = $conn->query($sql);
						
						addPost($ID, $poID,
							$prof_img, $fname, $lname,
							$potime, $potext, $poimg,
							get_is_liked($ID, $poID),
							get_is_shared($ID, $poID),
							get_is_friend($ID, $ID2) ||
								$ID == $ID2,
							$likes, $shares, $comments
						);
					}
				} else {
					echo "<p>No posts yet!</p>";
				}
				
				?>
			</div>
			
			<div id="prof-friends" class="prof-content">
				<?php
				
				// loading friends here...
				
				$sql = "Select * From users Where ID
						In (Select uID1 as ID From friends Where uID2=$ID2)
						Or ID In (Select uID2 as ID From friends Where uID1=$ID2);";
				$results = $conn->query($sql);
				
				if ($results->num_rows > 0) {
					
					while ($row = $results->fetch_assoc()) {
						
						$ID3       = $row['ID'];
						$fname3    = $row['fname'];
						$lname3    = $row['lname'];
						$prof_img3 = get_prof_img($ID3);
						
						$status = "";
						
						$sql1 = "Select * From friends
								Where (uID1=$ID And uID2=$ID3)
								Or (uID1=$ID3 And uID2=$ID)";

						$results1 = $conn->query($sql1);

						$sql2 = "Select * From friend_requests
								Where (uID1=$ID And uID2=$ID3)";

						$results2 = $conn->query($sql2);
						
						$sql3 = "Select * From friend_requests
								Where (uID1=$ID3 And uID2=$ID)";

						$results3 = $conn->query($sql3);

						if ($results1->num_rows == 1) {
							$status = "friends";
						} else if ($results2->num_rows == 1) {
							$status = "friend-request-sent";
						} else if ($results3->num_rows == 1) {
							$status = "get-friend-request";
						} else {
							$status = "none";
						}
						
						echo '<div class="friend">';
						
						if ($ID == $ID3) {
							addUser ($ID3, $prof_img3, $fname3, $lname3, $status, true);
						} else {
							addUser ($ID3, $prof_img3, $fname3, $lname3, $status, false);
						}
						
						echo '</div>';
					}
				} else {
					echo "<p>No friends yet!</p>";
				}
				
				?>
				
				<?php
				
				echo "
			</div>
			
			<div id='prof-about' class='prof-content'>
				<div class='prof-about-content'>
					<h3>Personal</h3>
					<ul>
						<li>name: <span>$fname $lname</span></li>
						<li>Date of birth: <span>$dob</span></li>
						<li>Gender: <span>$gdr</span></li>
					</ul>
				</div>
				
				<div class='prof-about-content'>
					<h3>Contact</h3>
					<ul>
						<li>E-mail: <span>$email</span></li>
						<li>Phone: <span>$phone</span></li>
					</ul>
				</div>
				
				<div class='prof-about-content'>
					<h3>account</h3>
					<ul>
						<li>username: <span>$uname</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<script src='scripts/profile-script.js'></script>
<script src='scripts/post-script.js'></script>";
?>

<?php include 'footer.php'; ?>
