function validateform () {
	var login = document.getElementById("login");
	var forms = login.getElementsByTagName("form");
	var inputs = forms[0].getElementsByTagName("input");
	var check = true;
	for (i = 0; i < inputs.length; i++) {
		if (inputs[i].value == "") {
			inputs[i].className = "invalid";
			check = false;
		}
	}
	return check;
}
