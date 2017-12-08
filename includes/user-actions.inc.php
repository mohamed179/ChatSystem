<?php

date_default_timezone_set("Africa/Cairo");

session_start();

if (isset($_SESSION['ID']) &&
	isset($_POST['submit'])) {
	
	require 'db.inc.php';
	
	$ID1     = htmlspecialchars($_SESSION['ID']);
	$ID2     = htmlspecialchars($_POST['ID2']);
	$action  = htmlspecialchars($_POST['submit']);
	$nowTime = date("Y/m/d h:i:s");
	
	// validating ID2...
	if (empty($ID2)) {
		
		// empty ID2.
		header("Location: ../index.php?user-action=emptyID2");
		exit();
	} else if (! preg_match("/^[1-9][0-9]*$/", $ID2)) {
		
		// invalid ID2.
		header("Location: ../index.php?user-action=invalidID2");
		exit();
	} else {
		$sql = "Select * From users Where ID=$ID2";
		$results = $conn->query($sql);
		if ($results->num_rows == 0) {
			
			// ID2 not found in the db.
			header("Location: ../index.php?user-action=ID2_not_found:$ID2");
			exit();
		}
	}
	
	if ($ID1 == $ID2) {
		
		// same IDs: (invalid action)...
		header("Location: ../index.php?user-action=sameIDs");
		exit();
	} else if ($action == "add-friend") {
		
		// checking if they are friends or one of them send a friend
		// request before...
		
		$sql1 = "Select * From friends Where
				 (uID1=$ID1 And uID2=$ID2)
				 Or (uID1=$ID2 And uID2=$ID1)";
		$results1 = $conn->query($sql1);
		
		$sql2 = "Select * From friend_requests Where
				 (uID1=$ID1 And uID2=$ID2)
				 Or (uID1=$ID2 And uID2=$ID1)";
		$results2 = $conn->query($sql2);
		
		if ($results1->num_rows == 1) {
			
			// they are already friends.
			header("Location: ../profile.php?id=$ID2&user-action=are_friends");
			exit();
		} else if ($results2->num_rows == 1) {
			
			// one of them send a frined request.
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_sent_before");
			exit();
		}
		
		// action: friend request from ID1 to ID2...
		
		$sql = "Insert Into friend_requests
				(uID1, uID2, stat, rqtime)
				Values
				($ID1, $ID2, 'wait', '$nowTime')";
		
		if($conn->query($sql) === true) {
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_sent");
			exit();
		} else {
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_not_sent");
			exit();
		}
	} else if ($action == "cancel-friend-request") {
		
		// checking if they are friends or
		// the friend request not sent before...
		
		$sql1 = "Select * From friends Where
				 (uID1=$ID1 And uID2=$ID2)
				 Or (uID1=$ID2 And uID2=$ID1)";
		$results1 = $conn->query($sql1);
		
		$sql2 = "Select * From friend_requests
				Where uID1=$ID1 And uID2=$ID2";
		$results2 = $conn->query($sql2);
		
		if ($results1->num_rows == 1) {
			
			// they are already friends.
			header("Location: ../profile.php?id=$ID2&user-action=are_friends");
			exit();
		} else if ($results2->num_rows == 0) {
			
			// friend request not sent before.
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_not_sent_before");
			exit();
		}
		
		// action: cancel friend request from ID1 to ID2...
		
		$sql = "Delete From friend_requests
				Where uID1=$ID1 And uID2=$ID2";
		
		if($conn->query($sql) === true) {
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_canceled");
			exit();
		} else {
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_not_canceled");
			exit();
		}
	} else if ($action == "accept-friend-request") {
		
		// checking if they are friends or
		// the friend request not received...
		
		$sql1 = "Select * From friends Where
				 (uID1=$ID1 And uID2=$ID2)
				 Or (uID1=$ID2 And uID2=$ID1)";
		$results1 = $conn->query($sql1);
		
		$sql2 = "Select * From friend_requests Where
				 (uID1=$ID2 And uID2=$ID1)";
		$results2 = $conn->query($sql2);
		
		if ($results1->num_rows == 1) {
			
			// they are already friends.
			header("Location: ../profile.php?id=$ID2&user-action=are_friends");
			exit();
		} else if ($results2->num_rows == 0) {
			
			// friend request not received.
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_not_received");
			exit();
		}
		
		// action: accept friend request received from ID2...
		
		$sql1 = "Delete From friend_requests
				 Where uID1=$ID2 And uID2=$ID1";
		
		$sql2 = "Insert Into friends (uID1, uID2, ftime)
				 Values ($ID2, $ID1, '$nowTime')";
		
		if($conn->query($sql1) === true) {
			if($conn->query($sql2) === true) {
				header("Location: ../profile.php?id=$ID2&user-action=friend_request_accepted");
				exit();
			} else {
				$row = $results2->fetch_assoc();
				$sql = "Insert Into friend_requests
						(uID1, uID2, stat, rqtime)
						Values
						(" . $row['uID1'] . ", " .
							 $row['uID2'] . ", 'wait', '" .
							 $row['frtime'] . "')";
				$conn->query($sql);
				header("Location: ../profile.php?id=$ID2&user-action=friend_request_not_accepted:P");
				exit();
			}
		} else {
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_not_accepted");
			exit();
		}
	} else if ($action == "refuse-friend-request") {
		
		// checking if they are friends or
		// the friend request not received...
		
		$sql1 = "Select * From friends Where
				 (uID1=$ID1 And uID2=$ID2)
				 Or (uID1=$ID2 And uID2=$ID1)";
		$results1 = $conn->query($sql1);
		
		$sql2 = "Select * From friend_requests Where
				 uID1=$ID2 And uID2=$ID1";
		$results2 = $conn->query($sql2);
		
		if ($results1->num_rows == 1) {
			
			// they are already friends.
			header("Location: ../profile.php?id=$ID2&user-action=are_friends");
			exit();
		} else if ($results2->num_rows == 0) {
			
			// friend request not received.
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_not_received");
			exit();
		}
		
		// action: refuse friend request received from ID2...
		
		$sql = "Delete From friend_requests Where
				uID1=$ID2 And uID2=$ID1";
		
		if($conn->query($sql) === true) {
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_refused");
			exit();
		} else {
			header("Location: ../profile.php?id=$ID2&user-action=friend_request_not_refused");
			exit();
		}
	} else if ($action == "remove-friend") {
		
		// checking if they are not friends...
		
		$sql = "Select * From friends Where
				(uID1=$ID1 And uID2=$ID2)
				Or (uID1=$ID2 And uID2=$ID1)";
		$results = $conn->query($sql);
		
		if ($results->num_rows == 0) {
			
			// they are not friends.
			header("Location: ../profile.php?id=$ID2&user-action=are_friends");
			exit();
		}
		
		// action: remove friendship between ID1 and ID2...
		
		$sql = "Delete From friends Where
				(uID1=$ID1 And uID2=$ID2)
				Or (uID1=$ID2 And uID2=$ID1)";
		
		if($conn->query($sql) === true) {
			header("Location: ../profile.php?id=$ID2&user-action=friend_removed");
			exit();
		} else {
			header("Location: ../profile.php?id=$ID2&user-action=friend_not_removed");
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