<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_conf'])) {
	if($_POST['password_conf'] != $_POST['password']){
		echo 'Passwords do not match.';
	}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		echo 'Email address is not valid.';
	}else{
		$name = explode(' ', $_POST['fullname']);
		$data = array(
  	// Escape variables for security - mysqli_real_escape_string for the sake of sanitising the input
			'firstname' => mysqli_real_escape_string($con, $name[0]),
			'lastname' => mysqli_real_escape_string($con, $name[1]),
			'email' => mysqli_real_escape_string($con, $_POST['email']),
			'password' => mysqli_real_escape_string($con, $_POST['password'])
		);
    // Encrypting the password and assigning it a salt (the email address in that case)
		$data['password'] = sha1($data['email'].$data['password']);
    // Query the DB and store the results in a var
    $q = 'INSERT INTO users (
			firstname,
			lastname,
			email,
			password,
			address,
			city,
			postcode,
			phone
		) VALUES (
			"'.$data['firstname'].'",
			"'.$data['lastname'].'",
			"'.$data['email'].'",
			"'.$data['password'].'",
			"0",
			"0",
			"0",
			"0"
		)';

    $query = mysqli_query($con, $q) or die(mysqli_error($con));

		header('location: login.php');
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='reso/static/css/registration.css'/>
	</head>
	<body>
		<form action='registration.php' method='POST'>
			<input type='text' name='fullname' placeholder='Full name'/>
			<input type='text' name='email' placeholder='Email address'/>
			<input type='password' name='password' placeholder='Password'/>
			<input type='password' name='password_conf' placeholder='Confirm password'/>
			<input type='submit' value='register'/>
		</form>
	</body>
</html>
