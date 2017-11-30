function showChatSidebar (ele) {
	document.getElementById('chat-aside').style.display = "block";
	document.getElementById('msg-head-name').innerHTML = ele.innerHTML;
	document.getElementById('msg-head-name').href = 
		"profile.php?id=" + ele.name.substr(1);
	
	var chat_lists = document.getElementsByClassName('msg-list');
	for (i = 0; i < chat_lists.length; i++) {
		chat_lists[i].className = "msg-list scrollable hidden-chat-list";
	}
	
	document.getElementById(ele.name).className = "msg-list scrollable";
}