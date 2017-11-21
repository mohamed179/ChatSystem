<?php

$host     = "localhost";
$username = "login";
$password = "login";
$database = "chatsystem";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error)
	die("connection faild: " . $conn->connect_error);

?>