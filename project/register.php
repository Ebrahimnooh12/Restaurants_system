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
    <title>D&D - Food Ordring Registration</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">

    <!-- CSS
	============================================ -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Bootstrap CSS -->


    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/icon-font.min.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script>
        var xmlHttp;
        var isVaild;
        var ava = false;
        var avaemail = false;
        var firstn = false,
            lastn = false,
            username = false,
            pass1 = false,
            pass2 = false,
            email = false;

        function GetXmlHttpObject() {
            var xmlHttp = null;
            try {
                // Firefox, Opera 8.0+, Safari 
                xmlHttp = new XMLHttpRequest();
            } catch (e) {
                // Internet Explorer 
                try {
                    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
            }
            return xmlHttp;
        }


        function register() {

            // xmlHttp = GetXmlHttpObject();
            // if (xmlHttp == null) {
            //     alert("Your browser does not support AJAX!");
            //     return;
            // }
            

            var url = "register-server.php";
            url = url + "?first=" + document.getElementById("regform").elements["fn"].value;
            url = url + "&last=" + document.getElementById("regform").elements["ln"].value;
            url = url + "&email=" + document.getElementById("regform").elements["em"].value;
            url = url + "&un=" + document.getElementById("regform").elements["un"].value;
            url = url + "&ps=" + document.getElementById("regform").elements["ps"].value;
            url = url + "&ps1=" + document.getElementById("regform").elements["cps"].value;
            // url = url + "&sid=" + Math.random();

            // xmlHttp.onreadystatechange = stateChanged;
            // xmlHttp.open("GET", url, true);
            // xmlHttp.send(null);

            //it work like this without ajax
            window.location.href = url;
        }

        function stateChanged() {
            var msg = xmlHttp.responseText;
            if (msg == "no") {
                document.getElementById("sign_btn").disabled = true;
                document.getElementById('regStatus').innerHTML = "<h4>Registration is not complete<h4>";
            } else {
                document.getElementById("sign_btn").disabled = false;
                document.getElementById('regStatus').innerHTML = "<h4>Registration is complete<h4>";
            }
        }



        function validate(str, type) {


            switch (type) {
                case 1:

                    if (str != "") {
                        firstn = true;
                    } else {
                        firstn = false;
                    }
                    break;
                case 2:
                    if (str != "" && firstn == true) {
                        lastn = true;
                        document.getElementById("ln_status").style.visibility = "";
                        document.getElementById("ln_status").innerHTML = '<i class="far fa-check-circle"></i>';
                        document.getElementById("em_msg").style.visibility = "hidden";
                        btn_dis();
                    } else {
                        lastn = false;
                        document.getElementById("ln_status").style.visibility = "";
                        document.getElementById("ln_status").innerHTML = '<i class="far fa-times-circle"></i>';
                        document.getElementById("em_msg").style.visibility = "";
                        document.getElementById("em_msg").innerHTML = '<h5>Only english alphabet is allowd for names</h5>';
                    }
                    break;
                case 3:
                    if (/^[A-z]\w{4,15}$/.test(str) && ava == true) {
                        username = true;
                        document.getElementById("em_msg").style.visibility = "hidden";
                        document.getElementById("ur_status").style.visibility = "";
                        document.getElementById("ur_status").innerHTML = '<i class="far fa-check-circle"></i>';
                        btn_dis();
                    } else {
                        username = false;
                        document.getElementById("ur_status").style.visibility = "";
                        document.getElementById("ur_status").innerHTML = '<i class="far fa-times-circle"></i>';
                        document.getElementById("em_msg").style.visibility = "";
                        document.getElementById("em_msg").innerHTML = '<h5>Username is taken/should be more than 4 characters</h5>';
                    }
                    break;
                case 4:
                    if (/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d^a-zA-Z0-9].{4,20}$/.test(str)) {
                        pass1 = true;
                        document.getElementById("em_msg").style.visibility = "hidden";
                        document.getElementById("ps_status").style.visibility = "";
                        document.getElementById("ps_status").innerHTML = '<i class="far fa-check-circle"></i>';
                        btn_dis();
                    } else {
                        pass1 = false;
                        document.getElementById("ps_status").style.visibility = "";
                        document.getElementById("ps_status").innerHTML = '<i class="far fa-times-circle"></i>';
                        document.getElementById("em_msg").style.visibility = "";
                        document.getElementById("em_msg").innerHTML = '<h5>should be between 4-20 characters</h5>';
                    }
                    break;
                case 5:
                    pastmp = document.getElementById("regform").elements["ps"].value;
                    if (pastmp == str) {
                        pass2 = true;
                        document.getElementById("em_msg").style.visibility = "hidden";
                        document.getElementById("cps_status").style.visibility = "";
                        document.getElementById("cps_status").innerHTML = '<i class="far fa-check-circle"></i>';
                        btn_dis();
                    } else {
                        pass2 = false;
                        document.getElementById("cps_status").style.visibility = "";
                        document.getElementById("cps_status").innerHTML = '<i class="far fa-times-circle"></i>';
                        document.getElementById("em_msg").style.visibility = "";
                        document.getElementById("em_msg").innerHTML = '<h5>Password is not matched</h5>';
                    }
                    break;
                case 6:
                    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(str) && avaemail == true) {
                        email = true;
                        document.getElementById("em_msg").style.visibility = "hidden";
                        document.getElementById("em_status").style.visibility = "";
                        document.getElementById("em_status").innerHTML = '<i class="far fa-check-circle"></i>';
                        btn_dis();
                    } else {
                        email = false;
                        document.getElementById("em_status").style.visibility = "";
                        document.getElementById("em_status").innerHTML = '<i class="far fa-times-circle"></i>';
                        document.getElementById("em_msg").style.visibility = "";
                        document.getElementById("em_msg").innerHTML = '<h5>Email is taken/syntax error</h5>';
                    }
                    break;

            }

        }

        function btn_dis() {
            if (firstn == true && lastn == true && pass1 == true && pass2 == true && email == true && username ==
                true) {
                document.getElementById("rbtn").disabled = false;
            } else {
                document.getElementById("rbtn").disabled = true;
            }
        }

        function available() {

            xmlHttp = GetXmlHttpObject();
            if (xmlHttp == null) {
                alert("Your browser does not support AJAX!");
                return;
            }

            var url = "ava-username.php";
            url = url + "?str=" + document.getElementById("regform").elements["un"].value;
            url = url + "&sid=" + Math.random();
            xmlHttp.onreadystatechange = isavailable;
            xmlHttp.open("GET", url, false);
            xmlHttp.send(null);
        }

        function isavailable() {

            if (xmlHttp.responseText == "no")
                ava = true;
            else
                ava = false;

            // console.log(ava);
        }


        function availableEmail() {

            xmlHttp = GetXmlHttpObject();
            if (xmlHttp == null) {
                alert("Your browser does not support AJAX!");
                return;
            }

            var url = "ava-email.php";
            url = url + "?str=" + document.getElementById("regform").elements["em"].value;
            url = url + "&sid=" + Math.random();
            console.log(url);
            xmlHttp.onreadystatechange = isavailableEmail;
            xmlHttp.open("GET", url, false);
            xmlHttp.send(null);
            }

            function isavailableEmail() {

            if (xmlHttp.responseText == "no")
                avaemail = true;
            else
                avaemail = false;

            // console.log(ava);
            }
    </script>

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
                                <img src="assets/images/pic/logo.png" width="100" height="100">
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
                <a class="image"><img src="<?php echo $p?>" alt="Product"></a>
                <div class="content">
                    <a href="single-dish.php?d='<?php echo $k ?>'" class="title"><?php echo $name ?></a>
                    <span class="price"><?php echo $price ?>BD</span>
                    <span class="qty">Qty:<?php echo $q ?></span>
                </div>
                <button class="remove" onclick="window.location.href='index.php?state=1&id=<?php echo $k ?>'"><i
                        class="fa fa-trash-o"></i></button>
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
                    <h1>Register</h1>
                </div>
            </div>

            <!-- Banner -->
            <div class="col-lg-4 col-md-6 col-12 order-lg-1">
                <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage (1).jpg" width="570"
                            height="232" alt="Banner"></a></div>
            </div>

            <!-- Banner -->
            <div class="col-lg-4 col-md-6 col-12 order-lg-3">
                <div class="banner"><a href="#"><img src="assets/images/pic/BeFunky-collage (1).jpg" width="570"
                            height="232" alt="Banner"></a></div>
            </div>

        </div>
    </div><!-- Page Banner Section End -->

    <!-- Register Section Start -->
    <div class="register-section section mt-40 mb-40 col-12">
        <div class="container">
            <div class="row">

                <!-- Register -->
                
                <div class="col-md-7 col-6 d-flex">


                    <!-- Register Form -->

                    <br>
                    <div class="ratting-form">
                        <noscript>
                            <H2 style="color:#FF0000">Please Enable JavaScript !</H2>
                        </noscript>
                        <h3>We will need for your registration</h3>
                        <br>
                        <form action="" id="regform" novalidate>


                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" aria-label="fname"
                                            placeholder="First Name" name="fn" onkeyup="validate(this.value,1)">
                                        <input type="text" class="form-control" aria-label="lname"
                                            placeholder="Last Name" name="ln" onkeyup="validate(this.value,2)"
                                            aria-describedby="ln_status">
                                        <div class="input-group-append " id="lname">
                                            <span class="input-group-text" style="visibility: hidden;"
                                                id="ln_status"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="Username" placeholder="User Name"
                                    name="un" onkeyup="available(); validate(this.value,3);"
                                    aria-describedby="ur_status">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="visibility: hidden;" id="ur_status"></span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="Email" placeholder="Email address"
                                    name="em" onkeyup="availableEmail(); validate(this.value,6);" aria-describedby="em_status" id="email">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="visibility: hidden;" id="em_status"></span>
                                </div>
                            </div>


                            <div class="input-group mb-3">
                                <input type="password" class="form-control" aria-label="Password" placeholder="Password"
                                    name="ps" onkeyup="validate(this.value,4)">
                                <div class="input-group-append" id="pass">
                                    <span class="input-group-text" style="visibility: hidden;" id="ps_status"></span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" aria-label="CPassword"
                                    placeholder="Confirm password" name="cps" onkeyup="validate(this.value,5)">
                                <div class="input-group-append" id="cpass">
                                    <span class="input-group-text" style="visibility: hidden;" id="cps_status"></span>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
                <div class="col-4"><br><br><br><span class="input-group-text" style="visibility: hidden;" id="em_msg"></span></div>
                <div class="col-12"><button class="btn btn-warning " id="rbtn" value="register" data-toggle="modal"
                        data-target="#Reg_Status" onclick="register()" disabled>Register </button>
                        </div>
            </div>
        
        </div>
    </div>
    </div>
    <!-- Register Section End -->
    <!-- Modal -->
    <div class="modal fade" id="Reg_Status" tabindex="-1" role="dialog" aria-labelledby="Reg_Status" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Registration Status</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="regStatus">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">dismiss</button>
                    <button type="button" class="btn btn-warning " id="sign_btn"
                        onclick="location.href='login.php'">Sign-In</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Model End -->
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
                        <button>subscribe</button>
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