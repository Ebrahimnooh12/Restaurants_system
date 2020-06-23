<?php
require('connection.php');
session_start();
extract($_GET);



if(!isset($o))
{
    header('location: login.php');
    die();
}

else {

    
try {  
        $order_dish_sql = "select * from orderdetail, dish, category WHERE dish.did = orderdetail.did  and dish.ct_id = category.qid and oid=$o;"; 

        $order_dish = $db->query($order_dish_sql);

        foreach($order_dish as $row){
            $dish_pic = "assets/images/pic/category/".$row['type'].'/'.$row['pic'];

            $_SESSION['mycart'][$row['did']]=array($row['name'],$row['price'],$row['qty'],$dish_pic,$row['did']);
        }

}



catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();


}
header("location:cart.php");

}

?>