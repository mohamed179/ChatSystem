<?php

function validatePhone($phone) {
	$phone = preg_replace("/[^\w\+]/", "", $phone);
	return preg_match("/^\+(\d{11,14})$/", $phone) == 1;
}

?>