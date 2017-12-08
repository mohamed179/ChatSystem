<?php

require 'comment.inc.php';

function addPost ($ID, $poID,
	$prof_img, $fname, $lname,
	$potime, $potext, $poimg,
	$is_liked, $is_shared, $is_friend,
	$likes, $shares, $comments) {
	
	echo "
<div id='post-id-$poID' class='post'>
	<div class='post-head'>
		<img src='prof_imgs/$prof_img' />
		<h3><a href='profile.php?id=1'>$fname $lname</a><span>at $potime</span></h3>
	</div>
	<div class='post-content'>
		<div class='post-content-text'>
			<p>$potext</p>
		</div>";
	
	if ($poimg !== NULL) {
		
		echo "
		<div class='post-content-img'>
			<img src='post_imgs/$poimg'/>
		</div>";
	}
	
	echo "
	</div>
	<div class='post-action'>
		<ul>
			<li>";
	
	if ($is_liked) {
		echo "
				<a class='post-action-item' target='_self'
				   href='includes/post-actions.php?action=dislike&poID=$poID'>
					<span class='fa fa-check'></span> Liked";
	} else {
		echo "
				<a class='post-action-item' target='_self'
				   href='includes/post-actions.php?action=like&poID=$poID'>
					Like";
	}
	
	echo "
				</a>
			</li>
			<li>
				<a class='post-action-item' onclick='foucsAddComment($poID)'>
					<span class='commint-icon'></span>Comment
				</a>
			</li>
			<li>
				<a target='_self'
				   href='includes/post-actions.php?action=share&poID=$poID'>";
	
	if ($is_shared) {
		echo "
					<span class='fa fa-check'></span> Shared";
	} else {
		echo "
					Share";
	}
	
	echo "
				</a>
			</li>
		</ul>
	</div>
	<div class='post-meta'>
		<ul>
			<li>
				<a name='likes'>" . $likes->num_rows . " Likes</a>
			</li>
			<li>
				<a class='post-meta-item' name='shares'>" . $shares->num_rows . " shares</a>
			</li>
			<li>
				<a class='post-meta-item' name='comments'>" . $comments->num_rows . " comments</a>
			</li>
		</ul>
	</div>
	<div class='post-comments'>
		<div id='post-id-$poID-comments' class='post-comments-wrapper'>";
	
	// load comments here...
	require 'db.inc.php';
	while ($comment = $comments->fetch_assoc()) {
		
		$coID   = $comment['coID'];
		$uID    = $comment['uID'];
		$cotext = $comment['cotext'];
		$cotime = $comment['cotime'];
		
		$fname = $lname = "";
		$prof_img = get_prof_img($uID);
		
		$sql = "Select fname, lname From users Where ID=$uID";
		$users = $conn->query($sql);
		if ($users->num_rows == 1) {
			
			$row = $users->fetch_assoc();
			
			$fname = $row['fname'];
			$lname = $row['lname'];
		}
		addComment ($coID,
			$prof_img, $fname, $lname,
			$cotime, $cotext);
	}
	
	echo "
		</div>";
	
	if ($comments->num_rows > 0) {
		echo "
		<div class='show-hide-comments'><a onclick='showHidePostComments(this, $poID)'>show comments</a></div>";
	}
	
	echo "
	</div>";
	
	if ($is_friend) {
		
		echo "
		<div id='add-comment-to-post-id-$poID' class='post-add-comment'>
		<form action='includes/add-comment.inc.php' method='POST' target='_self'>
			<input name='poID' value='$poID' class='post-id'/>
			<input class='comment' name='comment' placeholder='Enter comment..' autocomplete='off'/>
			<button type='submit' name='submit'>comment</button>
		</form>
	</div>";
			
	}
	
	echo "
</div>";
}

?>