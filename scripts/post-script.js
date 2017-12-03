function showHidePostComments (ele , postID) {
	var commentDiv = document.getElementById("post-id-" + postID);
	if (commentDiv.style.display == "block") {
		commentDiv.style.display = "none";
		ele.innerHTML = "show comments";
	} else {
		commentDiv.style.display = "block";
		ele.innerHTML = "hide comments";
	}
}