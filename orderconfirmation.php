<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

$userCheck = 'SELECT * FROM users AS u INNER JOIN orders AS o ON u.user_id = o.user_id WHERE o.order_id="'.$_GET['orderid'].'"';
  $userCh = mysqli_query($con, $userCheck) or die(mysqli_error($con));
  if(mysqli_num_rows($userCh) > 0){
    $userChecking = mysqli_fetch_all($userCh, MYSQLI_ASSOC);
    }

if(!empty($userChecking[0]['firstname']) && !empty($userChecking[0]['lastname']) && !empty($userChecking[0]['address']) && !empty($userChecking[0]['city']) && !empty($userChecking[0]['postcode']) && !empty($userChecking[0]['phone']) && !empty($_POST['cardName']) && !empty($_POST['cardnumber']) && !empty($_POST['expdate']) && !empty($_POST['seccode'])){
  $orderStatus = 'UPDATE orders SET completted = "true" WHERE order_id = "'.$_GET['orderid'].'"';
    $query = mysqli_query($con, $orderStatus) or die(mysqli_error($con));
      echo "<div>
              <h2>Thank you for you order!</h2>
              <h3>Your order number: ".$_GET['orderid']."</h3>
            </div>";
      $delete = 'DELETE FROM cart_item WHERE user_id = "'.$actUserId.'"';
        $query = mysqli_query($con, $delete) or die(mysqli_error($con));
}else{
  header('location: checkout.php?orderid='.$_GET['orderid'].'&empty=form');
}
?>
