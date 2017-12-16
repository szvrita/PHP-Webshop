<?php

include 'reso/frames/header.php';
include 'reso/frames/connection.php';

if(isset($_POST['email']) && isset($_POST['password'])){
  // Sanitise Email Address
  $email = mysqli_real_escape_string($con, $_POST['email']);
  // Query to search for user by email
  $query = 'SELECT * FROM users WHERE email = "'.$email.'" LIMIT 1';
  // Perform query and save in $user variable
  $user = mysqli_query($con, $query) or die(mysqli_connect_errorno());
  // Check if there are any results and do something with it
  if(mysqli_num_rows($user) > 0){
    // Parse results into a Hashmap
    $user = mysqli_fetch_all($user, MYSQLI_ASSOC);
    // Encrypt password from input
    $input_password = mysqli_real_escape_string($con, $_POST['password']);
    $input_password = sha1($email.$input_password);
    // Check passwords match
    if($input_password === $user[0]['password']){
      // Set logged in token
      $_SESSION['logged_in'] = true;
      // Save user details in session
      $_SESSION['user'] = $user[0];
        if(isset($_SESSION['products'])){
          for($i=0; $i< count($_SESSION['products']); $i++){

              $q = 'INSERT INTO cart_item (
                    user_id,
                    product_id,
                    prod_quantity,
                    prod_price,
                    prod_total
                  ) VALUES (
                    "'.$_SESSION['user']['user_id'].'",
                    "'.$_SESSION['products'][$i]['id'].'",
                    "'.$_SESSION['products'][$i]['quantity'].'",
                    "'.$_SESSION['products'][$i]['price'].'",
                    "'.$_SESSION['products'][$i]['total'].'"
                  )';

            $query = mysqli_query($con, $q) or die(mysqli_error($con));

            $_SESSION['products'][$i] = 0;
          }
            header('location: cart.php?user='.$_SESSION['user']['user_id'].'');
        }
          $selectOrder = 'SELECT order_id, completted FROM orders where user_id = "'.$_SESSION['user']['user_id'].'"';
            $selecOrder = mysqli_query($con, $selectOrder);
              if(mysqli_num_rows($selecOrder) > 0){
                $selectOrders = mysqli_fetch_all($selecOrder, MYSQLI_ASSOC);
                  foreach ($selectOrders as $keys) {
                      $false = $keys['completted'];
                      $falseId = $keys['order_id'];

                    if($false == "false" ){
                      header('location:/shop/checkout.php?orderid='.$falseId.'');
                    }else{
                      header('location: /shop/shop.php');
                    }
                  }
                }
    }else{
      echo "Check your password";
    }
  }else{
      echo 'No account found :o';
  }
}
?>
  <form action='login.php' method='POST'>
  	<input type='text' name='email' placeholder='Enter your email'/>
  	<input type='password' name='password' placeholder='Enter your password'/>
  	<input type='submit' value='Log In'/>
  </form>
</body>
</html>
