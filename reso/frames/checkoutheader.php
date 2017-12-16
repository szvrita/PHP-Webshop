<?php

session_start();
include 'reso/frames/connection.php';

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src='http://unpkg.com/jquery'></script>
    <link rel="stylesheet" href='reso/static/css/checkout.css'/>
    <title></title>
  </head>
  <body>

<?php

  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      $actUserId = $_SESSION['user']['user_id'];
      $actUser1 = $_SESSION['user']['firstname'];
      $actUser2 = $_SESSION['user']['lastname'];


      $cart = 'SELECT c.prod_quantity FROM cart_item AS c INNER JOIN users AS u ON c.user_id = u.user_id WHERE c.user_id="'.$actUserId.'"';
        $carts = mysqli_query($con, $cart);
            if (mysqli_num_rows($carts) >= 0) {
              $cartNum = mysqli_fetch_all($carts, MYSQLI_ASSOC);
              $cartNum = json_encode($cartNum);

              $cartNums = json_decode($cartNum);
              $cartIndex = 0;
              if($cartNum >= 0){
                foreach ($cartNums as $items){
                  $cartIndex += $items->prod_quantity;
                }
              }
                $_SESSION['$cartIndex'] = $cartIndex;
            }else{

            }

    echo '
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">BOOK-SHOP</a>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">

          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <h6>Hello: '.$actUser1.' '.$actUser2.'</h6>
          </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/shop/logout.php">Logout</a><br/>
            </div>
          </li>

          </div>
        </ul>
      </div>
      </nav>

      <a href="/shop/orderdelete.php?user='.$actUserId.'"  class="btn btn-primary">Back to shopping</a>';


    }else{

      }


      ?>

<script>
    function login() {
       alert("Please, Sign in/Login ");
    }
</script>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
