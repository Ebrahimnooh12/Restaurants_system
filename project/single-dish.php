<?php
session_start();
extract($_GET);
extract($_POST);
require("res_data.php");


if(isset($d))
    $id = $d;
else
    {
        header('location: index.php');
        die();
    }    


if(isset($state)) {

    if($state == 1)
            unset($_SESSION['mycart'][$id]);
}


try{
    require("connection.php");

    $sql = "select type from category ";
    $dishsql = "select * from dish INNER JOIN category ON dish.ct_id = category.qid where did= $id";
    $rel_sql = "select * from dish INNER JOIN category ON dish.ct_id = category.qid where type= (select type from dish INNER JOIN category ON dish.ct_id = category.qid where did= $id ORDER BY RAND())";
    
    $reply_sql ="select r.reply,c.username, s.Fname 
    from reply r, rate, customer c, staff s
    where r.rateID = rate.rid 
    and c.cid = rate.cid 
    and s.sid = r.sid
    and did=$id";

    $rs1= $db->query($sql);
    $rs2= $db->query($sql);
    $dish_d = $db->query($dishsql);
    $rel_dish = $db->query($rel_sql);
    $reply = $db->query($reply_sql);

    if(isset($_SESSION['activeuser']))
    {
        $user=$_SESSION['activeuser'][0];
        $cid = $_SESSION['activeuser'][1];

        $account_sql="select * from customer where username='$user';";

        $IsOrder_sql= "select * from ordering  o, orderdetail d 
        where  o.oid = d.oid
        and cid = $cid
        and did = $id;";

        $IsOrder = $db->query($IsOrder_sql);

        $c = $IsOrder-> rowCount();
        
    
        $IsRate="select * from rate where did=$id and cid=$cid ";

        $c_rate= $db->query($IsRate);

        $n = $c_rate-> rowCount();

        $account = $db->query($account_sql);
    }


    /*--------------------Review-------------------------*/

    $total_rate="select rate from dish where did=$id";
	$totalNumberOfRates="select count(did) from rate where did=$id";
	$Raters="select Fname, Lname, rate, comment, rid from customer, rate where customer.cid= rate.cid AND did=$id";
    

    $t_r= $db->query($total_rate);
	$t_n_o_r= $db->query($totalNumberOfRates);
	$r= $db->query($Raters);
    
    if(isset($rating))
    {
      if($rating == 0 || $review==null)  
      {
        header("location: single-dish.php?d=$id");
        die();
      }
      $db->beginTransaction();      
    
      $stmt = $db->prepare("iNSERT INTO rate (did,cid,rate,comment) VALUES (:dishid, :customerid, :rate, :comment)");
      $stmt->bindParam(':dishid', $id);
      $stmt->bindParam(':customerid', $cid);
      $stmt->bindParam(':rate', $rating);
      $stmt->bindParam(':comment', $review);

      $stmt->execute();

  
      $db->commit();
      $db=null;
      header('location: index.php');
  
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
    <title>D&D - Food Ordring </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- CSS
	============================================ -->
   <!-- our css -->
   <link rel="stylesheet" href="assets/css/stylenew.css"> 

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
        #addcart{background:#f5d730; color:#000; border:none;}
        #addcart:hover{background:#000; color:#f5d730;}


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
                                <a href="myaccount.php"><img id='propic' src="assets/images/userpic/<?php echo $row['profile_pic'];?>"> <span><?php echo $row['username'];?></span></a>
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
    </div><!-- Header Top End -->

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
                                                <li><a href="register.php">Register</a></li>
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
                                    {
                                        $type = $row["type"];
                                        echo "<li><a href='dish-grid.php?typ=$type'>";
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
            <a class="image"><img src="<?php echo $p?>" alt="Product"></a>
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
                <h1>Product Details</h1>
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

<!-- Single dish Section Start -->
<div class="product-section section mt-90 mb-90">
    <div class="container">
        
        <div class="row mb-90">
        <?php foreach($dish_d as $row) {
            ?>        
            <div class="col-lg-6 col-12 mb-50">

                <!-- Image -->
                        <div id="single-image-1" class="tab-pane fade show active big-image-slider">
                            <div class="big-image"><img src="assets/images/pic/category/<?php echo $row["type"].'/'.$row["pic"]?>" alt="Big Image"><a href="assets/images/pic/category/<?php echo $row["type"].'/'.$row["pic"]?>" class="big-image-popup">
                            <i class="fa fa-search-plus"></i></a></div>
                        </div>

            </div>
                    
            <div class="col-lg-6 col-12 mb-50">

                <!-- Content -->
            
                <div class="single-product-content">

                    <!-- Category & Title -->
                    <div class="head-content">
                        <div class="category-title">
                            <a href="#" class="cat"><?php echo $row["type"]?></a>
                            <h5 class="title"><?php echo $row["name"]?></h5>
                        </div>

                        <h5 class="price"><?php echo $row["price"]?>BD </h5>

                    </div>

                    <div class="single-product-description">

                        <div class="ratting">
                            <?php for($i=0 ; $i < $row["rate"] ; ++$i)
                              echo "<i class='fa fa-star'></i>";?>
                        </div>

                        <div class="desc">
                            <p><?php echo $row["description"]?></p>
                        </div>
                                                
                        <div class="quantity-colors">
                            
                            <div class="quantity">
                                <h5>Quantity</h5>
                                <form action="addcart.php" method="post">
                                <div class="pro-qty">
                                    <input type="text" name="qty" value="1">  
                                </div>
                                </br></br></br>
                                <input type="hidden" name="name" value="<?php echo $row['name']?>">
                                <input type="hidden" name="d" value="<?php echo $row['did']?>"> 
                                <input type="hidden" name="price" value="<?php echo $row['price']?>">
                                <input type="hidden" name="pic" value="assets/images/pic/category/<?php echo $row["type"].'/'.$row["pic"]?>">                                                                                                                                                                                                                                                              
                                <input id='addcart' class="btn" type="submit" value="ADD TO CART" name="sb">

                                </form>  
                            </div>                            
                        </div>                
                        <div class="share">
                            
                            <h5>Share: </h5>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                            
                        </div>

                    </div>

                </div>
            <?php }?>
            </div>
            
        </div>
        
        <div class="row">
            
            <div class="col-lg-10 col-12 ml-auto mr-auto">
                
                <ul class="single-product-tab-list nav">
                    <li><a href="#product-reviews" data-toggle="tab" >reviews</a></li>
                </ul>
                
                <div class="single-product-tab-content tab-content">
                    <div class="tab-pane fade" id="product-reviews">
                       
                        <div class="product-ratting-wrap">
							<div class="pro-avg-ratting">
								<h4>
									<?php 									
									foreach($t_r as $AvgOfRates)
									{
										echo " ($AvgOfRates[0]) ";
										echo "<div class='sin-list float-left'>";
										for($j=0;$j<5;++$j)
										{
											if($j<$AvgOfRates[0])
												echo "<i class='fa fa-star'></i>";
											else
												echo "<i class='fa fa-star-o'></i>";
										}
										echo "</div>";
									}
									?>
									<span>(Overall)</span>
								</h4>
								<span>Based on 
								<?php 
									$totalNumberOfRates1=0;
									foreach($t_n_o_r as $TTT)
									{
										$totalNumberOfRates1+=$TTT[0];
										echo $totalNumberOfRates1;
									}
									?>
								
								Rates</span>
							</div>
							
							<?php foreach($r as $Rater){ ?>
							<div class="rattings-wrapper">
							
								
								<div class="sin-rattings">
									<div class="ratting-author">
										<h3><?php echo "$Rater[0] $Rater[1]"; ?> </h3>
                                        <?php 
										
										echo "<div class='sin-list float-left'>";
										for($j=0;$j<5;++$j)
										{
											if($j<$Rater[2])
												echo "<i class='fa fa-star'></i>";
											else
												echo "<i class='fa fa-star-o'></i>";
										}
										echo "</div>";
									
									echo "</div>";
									echo "<p>$Rater[3]</p>";
                                    echo "</div>";
                                     } ?>
                                <hr>
							</div>
                            <div>
                            <?php $r_count= $reply->rowCount(); if($r_count != 0){
                                echo "<h4 class='nice'>Reply</h4>";
                            }?>
                                <?php
                                    foreach($reply as $r){
                                        echo '<b>'.$r['Fname'].' reply to '.$r['username'].' by : </b>'.$r['reply'].'</br>';
                                    }
                                ?>
                            </div>
                            <?php
                               if(isset($_SESSION['activeuser']) && $c  != 0  && $n == 0){

							?>
                                <hr>
                                <h4 class='nice'>Rate Here</h4>
								<form method='post'>
								    <div class="ratting-form row ml-15">
										<div class="col-12 mb-15">
											<h5  class="">Rating:</h5>
											<span onmouseover="starmark(this)" onclick="starmark(this)" id="1one" style="font-size:20px;cursor:pointer;"  class="fa fa-star checked"></span>
											<span onmouseover="starmark(this)" onclick="starmark(this)" id="2one"  style="font-size:20px;cursor:pointer;" class="fa fa-star "></span>
											<span onmouseover="starmark(this)" onclick="starmark(this)" id="3one"  style="font-size:20px;cursor:pointer;" class="fa fa-star "></span>
											<span onmouseover="starmark(this)" onclick="starmark(this)" id="4one"  style="font-size:20px;cursor:pointer;" class="fa fa-star"></span>
											<span onmouseover="starmark(this)" onclick="starmark(this)" id="5one"  style="font-size:20px;cursor:pointer;" class="fa fa-star"></span>
											<br/><br/>

										</div>
										
										<input id="rate" type="hidden" name="rating" value="">
                                        <input type="hidden" name="d" value="<?php echo $id;?>">

										
										<div class="col-12 mb-15">
											<label for="your-review">Your Review:</label>
											<textarea name="review" id="your-review" placeholder="Write a review"></textarea>
										</div>
										<div class="col-12">
											<input value="add review"  type="submit" class="btn btn-lg btn-success mb-15" onclick="send()" />
										</div>
								    </div>
								</form>
                            <?php 
                            }
                            if(isset($_SESSION['activeuser']))
                                if($n !=0 ) {
                                    echo'<hr>';
                                    echo "You have already reviewd this dish";}	?>
                                

						</div>
                        
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>
</div><!-- Single Product Section End -->

<!-- Related desh Section Start -->
<div class="product-section section mb-70 mt-30">
    <div class="container">
        <div class="row">
            
            <!-- Section Title Start -->
            <div class="col-12 mb-40">
                <div class="section-title-one" data-title="RELATED DISH"><h1>RELATED Dish</h1></div>
            </div><!-- Section Title End -->
            
            <!-- dish Tab Content Start -->
            <div class="col-12">
                        
                <!-- dish Slider Wrap Start -->
                <div class="product-slider-wrap product-slider-arrow-one">
                    <!-- dish Slider Start -->
                    <div class="product-slider product-slider-4">
                    <?php 
                        $relnum=0;
                        foreach($rel_dish as $row) {
                            if($relnum != 10) { ?>

                        <div class="col pb-20 pt-10">
                            <!-- dish Start -->
                            <div class="ee-product">

                                <!-- Image -->
                                <div class="image">

                                <a href="single-dish.php?Dname=<?php echo $row["did"]?>" class="img"><img src="assets/images/pic/category/<?php echo $row["type"].'/'.$row["pic"]?>" width="270" height="320" alt="Product Image"></a>                                    
                                <a href="#" class="add-to-cart"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></a>

                                </div>

                                <!-- Content -->
                                <div class="content">

                                    <!-- Category & Title -->
                                    <div class="category-title">

                                        <a href="#" class="cat"><?php echo $row["type"]?></a>
                                        <h5 class="title"><a href="single-dish.php?d='<?php echo $k ?>'"><?php echo $row["name"]?></a></h5>

                                    </div>

                                    <!-- Price & Ratting -->
                                    <div class="price-ratting">

                                        <h5 class="price"><?php echo $row["price"]?></h5>
                                        <div class="ratting">
                                        <?php for($i=0 ; $i < $row["rate"] ; ++$i)
                                                    echo "<i class='fa fa-star'></i>";?>
                                    </div>

                                    </div>

                                </div>

                            </div><!-- dish End -->
                        </div>

                        <?php ++$relnum; }} ?>


                    </div><!-- Product Slider End -->
                </div><!-- Product Slider Wrap End -->
                        
            </div><!-- Product Tab Content End -->
            
        </div>
    </div>
</div><!-- Related Product Section End -->

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
            </div><!-- Footer Widget End -->
            
            <div class="row">
                
                <!-- Footer Widget Start -->
                <div class="col-lg-4 col-md-6 col-12 mb-40">
                    <div class="footer-widget">
                       
                        <h4 class="widget-title">CONTACT INFO</h4>
                        
                        <p class="contact-info">
                            <span>Address</span>
                            <?php
                            
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

<script>
var count;
function starmark(item)
{
count=item.id[0];
sessionStorage.starRating = count;
var subid= item.id.substring(1);
for(var i=0;i<5;i++)
{
if(i<count)
{
document.getElementById((i+1)+subid).style.color="#f5d730";
}
else
{
document.getElementById((i+1)+subid).style.color="#000";
}
}
}
function send()
{
    document.getElementById("rate").value = count;
}



</script>

</body>

</html>