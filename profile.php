<?php include 'header.php'; ?>

<link rel="stylesheet" href="styles/profile-style.css"/>
<link rel="stylesheet" href="styles/post-style.css"/>
<link rel="stylesheet" href="styles/comment-style.css"/>
<link rel="stylesheet" href="styles/user-style.css"/>
<section id="container">
	<div id="prof-info">
		<div id="prof-img" onmouseover="showUploadNewProfile();" onmouseleave="hideUploadNewProfile();">
			<img src="prof_imgs/default-male.png" alt="Mohamed Kamal"/>
			<div id="prof-img-upload">
				<div><span>upload new image</span></div>
			</div>
		</div>
		
		<div id="prof-info-info">
			<div id="prof-name"><h1>Mohamed Kamal</h1></div>
			<div id="prof-action">
				<form action="includes/friend-action.inc.php" method="POST" target="_self">
					<button type="submit" name="submit" value="add-friend">
						<span class=""></span>Add Friend
					</button>
					<button type="submit" name="submit" value="follow">
						<span class="fa fa-check"></span> Followed
					</button>
					<button type="submit" name="submit" value="block">
						<span class=""></span>Block
					</button>
				</form>
			</div>
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
				<?php include 'includes/post.inc.php'; ?>
			</div>
			
			<div id="prof-friends" class="prof-content">
				<div class="friend"><?php include 'includes/user.inc.php'; ?></div>
				<div class="friend"><?php include 'includes/user.inc.php'; ?></div>
				<div class="friend"><?php include 'includes/user.inc.php'; ?></div>
				<div class="friend"><?php include 'includes/user.inc.php'; ?></div>
				<div class="friend"><?php include 'includes/user.inc.php'; ?></div>
			</div>
			
			<div id="prof-about" class="prof-content">
				<div class="prof-about-content">
					<h3>Personal</h3>
					<ul>
						<li>name: <span>Mohamed Kamal</span></li>
						<li>Date of birth: <span>1994/05/19</span></li>
						<li>Gender: <span>Male</span></li>
					</ul>
				</div>
				
				<div class="prof-about-content">
					<h3>Contact</h3>
					<ul>
						<li>E-mail: <span>mohamed77zaki@gmail.com</span></li>
						<li>Phone: <span>+201208315908</span></li>
					</ul>
				</div>
				
				<div class="prof-about-content">
					<h3>account</h3>
					<ul>
						<li>username: <span>admin123</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="scripts/profile-script.js"></script>
<script src="scripts/post-script.js"></script>

<?php include 'footer.php'; ?>
