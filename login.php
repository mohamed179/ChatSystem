<?php include 'header.php'; ?>
<link rel="stylesheet" href="styles/login-style.css">
	<section>
		<h1>Login</h1>
		<div id="login">
			<form action="includes/login.inc.php" method="POST" onsubmit="return validateform()" target="_self">
				<label for="login">Login:</label>
				<input type="text" name="login" placeholder="Enter username, email or phone.." oninput="this.className = ''" />
				<label for="pswd">Password:</label>
				<input type="password" name="pswd" placeholder="Enter password.." oninput="this.className = ''" />
				<button type="submit" name="submit">Login</button>
				<button type="reset" style="background: #bbbbbb;">Cancel</button>
			</form>
		</div>
	</section>
	<script src="scripts/login-script.js"></script>
<?php include 'footer.php'; ?>