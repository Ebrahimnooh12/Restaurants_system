<?php 
session_start();
extract($_GET);
extract($_POST);

if(!isset($_SESSION['activeuser']) )
    {   
        header('location: login.php');
        die();

    }
    $userid=$_SESSION['activeuser'][1];

    try{
        require("connection.php");
        //add address
        if(isset($add_a)){
            $stmt = $db->prepare("INSERT INTO address (cid,city,building,street) VALUES (:cid, :city, :building, :street)");
            $stmt->bindParam(':cid', $userid);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':building', $buil);
            $stmt->bindParam(':street', $stre);


            $stmt->execute();
        }

        
}

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

    header('location: myaccount.php');



 ?>   