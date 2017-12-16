<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
  $userid = $_SESSION['user']['user_id'];

  $userdet='SELECT * FROM users WHERE user_id="'.$_GET['user'].'"';
  $userDet = mysqli_query($con, $userdet);
    if (mysqli_num_rows($userDet) > 0){
      $userDetails = mysqli_fetch_all($userDet, MYSQLI_ASSOC);
    }

    $userfn = $userDetails[0]['firstname'];
    $userln = $userDetails[0]['lastname'];
    $useremail = $userDetails[0]['email'];
    $useraddress = $userDetails[0]['address'];
    $usercity = $userDetails[0]['city'];
    $userpostcode = $userDetails[0]['postcode'];
    $userphone = $userDetails[0]['phone'];

    echo "<h5>User name: $userfn $userln</h5>";
    echo "<h6>User email address: $useremail</h6>";
    echo '<div style="display:flex;">
            <div style="border: solid; width:90%; margin: 10px auto">
              <h4>Update your shipping details</h4>
                <div style="text-align:left; margin-left: 20px; width:99%; padding: 10px auto !important;" class="input-group">
                    <form id="shipping" action="shipping.php" method="POST">
                    <div class="form-row">
                      <div class="col-md-4">
                        <label for="firstname">Firstname:</label>
                        <input type="text" id="firstname" name="firstname" placeholder="Firstname" value="'.$actUser1.'">
                        <label for="lastname">Lastname:</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Lastname" value="'.$actUser2.'">
                      </div>
                      <div class="col-md-4">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" placeholder="Address" value="'.$useraddress.'">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" placeholder="City" value="'.$usercity.'">
                      </div>
                      <div class="col-md-4">
                        <label for="postcode">Postcode:</label>
                        <input type="text" id="postcode" name="postcode" placeholder="Postcode" value="'.$userpostcode.'">
                        <label for="phone">Phone number:</label>
                        <input type="text" id="phone" name="phone" placeholder="Phone number" value="'.$userphone.'">
                      </div></div>
                      <div class="col-auto">
                      <input type="submit" value="Set address"/>
                      </div>

                    </form>
                  </div>
                </div>
              </div>

      <hr>
        <div class="container">
          <h1>Your previous orders</h1>
          <div class = "row">';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
  $userid = $_SESSION['user']['user_id'];
// Select orders
  $ordereQuery = 'SELECT * FROM orders AS o INNER JOIN users AS u ON o.user_id = u.user_id WHERE o.user_id = "'.$userid.'" ORDER BY o.order_date DESC';
    $orderResult = mysqli_query($con, $ordereQuery);
    if(mysqli_num_rows($orderResult) > 0){
    	$orderresults = mysqli_fetch_all($orderResult, MYSQLI_ASSOC);
      if($orderresults > 0){
        foreach ($orderresults as $res){
          $ordersId = $res['order_id'];
          if($userid === $res['user_id']){
            echo '<div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                    <div class="card">
                      <h4 class="card-text">Order id: '.$res['order_id'].'</h4>
                      <p class="card-title">Order date: '.$res['order_date'].'</p>
                      <ol>';
      //Select ordered products
      $orderProd = 'SELECT * FROM order_items AS i INNER JOIN orders AS o ON i.order_id = o.order_id INNER JOIN products AS p ON i.product_id = p.product_id WHERE i.order_id = "'.$ordersId.'" ORDER BY o.order_date DESC';
        $orderProdResult = mysqli_query($con, $orderProd);
          if(mysqli_num_rows($orderProdResult) > 0){
          	$orderProdresults = mysqli_fetch_all($orderProdResult, MYSQLI_ASSOC);
                foreach ($orderProdresults as $prodres) {
                  echo '<li class="card-text">'.$prodres['title'].'
                          <p class="card-title">Author: '.$prodres['author'].'<br/>
                            Quantity: '.$prodres['prod_quantity'].'<br/>
                            Price: £'.$prodres['prod_price'].'</p>
                          <p class="card-title">Product total: £'.$prodres['prod_total'].'</p>
                        </li>';
                }echo '</ol>
                        <h4 class="card-title">Order total: £'.$res['order_total'].'</h4>
                    </div>';
                }
            }
            echo '</div>';
          }echo '</div>';
        }
      }else{
          $orderresults = 0;
          echo "<div><br/><br/>You dont have any order!<br/><br/></div>";
      }
  }
    echo '</div>
          </body>
          </html>';
}else{
  echo 'Login please!';
}
