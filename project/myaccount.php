<?php
session_start();
extract($_GET);
require("res_data.php");

if(isset($state)) {

    if($state == 1)
            unset($_SESSION['mycart'][$id]);
}


if(!isset($_SESSION['activeuser']) )
    {   
        header('location: login.php');
        die();

    }


try{
    require("connection.php");

    $sql = "select type from category ";
    $dishsql = "select * from dish INNER JOIN category ON dish.ct_id = category.qid ORDER BY RAND();";


    $rs2= $db->query($sql);
    $dish = $db->query($dishsql);

    if(isset($_SESSION['activeuser']))
    {
        $user=$_SESSION['activeuser'][0];
        $userid=$_SESSION['activeuser'][1];


        $account_sql="select * from customer where cid='$userid';";
        $adr_sql = "select * from address where cid='$userid'";
        $ctel_sql="select * from contact where cid='$userid';";

        $ctel = $db->query($ctel_sql);
        $account = $db->query($account_sql);
        $address = $db->query($adr_sql);

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
    <title>D&D - Food Ordring Myaccount</title>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <style>
        #delete:hover { color: red; }
        #sub:hover {background:#000;color:#f5d730;}
        #error {color:red;}
        #edit:hover{color:#f5d730;}
        #add:hover{color:#f5d730;}


        #propic {
            width:50px;  
            border-radius: 10%;
            border:1px solid #f5d730;
        }

        #propic:hover{
            border:1px solid #000;
        }
    
    #add-address{
    display: none;

    border: 3px solid #f5d730; 
    padding: 2em;
    width: 600px;
    text-align: center;
    background: #fff;
    position: fixed;
    top:50%;
    left:50%;
    transform: translate(-50%,-50%);
    -webkit-transform: translate(-50%,-50%);
    z-index:1000
    }
    .profile-pic {
    max-width: 300px;
    max-height: 300px;
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
<div id="add-address">
<form method='post' action="add-address.php">
    <h3>City</h3>
    <input type="text" name='city' required>
    <h3>Building</h3>
    <input type="number" name="buil" min='1' step='1'required>
    <h3>Street</h3>
    <input type="number" name="stre" min='1' step='1' required>
    </br></br>
    <input type="submit" value="ADD" name='add_a'>
</div>
</form>
</div>


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
                              foreach ($account as $row) {
                                     $u= $row['username'];
                                     $f= $row['Fname'];
                                     $l= $row['Lname'];
                                     $m= $row['Email'];
                                     $uP = $row['profile_pic']
                                  
                                  ?>
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
    
        <h4 class="sub-total">Total: <span> <?php echo $total ?> BD</span></h4>

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
                <h1>My Account</h1>
            </div>
        </div>

        <!-- Banner -->
        <div class="col-lg-4 col-md-6 col-12 order-lg-1">
            <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage (1).jpg" width="570" height="232" alt="Banner"></a></div>
        </div>

        <!-- Banner -->
        <div class="col-lg-4 col-md-6 col-12 order-lg-3">
            <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage (1).jpg" width="570" height="232" alt="Banner"></a></div>
        </div>

    </div>
</div><!-- Page Banner Section End -->

<!--  my account Start -->
<div class="register-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <!-- My account -->
            <div class="col-md-6 col-12 d-flex">
                <div class="ee-register">
                <?php if(isset($err))
                                        {   switch ($err) {
                                            case '5':
                                                echo "<span id='error' class='ml-10'>Invalid First name</span>";
                                                break;
                                            
                                            case '6':
                                                echo "<span id='error' class='ml-10'>Invalid Last name</span>";
                                                break;

                                            case '7':
                                                echo "<span id='error' class='ml-10'>Invalid Email number</span>";
                                                break;

                                            case '8':
                                                echo "<span id='error' class='ml-10'>Invalid Username number</span>";
                                                break;                                                                                                
                                        }
                                }    
                                 ?>            
                    <!-- my account Form -->
                    <form action="update.php" method='post'>
                        <div class="row">
                            <div class="col-12 mb-30"><h4><b>Username</b></h4><input required name='username' value='<?php echo $u;?>'></div>
                            <div class="col-12 mb-30"><h4><b>First Name</b></h4><input required name='fname' value='<?php echo $f;?>'></div>                          
                            <div class="col-12 mb-30"><h4><b>Last Name</b></h4><input required name='lname' value='<?php echo $l;?>'></div>                            
                            <div class="col-12 mb-30"><h4><b>Email</b></h4><input required type ="email" name='email' value='<?php echo $m;?>'></div>
                            <input type="hidden" name="pic" value= '<?php echo $uP;?>'>
                            <div class="col-12 mb-30"><h4><b>TEL</b></h4>
                            <?php foreach($ctel as $row) { ?>
                            <input type="hidden" name="telid[]" value='<?php echo $row['cnt_id'];?>'>
                            <input  required name='tel[]' class='mt-5' value='<?php echo $row['tel'];?>'>
                            <?php }?>
                            </div>

                            <div class="col-12 ml-150"><input  id='sub' type="submit" value="Save" name='info_u'></div>   

                            <div class="col-12 mb-30"><hr></div>

                        </div>
                    </form>
                </div>
            </div>
                        <!-- Account Image -->
            <div class="col-md-5 col-12 d-flex">
                <div class="ee-account-image">                    
                <img class="profile-pic" src="assets/images/userpic/<?php echo $uP;?>" with='500' hight='500'>
                <form action="uploadpic.php" method="post" enctype="multipart/form-data">
                    <div class="ml-30 mt-10"> <input type="file" name="myfile"  class='.file-upload' id="fileToUpload"></div>
                    <div class="mt-10"> <input type="submit" name="submit" value="Upload"></div>
                </form>              
                 </div>   
            </div>


            <div class="col-md-6 col-12 d-flex">
                <div class="ee-register">    
                    <!-- my account address Form  -->
                    <form action="update.php" method='post'>
                    <div class="row">
                        <div class="col-12 mb-30"><h4><b>Address</b></h4> <a id="add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        <?php if(isset($err))
                                        {   switch ($err) {
                                            case '1':
                                                echo "<span id='error' class='ml-10'>You can not be without an address !!, you can edit it for instead</span>";
                                                break;
                                            
                                            case '2':
                                                echo "<span id='error' class='ml-10'>Invalid City name</span>";
                                                break;

                                            case '3':
                                                echo "<span id='error' class='ml-10'>Invalid Building number</span>";
                                                break;

                                            case '4':
                                                echo "<span id='error' class='ml-10'>Invalid Street number</span>";
                                                break;                                                                                                
                                        }
                                }    
                                 ?>        
                        
                        </div>
                            <ol type="I">
                            <?php foreach($address as $row) {?> 

                            <li>
                            <div class="col-12 mb-30"><h4>
                                <b>Address</b></h4>   
                                <a id='<?php echo $row['lid'];?>' onclick='editAddress(this)'><i class="fa fa-pencil fa-lg mr-20"></i></a> 
                                <a href='update.php?locid=<?php echo $row['lid']; ?>&st=dl' id='delete'><i id='delete' class="fa fa-trash-o fa-lg "></i></a>   
                             </div>
                            <div class="col-12 mb-30"><h4>City</h4><input required class='<?php echo $row['lid'];?>' value='<?php echo $row['city'];?>'> </div>
                            <div class="col-12 mb-30"><h4>Buliding</h4><input required type='number' class='<?php echo $row['lid'];?>' value='<?php echo $row['building'];?>'></div>
                            <div class="col-12 mb-30"><h4>Streat</h4><input required type='number' class='<?php echo $row['lid'];?>' value='<?php echo $row['street'];?>'>
                            </div>
                            </li>
                            <?php }?>  
                            </ol>  
                        </div>
                </div>
                            </form>
            </div>

        </div>
    </div>
</div><!-- my account Section End -->

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
$(function() {
  // contact form animations
  $('#add').click(function() {
    $('#add-address').fadeToggle();
  })
  $(document).mouseup(function (e) {
    var container = $("#add-address");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.fadeOut();
    }
  });
  
});

function editAddress(ID){
    var x = ID.id;
    var elements = document.getElementsByClassName(x);

    for (var i = 0, len = elements.length; i < len; i++) {
          var city = elements[0].value;
          var building = elements[1].value;
          var street = elements[2].value;
    }
          var str = 'update.php?address='+x+'!'+city+'!'+building+'!'+street;


          window.location.href = str;


}
</script>
</body>



</html>