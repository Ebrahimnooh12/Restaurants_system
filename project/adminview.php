<?php
session_start();
extract($_GET);
extract($_POST);
           
if(!isset($_SESSION['admin'])){
    header('location: login.php');
    die();
}

if(isset($out)){
    unset($_SESSION['admin']);
    header('location: login.php');
    die();
}


    $staffun = $_SESSION['admin'][0];
    $staffid = $_SESSION['admin'][1];


    try{
        require("connection.php");

        switch ($v) {
            case 'd':
                $view_sql = "select name,did from dish ORDER BY name;";
                $h ='Dish';
                break;
            
            case 's':
                $view_sql = "select username,sid from staff ORDER BY username;";
                $h ='Staff Username';
                break;
            
            case 'c':
                $view_sql = "select username,cid from customer ORDER BY username;";

                $h ='Customer Username';
                break;

            case 'g':
                $view_sql = "select type,qid from category where qid != 25 ORDER BY type;";

                $h ='Category';
                $cat=true;
                break;

            case 'r':
                $view_sql = "SELECT rid,name, username,r.rate,comment
                from customer, dish , rate r
                WHERE customer.cid = r.cid
                and   dish.did = r.did;";
                $h ='Rate ID';
                $rev =true;
                break;

            case 'reply':
                $view_sql = "SELECT rp.R_id, c.username, s.username, d.name ,r.rate, r.comment, rp.reply 
                from customer c, staff s, rate r, reply rp, dish d
                WHERE c.cid = r.cid
                AND   s.sid = rp.sid
                AND   d.did = r.did
                AND   r.rid = rp.rateID;";

                $h ='Reply ID';
                $rep =true;
                break; 
                
            case 'o':
                $view_sql = "SELECT oid from ordering order by date;";

                $h ='Order ID';
                break;      
        }


        if(isset($add)) {
            $stmt = $db->prepare("INSERT INTO category (type) VALUES (:type)");
            $stmt->bindParam(':type', $category_name);

            $stmt->execute();


        }

      
           
        $view= $db->query($view_sql);
    
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

    #form { 
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

<body>


<div id="form">
<form method='post'>
<div class="input-group mb-3">
  <input name='category_name' type="text" class="form-control" placeholder="Qategory" aria-label="Recipient's username" aria-describedby="basic-addon2">
  <div class="input-group-append ml-15">
    <input type="submit" value="ADD" name='add'>
  </div>
</div>
</form>
</div>


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
                </div>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu order-12 d-block d-lg-none col"></div>

            </div>
        </div>
    </div><!-- Header Bottom End -->
</div>

<!-- Header Advance Search Start -->
<div style='float: left; margin-left:45%'>
        <div class="input"><input id='myInput' class='form-control mt-1' type="text" placeholder="Search"></div>
        <?php if(isset($cat)) { ?>
        <button id='add' type="button" class="btn btn-outline-warning mt-15 ml-60">ADD</button>  
        <?php } ?>  
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
                                    <th class="pro-price"><?php echo $h?></th>
                                    <?php 
                                    if(isset($rev)){?>
                                        <th>Dish</th>
                                        <th>Customer</th>
                                        <th>Rate</th>
                                        <th>Comment</th>
                                    <?php
                                    }
                                    else{
                                    if(isset($rep)) 
                                    {?>

                                        <th>staff</th>
                                        <th>Customer</th>
                                        <th>Dish</th>
                                        <th>Rate</th>
                                        <th>Comment</th>
                                        <th>Reply</th>
                                   <?php  }        

                                    if(!isset($cat) && !isset($rep) ){?>
                                    <th>Detail</th>
                                    <?php }
                                    if(!isset($rep)){
                                    ?>
                                    <th>Remove</th>
                                    <?php }}?>
                                </tr>
                            </thead>
                            
                            <?php
                            if($view->rowCount()==0){  ?>
                                        <tbody>
                                            <tr><th class='empty' colspan='7'>EMPTY</th></tr>
                                        </tbody>



                            <?php } 
                            else {
                                    foreach($view as $row) {
                             ?>
                            <tbody id='myTable'>
                                <tr>
                                    <td class="pro-title"><?php echo $row['0'] ?></td>
                                    <?php
                                        if(isset($rev)){?>
                                            <td class="pro-title"><?php echo $row['1'] ?></td>
                                            <td class="pro-title"><?php echo $row['2'] ?></td>
                                            <td class="pro-title"><?php echo $row['3'] ?></td>
                                            <td class="pro-title"><?php echo $row['4'] ?></td>


                                       <?php     
                                        }    
                                        else {
                                        if(isset($rep)){?>
                                            <td class="pro-title"><?php echo $row['2'] ?></td>
                                            <td class="pro-title"><?php echo $row['1'] ?></td>
                                            <td class="pro-title"><?php echo $row['3'] ?></td>
                                            <td class="pro-title"><?php echo $row['4'] ?></td>
                                            <td class="pro-title"><?php echo $row['5'] ?></td>
                                            <td class="pro-title"><?php echo $row['6'] ?></td>


                                       <?php     
                                        }         
                                        else{
                                        if(!isset($cat)){?>
                                    <td><a class='info' href='singleview.php?sv=<?php echo $v?>&n=<?php echo $row['0'] ?>'><i class="fa fa-info info"></i></a></td>
                                    <?php }?>
                                    <td><a class='delete' href='adminDelete.php?d=<?php echo $v?>&i=<?php echo $row['1']?>'><i class="fa fa-trash delete"></i></a></td>
                                        <?php }}?>
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

// user input : myInput
// the table to be search in it : myTable
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


$(function() {
  
  // contact form animations
  $('#add').click(function() {
    $('#form').fadeToggle();
  })
  $(document).mouseup(function (e) {
    var container = $("#form");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.fadeOut();
    }
  });
  
});

</script>  

</body>

</html>