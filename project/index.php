<?php
    session_start();
    extract($_GET);

    

    if(isset($state)) {

        if($state == 1)
                unset($_SESSION['mycart'][$id]);
    }


    try{
        require("connection.php");
        $sql = "select type from category ";
        $dishsql = "SELECT did,name,type,price,rate,pic,offer,d.fid FROM dish d, category c, offer o WHERE d.ct_id = c.qid  GROUP BY did ORDER BY RAND() ;";
        $offer_sql = "SELECT did,name,type,price,rate,pic,offer
        FROM dish d, category c, offer o 
        WHERE d.ct_id = c.qid
        AND   o.fid = d.fid 
        AND d.fid IS NOT NULL 
        ORDER BY RAND() ;";

        $maxOffer_sql = "select max(offer) from offer;";

        $maxOffer = $db->query($maxOffer_sql);
        $offer = $db->query($offer_sql);
        $rs2= $db->query($sql);
        $dish = $db->query($dishsql);
        $bestdish=$db->query($offer_sql);
        if(isset($_SESSION['activeuser']))
        {
            $user=$_SESSION['activeuser'][0];
            $account_sql="select * from customer where username='$user';";

            $account = $db->query($account_sql);


        }

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

    <style>
        #propic {
            width:50px;  
            border-radius: 10%;
            border:1px solid #f5d730;
        }

        #propic:hover{
            border:1px solid #000;
        }

        #best {
            border: 1px solid #000;
            border-radius: 4px;
            padding: 5px;
            -moz-box-shadow: 5px 5px 0px #999;
            -webkit-box-shadow: 5px 5px 0px #999;
            box-shadow: 5px 5px 0px #999;
        }
    
    </style>

    <script>
    
        var url="coupon.php?str=1";
        function copo(){
            var urll="coupon.php?str=1";
            document.getElementById("lv-qr-code").src="https://chart.googleapis.com/chart?cht=qr&chl=localhost/project/ITCS473-Resturant/proT1/d_d/coupon.php?str=1&chs=160x160&chld=L|0"; 
            }
        var xmlHttp;

            function GetXmlHttpObject() {
            var xmlHttp = null;
            try {
                // Firefox, Opera 8.0+, Safari 
                xmlHttp = new XMLHttpRequest();
            }
            catch (e) {
                // Internet Explorer 
                try { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
                catch (e) { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); }
            }
            return xmlHttp;
                }
        function searchHintReq(){
                xmlHttp = GetXmlHttpObject();
                if (xmlHttp == null) { alert("Your browser does not support AJAX!"); return; }

                var url = "getDishs.php";
                //url +="?str="+document.getElementById('hint').value;
                xmlHttp.onreadystatechange = searchHint;
                xmlHttp.open("GET", url, true);
                xmlHttp.send(null);
            }

            function searchHint(val)
            {
                console.log(xmlHttp.responseText);
                document.getElementById('dishlist').innerHTML= "";
                if(xmlHttp.responseText=="no")
                {
                    document.getElementById('dishlist').innerHTML = "<option value='-1'>No dish found</option>";
                }
                else
                {
                    var obj = JSON.parse(xmlHttp.responseText);
                    for (i = 0; i < obj.length; i++) {
                    name = obj[i].name;
                    id=obj[i].id;
                    document.getElementById('dishlist').innerHTML += "<option value='"+id+"'>"+name+"</option>";

                    }
                }
                
                
            }

    </script>
</head>

<body onload="searchHintReq(); copo();">

<!-- Header Section Start -->
<div class="header-section section">
    <!-- Header Top Start -->
    <div class="header-top header-top-one header-top-border pt-10 pb-10">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col order-12 order-xs-12 order-lg-2 mt-10 mb-10">
                    <!-- Header Advance Search Start -->
                        <div class="header-advance-search">    
                            <form action="single-dish.php" autocomplete="off" id="dishsearch">
                                <div class="input" id="dlist"><input type="text" name="d" list="dishlist" placeholder="Search your dish" id="hint" onkeyup="">
                                    <datalist id="dishlist"></datalist>
                                </div>
                                <input type="hidden" > <div class="submit"><button><i class="icofont icofont-search-alt-1"></i></button></div>
                            </form>
                        </div>
                    <!-- Header Advance Search End -->
                </div>
        
                      <div class="col order-2 order-xs-2 order-lg-12 mt-10 mb-10">
                         <!-- Header Account Links Start -->
                        <div class="header-account-links">
                              
                              <?php  
                              if(isset($_SESSION['activeuser'])){
                              foreach ($account as $row) {?>
                                <a href="myaccount.php"><img id='propic' src="assets/images/userpic/<?php echo $row['profile_pic'];?>" > <span><?php echo $row['username'];?></span></a>
                                 <a href="logout.php"><i class="icofont icofont-login d-none"></i> <span>Logout</span></a>

                              <?php }}
                              
                              else {?>

                                <a href="register.php"><span>Register</span></a>
                                <a href="login.php"><i class="icofont icofont-login d-none"></i> <span>Login</span></a>

                              <?php } ?>

                        </div><!-- Header Account Links End -->
                    </div>

            </div>
        </div>
    </div>
