<?php
session_start();
extract($_GET);
        

if(!isset($_SESSION['admin'])){
    header('location: login.php');
    die();
}

if(isset($out)){
    unset($_SESSION['admin']);
    header('location: login.php');
    die();
}

if(!isset($sv)){
    unset($_SESSION['admin']);
    header('location: login.php');
    die();
}


    $staffun = $_SESSION['admin'][0];
    $staffid = $_SESSION['admin'][1];


    try{
        require("connection.php");

        switch ($sv) {
            case 'd':
                $sview_sql = "select * from dish INNER JOIN category ON dish.ct_id = category.qid where name like '$n%' ;";
                $cat_sql = "select * from category ";
                $offer_sql = "select * from offer;";
                break;
            
            case 's':
                $sview_sql = "select * from staff where username = '$n';";
                break;
            
            case 'c':
                $sview_sql = "select * from customer where username = '$n';";
                break;

            case 'o':
                $sview_sql = "select * 
                from ordering,customer,address,payment
                where customer.cid = ordering.cid
                and   ordering.location = address.lid
                and payment.pid = ordering.pid
                and oid='$n';";

                $detail_sql = "select * from orderdetail, dish WHERE dish.did = orderdetail.did and oid=$n;";
                $detail = $db->query($detail_sql);
                break;
            
        }

      
    
    
       
        $sview= $db->query($sview_sql);

        if($sv == 'd')
            {
                $cat = $db->query($cat_sql);
                $offer = $db->query($offer_sql);
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
        .nice-text{
            border-radius:3%;
                }

        #sub{background:#f5d730; color:#000; border:none;  border-radius:10px;}
        #sub:hover{background:#000; color:#f5d730;}        
        
        .dish-pic {
    max-width: 300px;
    max-height: 300px;
}
    
    
    </style>
</head>

<body>
<div class="header-section section">    
<div class="header-top header-top-one header-top-border pt-10 pb-10">
        <div class="container">
            <div class="row align-items-center justify-content-between">


                <div class="col order-2 order-xs-2 order-lg-12 mt-10 mb-10">
                    <!-- Header Account Links Start -->
                    <div class="header-account-links">
                    <a href="adminaccount.php"><i class="icofont icofont-user-alt-7"></i> <span><?php echo $staffun;?></span></a>
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



<?php
    if($sv == 'd'){?>
<div class="register-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 d-flex">
                <div class="ee-register">    
                    <form action="ad-update.php" method='post'>
                        <div class="row">
                        <?php foreach($sview as $row){?>
                            <div class="col-12 mb-30"><h4><b>Dish</b></h4><input name='dish' value='<?php echo $row['name'];?>'> 
                            <input type="hidden" name="old" value='<?php echo $row['did'];?>'>
                            <input type="hidden" name="old_cat" value='<?php echo $row['type'];?>'>
                            <input type="hidden" name="old_pic" value='<?php echo $row['pic'];?>'>

                            </div>
                            <div class="col-12 mb-30"><h4><b>Category</b></h4>
                                <select name="cat" class="nice-select">
                                    <option value="<?php echo $row['qid'].'!'.$row['type'];?>"><?php echo $row['type'];?></option>
                                    <?php foreach($cat as $k){?>
                                            <option value='<?php echo $k['qid'].'!'.$k['type'];;?>'><?php echo $k['type'];?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="col-12 mb-30"><h4><b>Description</b></h4><textarea name="desc" rows='10' cols='50' class='nice-text'><?php echo $row['description'];?></textarea></div>                          
                            <div class="col-12 mb-30"><h4><b>Price</b></h4><input type='number' min='0.001' step='0.001' name='price' value='<?php echo $row['price'];?>'></div>                            
                        <?php }?> 

                            <div class="col-12 ml-150"><input  id='sub' type="submit" value="Save" name='dish_up'></div>   
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-5 col-12 d-flex">
                <div class="ee-account-image">                    
                <img class="dish-pic " src="assets/images/pic/category/<?php echo $row["type"].'/'.$row["pic"]?>" with='500' hight='500'>
                <form action="dish_pic.php?t=<?php echo $row['type']?>&n=<?php echo$row['name']?>" method="post" enctype="multipart/form-data">
                    <div class="ml-50 mt-20"> <input type="file" name="myfile"  class='.file-upload' id="fileToUpload"></div>
                    <div class="mt-10"> <input type="submit" name="submit" value="Upload"></div>
                </form>              
                 </div>   
            </div>
    </div>
</div>
<?php }?>


<?php
    if($sv == 'c'){?>
<div class="register-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 d-flex">
                <div class="ee-register">    
                    <form action="ad-update.php" method='post'>
                        <div class="row">
                        <?php foreach($sview as $row){?>
                            <div class="col-12 mb-30"><h4><b>Username</b></h4><input name='username' value='<?php echo $row['username'];?>'>
                            <input type="hidden" name="old" value='<?php echo $row['username'];?>'>
                            </div>
                            <div class="col-12 mb-30"><h4><b>Fisrt Name</b></h4><input name='Fname' value='<?php echo $row['Fname'];?>'></div>
                            <div class="col-12 mb-30"><h4><b>Last Name</b></h4><input name='Lname' value='<?php echo $row['Lname'];?>'></div>
                            <div class="col-12 mb-30"><h4><b>Email</b></h4><input name='Email' value='<?php echo $row['Email'];?>'></div>                        

                        <?php }?> 
                            <div class="col-12 ml-150">
                            <input  id='sub' type="submit" value="Save" name='cus_up'>
                            </div>      
                        </div>
                    </form>
                    <button id='sub' class='btn ml-160' onclick="window.location.href='cus-staf.php?t=c&i=<?php echo $row['cid'];?>'">Staff<i class="fa fa-exchange ml-15" aria-hidden="true"></i></button>

                </div>
            </div>
    </div>
</div>
<?php }?>



<?php
    if($sv == 's'){?>
<div class="register-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 d-flex">
                <div class="ee-register">    
                    <form action="ad-update.php" method='post'>
                        <div class="row">
                        <?php foreach($sview as $row){?>
                            <div class="col-12 mb-30"><h4><b>Username</b></h4><input name='username' value='<?php echo $row['username'];?>'>
                            <input type="hidden" name="old" value='<?php echo $row['username'];?>'>
                            </div>
                            <div class="col-12 mb-30"><h4><b>Fisrt Name</b></h4><input name='Fname' value='<?php echo $row['Fname'];?>'></div>
                            <div class="col-12 mb-30"><h4><b>Last Name</b></h4><input name='Lname' value='<?php echo $row['Lname'];?>'></div>
                            <div class="col-12 mb-30"><h4><b>Job</b></h4>
                                <select name="job" class="nice-select">
                                    <?php switch ($row['type']) {
                                            case 'A':
                                                $job = 'Admin';
                                                break;
                                            case 'C':
                                                $job = 'Cooker';
                                                break;
                                            case 'D':
                                                $job = 'Driver';
                                                break;    
                                        }?>
                                        <option value="<?php echo $row['type'];?>"><?php echo $job;?></option>
                                        <option value='A'>Admin</option>
                                        <option value='C'>Cooker</option>
                                        <option value='D'>Driver</option>
                                </select>
                            </div>
                            <div class="col-12 ml-170">
                            <input  id='sub' type="submit" value="Save" name='stf'>
                            </div>         
                        </div>
                    </form>
                    <button id='sub' class='btn ml-160' onclick="window.location.href='cus-staf.php?t=s&i=<?php echo $row['sid'];?>'">Customer<i class="fa fa-exchange ml-15" aria-hidden="true"></i></button>

                </div>
            </div>
    </div>
</div>
<?php } }?>

<?php
    if($sv == 'o'){?>
<div class="register-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 d-flex">
                <div class="ee-register">    
                    <form action="ad-update.php" method='post'>
                        <div class="row">
                        <?php foreach($sview as $row){?>
                            <div class="col-12 mb-30"><h4><b>Order ID</b></h4><h4 class='ml-20'><?php echo $row['oid'];?></h4></div>
                            <div class="col-12 mb-30"><h4><b>Customer</b></h4><h4 class='ml-20'><?php echo $row['username'];?></h4></div>
                            <div class="col-12 mb-30"><h4><b>Date</b></h4><h4 class='ml-20'><?php echo $row['date'];?></h4></div>
                            <div class="col-12 mb-10"><h4><b>Address:-</b></h4></div>
                            <div class="col-12 mb-30"><h4><b>City: </b><?php echo $row['city'];?></h4><h4><b>Street: </b><?php echo $row['street'];?></h4><h4><b>Building: </b><?php echo $row['building'];?></h4></div>
                            <div class="col-12 mb-30"><h4><b>payment Method</b></h4><h4 class='ml-20'><?php echo $row['type'];?></h4></div>
                            <div class="col-12 mb-30"><h4><b>Order State</b></h4><h4 class='ml-20'>
                            <?php 
                                switch ($row['state']) {
                                    case 'C':
                                        echo 'Cooking';
                                        break;
                                    case 'D':
                                        echo 'Delivering';
                                        break;
                                    case 'F':
                                        echo 'Finished';
                                        break;                                                                        
                                }
                            ?>
                            </h4></div>

                        <?php } ?>
                            <div class="col-12 ml-150">
                            <button type="button"  class="btn btn-outline-warning mt-10 ml-60" onclick="window.location.href='adminview.php?v=o'"><i class="fa fa-arrow-circle-left mr-5"></i>Back</button></td></tr>                            
                            </div>      
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-5 col-12 d-flex">                  
                <div class="col-12 mb-30">
                <h4><b>Order Details:- </b></h4>
                <h4><b>Dishs: </b></h4>
                <?php $total=0; foreach($detail as $row){?>
                <h4 class='ml-20'><?php echo $row['name'];?>... Unite Price: <?php echo $row['price'];?>BD NO. <?php echo $row['qty'];?></h4>
                <?php $total+= ($row['price'] * $row['qty']); } ?>
                <h4><b>----------------------------</b></h4>
                <h4><b>Total: <?php echo $total;?> BD</b></h4>
                </div>
            </div>
    </div>
</div>
<?php }?>

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