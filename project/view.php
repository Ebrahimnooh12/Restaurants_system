<?php
session_start();
extract($_POST);
extract($_GET);

           
if(!isset($_SESSION['activestaff'])){
    header('location: index.php');
    die();
}

if(isset($out)){
    unset($_SESSION['activestaff']);
    header('location: index.php');
    die();
}

try{
    require("connection.php");

    if(isset($sub)){
    switch ($sub) {
        case 'filter':
            $dishsql = "select * from dish INNER JOIN category ON dish.ct_id = category.qid  WHERE type='$c_type' ORDER BY name;";
            break;
        
        case 'sort':
            if($sort == 'h')
                $dishsql = "select * from dish INNER JOIN category ON dish.ct_id = category.qid ORDER BY price DESC;";
            else
                $dishsql = "select * from dish INNER JOIN category ON dish.ct_id = category.qid ORDER BY $sort;";
        break;
    }
}

    else {
        $dishsql = "select * from dish INNER JOIN category ON dish.ct_id = category.qid ORDER BY name;";
    }

    $catsql = "select type from category ";

    $dish = $db->query($dishsql);
    $cat = $db->query($catsql);


    $db = null;
    

}

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

    $staffun = $_SESSION['activestaff'][0];
    $staffid = $_SESSION['activestaff'][1];




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
        #search{
            float: left;
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
                        <a href="staffaccount.php"><i class="icofont icofont-user-alt-7"></i> <span><?php echo $staffun;?></span></a>
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

                <div class="col order-12 order-lg-2 order-xl-2 d-none d-lg-block ">
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
                </div>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu order-12 d-block d-lg-none col"></div>

            </div>
        </div>
                            

    </div><!-- Header Bottom End -->
</div>

<!-- Header Advance Search Start -->
<div style='float: left; margin-left:35%'>
                        
    <form action="#">
        <div class="input"><input id='myInput' class='form-control mt-1' type="text" placeholder="Search your dish"></div>
    </form>
                    
</div><!-- Header Advance Search End -->


<!-- Header Advance filter Start -->
<div style='float: left; margin-left:30px'>
                        
    <form method='post'>
        <select class="nice-select mr-10" name='c_type'>
            <?php foreach($cat as $row){?>
            <option><?php echo $row['type'];?></option>
            <?php }?>
        </select>
        <input type="submit" value='filter' name='sub'>                             
    </form>

                    
</div><!-- Header Advance filter End -->

<!-- Header Advance sort Start -->

<div style='float: left; margin-left:20px'>

    <form method='post'>
        <select class="nice-select mr-10" name='sort'>

            <option value='price'>Low Price</option>
            <option value='h'>height Price</option>
            <option value='name' >Dish</option>
            <option value='type'>Category</option>

        </select>
        <input type="submit" value='sort' name='sub'>                             
    </form>

</div><!-- Header Advance sort End -->


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
                                    <th class="pro-title">pic </th>
                                    <th class="pro-title">name</th>
                                    <th class="pro-title">category</th>
                                    <th class="pro-price">price</th>
                                </tr>
                            </thead>
                            
                            <?php
                            if($dish->rowCount()==0){  ?>
                                        <tbody>
                                            <tr><th class='empty' colspan='7'>EMPTY</th></tr>
                                        </tbody>



                            <?php } 
                            else {
                                    foreach($dish as $row) {
                             ?>
                            <tbody id="myTable">
                                <tr>
                                    <td class="pro-price"><img width='100' src="assets/images/pic/category/<?php echo $row["type"].'/'.$row['pic'] ?>"></td>
                                    <td class="pro-price"><span><?php echo $row['name'] ?></span></td>
                                    <td class="pro-price"><span><?php echo $row['type'] ?></span></td>
                                    <td class="pro-price"><span><?php echo $row['price'] ?> BD</span></td>
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