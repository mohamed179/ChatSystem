<?php

date_default_timezone_set("Africa/Cairo");

session_start();

if (isset($_SESSION['ID'])) {
	
	require 'db.inc.php';
	
	$ID = $_SESSION['ID'];
	
	if (isset($_POST['getMsgs'])) {
		
		// code for getting unseen message...
		
		$last_update = $_POST['last_update'];
		
		$sql = "Select * From chats
				Where uID2 = $ID And stat = 'unseen'";
		$results = $conn->query($sql);
		
		if ($results->num_rows > 0) {
			
			echo "<messages>";
			
			while ($row = $results->fetch_assoc()) {
				
				$cID  = $row['cID'];
				$uID1 = $row['uID1'];
				$uID2 = $row['uID2'];
				$text = $row['msg'];
				echo "
				<message><uID1>$uID1</uID1><uID2>$uID2</uID2><text>$text</text></message>
				";
				
				// setting the messages seen...
				$sql = "Update chats
						Set stat = 'seen'
						Where cID = $cID";
				$conn->query($sql);
			}
			
			echo "</messages>";
		}
		
	} else if (isset($_POST['sendMsg'])) {
		
		// code for adding new message to the database...
		
		$ID2 = htmlspecialchars($_POST['ID2']);
		$msg = htmlspecialchars($_POST['msg']);
		$nowTime = date("Y-m-d H:i:s");
		
		// validating ID2 and message...
		if (preg_match("/^[1-9][0-9]*$/", $ID2) &&
			$ID != $ID2 && empty($msg) == false) {
		
			// valid ID2 and message...
			
			$sql = "Select * From friends
					Where (uID1=$ID And uID2=$ID2)
					Or (uID1=$ID2 And uID2=$ID)";
			$results = $conn->query($sql);

			if ($results->num_rows == 1) {
				$sql = "Insert Into chats (uID1, uID2, msg, ctime)
						Values ($ID, $ID2, '$msg', '$nowTime')";

				if($conn->query($sql) === true) {
					echo "sent";
				} else {
					echo "not sent";
				}
			} else {
				echo "not frineds";
			}
		} else {
			echo "not valid ID2 or msg";
		}
	}
} else {
	session_unset();
	session_destroy();
}

?>