<!-- Header Top End -->

    <!-- Header Bottom Start -->
    <div class="header-bottom header-bottom-one header-sticky">
        <div class="container">
            <div class="row align-items-center justify-content-between">

                <div class="col mt-15 mb-15">
                    <!-- Logo Start -->
                    <div class="header-logo">
                        <a href="index.html">
                            <img src="assets/images/pic/logo.png"  width="100" height="100">
                            <img class="theme-dark" src="assets/images/logo-light.png">
                        </a>
                    </div><!-- Logo End -->
                </div>

                <div class="col order-12 order-lg-2 order-xl-2 d-none d-lg-block">
                   <!-- Main Menu Start -->
                   <div class="main-menu">
                        <nav>
                            <ul>
                                <li class="active"><a href="index.php">HOME</a></li>
                                <li class="menu-item-has-children"><a href="#">Descover</a>
                                    <ul class="mega-menu two-column">
                                        <li><a href="#">Menu</a>
                                            <ul>
                                                <li><a href="dish-grid.php">Dish</a></li>
                                                <li><a href="best-deals.php">Best Deals</a></li>
                                                <li><a href="fullcategory.php">Category</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Account</a>
                                            <ul>
                                                <li><a href="myaccount.php">My Account</a></li>
                                                <li><a href="cart.php">Cart</a></li>
                                                <li><a href="checkout.php">Checkout</a></li>
                                                <li><a href="myorder.php">My Orders</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <li><a href="contact.php">CONTACT</a></li>

                            </ul>
                        </nav>
                    </div><!-- Main Menu End -->
                </div>

                <div class="col order-2 order-lg-12 order-xl-12">
                    <!-- Header Shop Links Start -->
                    <div class="header-shop-links">
                        
                        <!-- Cart -->
                        <a href="cart.php" class="header-cart"><i class="ti-shopping-cart"></i> <span class="number"><?php echo count($_SESSION['mycart']); ?> </span></a>
                        
                    </div><!-- Header Shop Links End -->
                </div>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu order-12 d-block d-lg-none col"></div>

            </div>
        </div>
    </div><!-- Header Bottom End -->

    <!-- Header Category Start -->
    <div class="header-category-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    
                    <!-- Header Category -->
                    <div class="header-category">
                        
                        <!-- Category Toggle Wrap -->
                        <div class="category-toggle-wrap d-block d-lg-none">
                            <!-- Category Toggle -->
                            <button class="category-toggle">Categories <i class="ti-menu"></i></button>
                        </div>
                        
                        <!-- Category Menu -->
                        <nav class="category-menu">
                            <ul sty>
                            <?php 
                                $m=0;
                                foreach($rs2 as $row) {
                                    if($m != 9)
                                    {   $type = $row["type"];
                                        echo "<li><a href='dish-grid.php?t=$type'>";
                                        echo $row["type"];
                                        echo"</a></li>";
                                        ++$m;
                                    }
                                    else
                                       break;
                                }
                                ?>    
                                <li><a href="fullcategory.php">More</a></li>
                            </ul>
                        </nav>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div><!-- Header Category End -->

