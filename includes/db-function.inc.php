<?php

function get_is_liked ($uID, $poID) {
	
	require 'includes/db.inc.php';
	
	$sql = "Select * From likes
			Where uID=$uID And poID=$poID";
	
	$results = $conn->query($sql);
	
	if ($results->num_rows == 1) {
		
		return true;
	} else {
		return false;
	}
}

function get_is_shared ($uID, $poID) {
	
	require 'includes/db.inc.php';
	
	$sql = "Select * From shares
			Where uID=$uID And poID1=$poID";
	
	$results = $conn->query($sql);
	
	if ($results->num_rows == 1) {
		
		return true;
	} else {
		return false;
	}
}

function get_prof_img ($uID) {
	
	require 'includes/db.inc.php';
	
	$sql = "Select prof_imgs.img As img
			From curr_prof_img Inner Join prof_imgs
			On curr_prof_img.piID = prof_imgs.piID
			And curr_prof_img.uID = prof_imgs.uID
			Where prof_imgs.uID = $uID";
	
	$results = $conn->query($sql);
	
	if ($results->num_rows == 1) {
		
		$row = $results->fetch_assoc();
		return $row['img'];
	} else {
		$sql = "Select gdr From users Where ID=$uID";
		
		$results = $conn->query($sql);
		if ($results->num_rows == 1) {
			
			$row = $results->fetch_assoc();
			if ($row['gdr'] == 'Male') {
				return 'default-male.png';
			} else {
				return 'default-female.png';
			}
		} else {
			return null;
		}
	}
}

function get_is_friend ($ID1, $ID2) {
	
	require 'includes/db.inc.php';
	
	$sql = "Select * From friends Where
			(uID1=$ID1 And uID2=$ID2)
			Or (uID1=$ID2 And uID2=$ID1)";
	
	$results = $conn->query($sql);
	
	if ($results->num_rows == 1) {
		return true;
	} else {
		return false;
	}
}

?>