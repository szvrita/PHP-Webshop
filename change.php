<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
  $actUser = $_SESSION['user']['user_id'];

  $cart_item = 'SELECT prod_quantity FROM cart_item WHERE cart_id="'.$_GET['cartId1'].'"';
    $item = mysqli_query($con, $cart_item);
      if(mysqli_num_rows($item) > 0){
        $cartItems = mysqli_fetch_all($item, MYSQLI_ASSOC);
      }
      if($cartItems[0]['prod_quantity'] <= 1 AND isset($_GET['cartId1'])){
        $change ='DELETE FROM cart_item WHERE cart_id = "'.$_GET['cartId1'].'"';
      }else{
        // Update with -1 quantity
        $change = 'UPDATE cart_item SET prod_quantity = prod_quantity - 1, prod_total = prod_total - prod_price  WHERE cart_id = "'.$_GET['cartId1'].'"';
      }

    $query = mysqli_query($con, $change) or die(mysqli_error($con));

    if (isset($_GET['cartId2'])) {
      $increase = 'UPDATE cart_item SET prod_quantity = prod_quantity + 1, prod_total = prod_total + prod_price WHERE cart_id = "'.$_GET['cartId2'].'"';
        $query = mysqli_query($con, $increase) or die(mysqli_error($con));
    }

    header('location: cart.php?user='.$actUser.'');

  if(isset($_GET['cartId'])){
    $delete = 'DELETE FROM cart_item WHERE cart_id = "'.$_GET['cartId'].'"';

    $query = mysqli_query($con, $delete) or die(mysqli_error($con));
  }
    header('location: cart.php?user='.$actUser.'');

}else{

  for($i=0; $i< count($_SESSION['products']); $i++){

    if(isset($_GET['sessprodId2'])){
    if($_SESSION['products'][$i]['id'] == $_GET['sessprodId2']){
        $_SESSION['products'][$i]['quantity']++;
        $_SESSION['products'][$i]['total'] += $_SESSION['products'][$i]['price'];
      }
    }

    if(isset($_GET['sessprodId1'])){
      if($_SESSION['products'][$i]['id'] == $_GET['sessprodId1']){
        if($_SESSION['products'][$i]['quantity'] <= 1 ){
            $_SESSION['products'][$i]['id'] = 0;
            $_SESSION['products'][$i]['quantity'] = 0;
            $_SESSION['products'][$i]['price'] = 0;
            $_SESSION['products'][$i]['total'] = 0;
          }else{
            $_SESSION['products'][$i]['quantity'] = $_SESSION['products'][$i]['quantity'] - 1;
            $_SESSION['products'][$i]['total'] = $_SESSION['products'][$i]['total'] - $_SESSION['products'][$i]['price'];
          }
        }
      }

    if(isset($_GET['sessprodId'])){
      if($_SESSION['products'][$i]['id'] == $_GET['sessprodId']){
            $_SESSION['products'][$i]['id'] = 0;
            $_SESSION['products'][$i]['quantity'] = 0;
            $_SESSION['products'][$i]['price'] = 0;
            $_SESSION['products'][$i]['total'] = 0;
      }
    }
  }

header('location: cart.php');

}
