 <h2>Create Account</h2>

<style>
	input { display: block;}
	
</style>

<?php 
	echo "<p>" . anchor('customer/loginForm','Back') . "</p>";
	
	echo form_open_multipart('customer/createCustomer');
		
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
	echo form_error('passConf');
	echo form_password('passConf', "", "required");
	
	if(isset($fileerror))
		echo $fileerror;		
	
	echo form_submit('submit', 'Create Account');
	echo form_close();
?>	
