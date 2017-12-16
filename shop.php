<link rel="stylesheet" href='reso/static/css/shop.css'/>

<?php
include 'reso/frames/header.php';
include 'reso/frames/connection.php';

  $shopQuery = "SELECT * FROM products";
    $result = mysqli_query($con, $shopQuery);
      if (mysqli_num_rows($result) > 0) {
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
      }else{
        echo "No results";
      }
?>
<div class="container">
  <div class="row">
<?php
  foreach($results as $res){
    $prodId = $res['product_id'];
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      echo '<div class="col-sm-6 col-md-4 col-lg-3 mt-4">
              <div prodId="'.$prodId.'" class="card">
                <img class="card-img-top" src="'.$res['img'].'" alt="Card image cap">
                <div class="card-body">
                  <h6>'.$res['title'].'</h6>
                  <p class="card-text">'.$res['description'].'</p>
                  <p class="card-subtitle mb-2 text-muted">£'.$res['price'].'</p>
                  <p class="card-text">'.$res['author'].'</p>
                  <a href="/shop/cartitem.php?product_id='.$prodId.'" class="btn btn-primary">Add to cart</a>
                </div>
              </div>
            </div>';
      }else{
        echo '<div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                <div prodId="'.$prodId.'" class="card">
                  <img class="card-img-top" src="'.$res['img'].'" alt="Card image cap">
                  <div class="card-body">
                    <h6>'.$res['title'].'</h6>
                    <p class="card-text">'.$res['description'].'</p>
                    <p class="card-subtitle mb-2 text-muted">£'.$res['price'].'</p>
                    <p class="card-text">'.$res['author'].'</p>
                    <a href="/shop/cartsession.php?product_id='.$prodId.'" class="btn btn-primary">Add to cart</a>
                  </div>
                </div>
              </div>';
      }
    }
?>
        </div>
      </div>
    <script>
        function login() {
           alert("Please, Sign in/Login ");
        }
    </script>
  </body>
</html>
