<?php include 'header.php'; ?>
<?php include 'aside.php'; ?>

<link rel="stylesheet" href="styles/profile-style.css"/>
<link rel="stylesheet" href="styles/post-style.css"/>
<link rel="stylesheet" href="styles/comment-style.css"/>
<link rel="stylesheet" href="styles/user-style.css"/>

<?php

session_start();

if (isset($_SESSION['ID'])) {
	
	require 'includes/post.inc.php';
	require 'includes/db-function.inc.php';
	require 'includes/db.inc.php';
	require 'includes/user.inc.php';
	
	$ID    = $_SESSION['ID'];
	$uname = $_SESSION['uname'];
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	$email = $_SESSION['email'];
	
	echo "
	<section id='main-container'>
		<div id='create-post'>
			<form action='includes/add-post.php'
				  method='POST' target='_self'>
				<label for='login'><b>Create Post:</b></label>
				<textarea type='text' name='new-post'
						  placeholder=\"What's up, $fname?\"></textarea>
				<button type='submit' name='submit'>Post</button>
			</form>
		</div>";
	
	echo "
		<div id='post-container'>";
	
	$sql = "Select * From posts Where
			uID In (Select uID1 As uID from friends Where uID2=$ID)
			Or uID In (Select uID2 As uID from friends Where uID1=$ID)
			Or uID=$ID
			Order By potime DESC";
	
	$posts = $conn->query($sql);
				
	if ($posts->num_rows > 0) {

		while ($row = $posts->fetch_assoc()) {

			$poID   = $row['poID'];
			$ID2    = $row['uID'];
			$poimg  = $row['poimg'];
			$potext = $row['potext'];
			$potime = $row['potime'];
			
			$sql = "Select fname, lname From users Where ID=$ID2";
			$user = $conn->query($sql);
			$row = $user->fetch_assoc();
			$fname2 = $row['fname'];
			$lname2 = $row['lname'];

			$sql = "Select * From likes Where poID=$poID";
			$likes = $conn->query($sql);

			$sql = "Select * From shares Where poID1=$poID";
			$shares = $conn->query($sql);

			$sql = "Select * From comments Where poID=$poID";
			$comments = $conn->query($sql);

			addPost($ID2, $poID,
				get_prof_img($ID2),
				$fname2, $lname2,
				$potime, $potext, $poimg,
				get_is_liked($ID, $poID),
				get_is_shared($ID, $poID),
				true, $likes, $shares, $comments
			);
		}
	} else {
		echo "<p>No posts yet!</p>";
	}
	
	echo "
		</div>
	</section>";
} else {
	session_unset();
	session_destroy();
}

?>

<script src='scripts/post-script.js'></script>

<?php include 'footer.php'; ?>