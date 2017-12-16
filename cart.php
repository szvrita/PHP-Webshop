<?php
include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
  $cartItem = 'SELECT c.*, p.* FROM cart_item AS c INNER JOIN products AS p ON c.product_id = p.product_id INNER JOIN users AS u ON c.user_id = u.user_id WHERE c.user_id="'.$_GET['user'].'"';
    $carts = mysqli_query($con, $cartItem);
      if (mysqli_num_rows($carts) > 0) {
        $cartItems = mysqli_fetch_all($carts, MYSQLI_ASSOC);
      }else{
        $cartItems = 0;
      }
?>
<table class="table table-striped" style="line-height:40px; vertical-align: middle !important;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Each Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total price</th>
      <th scope="col">Remove</th>
    </tr>
  </thead>
  <tbody>
<?php
if($cartItems > 0){
  foreach ($cartItems as $car){
    $cartId = $car['cart_id'];
      echo '<tr>
              <th scope="row"><img style="width: 50px; height:50px" src="'.$car['img'].'"/></th>
                <td>'.$car['title'].'</td>
                <td>£'.$car['prod_price'].'</td>
                <td style= "display: inline-flex;">
                  <a href="/shop/change.php?cartId1='.$cartId.'" class="btn btn-secondary" style="margin: 1em;">-</a>
                  <p class="">Quantity: '.$car['prod_quantity'].'</p>
                  <a href="/shop/change.php?cartId2='.$cartId.'" class="btn btn-secondary" style="margin: 1em;">+</a>
                </td>
                <td>£'.$car['prod_total'].'</td>
                <td>
                  <a href="/shop/change.php?cartId='.$cartId.'" class=""><img src="reso/static/img/bin.png" style="width:50px; height: 50px;"/></a>
                </td>
            </tr>';
  }
}
?>
  </tbody>
</table>
<div>
<?php
  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $actUserId = $_SESSION['user']['user_id'];

    $cartValue = 'SELECT c.prod_total FROM cart_item AS c INNER JOIN products AS p ON c.product_id = p.product_id INNER JOIN users AS u ON c.user_id = u.user_id WHERE c.user_id="'.$_GET['user'].'"';
    $cartSum = mysqli_query($con, $cartValue);
      if (mysqli_num_rows($cartSum) > 0){
        $userSum = mysqli_fetch_all($cartSum, MYSQLI_ASSOC);
        $userSum = json_encode($userSum);

        $jsonObj = json_decode($userSum);
        $total = 0;
        if($userSum >=0){
          foreach ($jsonObj as $item){
            $total += $item->prod_total;
          }
        }

        $_SESSION['total'] = $total;

          // Print the SUM
        echo '<h2>Cart total: £'.$total.'
              <a href="/shop/ordersave.php?user='.$actUserId.'" style="float:right;" class="btn btn-primary">Go to checkout</a>
              </h2>';
      }else{

        echo "<h1 style='text-align: center;'>Yours basket is empty!</h1><br/><br/>";
      }
  }
}else{
?>
<table class="table table-striped" style="line-height:40px; vertical-align: middle !important;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Each Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total price</th>
      <th scope="col">Remove</th>
    </tr>
  </thead>
  <tbody>
<?php
$sessCartProd = 'SELECT * FROM products';
  $sessCP = mysqli_query($con, $sessCartProd);
    if(mysqli_num_rows($sessCP) > 0){
      $sessionCP = mysqli_fetch_all($sessCP, MYSQLI_ASSOC);
      for ($j=0; $j<count($sessionCP); $j++) {
        $sessionCPId = $sessionCP[$j]['product_id'];

        if(isset($_SESSION['products'])){
          $sessCartItems = $_SESSION['products'];
            for ($i=0; $i<count($sessCartItems); $i++){
              $sessCartProdId = $_SESSION['products'][$i]['id'];
              if($sessionCPId == $sessCartProdId){
                echo '<tr>
                        <th scope="row"><img style="width: 50px; height:50px" src="'.$sessionCP[$j]['img'].'"/></th>
                          <td>'.$sessionCP[$j]['title'].'</td>
                          <td>£'.$sessCartItems[$i]['price'].'</td>
                          <td style= "display: inline-flex;">
                            <a href="/shop/change.php?sessprodId1='.$sessionCPId.'" class="btn btn-secondary" style="margin: 1em;">-</a>
                            <p class="">Quantity: '.$sessCartItems[$i]['quantity'].'</p>
                            <a href="/shop/change.php?sessprodId2='.$sessionCPId.'" class="btn btn-secondary" style="margin: 1em;">+</a>
                          </td>
                          <td>£'.$sessCartItems[$i]['total'].'</td>
                          <td>
                            <a href="/shop/change.php?sessprodId='.$sessionCPId.'" class=""><img src="reso/static/img/bin.png" style="width:50px; height: 50px;"/></a>
                          </td>
                    </tr>';
              }
            }
          }
        }
      }
?>
  </tbody>
</table>
<div>
<?php
    if(isset($_SESSION['products'])){
      $sessionCartItems = $_SESSION['products'];
      $sessCartTotal = 0;

      for ($i=0; $i<count($sessCartItems); $i++){
        $sessCartProdQ = $_SESSION['products'][$i]['total'];

        $sessCartTotal += $sessCartProdQ;
      }
        // Print the SUM
    echo '<h2>Cart total: £'.$sessCartTotal.'
    <a href="" onclick="login()" style="float:right;" class="btn btn-primary">Go to checkout</a>
    </h2>';
    }else{
      echo "<h1 style='text-align: center;'>Yours basket is empty!</h1><br/><br/>";
    }
}
?>
  </div>
</body>
</html>
