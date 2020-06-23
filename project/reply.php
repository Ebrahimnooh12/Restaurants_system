<?php
session_start();
extract($_GET);
extract($_POST);
$flag = false;

if(!isset($_SESSION['admin']) && !isset($_SESSION['activestaff'])){
    header('location: login.php');
    die();
}
else
    {   
        if(isset($_SESSION['activestaff'])){   
            $staffun = $_SESSION['activestaff'][0];
            $staffid = $_SESSION['activestaff'][1];
            
            $reply_sql = " select username, name, r.rate, comment, rid
            from customer c, dish d, rate r
            where c.cid = r.cid
            and   d.did = r.did
            and rid not in ( select rateID
                             from reply);";

        } 
        else {
            $flag = true;
            $staffun = $_SESSION['admin'][0];
            $staffid = $_SESSION['admin'][1]; 
            
            $reply_sql = " select username, name, r.rate, comment, rid
            from customer c, dish d, rate r
            where c.cid = r.cid
            and   d.did = r.did
            and rid not in ( select rateID
                             from reply
                             Where sid = '$staffid'   
                            );";
        }

    }     



if(isset($out)){
    unset($_SESSION['admin']);
    unset($_SESSION['activestaff']);
    header('location: login.php');
    die();
}




try{
    require("connection.php");


    if(isset($reply))
	    {
		require('connection.php');
		$stmt = $db->exec("iNSERT INTO reply (rateID,reply,sid) VALUES ('$rateID', '$reply','$staffID')");
        }
    
        $reply= $db->query($reply_sql);
    
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
     .delete:hover{color:red;cursor:pointer}
     .info:hover{color:#f5d730; cursor:pointer}

    #contact:hover { background: #666; }
    #contact:active { background: #444; }

    #confirm { 
    display: none;

    border: 3px solid #f5d730; 
    padding: 2em;
    width: 400px;
    text-align: center;
    background: #fff;
    position: fixed;
    top:50%;
    left:50%;
    transform: translate(-50%,-50%);
    -webkit-transform: translate(-50%,-50%);
    z-index:1000

  
    }


    </style>
  
</head>

<div id="confirm">

  
  <form action="#">
    <h2>Are You Sure ?</h2>
      
    <input type="submit" value="confirm">

    <div class="button mt-5">
        <a id='cancel' href="#">Cancel</a>
    </div> 
  </form>
</div>



<body>
<div class="header-section section">    
<div class="header-top header-top-one header-top-border pt-10 pb-10">
        <div class="container">
            <div class="row align-items-center justify-content-between">


                <div class="col order-2 order-xs-2 order-lg-12 mt-10 mb-10">
                    <!-- Header Account Links Start -->
                    <div class="header-account-links">
                    <?php if($flag == true) {?>
                    <a href="adminaccount.php"><i class="icofont icofont-user-alt-7"></i> <span><?php echo $staffun;?></span></a>
                    <a href="AdminDashBoard.php?out=1"><i class="icofont icofont-login d-none"></i> <span>Logout</span></a>
                    <?php }
                    else
                        {
                    ?>
                    <a href="staffaccount.php"><i class="icofont icofont-user-alt-7"></i> <span><?php echo $staffun;?></span></a>
                    <a href="StaffDashBoard.php?out=1"><i class="icofont icofont-login d-none"></i> <span>Logout</span></a>
                    <?php } ?>
                    </div><!-- Header Account Links End -->
                </div>

            </div>
        </div>
    </div><!-- Header Top End -->

    <!-- Header Bottom Start -->
    <div class="header-bottom header-bottom-one header-sticky">
        <div class="container">
            <div class="row align-items-center">
            <?php if($flag == true) {?>
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
                                                <li><a href="add-coupon.php">ADD Coupon</a></li>
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
                    <?php }
                    else
                        {
                    ?>
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
                   <div class="main-menu"  style='margin-left:35%'>
                        <nav>
                            <ul>
                                <li class="active"><a href="StaffDashBoard.php?s=<?php echo $s?>">ORDER</a></li>
                                <li class="menu-item-has-children"><a href="#">DISH</a>
                                    <ul class="mega-menu two-column">
                                        <li><a href="view.php?v=d&s=<?php echo $s?>">VIEW DISH</a></li>
                                        <li><a href="reply.php?s=<?php echo $s?>">REPLY</a></li>
                                    </ul>
                                </li>
                                <li><a href="staffaccount.php?s=<?php echo $s?>">MY ACCOUNT</a></li>

                            </ul>
                        </nav>
                    </div><!-- Main Menu End -->
                        <?php }?>
                </div>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu order-12 d-block d-lg-none col"></div>

            </div>
        </div>
    </div><!-- Header Bottom End -->
</div>

<!-- Header Advance Search Start -->
<div style='float: left; margin-left:45%'>
    <form action="#">
        <div class="input">
            <input id='myInput' class='form-control mt-1' type="text" placeholder="Search">                     
            <button type="button"  class="btn btn-outline-warning mt-15 ml-35" onclick="window.location.href='adminview.php?v=reply'">View Replys</button>                    
        </div>
    </form>

</div><!-- Header Advance Search End -->
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
                                
                                    <th class="pro-price">Customer Name</th>
                                    <th class="pro-price">Dish Name</th>
                                    <th class="pro-price">Rate</th>
                                    <th class="pro-price">Comment</th>
                                    <th class="pro-price">Reply</th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <?php
                            if($reply->rowCount()==0){  ?>
                                        <tbody>
                                            <tr><th class='empty' colspan='7'>EMPTY</th></tr>
                                        </tbody>



                            <?php } 
                            else {
                                    foreach($reply as $row) {
                             ?>
                            <tbody id='myTable'>
                                <tr>
                                    <td class="pro-title"><?php echo $row['username'] ?></td>
                                    <td class="pro-title"><?php echo $row['name'] ?></td>
                                    <td class="pro-title">
                                        <div class="ratting">
                                            <?php for($i=0 ; $i < $row["rate"] ; ++$i)
                                            echo "<i class='fa fa-star'></i>";?>
                                        </div>
                                    </td>
                                    <td class="pro-title"><?php echo $row['comment'] ?></td>
                                    <td>
                                    <form method="post">
                                    <textarea name="reply" id="your-review" placeholder="Write a reply"></textarea>
                                    <input type='hidden' name='staffID' value= '<?php echo $staffid ?>'/>
                                    <input type='hidden' name='rateID' value='<?php echo $row['rid'] ?>' />
                                    <input type="submit" value="Send reply">    
                                    </form>

                                    </td>    
                                </tr>
                            </tbody>

                            <?php }}?>
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


<script>


$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>  

</body>

</html>