<?php

date_default_timezone_set("Africa/Cairo");

session_start();

if (isset($_SESSION['ID']) &&
	isset($_GET['action']) &&
    isset($_GET['poID'])) {
	
	require 'db.inc.php';
	
	$ID = $_SESSION['ID'];
	$nowTime = date("Y-m-d h:i:s");
	
	$action = htmlspecialchars($_GET['action']);
	$poID   = htmlspecialchars($_GET['poID']);
	
	$ID2 = "";
	
	// validating action...
	if (empty($action)) {
		header("Location: ../index.php?post-action=empty_action");
		exit();
	}
	
	// validating poID
	if (empty($poID)) {
		header("Location: ../index.php?post-action=empty_poID");
		exit();
	} else if (! preg_match("/^[1-9][0-9]*$/", $poID)) {
		header("Location: ../index.php?post-action=invalid_poID");
		exit();
	}
	
	// checking if the post exists...
	$sql = "Select * From posts Where poID=$poID";
	
	$result = $conn->query($sql);
	
	if ($result->num_rows == 0) {
		
		// poID not found.
		header("Location: ../index.php?post-action=poID_not_found");
		exit();
	} else {
		
		// getting ID2...
		$sql = "Select uID From posts Where poID=$poID";
		$results = $conn->query($sql);
		$row = $results->fetch_assoc();
		$ID2 = $row['uID'];
	}
	
	if ($action == "like") {
		
		// checking if the post is liked before...
		$sql = "Select * From likes
				Where poID=$poID And uID=$ID";
		$results = $conn->query($sql);
		
		if($results->num_rows == 1) {
			
			// post is liked before.
			header("Location: ../profile.php?id=$ID2&post-action=post_liked_before");
			exit();
		} else {
			
			// like the post.
			$sql = "Insert Into likes (poID, uID, ltime)
					Values ($poID, $ID, '$nowTime')";
			
			if ($conn->query($sql) === false) {
			
				// post is not liked.
				header("Location: ../profile.php?id=$ID2&post-action=post_not_liked");
				exit();
			} else {
			
				// post liked.
				header("Location: ../profile.php?id=$ID2&post-action=post_liked");
				exit();
			}
		}
	} else if ($action == "dislike") {
		
		// trying removing like...
		$sql = "Delete From likes Where
				poID=$poID And uID=$ID";
		
		if ($conn->query($sql) === false) {
			
			// post not liked before.
			header("Location: ../profile.php?id=$ID2&post-action=post_not_liked_before");
			exit();
		} else {
			
			// post disliked.
			header("Location: ../profile.php?id=$ID2&post-action=post_disliked");
			exit();
		}
	} else if ($action == "share") {
		
		// checking if ID and ID2 users are friend...
		$sql = "Select * From friends Where
				(uID1=$ID And uID2=$ID2)
				Or (uID1=$ID2 And uID2=$ID)";
		$results = $conn->query($sql);
		
		if ($results->num_rows == 1 ||
		   $ID == $ID2) {
			
			// share the post.
			$sql = "Select * From posts Where poID=$poID";
			$results = $conn->query($sql);
			$row = $results->fetch_assoc();
			
			$sql = "Insert Into posts (uID, poimg, potext, potime) Values
					($ID, ";
			if($row['poimg'] === NULL) {
				$sql = $sql . "NULL, ";
			} else {
				$sql = $sql . "'" . $row['poimg'] . "', ";
			}
			
			$sql = $sql . "'" . $row['potext'] . "', '$nowTime')";
			
			if ($conn->query($sql) === false) {
				
				// post not shared.
				header("Location: ../profile.php?id=$ID2&post-action=post_not_shared");
				exit();
			} else {
				
				// post shared.
				header("Location: ../profile.php?id=$ID2&post-action=post_shared");
				exit();
			}
		} else {
			
			// they are  not friends.
			header("Location: ../profile.php?id=$ID2&post-action=not_friends");
			exit();
		}
	} else {
		header("Location: ../index.php?post-action=invalid_action");
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

?>