<?php include 'header.php'; ?>
<link rel="stylesheet" href="styles/signup-style.css">
	<section>
		<h1>Sign up</h1>
		<div id="signup">
			<form action="includes/signup.inc.php" method="POST" onsubmit="return validatefrom()" target="_self">
				<div class="tab">
					<h2>Personal</h2>
					<label for="fname"><b>Firstname :</b></label>
					<input type="text" name="fname" placeholder="Enter firstname.." oninput="this.className = ''" />
					<label for="lname"><b>Lastname :</b></label>
					<input type="text" name="lname" placeholder="Enter lastname.." oninput="this.className = ''" />
					<label for="dob"><b>Date of birth :</b></label>
					<input type="date" name="dob" />
					<label for="gdr"><b>Gender :</b></label>
					<select name="gdr">
						<option>Male</option>
						<option>Female</option>
					</select>
				</div>
				<div class="tab">
					<h2>Contact</h2>
					<label for="email"><b>E-mail :</b></label>
					<input type="email" name="email" placeholder="Enter e-mail.." oninput="this.className = ''" />
					<label for="phone"><b>Phone <span>(not required)</span> :</b></label>
					<input type="tel" name="phone" placeholder="Enter phone.." />
				</div>
				<div class="tab">
					<h2>Login info</h2>
					<label for="uname"><b>Username :</b></label>
					<input type="text" name="uname" placeholder="Enter username.." oninput="this.className = ''" />
					<label for="pswd"><b>Password :</b></label>
					<input type="password" name="pswd" placeholder="Enter password.." oninput="this.className = ''" />
					<input type="password" name="repswd" placeholder="Re-enter password.." oninput="this.className = ''" />
				</div>
				<div id="signup-buttons">
					<button id="submitBtn" type="submit" name="submit">Sign up</button>
					<button id="nxtBtn" type="button" onclick="nxtPrev(1)">Next</button>
					<button id="prevBtn" type="button" onclick="nxtPrev(-1)" style="background: #bbbbbb;">Previous</button>
				</div>
			</form>
		</div>
	</section>
	<script src="scripts/signup-script.js"></script>
<?php include 'footer.php'; ?>