<?php 
session_start();
extract($_POST);

$old= $_SESSION['activestaff'][0];
echo $old;
try{
    require("connection.php");

    if(isset($subs)){

        $updatestaff_sql = "UPDATE staff
        SET username ='$susername' , Fname ='$sfname' , Lname='$slname'
        WHERE username ='$old' ;";
        
        $_SESSION['activestaff'][0] = $susername;

        $updatestaff = $db->exec($updatestaff_sql);

        header('location: staffaccount.php');

    }
}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
   