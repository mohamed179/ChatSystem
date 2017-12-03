function showUploadNewProfile () {
	document.getElementById('prof-img-upload').style.display = "block";
}

function hideUploadNewProfile () {
	document.getElementById('prof-img-upload').style.display = "none";
}

function selectTab (ele) {
	var menu = document.getElementById("prof-nav-menu");
	var list = menu.getElementsByTagName("li");
	for (i = 0; i < list.length; i++) {
		var tagHead = list[i].getElementsByTagName("a")[0];
		document.getElementById(tagHead.name).style.display = "none";
		tagHead.className = "";
	}
	ele.className = "selected-tab";
	document.getElementById(ele.name).style.display = "block";
}