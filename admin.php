<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['img']) ) {
		$data = array(
  	// Escape variables for security - mysqli_real_escape_string for the sake of sanitising the input
			'title' => mysqli_real_escape_string($con, $_POST['title']),
			'author' => mysqli_real_escape_string($con, $_POST['author']),
			'description' => mysqli_real_escape_string($con, $_POST['description']),
			'price' => mysqli_real_escape_string($con, $_POST['price']),
			'quantity' => mysqli_real_escape_string($con, $_POST['quantity']),
      'img' => mysqli_real_escape_string($con, $_POST['img'])
		);

    // Query the DB and store the results in a var
    $q = 'INSERT INTO products (
			title,
			author,
			description,
			price,
			quantity,
      img
		) VALUES (
			"'.$data['title'].'",
			"'.$data['author'].'",
			"'.$data['description'].'",
			"'.$data['price'].'",
			"'.$data['quantity'].'",
      "'.$data['img'].'"
		)';

    $query = mysqli_query($con, $q) or die(mysqli_error($con));
    // $results = mysqli_fetch_all($query, MYSQLI_ASSOC);
    // var_dump($results);
		header('location: admin.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='reso/static/css/registration.css'/>
</head>
<body>
	<form action='admin.php' method='POST'>
		<input type='text' name='title' placeholder='Title'/>
		<input type='text' name='author' placeholder='Author'/>
		<input type='text' name='description' placeholder='Description'/>
		<input type='text' name='price' placeholder='Price'/>
    <input type='text' name='quantity' placeholder='Quantity'/>
    <input type='text' name='img' placeholder='Image url'/>
		<input type='submit' value='Add product'/>
	</form>
</body>
</html>
