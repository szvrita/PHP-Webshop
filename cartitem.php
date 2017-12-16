<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';
//check the database product is in the basket or not
$check = 'SELECT * FROM cart_item WHERE product_id = "'.$_GET['product_id'].'" AND user_id = "'.$actUserId.'" ';
  $checkQuery = mysqli_query($con, $check);
    $checks = mysqli_fetch_object($checkQuery);

if($checks->product_id == $_GET['product_id'] AND $checks->user_id == $actUserId ){
  $increase = 'UPDATE cart_item SET prod_quantity = prod_quantity + 1, prod_total = prod_total + prod_price WHERE cart_id = "'.$checks->cart_id.'"';
    $query = mysqli_query($con, $increase) or die(mysqli_error($con));

}else{
  $prod = 'SELECT * FROM products WHERE product_id = "'.$_GET['product_id'].'"';
    $prodQuery = mysqli_query($con, $prod);
      $result = mysqli_fetch_object($prodQuery);

    if(isset($_GET['product_id'])){
      if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        $actUser = $_SESSION['user']['user_id'];
        $data = array(
          'product_id' => mysqli_real_escape_string($con, $_GET['product_id'])
        );
        $quantity = 1;
        $prod_price = $result->price;
        $prod_total = $result->price;
      }
      // Query the DB and store the results in a var
      $q = 'INSERT INTO cart_item (
                user_id,
                product_id,
                prod_quantity,
                prod_price,
                prod_total

              ) VALUES (
                "'.$actUser.'",
                "'.$data['product_id'].'",
                "'.$quantity.'",
                "'.$prod_price.'",
                "'.$prod_total.'"
              )';
      }

    $query = mysqli_query($con, $q) or die(mysqli_error($con));
}
        header('location: shop.php');
?>
