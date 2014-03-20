
 <h1>Login</h1>

<?php 
	
	echo "<p>" . anchor('customer_controller/createCustomerForm','Create New Account') . "</p>";
	if (isset($errmsg)) {
		echo "<p><strong>$errmsg</strong></p>";
    } 

	echo "<p>Login to access the Candy Store</p>";

	echo validation_errors();

	echo form_open_multipart('customer_controller/login');

	echo form_label('Username');
	echo form_error('username');
	echo form_input('username',set_value('username'), "required");

	echo form_label('Password');
	echo form_error('password');
	echo form_password('password', "", "required");	
	
	echo form_submit('submit', 'Login');
	echo form_close();

?> 