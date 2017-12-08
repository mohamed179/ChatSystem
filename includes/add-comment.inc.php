<?php

date_default_timezone_set("Africa/Cairo");

session_start();

if (isset($_SESSION['ID']) && isset($_POST['submit'])) {
	
	require 'db.inc.php';
	
	$ID      = htmlspecialchars($_SESSION['ID']);
	$poID    = htmlspecialchars($_POST['poID']);
	$comment = htmlspecialchars($_POST['comment']);
	
	// validating ID...
	if (! preg_match("/^[1-9][0-9]*$/", $ID)) {
		
		// invalid ID.
		header("Location: ../index.php?comment=unvalidID:$ID");
		exit();
	}
	
	// validating poID...
	if (! preg_match("/^[1-9][0-9]*$/", $poID)) {
		
		// invalid poID.
		header("Location: ../index.php?comment=unvalidPoID:$poID");
		exit();
	}
	
	// validate comment...
	if (empty($comment)) {
		header("Location: ../index.php?comment=emptyComment");
		exit();
	}
	
	// sanitize comment...
	$comment = preg_replace("/^[\r\n]$/", "<br>", $comment);
	
	$sql = "Select uID From posts Where poID=$poID";
	$posts = $conn->query($sql);
	
	if ($posts->num_rows == 1) {
		
		$row = $posts->fetch_assoc();
		
		$ID2 = $row['uID'];
		$nowTime = date("Y-m-d h:i:s");
		
		$sql = "Select * From friends
				Where (uID1=$ID And uID2=$ID2)
				Or (uID1=$ID2 And uID2=$ID)";
		$results = $conn->query($sql);
		
		if ($results->num_rows == 1 || $ID == $ID2) {
			$sql = "Insert Into comments (poID, uID, cotext, cotime)
					Values ($poID, $ID, '$comment', '$nowTime')";
			
			if($conn->query($sql) === true) {
				header("Location: ../profile.php?id=$ID2&comment=added_at_$nowTime");
				exit();
			} else {
				header("Location: ../profile.php?id=$ID2&comment=not-added");
				exit();
			}
		} else {
			header("Location: ../profile.php?id=$ID2");
			exit();
		}
	} else {
		header("Location: ../index.php");
		exit();
	}
} else {
	
	if (! isset($_SESSION['ID'])) {
		session_unset();
		session_destroy();
	}
	
	header("Location: ../index.php");
	exit();
}