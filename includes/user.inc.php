<?php

function addUser ($uID,
	$prof_img, $fname,
	$lname, $status, $isMe) {
	
	echo "
<div class='user'>
	<div class='user-img'>
		<img src='prof_imgs/$prof_img' />
	</div>
	
	<div class='user-info'>
		<div class='user-info-name'><h3><a href='profile.php?id=$uID'>$fname $lname</a></h3></div>
		<div class='user-action'>
			<form action='includes/user-actions.inc.php' method='POST' target='_self'>";
	
	if (! $isMe) {
		if ($status === "friends") {
			echo '<button type="submit" name="submit" value="remove-friend">
						<span class="fa fa-check"></span> Friend
				  </button>';
		} else if ($status === "friend-request-sent") {
			echo '<button type="submit" name="submit" value="cancel-friend-request">
						Cancel friend request
				  </button>';
		} else if ($status === "get-friend-request") {
			echo '<button type="submit" name="submit" value="accept-friend-request">
						Accept Friend request
				  </button>';

			echo '<button type="submit" name="submit" value="refuse-friend-request">
						Refuse Friend request
				  </button>';
		} else {
			echo '<button type="submit" name="submit" value="add-friend">
						Add friend
				  </button>';
		}
		
	}
					
	echo "
				<input type='text' name='ID2' value='$uID' style='display:none;'/>
			</form>
		</div>
	</div>
</div>";
	
}

?>

