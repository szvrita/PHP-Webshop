<?php

include 'reso/frames/checkoutheader.php';
include 'reso/frames/connection.php';

$orderid = 'SELECT * FROM orders WHERE user_id = "'.$actUserId.'" AND order_id = "'.$_GET['orderid'].'"';
  $orderidQuery = mysqli_query($con, $orderid);
    if(mysqli_num_rows($orderidQuery) > 0){
      $orderIDs = mysqli_fetch_all($orderidQuery, MYSQLI_ASSOC);
        $ordereID = $orderIDs[0]['order_id'];

        if(isset($_POST['address']) && isset($_POST['city']) && isset($_POST['postcode']) && isset($_POST['phone'])){
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
            $q = 'UPDATE users SET firstname = "'.$data['firstname'].'", lastname = "'.$data['lastname'].'", address = "'.$data['address'].'", city = "'.$data['city'].'", postcode = "'.$data['postcode'].'", phone = "'.$data['phone'].'" WHERE user_id = "'.$actUserId.'"';

            $query = mysqli_query($con, $q) or die(mysqli_error($con));

            header('location: checkout.php?orderid='.$ordereID.'');
       }
 }
?>
