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

function formatDatetime (dt) {
	var datetime = dt.getFullYear()
    + '-' + (dt.getMonth() + 1)
    + '-' + dt.getDate()
	
	if (dt.getHours() < 10)
    	datetime += ' 0' + (dt.getHours());
	else
		datetime += ' ' + (dt.getHours());
	
	if (dt.getMinutes() < 10)
    	datetime += ':0' + (dt.getMinutes());
	else
		datetime += ':' + (dt.getMinutes());
	
	if (dt.getSeconds() < 10)
    	datetime += ':0' + (dt.getSeconds());
	else
		datetime += ':' + (dt.getSeconds());
	
	return datetime;
}

// for chat AJAX...

var ID = document.getElementById('user').name;
ID = ID.substr(1);

var chat = {
	
	createNewList : function (msgOwn, text) {
		var newList = "<div class='" + msgOwn + "'>" +
					"<li><a>" + text + "</a></li></div>";
		return newList;
	},
	
	addMsg : function (uID1, uID2, text) {
		var chatWdo = (uID1 == ID) ?
					document.getElementById('u' + uID2) :
					document.getElementById('u' + uID1);

		var lastMsgList = chatWdo.getElementsByTagName('div');
		if (lastMsgList.length > 0)
			lastMsgList = lastMsgList[lastMsgList.length - 1];
		else
			lastMsgList = null;

		var newList      = ""; // is used if new list must be inserted
		var newListItem  = ""; // is used if the last list must be used

		if(lastMsgList == null) {

			// no messages yet
			chatWdo.innerHTML = "";
			var msgOwn = (uID1 == ID) ? "my-msg" : "friend-msg";
			newList = chat.createNewList(msgOwn, text);

		} else if (lastMsgList.className == "my-msg") {

			// last message list is for the loged-in user
			if (uID1 == ID)
				newListItem = "<li><a>" + text + "</a></li>";
			else
				newList = chat.createNewList("friend-msg", text);

		} else {

			// last message list is for the loged-in user's friend
			if (uID1 == ID)
				newList = chat.createNewList("my-msg", text);
			else
				newListItem = "<li><a>" + text + "</a></li>";

		}

		if (newList != "")
			chatWdo.innerHTML += newList;
		else
			lastMsgList.innerHTML += newListItem;
	},

	sendMessage : function (ele, event) {
		
		if  (event.keyCode == 13)  {

			var msg = ele.value;
			ele.value = "";

			var ID2 = document.getElementsByClassName('msg-list scrollable');
			for (i = 0; i < ID2.length; i++) {
				if (ID2[i].className != "msg-list scrollable hidden-chat-list") {
					ID2 = ID2[i].id;
					break;
				}
			}
			ID2 = ID2.substr(1);

			if (msg != "\n") {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function () {
					if (this.readyState == 4 &&
						this.status == 200) {

						// checking if the message sent...
						if (xhttp.responseText == "sent") {
							chat.addMsg(ID, ID2, msg);
						}
					}
				};
				xhttp.open("POST", "includes/chat.inc.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("sendMsg=true&ID2=" + ID2 + "&msg=" + msg);
			}
		}
	},

	updateChat : function () {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState == 4 &&
				this.status == 200) {

				// adding the new messages...
				var domParser = new DOMParser();
				var xmlResponse = domParser.parseFromString(xhttp.responseText, "text/xml");
				var xmlMsgs = xmlResponse.getElementsByTagName('message');
				for (i = 0; i < xmlMsgs.length; i++) {

					var uID1 = xmlMsgs[i].childNodes[0].childNodes[0].nodeValue;
					var uID2 = xmlMsgs[i].childNodes[1].childNodes[0].nodeValue;
					var text = xmlMsgs[i].childNodes[2].childNodes[0].nodeValue;
					
					chat.addMsg(uID1, uID2, text);
				}
			}
		};
		
		xhttp.open("POST", "includes/chat.inc.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("getMsgs=true");
	}

};

chat.interval = setInterval(chat.updateChat, 5000);
