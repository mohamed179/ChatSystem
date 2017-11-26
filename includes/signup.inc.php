<?php

try {

if (isset($_POST['submit'])) {
	
	require 'db.inc.php';
	
	$fname = htmlspecialchars($_POST['fname']);
	$lname  = htmlspecialchars($_POST['lname']);
	$dob   = htmlspecialchars($_POST['dob']);
	$gdr   = htmlspecialchars($_POST['gdr']);
	$email = htmlspecialchars($_POST['email']);
	$phone = htmlspecialchars($_POST['phone']);
	$uname = htmlspecialchars($_POST['uname']);
	$pswd  = htmlspecialchars($_POST['pswd']);
	
	// check firstname...
	if (empty($fname)) {
		header("Location: ../signup.php?signup=empty_fname");
		exit();
	} else if (! preg_match("/^[a-z]*$/i", $fname)) {
		// invalid firstname.
		header("Location: ../signup.php?signup=invalid_fname");
		exit();
	} else if (strlen($fname) < 3) {
		// short firstname.
		header("Location: ../signup.php?signup=short_fname");
		exit();
	} else if (strlen($fname) > 20) {
		// long firstname.
		header("Location: ../signup.php?signup=long_fname");
		exit();
	} else {
		// valid firstname.
		// setting the format to insert to database...
		$fname = strtolower($fname);
		$fname = ucfirst($fname);
	}
		
	// check lastname...
	if (empty($lname)) {
		header("Location: ../signup.php?signup=empty_lname");
		exit();
	} else if (! preg_match("/^[a-z]*$/i", $lname)) {
		// invalid lastname
		header("Location: ../signup.php?signup=invalid_lname");
		exit();
	} else if (strlen($lname) < 3) {
		// short lastname.
		header("Location: ../signup.php?signup=short_lname");
		exit();
	} else if (strlen($lname) > 20) {
		// long lastname.
		header("Location: ../signup.php?signup=long_lname");
		exit();
	} else {
		// valid lastname.
		// setting the format to insert to database...
		$lname = strtolower($lname);
		$lname = ucfirst($lname);
	}
	
	// check date of birth...
	if (empty($dob)) {
		header("Location: ../signup.php?signup=empty_dob");
		exit();
	} else if (is_string($dob)) {
		// note: date must be in "mm/dd/yyyy" form.
		// example: "03/22/2010"
		$dob = date("m/d/Y", strtotime($dob));
		$test_arr  = explode("/", $dob);
		if (count($test_arr) != 3 || 
			! checkdate($test_arr[0], $test_arr[1], $test_arr[2])) {
			// invalid date of birth.
			header("Location: ../signup.php?signup=invalid_dob");
			exit();
		} else {
			// valid date fo birth.
			// setting the format to insert to database...
			$dob = date("Y-m-d", strtotime($dob));
		}
	} else {
		// invalid date of birth.
		header("Location: ../signup.php?signup=invalid_dob");
		exit();
	}
	
	// check gender...
	if (empty($gdr)) {
		header("Location: ../signup.php?signup=empty_gdr");
		exit();
	} else if ($gdr !== "Male" && $gdr !== "Female") {
		// invalid gender.
		header("Location: ../signup.php?signup=invalid_gdr");
		exit();
	}
	
	// check email...
	if (empty($email)) {
		header("Location: ../signup.php?signup=empty_email");
		exit();
	} else if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// invalid email.
		header("Location: ../signup.php?signup=invalid_email");
		exit();
	} else {
		$sql = "Select * From users Where email = '$email'";
		$result = $conn->query($sql);
		$resultCheck = $result->num_rows == 0;
		if (! $resultCheck) {
			// email used before.
			header("Location: ../signup.php?signup=reused_email");
			exit();
		}
	}
	
	// check phone...
	require '../utilities/utils.util.php';
	if (! is_string($phone) || 
		(! empty($phone) && ! validatePhone($phone))) {
		// invalid phone number.
		header("Location: ../signup.php?signup=invalid_phone");
		exit();
	} else {
		$sql = "Select * From users Where phone = '$phone'";
		$result = $conn->query($sql);
		$resultCheck = $result->num_rows == 0;
		if (! $resultCheck) {
			// email used before.
			header("Location: ../signup.php?signup=reused_phone");
			exit();
		}
	}
	
	// check username...
	/*
	   username must start with letter then followed by any number of
	   letters, digits and underscores but no consecutive underscores.
	*/
	if (empty($uname)) {
		header("Location: ../signup.php?signup=empty_uname");
		exit();
	} else if (! preg_match("/^[a-z]+[a-z0-9]*([_\.\-][a-z0-9]+)*$/i", $uname)) {
		// invalid username.
		header("Location: ../signup.php?signup=invalid_uname");
		exit();
	} else if (strlen($uname) < 8) {
		// short username.
		header("Location: ../signup.php?signup=short_uname");
		exit();
	} else if (strlen($uname) > 20) {
		// long username.
		header("Location: ../signup.php?signup=long_uname");
		exit();
	} else {
		$sql = "Select * From users Where uname = '$uname'";
		$result = $conn->query($sql);
		$resultCheck = $result->num_rows == 0;
		if (! $resultCheck) {
			// username used before.
			header("Location: ../signup.php?signup=reused_uname");
			exit();
		} else {
			$uname = strtolower($uname);
		}
	}
	
	// check password...
	if (empty($pswd)) {
		header("Location: ../signup.php?signup=empty_pswd");
		exit();
	} else if (! is_string($pswd)) {
		// invalid password.
		header("Location: ../signup.php?signup=inavalid_pswd");
		exit();
	} else if (strlen($pswd) < 8) {
		// short firstname.
		header("Location: ../signup.php?signup=shortpswd");
		exit();
	} else if (strlen($pswd) > 20) {
		// long firstname.
		header("Location: ../signup.php?signup=long_pswd");
		exit();
	} else {
		// Hashing the password
		$hashedPswd = password_hash($pswd, PASSWORD_DEFAULT);
	}
	
	$sql = "Insert Into users";
	if (empty($phone)) {
		$sql = $sql . " (fname, lname, dob, gdr, email, uname, pswd)
						 Values
						 ('$fname', '$lname', '$dob', '$gdr', '$email', '$uname', '$hashedPswd')";
	} else {
		$sql = $sql . " (fname, lname, dob, gdr, email, phone, uname, pswd)
						 Values
						 ('$fname', '$lname', '$dob', '$gdr', '$email', '$phone', '$uname', '$hashedPswd')";
	}
	
	if($conn->query($sql) === true) {
		
		session_start();
		$_SESSION['signupOK'] = "OK";
		$_SESSION['login']    = $uname;
		$_SESSION['pswd']     = $pswd;
		header("Location: login.inc.php?signup=success");
		exit();
	} else {
		header("Location: ../signup.php?signup=dberror");
		exit();
	}
	
} else {
	// visiting this page without signing up form...
	header("Location: ../index.php");
	exit();
}
	
} catch (Exception $ex) {
	echo $ex->getMessage();
}

?>