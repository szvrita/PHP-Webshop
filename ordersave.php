<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
  $actUserId = $_SESSION['user']['user_id'];

  $orderValue = 'SELECT * FROM cart_item WHERE user_id = "'.$_GET['user'].'"';
    $orderQuery = mysqli_query($con, $orderValue);
      if(mysqli_num_rows($orderQuery) > 0){
        $order = mysqli_fetch_all($orderQuery, MYSQLI_ASSOC);

        if(isset($_GET['user'])){
          if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
            $actUser = $_SESSION['user']['user_id'];
            $order_total = $_SESSION['total'];
            $completted = 'false';
            }
          }

          $q = 'INSERT INTO orders (
                    user_id,
                    order_total,
                    completted
                  ) VALUES (
                    "'.$actUser.'",
                    "'.$order_total.'",
                    "'.$completted.'"
                  )';

          $query = mysqli_query($con, $q) or die(mysqli_error($con));

          header('location: orderitemsave.php?user='.$actUserId.'');

      }else {
          header('location: orderitemsave.php?user='.$actUserId.'');
      }
}
?>
