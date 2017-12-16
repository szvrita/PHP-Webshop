<?php

include 'reso/frames/checkoutheader.php';
include 'reso/frames/connection.php';

$orders = 'SELECT * FROM order_items AS i INNER JOIN orders AS o ON i.order_id = o.order_id INNER JOIN products AS p ON i.product_id = p.product_id INNER JOIN users AS u ON o.user_id=u.user_id WHERE i.order_id="'.$_GET['orderid'].'"';
  $checkoutsitem = mysqli_query($con, $orders);
      if (mysqli_num_rows($checkoutsitem) > 0) {
        $checkout = mysqli_fetch_all($checkoutsitem, MYSQLI_ASSOC);
          $actFn = $checkout[0]['firstname'];
          $actLn = $checkout[0]['lastname'];
          $actAddress = $checkout[0]['address'];
          $actCity = $checkout[0]['city'];
          $actPostcode = $checkout[0]['postcode'];
          $actPhone = $checkout[0]['phone'];
          $actOrderTotal = $checkout[0]['order_total'];
          $actOrderId = $checkout[0]['order_id'];
      }else{
        echo "No results";
      }
?>
<hr>
  <div style="border: solid; padding: 10px; text-align: center; width: 90%; margin: auto;">
    <div>
      <h1>Order preview</h1>
    </div>
    <div style=" display: inline-flex; width: 98%; margin: auto;">
      <div style="padding: 10px; border: solid; margin: 10px; width: 20%; text-align: left;">
        <h4 style="text-align: center;">Shipping address</h4>
          <ul>
            <li>Name: <?php echo $actFn.' '.$actLn; ?></li>
            <li>Address: <?php echo $actAddress; ?></li>
            <li>City: <?php echo $actCity; ?></li>
            <li>Postcode: <?php echo $actPostcode; ?></li>
            <li>Phone number: <?php echo $actPhone; ?></li>
          </ul>
      </div>
      <div style="padding: 10px; display: block; text-align:left; border:solid; margin: 10px !important; width: 35%;" class="input-group">
        <div style="text-align: center;">
          <h4>Change shipping details</h4>
        </div>
        <div style="">
          <form action="checkoutshipping.php?orderid=<?php echo $actOrderId;?>" method="POST">
          <label for="firstname">Firstname:</label>
          <input type="text" name="firstname" id="firstname" placeholder="Firstname" value="<?php echo $actFn; ?>"><br/>
          <label for="lastname">Lastname:</label>
          <input type="text" name="lastname" id="lastname" placeholder="Lastname" value="<?php echo $actLn; ?>"><br/>
          <label for="address">Address:</label>
          <input type="text" name="address" id="address" placeholder="Address" value="<?php echo $actAddress; ?>"><br/>
          <label for="city">City:</label>
          <input type="text" name="city" id="city" placeholder="City" value="<?php echo $actCity; ?>"><br/>
          <label for="postcode">Postcode:</label>
          <input type="text" name="postcode" id="postcode" placeholder="Postcode" value="<?php echo $actPostcode?>"><br/>
          <label for="phone">Phone number:</label>
          <input type="text" name="phone" id="phone" placeholder="Phone number" value="<?php echo $actPhone; ?>"><br/>
          <input type="submit" value="Set address"/>
          </form>
        </div>
      </div>
      <div style="padding: 10px; border: solid; margin: 10px; width: 40%;">
        <h4>Products</h4>
        <table class="table table-striped" style="line-height:40px; vertical-align: middle !important;">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Each Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Total price</th>
            </tr>
          </thead>
          <tbody>
<?php
  foreach ($checkout as $checkOut) {
    $checkOutId = $checkOut['item_id'];
      echo '<tr>
              <th scope="row"><img style="width: 50px; height:50px" src="'.$checkOut['img'].'"/></th>
                <td>'.$checkOut['title'].'</td>
                <td>£'.$checkOut['prod_price'].'</td>
                <td style= "display: inline-flex;">
                <p class="">'.$checkOut['prod_quantity'].'</p>
                  </td>
                <td>£'.$checkOut['prod_total'].'</td>
          </tr>';
    }
 ?>

          </tbody>
        </table>
        <h2 style="text-align: right;">Total pay: £<?php echo $actOrderTotal ?></h2>
      </div>
    </div>
  </div>


  <div style="border: solid; padding: 10px; width: 50%; margin: 10px auto;">
    <h1>Card details</h1>
    <div>
      <form action="orderconfirmation.php?orderid=<?php echo $actOrderId; ?>" id='cardDetails' method='POST'>
        <label for="">Card type:</lable>
        <input class="cardDetails" type="radio" name="card" value="debit" />Debit Card
        <input class="cardDetails" type="radio" name="card" value="credit"/>Credit Card<br/>
        <label for="cardName">Name on the card:</lable>
        <input class="cardDetails" type="text" id="cardName" name="cardName" value="<?php echo $actFn.' '.$actLn;?>"/><br/>
        <label for="cardnumber">Card number:</lable>
        <input class="cardDetails" type="text" id="cardnumber" name="cardnumber" placeholder="card number" /><br/>
        <label for="expdate">Expiry date:</lable>
        <input class="cardDetails" type="date" id="expdate" name="expdate" placeholder="Address" /><br/>
        <label for="seccode">Security code:</lable>
        <input class="cardDetails" type="text" id="seccode" name="seccode" placeholder="Security code" /><br/>
        <input type="submit" id="submit" value="Pay"/>
      </form>
    </div>
  </div>
<?php
if(isset($_GET['empty'])){
  if ($_GET['empty'] === 'form'){
      echo "<script type='text/javascript'>
            alert('Fill the form!');
            </script>";
          }
  }
?>
</body>
</html>
