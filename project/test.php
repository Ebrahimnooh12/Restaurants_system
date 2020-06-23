

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

    <link href="https://fonts.googleapis.com/css?family=Anton&display=swap" rel="stylesheet">
    
    <style>
     .box {
         height: 300px;
         width: 200px;
         margin: 10px;
         border: 10px solid #92a8d1;
         position: relative;
         box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
     }

     .child {
        font-family: 'Anton', sans-serif;
        font-size: 70px;
        position: absolute;
        top: 42%;
        right:42%;

     }

     .lable {
        font-family: 'Anton', sans-serif;
        font-size: 25px;
     }
     .order-detail {
        top:70%; 
        position: absolute;
     }
     .order-detail-data {
        top:85%; 
        position: absolute;
     }


     .detail{
        font-family: 'Anton', sans-serif;
        font-size: 15px;
        display:inline-block;
     }

     
     .cooke{
         color:#ff6f69;
     }

     .Delivering{
        color:#ffcc5c;
     }

     .Done {
        color:#96ceb4;
     }

     .total-box {
        height: 300px;
         margin: 10px;
         border: 10px solid #c83349;
         position: relative;
         box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
     }

     .total {
        position: absolute;
        font-family: 'Anton', sans-serif;
        font-size: 90px;
        right: 42%;
        top:40px;
     }

     .total-num {
        position: absolute;
        font-family: 'Anton', sans-serif;
        font-size: 60px;
        right: 40%;
        top:60%;
     }
    

     
    
    
    </style>

<script>
function interval(){
    getEmoloyee();
    getCustomer();
    getOrder();
    getTotal();
    getCooking();
    getDelivring();
    getDone();
    var e = setInterval("getEmoloyee()",1000);
    var c = setInterval("getCustomer();",1000);
    var o = setInterval("getOrder();",1000);
    var t = setInterval("getTotal();",1000);
    var orderState = setInterval("getCooking();getDelivring();getDone();",1000);


}

function getEmoloyee() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                document.getElementById("emp").textContent =this.responseText;;
            }
        };
        xmlhttp.open("GET", "dashboarddata.php?state=e", true);
        xmlhttp.send();
    }

function getCustomer() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                document.getElementById("cus").textContent =this.responseText;;
            }
        };
        xmlhttp.open("GET", "dashboarddata.php?state=c", true);
        xmlhttp.send();
    } 

function getOrder() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                document.getElementById("order").textContent =this.responseText;;
            }
        };
        xmlhttp.open("GET", "dashboarddata.php?state=o", true);
        xmlhttp.send();
    }

function getTotal() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                document.getElementById("tot").textContent =this.responseText;;
            }
        };
        xmlhttp.open("GET", "dashboarddata.php?state=t", true);
        xmlhttp.send();
    }    


function getCooking() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                document.getElementById("cok").textContent =this.responseText;;
            }
        };
        xmlhttp.open("GET", "dashboarddata.php?state=cooke", true);
        xmlhttp.send();
    }

function getDelivring() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                document.getElementById("deli").textContent =this.responseText;;
            }
        };
        xmlhttp.open("GET", "dashboarddata.php?state=deliver", true);
        xmlhttp.send();
    }

function getDone() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                document.getElementById("don").textContent =this.responseText;;
            }
        };
        xmlhttp.open("GET", "dashboarddata.php?state=done", true);
        xmlhttp.send();
    }    
</script>


</head>

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

<body onload="interval()">
<div class="header-section section">    
<div class="header-top header-top-one header-top-border pt-10 pb-10">
        <div class="container">
            <div class="row align-items-center justify-content-between">


                <div class="col order-2 order-xs-2 order-lg-12 mt-10 mb-10">
                    <!-- Header Account Links Start -->
                    <div class="header-account-links">
                    <a href="AdminDashBoard.php"><i class="icofont icofont-user-alt-7"></i> <span><?php echo $staffun;?></span></a>
                    <a href="AdminDashBoard.php?out=1"><i class="icofont icofont-login d-none"></i> <span>Logout</span></a>
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
                        <a href="AdminDashBoard.php">
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
                                <li class="active"><a href="AdminDashBoard.php">HOME</a></li>
                                <li class="menu-item-has-children"><a href="#">Resturant Managment</a>
                                    <ul class="mega-menu three-column">
                                        <li><a href="#">DISHS</a>
                                            <ul>
                                                <li><a href="adminview.php?v=d">VIEW DISH</a></li>
                                                <li><a href="add-dish.php">ADD DISH</a></li>
                                                <li><a href="adminview.php?v=g">CATEGORY</a></li>
                                                <li><a href="offer.php">OFFER</a></li>
                                                <li><a href="adminview.php?v=r">REVIWES</a></li>
                                                <li><a href="reply.php">REPLY</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">ACCOUNTS</a>
                                            <ul>
                                                <li><a href="adminview.php?v=s">STAFF</a></li>
                                                <li><a href="adminview.php?v=c">CUSTOMER</a></li>
                                            </ul>
                                        </li>

                                        <li><a href="#">RESTURANT</a>
                                            <ul>
                                                <li><a href="res-informaion.php">INFORAMATION</a></li>
                                                <li><a href="adminview.php?v=o">ORDER</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <li><a href="adminaccount.php">My ACCOUNT</a></li>

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

<div class="container">
  <div class="row">
    <div class="col box">
      <h2 class='lable' >Employee</h2>
      <h1 id='emp' class='child'> </h1>
    </div>
    <div class="col box">
     <h2 class='lable' >Customer</h2>   
     <h1 id='cus'  class='child'> </h1>

    </div>
    <div id='ord' class="col box">
    <h2 class='lable'>Order</h2>    
    <h1 id='order' class='child'> </h1>
     <div class="order-detail ml-20">
        <h4 class="detail mr-30 ml-10 cooke">Cooking : <span id='cok'> </span></h4>
        <h4 class="detail mr-15 Delivering">Delivering : <span id="deli"> </span> </h4>
        <h4 class="detail ml-10 Done">Done : <span id="don"> </span></h4>
     </div>
  </div>
</div>

<div class='total-box'>
<h1 class='total'>TOTALE</h1>
<h2 id="tot"class="total-num"> </h2>
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