</div><!-- Header Section End -->

    
    <!-- Mini Cart Wrap Start -->                      
    <div class="mini-cart-wrap">
    
        <!-- Mini Cart Top -->
        <div class="mini-cart-top">    
        
            <button class="close-cart">Close Cart<i class="icofont icofont-close"></i></button>
            
        </div>
    

    <!-- Mini Cart dish -->
    <ul class="mini-cart-products">
        <?php 
        $total=0; 
        if(!empty($_SESSION['mycart'])){
        foreach($_SESSION['mycart'] as $k=>$v) {
            $name=$v[0];
            $price=$v[1];
            $q=$v[2];
            $p=$v[3];
            
            $total += $price * $q;
        ?>
     
        <li>
            <a class="image"><img src="<?php echo $p?>" alt="Product" onerror=this.src="assets/images/pic/default.jpg"></a>
            <div class="content">
                <a href="single-dish.php?d='<?php echo $k ?>'" class="title"><?php echo $name ?></a>
                <span class="price"><?php echo $price ?>BD</span>
                <span class="qty">Qty:<?php echo $q ?></span>
            </div>
            <button class="remove" onclick="window.location.href='index.php?state=1&id=<?php echo $k ?>'"><i class="fa fa-trash-o"></i></button>
        </li>

        <?php }}?>
    </ul>
    
        <!-- Mini Cart Bottom -->
        <div class="mini-cart-bottom">    
        
            <h4 class="sub-total">Total: <span><?php echo $total?> BD</span></h4>
    
            <div class="button">
            <a href="cart.php">ORDER</a>
            </div>
            
        </div>
    
    </div><!-- Mini Cart Wrap End --> 

<!-- Cart Overlay -->
<div class="cart-overlay"></div>

<!-- Hero Section Start -->
<div class="hero-section section mb-30">
    <div class="container">
        <div class="row">
            <div class="col">

                <!-- Hero Slider Start -->
                <div class="hero-slider hero-slider-one">
                <?php foreach($bestdish as $row){ ?>
                    <!-- Hero Item Start -->
                    <div class="hero-item">
                        <div class="row align-items-center justify-content-between">

                            <!-- Hero Content -->
                            <div class="hero-content col">

                                <h2>HURRY UP!</h2>
                                <h1><span><?php echo $row['name']?></span></h1>
                                <h1>IT’S <span class="big"><?php echo $row['offer']?>%</span> OFF</h1>
                                <a href="single-dish.php?d=<?php echo $row["did"]?>">get it now</a>

                            </div>

                            <!-- Hero Image -->
                            <div class="hero-image col">
                               <img id='best' src="assets/images/pic/category/<?php echo $row['type'].'/'.$row['pic']?>" alt="Hero Image" width="300">
                            </div>
                        
                        </div>     
                    </div><!-- Hero Item End -->
                <?php } ?>
                </div><!-- Hero Slider End -->

            </div>
        </div>
    </div>
</div><!-- Hero Section End -->

<!-- Banner Section Start -->
<div class="banner-section section mb-60">
    <div class="container">
        <div class="row row-10">
            
            <!-- Banner -->
            <div class="col-md-8 col-12 mb-30">
                <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage.jpg"  width="1000" height="320" alt="Banner"></a></div>
            </div>
            
            <!-- Banner -->
            <div class="col-md-4 col-12 mb-30">
                <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage (1).jpg" width="380" height="320" alt="Banner"></a></div>
            </div>
            
        </div>
    </div>
</div><!-- Banner Section End -->

<!-- Dishs Section Start -->
<div class="product-section section mb-60">
    <div class="container">
        <div class="row">
            
            <!-- Section Title Start -->
            <div class="col-12 mb-40">
                <div class="section-title-one" data-title="DISHS"><h1>Dishs</h1></div>
            </div><!-- Section Title End -->
            
            <div class="col-12">
                <div class="row">
                    <?php
                    $rownum=0;
                    foreach($dish as $row) { 
                        if($rownum != 16){    
                    ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 pb-30 pt-10">
                        <!-- Product Start -->
                        <div class="ee-product">

                            <!-- Image -->
                            <div class="image">
                                <a href="single-dish.php?d=<?php echo $row["did"]?>" class="img"><img src="assets/images/pic/category/<?php echo $row["type"].'/'.$row["pic"]?>" width="270" height="320" alt="Product Image" onerror=this.src="assets/images/pic/default.jpg"></a>
                                <button type="button"  class="btn btn-outline-warning mt-10 ml-60" onclick="window.location.href='single-dish.php?d=<?php echo $row['did']?>'"><i class="ti-shopping-cart"></i>order</button>
                            </div>

                            <!-- Content -->
                            <div class="content">

                                <!-- Category & Title -->
                                <div class="category-title">

                                    <a href="#" class="cat"><?php echo $row["type"]?></a>
                                    <h5 class="title"><a href="single-dish.php"><?php echo $row["name"]?></a></h5>
                                </div>

                                <!-- Price & Ratting -->
                                <div class="price-ratting">
                                    <?php if($row['fid'] == null){?>
                                    <h5 class="price"><?php echo $row["price"].'BD'?></h5>
                                    <?php }
                                    else {
                                    ?>
                                    <h5 class="price"><span class="old"><?php echo $row["price"]?> BD</span><?php echo ($row["price"]-($row["price"] * ($row["offer"] / 100 ))) ?> BD</h5>    
                                    <?php } ?>
                                    <div class="ratting">
                                        <?php for($i=0 ; $i < $row["rate"] ; ++$i)
                                                    echo "<i class='fa fa-star'></i>";?>
                                    </div>

                                </div>

                            </div>

                        </div><!-- Product End -->
                    </div>
                    <?php ++$rownum;} } ?>
                </div>
            </div>
            
        </div>
    </div>
