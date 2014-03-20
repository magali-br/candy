<!DOCTYPE html>
<html>
<head>
	<script src='http://code.jquery.com/jquery-latest.js'></script>
	<script>
		function checkCreditCard() {
			var number = $("#creditCard");

			if (/^\d{16})$/.test(number)) {
				number.get(0).setCustomValidity("");
				return true;
			} else {
				number.get(0).setCustomValidity("The Credit Card Number is invalid.");
				return false;
			}
		}

		function checkExpiryDate() {
			var month = $("#expiryMonth");
			var year = $("#expiryYear");

			if (!/^\d{2})$/.test(month)) {
				month.get(0).setCustomValidity("The Credit Card Expiry Month is invalid.");
				return false;
			}

			if (/^\d{2})$/.test(year)) {
				year.get(0).setCustomValidity("The Credit Card Expiry Year is invalid.");
				return false;
			}

			month = parseInt(month);
			year = parseInt(year);

			if (month > 12 || month < 1) {
				month.get(0).setCustomValidity("The Credit Card Expiry Month is invalid.");
				return false;
			}

			month.get(0).setCustomValidity("");
			year.get(0).setCustomValidity("");


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
	echo form_input('email',set_value('email'), "required");

	echo form_label('Password');
	echo form_error('password');
	echo form_password('password',"", "required");
	
	echo form_label('Password Confirmation');
	echo form_error('passconf');
	echo form_password('passconf', "", "required");		
	
	echo form_submit('submit', 'Create Account');
	echo form_close();
?>	

</body>
</html>
