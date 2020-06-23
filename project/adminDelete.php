<?php
session_start();
extract($_GET);
           
if(!isset($_SESSION['admin'])){
    header('location: login.php');
    die();
}

try{
    require("connection.php");

    switch ($d) {
        //delete dish
        case 'd':
            $delete_sql = "DELETE FROM dish WHERE did=$i;";
            break;
     //delete staff       
        case 's':
            $delete_sql = "DELETE FROM staff WHERE sid=$i;";
            break;
     //delete customer       
        case 'c':
            $delete_sql = "DELETE FROM customer WHERE cid=$i;";
            $address_delete_sql = "DELETE FROM address WHERE cid=$i;";
            $contact_delete_sql = "DELETE FROM contact WHERE cid=$i;";

            $d_address = $db->exec($address_delete_sql);
            $d_contact = $db->exec($contact_delete_sql);

            break;

    //delete offer
        case 'o':
            $delete_sql = "DELETE FROM offer WHERE fid=$i;";
            $dis_sql ="SET FOREIGN_KEY_CHECKS=0;";
            $offer_delete_sql = "UPDATE dish
            SET fid = NULL
            WHERE fid =$i;";

            $dis = $db->exec($dis_sql);
            $d_offer = $db->exec($offer_delete_sql);

            $en_sql = "SET FOREIGN_KEY_CHECKS=1;";
            $en = $db->exec($en_sql);

            break;  

        //delete category
        case 'g':
            $delete_sql = "DELETE FROM category WHERE qid=$i;";
            $dis_sql ="SET FOREIGN_KEY_CHECKS=0;";
            $cat_delete_sql = "UPDATE dish
            SET ct_id = '25'
            WHERE ct_id =$i;";

            $dis = $db->exec($dis_sql);
            $d_cat = $db->exec($cat_delete_sql);

            $en_sql = "SET FOREIGN_KEY_CHECKS=1;";
            $en = $db->exec($en_sql);

            break;   
    }

       
    $delete= $db->exec($delete_sql);


    $db = null;
    

}

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);

?>