var currentTab = 0;
showTab(currentTab);
nxtPrev(0);

function showTab () {
	var tabs = document.getElementsByClassName("tab");
	for (i = 0; i < tabs.length; i++) {
		if (i == currentTab)
			tabs[i].style.display = "block";
		else
			tabs[i].style.display = "none";
	}
}

function checkInputs () {
	var tabs = document.getElementsByClassName("tab");
	var inputs = tabs[currentTab].getElementsByTagName("input");
	var check = true;
	for (i = 0; i < inputs.length; i++) {
		if (inputs[i].value == "" && inputs[i].name != "phone") {
			inputs[i].className = "invalid"
			check = false;
		}
	}
	return check;
}

function validatePass () {
	var tabs = document.getElementsByClassName("tab");
	var inputs = tabs[currentTab].getElementsByTagName("input");
	var pass = inputs[1].value;
	var repass = inputs[2].value;
	if (pass != repass) {
		inputs[2].className = "invalid";
		return false;
	} else {
		return true;
	}
}

function validatefrom () {
	return (checkInputs() && validatePass());
}

function nxtPrev ($x) {
	if ($x <= 0 || ($x == 1 && checkInputs())) {
		currentTab += $x;
		showTab(currentTab);
		if (currentTab == 0) {
			document.getElementById("nxtBtn").style.display = "block";
			document.getElementById("prevBtn").style.display = "none";
			document.getElementById("submitBtn").style.display = "none";
		}
		else if (currentTab == 1) {
			document.getElementById("nxtBtn").style.display = "block";
			document.getElementById("prevBtn").style.display = "block";
			document.getElementById("submitBtn").style.display = "none";
		} else {
			document.getElementById("nxtBtn").style.display = "none";
			document.getElementById("prevBtn").style.display = "block";
			document.getElementById("submitBtn").style.display = "block";
		}
	}
	
	if ($x == -1) {
		var tabs = document.getElementsByClassName("tab");
		var inputs = tabs[currentTab + 1].getElementsByTagName("input");
		var check = true;
		for (i = 0; i < inputs.length; i++) {
			inputs[i].className = "";
		}
	}
}