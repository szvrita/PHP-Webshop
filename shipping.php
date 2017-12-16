<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
  $actUser = $_SESSION['user']['user_id'];

  if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['postcode']) && isset($_POST['phone'])) {
		$data = array(
  	// Escape variables for security - mysqli_real_escape_string for the sake of sanitising the input
      'firstname' => mysqli_real_escape_string($con, $_POST['firstname']),
      'lastname' => mysqli_real_escape_string($con, $_POST['lastname']),
      'address' => mysqli_real_escape_string($con, $_POST['address']),
			'city' => mysqli_real_escape_string($con, $_POST['city']),
			'postcode' => mysqli_real_escape_string($con, $_POST['postcode']),
			'phone' => mysqli_real_escape_string($con, $_POST['phone'])
		);
    // Query the DB and store the results in a var
    $q = 'UPDATE users SET firstname="'.$data['firstname'].'", lastname="'.$data['lastname'].'",address = "'.$data['address'].'", city = "'.$data['city'].'", postcode = "'.$data['postcode'].'", phone = "'.$data['phone'].'" WHERE user_id = "'.$actUser.'"';

    $query = mysqli_query($con, $q) or die(mysqli_error($con));

    header('location: feed.php?user='.$actUserId.'');
	}
}
?>
