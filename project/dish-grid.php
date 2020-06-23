<?php
extract($_GET);
session_start();

if(isset($state)) {

    if($state == 1)
            unset($_SESSION['mycart'][$id]);
}



if(isset($state)) {

if($state == 1)
        unset($_SESSION['mycart'][$id]);
}


$flag=false;
try{
require("connection.php");
$sql = "select type from category ";

if(isset($typ)) 
    $dishsql = "SELECT did,name,type,price,rate,pic,offer,d.fid FROM dish d, category c, offer o WHERE d.ct_id = c.qid and type='$typ' GROUP BY did ORDER BY did";    
else
    $dishsql = "SELECT did,name,type,price,rate,pic,offer,d.fid FROM dish d, category c, offer o WHERE d.ct_id = c.qid GROUP BY did ORDER BY did";

$rs1= $db->query($sql);
$rs2= $db->query($sql);
$dish = $db->query($dishsql);

if(isset($_SESSION['activeuser']))
{
    $user=$_SESSION['activeuser'][0];
    $account_sql="select * from customer where username='$user';";

    $account = $db->query($account_sql);

}

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

        .nice {
            font-weight: bold;
        }
    
        .autocomplete {
        /*the container must be positioned relative:*/
        position: relative;
        display: inline-block;
        }
    </style>

    <script>
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
            
        function viewTable(page) {

            xmlHttp = GetXmlHttpObject();
            if (xmlHttp == null) { alert("Your browser does not support AJAX!"); return; }

            var url = "dish_table.php";
            url = url + "?page=" + page;
            url = url + "&type_s=" + document.getElementById("types").value
            url = url + "&rate_s=" + document.getElementById("rates").value
            url = url + "&sid=" + Math.random();

            xmlHttp.onreadystatechange = ApplyTable;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
            }

        function ApplyTable() {
                console.log(xmlHttp.responseText);
            document.getElementById("dishTable").innerHTML=xmlHttp.responseText;
            }
            
        function updatefilter(type){
            //console.log(type);
            document.getElementById("types").value=type;
            viewTable(0);
        }

        function filter_from_url(){
            var url_string = window.location.href;
            var url = new URL(url_string);
            var c = url.searchParams.get("t");
            updatefilter(c);
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

<body onload="searchHintReq();">

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
                        <a href="index.php">
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
                                <li><a href="contact.html">CONTACT</a></li>

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
    </div>
<!-- Header Bottom End -->

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
                                    {
                                        $type = $row["type"];
                                        echo "<li><a  onclick=".'"'."updatefilter('$type')".'"'.">";
                                        echo $row["type"];
                                        echo"</a></li>";
                                        ++$m;
                                    }
                                    else
                                    if($m==9)
                                    {  echo '<div class="dropdown ">
                                        <li><a class="dropdown-toggle"  id="More" data-toggle="dropdown" >
                                          More
                                        </a>
                                      
                                        <div class="dropdown-menu" aria-labelledby="More">';
                                        $type = $row["type"];
                                            echo "<a  class='dropdown-item' onclick=".'"'."updatefilter('$type')".'"'.">";
                                            echo $row["type"];
                                            echo"</a>";
                                        foreach($rs2 as $row){
                                            $type = $row["type"];
                                            echo "<a  class='dropdown-item' onclick=".'"'."updatefilter('$type')".'"'.">";
                                            echo $row["type"];
                                            echo"</a>";
                                        }
                                       
                                        break;
                                    }
                                  
                                }
                                ?>    
                                </li> 
                                 </div>
                                 
                                      </div>
                                              
                            </ul>
                        </nav>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
<!-- Header Category End -->

</div>
<!-- Header Section End -->
    
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

<!-- Page Banner Section Start -->
<div class="page-banner-section section">
    <div class="page-banner-wrap row row-0 d-flex align-items-center ">

        <!-- Page Banner -->
        <div class="col-lg-4 col-12 order-lg-2 d-flex align-items-center justify-content-center">
            <div class="page-banner">
                <h1>Dishs</h1>
                <p>Feel Free And Anjoy Our Dishs</p>
            </div>
        </div>

         <!-- Banner -->
         <div class="col-lg-4 col-md-6 col-12 order-lg-1">
            <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage (2).jpg" alt="Banner"></a></div>
        </div>
    
            <!-- Banner -->
        <div class="col-lg-4 col-md-6 col-12 order-lg-3">
            <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage (2).jpg" alt="Banner"></a></div>
        </div>
    </div>
</div><!-- Page Banner Section End -->

<!-- Dish Section Start -->
<div class="product-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
           
            <div class="col-12">
            <div class="row">
                    <div class="col">
                       
<!-- Shop Top Bar Start -->
    <!-- Filter -->
                        <div class="shop-top-bar">
                        <form action="">
                            <div class="row">
                                <div class="form-group input-group-prepend d-flex justify-content-center ml-50">
                                    <!-- filter Type -->
                                        <span class='input-group-text nice mt-10' >Type:</span>
                                        <select class="form-control ml-2 " id="types" name="type_s" onchange="viewTable(0)">
                                            <option>All</option>
                                            <?php
                                            $cats = $db->query("select * from category");
                                                foreach($cats as $cat){ 
                                                echo"<option >".$cat['type']."</option>";}
                                                ?>
                                        </select>
                                    <!-- filter rate -->
                                        <span class='input-group-text ml-3 nice mt-10' >Rate:</span>
                                        <select class="form-control ml-2 " id="rates" name="rates_s" onchange="viewTable(0)">
                                            <option>All</option>
                                            <?php
                                                for($i=1;$i<=5;$i++){ 
                                                echo "<option >$i</option>";}
                                                ?>
                                        </select>
                                </div>
                            </div>
                                
    <!--End of Filter -->    
        </div>
  
<!-- Shop Top Bar End -->
   
        </div>
 </div>
 <hr>       
                <!-- dish Wrap Start -->
                <div id="dishTable">
                   
                    
                </div><!-- dish Wrap End -->
                
                </form>
                <?php
        if(isset($t)){
            echo '<script>filter_from_url();</script>';
        }else
            echo '<script>viewTable(0);</script>'?>
        </div>
    </div>
</div><!-- Feature dish Section End -->

<!-- Brands Section Start -->
<div class="brands-section section mb-15">
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
<div class="subscribe-section section bg-gray pt-15 pb-15">
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
                <div class="col-lg-6 col-12 mb-5 mt-15">
                    
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

</body>

</html>