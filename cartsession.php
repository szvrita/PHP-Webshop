<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

$prodSess = 'SELECT * FROM products WHERE product_id ="'.$_GET['product_id'].'"';
  $sessProdQuery = mysqli_query($con, $prodSess);
    $sessResult = mysqli_fetch_object($sessProdQuery);

// Check if session['products'] is not set
if(!isset($_SESSION['products'])){
  // Create session['products']
  $_SESSION['products'] = array();
}
// Check if product_id is set
if(isset($_GET['product_id'])){
  // Set matched variable
  $matched = false;
  // Loop through items in session['products']
  for ($i = 0; $i < count($_SESSION['products']); $i++) {
    // Check if ID matches $_GET['product_id']
    if ($_GET['product_id'] == $_SESSION['products'][$i]['id']) {
      // Declare that we have a match
      $matched = true;
      // Increase quantity
      $_SESSION['products'][$i]['quantity']++;
      // Increase price
      $_SESSION['products'][$i]['total'] += $_SESSION['products'][$i]['price'];
      break;
    }
  }
  if (!$matched) {
    // Add product
    $_SESSION['products'][count($_SESSION['products'])] = array(
      'id'        => $_GET['product_id'],
      'price'     => $sessResult->price,
      'quantity'  => 1,
      'total'     => $sessResult->price
    );
  }
}

header('location: shop.php');

?>
