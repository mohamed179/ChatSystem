function showHidePostComments (ele , postID) {
	var commentDiv = document.getElementById("post-id-" + postID + "-comments");
	if (commentDiv.style.display == "block") {
		commentDiv.style.display = "none";
		ele.innerHTML = "show comments";
	} else {
		commentDiv.style.display = "block";
		ele.innerHTML = "hide comments";
	}
}

function foucsAddComment (postID) {
	var addCommentDiv = document.getElementById("add-comment-to-post-id-" + postID);
	var form = addCommentDiv.getElementsByTagName("form")[0];
	var comment = form.getElementsByClassName("comment")[0];
	comment.focus();
}