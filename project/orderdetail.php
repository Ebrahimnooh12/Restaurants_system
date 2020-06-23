<?php
session_start();
extract($_POST);
extract($_GET);

$staffun = $_SESSION['activestaff'][0];
$staffid = $_SESSION['activestaff'][1];
           


if(isset($out)){
    unset($_SESSION['activestaff']);
    header('location: index.php');
    die();
}

try{
    require("connection.php");
    $sqlorderd = "select * from orderdetail, dish WHERE dish.did = orderdetail.did and oid=$od;";
   
    $orderdetal= $db->query($sqlorderd);

    $db = null;
    

}

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

?>


<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>D&D - Food Ordring</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- CSS
	============================================ -->
   <!-- our css -->
   <link rel="stylesheet" href="assets/css/ourStyle.css"> 

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/icon-font.min.css">
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css">
    
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
<div class="header-section section">    
<div class="header-top header-top-one header-top-border pt-10 pb-10">
        <div class="container">
            <div class="row align-items-center justify-content-between">


                <div class="col order-2 order-xs-2 order-lg-12 mt-10 mb-10">
                    <!-- Header Account Links Start -->
                    <div class="header-account-links">
                        <a href="#"><i class="icofont icofont-user-alt-7"></i> <span><?php echo $staffun;?></span></a>
                        <a href="StaffDashBoard.php?out=1"><i class="icofont icofont-login d-none"></i> <span>Logout</span></a>
                    </div><!-- Header Account Links End -->
                </div>

            </div>
        </div>
    </div><!-- Header Top End -->

    <!-- Header Bottom Start -->
    <div class="header-bottom header-bottom-one header-sticky">
        <div class="container">
            <div class="row align-items-center">

                <div class="mt-15 mb-15">
                    <!-- Logo Start -->
                    <div class="header-logo">
                        <a href="StaffDashBoard.php?s=<?php echo $s?>">
                            <img src="assets/images/pic/logo.png"  width="100" height="100">
                            <img class="theme-dark" src="assets/images/logo-light.png">
                        </a>
                    </div><!-- Logo End -->
                </div>

                <div class="col order-12 order-lg-2 order-xl-2 d-none d-lg-block">
                   <!-- Main Menu Start -->
                   <div class="main-menu" style='margin-left:35%'>
                        <nav>
                            <ul>
                                <li class="active"><a href="StaffDashBoard.php?s=<?php echo $s?>">ORDER</a></li>
                                <li class="menu-item-has-children"><a href="#">DISH</a>
                                    <ul class="mega-menu two-column">
                                        <li><a href="view.php?v=d&s=<?php echo $s?>">VIEW DISH</a></li>
                                        <li><a href="reply.php?s=<?php echo $s?>">REVIWES</a></li>
                                    </ul>
                                </li>
                                <li><a href="staffaccount.php?s=<?php echo $s?>">MY ACCOUNT</a></li>

                            </ul>
                        </nav>
                    </div><!-- Main Menu End -->
                </div>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu order-12 d-block d-lg-none col"></div>

            </div>
        </div>
    </div><!-- Header Bottom End -->
</div>


<div class="page-section section pt-90 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="#">				
                    <!-- Cart Table -->
                    <div class="cart-table table-responsive mb-40">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pro-title">dish </th>
                                    <th class="pro-quantity">Quantity</th>
                                    <th class="pro-subtotal">Unite Pice</th>
                                </tr>
                            </thead>
                            
                            <?php
                            if($orderdetal->rowCount()==0){  ?>
                                        <tbody>
                                            <tr><th class='empty' colspan='7'> YOUR CART IS EMPTY</th></tr>
                                        </tbody>



                            <?php } 
                            else {
                                    foreach($orderdetal as $row) {
                             ?>
                            <tbody>
                                <tr>
                                    <td class="pro-title"><?php echo $row['name'] ?></td>
                                    <td class="pro-title"><?php echo $row['qty'] ?></td>
                                    <td class="pro-price"><span><?php echo $row['unitPrice'] ?> BD</span></td>
                                </tr>
                            </tbody>

                            <?php }}?>
                                <tr ><td colspan='3'> <button type="button"  class="btn btn-outline-warning mt-10 ml-60" onclick="window.location.href='StaffDashBoard.php?s=<?php echo $s?>'"><i class="fa fa-arrow-circle-left mr-5"></i>Back</button></td></tr>
                        </table>
                    </div>
                    
                </form>	
            </div>
        </div>
    </div>
</div>


<!-- JS
============================================ -->

<!-- jQuery JS -->
<script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
<!-- Popper JS -->
<script src="assets/js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Plugins JS -->
<script src="assets/js/plugins.js"></script>

<!-- Main JS -->
<script src="assets/js/main.js"></script>

<!-- our js -->
<script src="assets/js/script.js"></script>
</body>

</html>