</div><!-- Dishs Section End -->

<!-- Banner Section Start -->
<div class="banner-section section mb-90">
    <div class="container">
        <div class="row">
            
            <!-- Banner -->
            <div class="col-12">
                <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage.jpg" width="1070" height="350" alt="Banner"></a></div>
            </div>
            
        </div>
    </div>
</div><!-- Banner Section End -->


<!-- Best Deals Product Section Start -->
<div class="product-section section mb-40">
    <div class="container">
        <div class="row">
            
            <!-- Section Title Start -->
            <div class="col-12 mb-40">
                <div class="section-title-one" data-title="BEST DEALS"><h1>OFFERS</h1></div>
            </div><!-- Section Title End -->
            
            <!-- Product Tab Filter Start-->
            <div class="col-12">
                <div class="offer-product-wrap row">
                    <!-- Offer Time Wrap Start -->
                    <div class="col mb-30" width="300">
                        <div class="offer-time-wrap" style="background-image: url(assets/images/bg/offer-products.jpg)">
                            <?php foreach($maxOffer as $row){?>
                            <h1><span>UP TO</span> <?php echo $row['0']?>%</h1>
                            <h3>DELICIOUS  & EXCLUSIVE <span>Dishs</span></h3>
                            <h4><span>LIMITED TIME OFFER</span> ORDER YOUR DISH</h4>
                            <?php }?>
                        </div>
                    </div><!-- Offer Time Wrap End -->

                    <!-- Product Tab Content Start -->
                    <div class="col-12 mb-30">
                        <div class="tab-content">

                            <!-- Tab Pane Start -->
                            <div class="tab-pane fade show active" id="tab-three">

                                <!-- Product Slider Wrap Start -->
                                <div class="product-slider-wrap product-slider-arrow-two">
                                    <!-- Product Slider Start -->
                                    <div class="product-slider product-slider-3">
                                        <?php foreach($offer as $row){?>
                                        <div class="col pb-20 pt-10">
                                            <!-- Product Start -->
                                            <div class="ee-product">

                                                <!-- Image -->
                                                <div class="image" >
                                                    <a href="single-dish.php?d=<?php echo $row["did"]?>" class="img"><img src="assets/images/pic/category/<?php echo $row["type"].'/'.$row["pic"]?>" width="270=" height="320" alt="Product Image" onerror=this.src="assets/images/pic/default.jpg"></a>
                                                    <button type="button"  class="btn btn-outline-warning mt-20 ml-120" onclick="window.location.href='single-dish.php?d=<?php echo $row['did']?>'"><i class="ti-shopping-cart"></i>order</button>
                                                </div>

                                                <!-- Content -->
                                                <div class="content">

                                                    <!-- Category & Title -->
                                                    <div class="category-title">

                                                        <a href="#" class="cat"><?php echo $row["type"]?></a>
                                                        <h5 class="title"><a href="single-dish.php?d=<?php echo $row["did"]?>"><?php echo $row["name"]?></a></h5>

                                                    </div>

                                                    <!-- Price & Ratting -->
                                                    <div class="price-ratting">

                                                        <h5 class="price"><span class="old"><?php echo $row["price"]?> BD</span><?php echo ($row["price"]-($row["price"] * ($row["offer"] / 100 ))) ?> BD</h5>
                                                        <div class="ratting">
                                                            <?php for($i=0 ; $i < $row["rate"] ; ++$i)
                                                                        echo "<i class='fa fa-star'></i>";?>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div><!-- Product End -->
                                        </div>
                                        <?php }?> 
                                    </div><!-- Product Slider End -->
                                </div><!-- Product Slider Wrap End -->

                            </div><!-- Tab Pane End -->

                        </div>
                    </div><!-- Product Tab Content End -->
                    
                </div>
            </div><!-- Product Tab Filter End-->
            
        </div>
    </div>
</div><!-- Best Deals Product Section End -->





