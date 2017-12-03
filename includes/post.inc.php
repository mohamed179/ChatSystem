<div class="post">
	<div class="post-head">
		<img src="prof_imgs/default-male.png" />
		<h3><a href="profile.php?id=1">Mohamed Kamal</a><span>at 2017/12/02 12:05AM</span></h3>
	</div>
	<div class="post-content">
		<div class="post-content-text">
			<p>Today I traveled to Paris.<br>
			   It's a great city :D</p>
		</div>
		<div class="post-content-img">
			<img src="post_imgs/1.jpg"/>
		</div>
	</div>
	<div class="post-action">
		<ul>
			<li><a class="post-action-item"><span class="like-icon"></span>Like</a></li>
			<li><a class="post-action-item"><span class="commint-icon"></span>Comment</a></li>
			<li><a><span class="sare-icon"></span>Share</a></li>
		</ul>
	</div>
	<div class="post-meta">
		<ul>
			<li><a name="likes">12 Likes</a></li>
			<li><a class="post-meta-item" name="shares">1 shares</a></li>
			<li><a class="post-meta-item" name="comments">2 comments</a></li>
		</ul>
	</div>
	<div class="post-comments">
		<div id="post-id-1" class="post-comments-wrapper">
			<?php include 'comment.inc.php'; ?>
			<?php include 'comment.inc.php'; ?>
		</div>
		<div class="show-hide-comments"><a onclick="showHidePostComments(this, 1)">show comments</a></div>
	</div>
	<div class="post-add-comment">
		<form action="includes/add-comment.inc.php" method="POST">
			<input name="post-id" value="1" class="post-id"/>
			<input name="comment" placeholder="Enter comment.."/>
			<button type="submit" name="submit">comment</button>
		</form>
	</div>
</div>