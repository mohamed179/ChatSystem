<?php

session_start();
require 'db.inc.php';

if (isset($_POST['submit'])) {
	
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
			session_unset();
			session_destroy();
			header("Location: ../login.php?signin=wrong");
			exit();
		}
		
		$row = $result->fetch_assoc();
		$hashedPasswdCheck = password_verify($pswd, $row['pswd']);

		if ($hashedPasswdCheck === false) {
			session_unset();
			session_destroy();
			header("Location: ../login.php?login=wrong");
			exit();
		} else if ($hashedPasswdCheck === true) {
			
			// Login the user...
			$_SESSION['uname'] = $row['uname'];
			$_SESSION['fname'] = $row['fname'];
			$_SESSION['lname'] = $row['lname'];
			$_SESSION['dob']   = $row['dob'];
			$_SESSION['gdr']   = $row['gdr'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['phone'] = $row['phone'];
			$_SESSION['ID']    = $row['ID'];
			header("Location: ../index.php?login=success");
			exit();
		}
		
	}
		
	
} else if(isset($_SESSION['signupOK'])) {
	
	// checking the login and password...
	
	$login = $_SESSION['login'];
	$pswd  = $_SESSION['pswd'];
	
	$sql = "Select * From users Where
			uname = '$login'";
	$result = $conn->query($sql);

	if (! $result->num_rows == 1) {
		session_unset();
		session_destroy();
		header("Location: ../login.php?signin=wrong");
		exit();
	}

	$row = $result->fetch_assoc();
	$hashedPasswdCheck = password_verify($pswd, $row['pswd']);

	if ($hashedPasswdCheck === false) {
		session_unset();
		session_destroy();
		header("Location: ../login.php?login=wrong");
		exit();
	} else if ($hashedPasswdCheck === true) {

		// Login the user...
		session_unset();
		$_SESSION['uname'] = $row['uname'];
		$_SESSION['fname'] = $row['fname'];
		$_SESSION['lname'] = $row['lname'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['ID']    = $row['ID'];
		header("Location: ../index.php?login=success");
		exit();
	}
	
}else {
	session_unset();
	session_destroy();
	header("Location: ../index.php");
	exit();
}

?>
