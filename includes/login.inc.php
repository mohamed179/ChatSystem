<?php

if (isset($_POST['submit'])) {
	
	require 'db.inc.php';
	
	$login = htmlspecialchars($_POST['login']);
	$pswd  = htmlspecialchars($_POST['pswd']);
	
	if (empty($login)) {
		// empty login.
		header("Location: ../login.php?signin=empty_login");
		exit();
	} else if (empty($pswd)) {
		// empty password.
		header("Location: ../login.php?signin=empty_pswd");
		exit();
	} else {
		
		// checking the login and password...
		$sql = "Select * From users Where
				uname = '$login' Or email = '$login' Or phone = '$login'";
		$result = $conn->query($sql);
		
		if (! $result->num_rows == 1) {
			header("Location: ../login.php?signin=wrong_login");
			exit();
		}
		
		$row = $result->fetch_assoc();
		$hashedPasswdCheck = password_verify($pswd, $row['pswd']);

		if ($hashedPasswdCheck === false) {
			header("Location: ../login.php?login=wrong_pswd");
			exit();
		} else if ($hashedPasswdCheck === true) {
			
			// Login the user...
			session_start();
			$_SESSION['uname'] = $row['uname'];
			$_SESSION['fname'] = $row['fname'];
			$_SESSION['lname'] = $row['lname'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['ID']    = $row['ID'];
			header("Location: ../index.php?login=success");
			exit();
		}
		
	}
		
	
} else {
	header("Location: ../index.php");
	exit();
}

?>
