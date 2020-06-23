<?php
require('connection.php');
session_start();
extract($_POST);

if(!isset($_SESSION['activeuser']))
        die();

$total=0; 

$user=$_SESSION['activeuser'][0];

foreach($_SESSION['mycart'] as $k=>$v) {
    $price=$v[1];
    $q=$v[2];
   $total += $price * $q;
} 
if(isset($_SESSION["cop"]))
 {
$total=$total-($total*$_SESSION["cop"]["val"]);
                                    
}
try {  
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    $db->beginTransaction();
    $user_sql = "select cid from customer where username = '$user';";
    $user = $db->query($user_sql);

    foreach($user as $row) 
                $id=$row['cid'];

    $rs=$db->exec("insert into ordering (cid,date,pid,total,location) values ($id, NOW(),$payment_method,$total,$add)");
    
    $orderid= $db->lastInsertId();
  
    $stmt = $db->prepare("iNSERT INTO orderdetail (oid,did,qty,unitPrice) VALUES (:orderID, :dishid, :qty, :unitPrice)");
    $stmt->bindParam(':orderID', $orderID);
    $stmt->bindParam(':dishid', $did);
    $stmt->bindParam(':qty', $qty);
    $stmt->bindParam(':unitPrice', $unitPrice);

    
    foreach($_SESSION['mycart'] as $k=>$v) { 

            $orderID = $orderid;
            $did = $k;
            $qty = $v[2];
            $unitPrice =$v[1];
            $stmt->execute();
            unset($_SESSION['mycart'][$k]);
    }

    $db->commit();
    $db=null;
    unset($_SESSION["cop"]);
    header('location: index.php?promo=1');

}



catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    header('location: index.php?error=1');
    }
    

?>

