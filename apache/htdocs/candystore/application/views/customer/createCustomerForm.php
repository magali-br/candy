<!DOCTYPE html>
<html>
<head>
	<script src='http://code.jquery.com/jquery-latest.js'></script>
	<script>
		function checkPassword() {
			var password = $("#password");
			var passconf = $("#passconf");

			if (password.val() == passconf.val()) {
				passconf.get(0).setCustomValidity("");
				return true;
			} else {
				passconf.get(0).setCustomValidity("The passwords do not match.");
				return false;
			}
		}

		function checkEmail() {
			var email = $("#email");
			if (/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(email.val())) {
				email.get(0).setCustomValidity("");
				return true;
			} else {
				email.get(0).setCustomValidity("Invalid Email.");
				return false;
			}

		}

	 </script>

</head>

<body>
<h1> Create Account </h1>

<?php 
	echo "<p>" . anchor('customer_controller/loginForm','Back') . "</p>";

	echo validation_errors();
	
	echo form_open_multipart('customer_controller/createCustomer');
		
	echo form_label('First Name'); 
	echo form_error('firstName');
	echo form_input('firstName',set_value('firstName'), "required");

	echo form_label('Last Name');
	echo form_error('lastName');
	echo form_input('lastName',set_value('lastName'), "required");

	echo form_label('Username');
	echo form_error('username');
	echo form_input('username',set_value('username'), "required");

	echo form_label('Email');
	echo form_error('email');
	echo form_input('email',set_value('email'), "required id='email' oninput='checkEmail()'");

	echo form_label('Password');
	echo form_error('password');
	echo form_password('password',"", "required id='password'");
	
	echo form_label('Password Confirmation');
	echo form_error('passconf');
	echo form_password('passconf', "", "required id='passconf' oninput='checkPassword()'");		
	
	echo form_submit('submit', 'Create Account');
	echo form_close();
?>	

</body>
</html>
