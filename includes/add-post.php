<?php

date_default_timezone_set("Africa/Cairo");

session_start();

if (isset($_SESSION['ID']) &&
	isset($_POST['submit'])) {
	
	require 'db.inc.php';
	
	$ID = $_SESSION['ID'];
	$potext = htmlspecialchars($_POST['new-post']);
	$nowTime = date("Y-m-d h:i:s");
	
	if (empty($potext)) {
		
		// empty post text.
		header("Location: ../index.php?add-post=empty_post_text");
		exit();
	} else {
		
		// create the post.
		$sql = "Insert Into posts (uID, poimg, potext, potime)
				Values ($ID, NULL, '$potext', '$nowTime')";
		
		if ($conn->query($sql) === false) {
			
			// post not created.
			header("Location: ../index.php?add-post=post_not_created");
			exit();
		} else {
			
			// post created.
			header("Location: ../index.php?add-post=post_created");
			exit();
		}
	}
} else {
	
	if (! isset($_SESSION['ID'])) {
		session_unset();
		session_destroy();
	}
	
	header("Location: ../index.php");
	exit();
}

?>