<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta name="charset" content="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="A good chat system"/>
	<base target="_blank"/>
	<title>Chat System</title>
	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/font-awesome-4.7.0/css/font-awesome.min.css">
	<script src="scripts/script.js"></script>
	<script src="scripts/jquery/jquery-3.2.1.min.js"></script>
	<script src="scripts/jquery/script.js"></script>
</head>
<body>
	<header id="main-header">
		<nav id="main-nav">
			<div id="main-wrapper">
				<div id="nav-menu">
					<ul>
						<li><a target="_self" href="index.php">Home</a></li>
						<li><a target="_self" href="profile.php">Profile</a></li>
					</ul>
				</div>
				<div id="nav-user">
					<?php
					
					session_start();
					
					if (isset($_SESSION["ID"])) {
						echo '<ul>
							  	<li><a target="_self" href="profile.php">' . $_SESSION['fname'] . '</a></li>
								<li><a target="_self" href="includes/logout.inc.php">Logout</a></li>
							  </ul>';
					} else {
						session_unset();
						session_destroy();
						echo '<ul>
							  	<li><a target="_self" href="login.php">Login</a></li>
								<li><a target="_self" href="signup.php">Signup</a></li>
							  </ul>';
					}
					
					?>
				</div>
				<div id="nav-search">
					<form>
						<input type="text" name="search" placeholder="Search.."/>
						<button type="submit">submit</button>
					</form>
				</div>
			</div>
		</nav>
	</header>