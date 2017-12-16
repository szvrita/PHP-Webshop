<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_GET['user'])){
  $delete = 'DELETE FROM orders WHERE user_id = "'.$_GET['user'].'" AND completted = "false"';
    $query = mysqli_query($con, $delete) or die(mysqli_error($con));
  }

  header('location: shop.php');
?>
