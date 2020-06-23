<!doctype html>
<html>
<head>

  <style>
      .coupon {
      border: 5px dotted #bbb; /* Dotted border */
      width: 80%; 
      border-radius: 15px; /* Rounded border */
      margin: 0 auto; /* Center the coupon */
      max-width: 600px; 
    }

    .container {
      padding: 2px 16px;
      background-color: #f1f1f1;
    }

    .promo {
      background: #ccc;
      padding: 3px;
    }

    .expire {
      color: red;
    }
    .center {
      display: block;
      margin-left: auto;
      margin-right: auto;
      width: 50%;
    }
  </style>
</head>
<body>
  <?php
  //extract($_GET);
  $coupons=json_decode(file_get_contents('coupon.txt'), true);
  $luck=rand (0,10); 

  if(isset($coupons[$luck]) && isset($_GET['str'])){
  ?>
  <div class="coupon">
    <div class="container">
      <h3 align="center">Wellcome to our Resturant</h3>
    </div>
    <img src="logo.png" alt="Avatar" height="240" width="240" class="center">
    <div class="container" style="background-color:white">
      <h2><b><?php echo $coupons[$luck]["val"]*100; ?>% OFF YOUR PURCHASE</b></h2> 
      <p>Save and Apply it in your cart</p>
    </div>
    <div class="container">
      <p>Use Promo Code: <span class="promo"><?php echo $coupons[$luck]["code"]; ?></span></p>
      <p class="expire">Expires: <?php echo $coupons[$luck]["exp"]; ?> </p>
    </div>
  </div>
  <?php
  }
  else{
  ?>
  <div class="coupon">
    <div class="container">
      <h3 align="center">Lucky Coupon</h3>
    </div>
    <img src="logo.png" alt="Avatar" height="240" width="240" class="center">
    <div class="container" style="background-color:white">
      <h2><b>Sorry, you are not lucky today.</b></h2> 
    </div>
    <div class="container">
      <p>Try again Later </p>
    </div>
  </div>
  <?php
  }
  ?>
</body>

</html>