<!-- Brands Section Start -->
<div class="brands-section section mb-90">
    <div class="container">
        <div class="row">
            
            <!-- Brand Slider Start -->
            <div class="brand-slider col">
                <div class="brand-item col"><img src="assets/images/brands/brand-1.png" alt="Brands"></div>
                <div class="brand-item col"><img src="assets/images/brands/brand-2.png" alt="Brands"></div>
                <div class="brand-item col"><img src="assets/images/brands/brand-3.png" alt="Brands"></div>
                <div class="brand-item col"><img src="assets/images/brands/brand-4.png" alt="Brands"></div>
                <div class="brand-item col"><img src="assets/images/brands/brand-5.png" alt="Brands"></div>
            </div><!-- Brand Slider End -->
            
        </div>
    </div>
</div><!-- Brands Section End -->

<!-- Subscribe Section Start -->
<div class="subscribe-section section bg-gray pt-55 pb-55">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Mailchimp Subscribe Content Start -->
            <div class="col-lg-6 col-12 mb-15 mt-15">
                <div class="subscribe-content">
                    <h2>SUBSCRIBE <span>OUR NEWSLETTER</span></h2>
                    <h2><span>TO GET LATEST</span> DISH UPDATE</h2>
                </div>
            </div><!-- Mailchimp Subscribe Content End -->
            
            
            <!-- Mailchimp Subscribe Form Start -->
            <div class="col-lg-6 col-12 mb-15 mt-15">
                
				<form class="subscribe-form" action="#">
					<input type="email" autocomplete="off" placeholder="Enter your email here" />
					<button >subscribe</button>
				</form>
				<!-- mailchimp-alerts Start -->
				<div class="mailchimp-alerts text-centre">
					<div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
					<div class="mailchimp-success"></div><!-- mailchimp-success end -->
					<div class="mailchimp-error"></div><!-- mailchimp-error end -->
				</div><!-- mailchimp-alerts end -->
                
            </div><!-- Mailchimp Subscribe Form End -->
            
        </div>
    </div>
</div><!-- Subscribe Section End -->

<!-- Footer Section Start -->
<div class="footer-section section bg-ivory">
   
    <!-- Footer Top Section Start -->
    <div class="footer-top-section section pt-90 pb-50">
        <div class="container">
           
            <!-- Footer Widget Start -->
            <div class="row">
                <div class="col mb-90">
                    <div class="footer-widget text-center">
                        <div class="footer-logo">
                                <img src="assets/images/pic/logo.png"  width="100" height="100">
                                <img class="theme-dark" src="assets/images/logo-light.png" alt="E&E - Electronics eCommerce Bootstrap4 HTML Template">
                        </div>
                        <p>Cooking is all about people. Food is maybe the only universal thing that really has the power to bring everyone together. No matter what culture, everywhere around the world, people get together to eat.</p>
                    </div>
                </div>
         
                
                <!-- Footer Widget Start -->
                <div class="col-lg-4 col-md-6 col-12 mb-40">
                    <div class="footer-widget">
                       
                        <h4 class="widget-title">CONTACT INFO</h4>
                        
                        <p class="contact-info">
                            <span>Address</span>
                            <?php
                            require("res_data.php");
                            $c_add = count($data[0]);
                            $c_tel = count($data[1]);
                            $c_web = count($data[2]);

                            for ($i=0; $i <  $c_add; $i++) { 
                                echo $data[0][$i].'</br>';
                            }
                            ?>
                        </p>
                        
                        <p class="contact-info">
                            <span>Phone</span>
                            <?php
                            for ($i=0; $i <  $c_tel; $i++) { 
                                echo $data[1][$i].'</br>';
                            }
                            ?>
                        </p>
                        
                        <p class="contact-info">
                            <span>Web</span>
                            <?php
                            for ($i=0; $i <  $c_tel; $i++) { 
                                echo "<a href='#'>".$data[2][$i]."</a></br>";
                            }
                            ?>
                            
                        </p>
                        
                    </div>
                </div><!-- Footer Widget End -->
            </div>
            
        </div>
    </div><!-- Footer Bottom Section Start -->
   
    
</div><!-- Footer Section End -->

<!-- Modal -->
<div class="modal fade" id="promo" tabindex="-1" role="dialog" aria-labelledby="promo" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="promo">Coupon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="center">
          <h2>Scan the QR-Code To have a chance to win free coupon</h2>
      <img class='text-center' id='lv-qr-code'src='' >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
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

<?php 



if(isset($promo)){

    echo "<script type='text/javascript'>
    $(document).ready(function(){
    $('#promo').modal('show');
    });
    </script>";
}


?>
</body>

</html>