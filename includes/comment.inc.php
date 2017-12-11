<?php

function addComment ($uID, $coID,
	$prof_img, $fname, $lname,
	$cotime, $cotext) {
	
	echo "
<div class='post-comment'>
	<div class='post-comment-user-info'>
		<div class='post-comment-user-info-img'>
			<img src='prof_imgs/$prof_img' />
		</div>
		<div class='post-comment-user-info-name'>
			<h3>
				<a href='profile.php?id=$uID'>$fname $lname</a><span>at $cotime</span>
			</h3>
		</div>
	</div>
	<div class='post-comment-content'>
		<p>$cotext</p>
	</div>
</div>";
}

?>
