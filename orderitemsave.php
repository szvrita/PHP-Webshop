<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
      $actUserId = $_SESSION['user']['user_id'];

  $orderid = 'SELECT * FROM orders WHERE user_id = "'.$actUserId.'" AND order_total = "'.$_SESSION['total'].'"';
    $orderidQuery = mysqli_query($con, $orderid);
      if(mysqli_num_rows($orderidQuery) > 0){
        $orderIDs = mysqli_fetch_all($orderidQuery, MYSQLI_ASSOC);
          $ordereID = $orderIDs[0]['order_id'];

        $orderValue = 'SELECT * FROM cart_item WHERE user_id = "'.$_SESSION['user']['user_id'].'"';
          $orderQuery = mysqli_query($con, $orderValue);
            if(mysqli_num_rows($orderQuery) > 0){
              $order = mysqli_fetch_all($orderQuery, MYSQLI_ASSOC);
            }

        foreach($order as $orderItems){
         if(isset($_GET['user'])){
           if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
                $order_id = $ordereID;
                $actUser = $actUserId;
                $product_id = $orderItems['product_id'];
                $quantity = $orderItems['prod_quantity'];
                $prod_price = $orderItems['prod_price'];
                $prod_total = $orderItems['prod_total'];
            }
          }
              $q2 = 'INSERT INTO order_items (
                        order_id,
                        user_id,
                        product_id,
                        prod_quantity,
                        prod_price,
                        prod_total
                      ) VALUES (
                        "'.$order_id.'",
                        "'.$actUser.'",
                        "'.$product_id.'",
                        "'.$quantity.'",
                        "'.$prod_price.'",
                        "'.$prod_total.'"
                      )';

             $query = mysqli_query($con, $q2) or die(mysqli_error($con));

             header('location: checkout.php?orderid='.$ordereID.'');
        }
      }else{
              header('location: checkout.php?orderid='.$ordereID.'');
      }
}
?>
