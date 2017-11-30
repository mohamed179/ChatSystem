<?php

session_start();

if(isset($_SESSION['ID'])) {
	
	require 'includes/db.inc.php';
	
	// sidebar when a user loged in (chat)...
	
	$ID    = $_SESSION['ID'];
	$uname = $_SESSION['uname'];
	$fname = $_SESSION['fname'];
	$lname = $_SESSION['lname'];
	
	// code for loading friends of the user logedin from the db...
	
	echo '<link rel="stylesheet" href="styles/chat-aside-style.css" />
		  <aside id="main-aside">
			  <div id="friends-aside" class="scrollable unvisible-scrollbar">';
	
	
	$sql = "Select ID, fname, lname From users
			Where ID IN (
    			Select uID1 From friends Where uID2 = $ID)
			OR ID IN (
    			Select uID2 From friends Where uID1 = $ID)
			Order By fname, lname";
	
	$results = $conn->query($sql);
	if ($results->num_rows > 0) {
		
		echo '<ul class="friend-list">';
		while ($row = $results->fetch_assoc()) {
			
			$friend_ID    = $row['ID'];
			$friend_fname = $row['fname'];
			$friend_lname = $row['lname'];
			echo "<li><a name='u$friend_ID' onclick='showChatSidebar(this)'>
					  $friend_fname $friend_lname
				  </a></li>";
		}
		echo '</ul>';
	} else {
		echo '<p style="text-align: center;">No Friends</p>';
	}
	
	echo '</div>
			<div id="search-friend">
				<input type="text" name="find-user" placeholder="Search" />
			</div>
		</aside>';
	
	
	
	// code for loading chat lists of the user logedin from the db...
	
	echo '<aside id="chat-aside">
			<div id="toggle-chat">
				<span id="toggle-chat-icon" class="center-content fa fa-chevron-left"></span>
			</div>
			<div id="chat-wrapper">';
	
	$results->data_seek(0);
	
	if ($results->num_rows > 0) {
		
		echo '	<div id="msg-head"><span class="center-content"><a id="msg-head-name"></a></span></div>';
		
		while ($row = $results->fetch_assoc()) {
			
			$friend_ID    = $row['ID'];
			$friend_fname = $row['fname'];
			$friend_lname = $row['lname'];
			
			echo '	<div class="msg-list scrollable hidden-chat-list" id="u' . $friend_ID .'">';
			
			$sql = "Select uID1, uID2, msg From chats
					Where (uID1 = $ID And uID2 = $friend_ID) Or 
						  (uID1 = $friend_ID And uID2 = $ID)";
			
			$chat_results = $conn->query($sql);
			$lmu = 0; // last message user.
			if ($chat_results->num_rows > 0) {
				
				while ($chat = $chat_results->fetch_assoc()) {
					
					$uID1 = $chat['uID1'];
					$uID2 = $chat['uID2'];
					$msg  = $chat['msg'];
					
					if ($lmu != $uID1) {
						
						if ($lmu != 0) {
							echo '</div>';
						}
						
						if ($uID1 == $ID) {
							echo '<div class="my-msg">';
						} else {
							echo '<div class="friend-msg">';
						}
					}
					
					echo "<li><a>$msg</a></li>";
					$lmu = $uID1;
				}
			} else {
				echo '<p style="text-align: center">No chats yet!</p>';
			}
			
			if ($lmu != 0) {
				echo '	</div>';
			}
			echo '	</div>';
		}
	} else {
	}
				
	echo '	<div id="enter-msg">
				<textarea placeholder="Enter message"></textarea>
			</div>
		</div>
	</aside>
	<script src="scripts/chat-script.js"></script>
	<script src="scripts/jquery/chat-script.js"></script>';
} else {
	session_unset();
	session_destroy();
}

?>
