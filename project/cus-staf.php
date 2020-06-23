<?php
session_start();
extract($_GET);


try{
    require("connection.php");
    if(isset($t)) {

        if($t == 'c'){
            $getUser_sql = "select username,Fname,Lname from customer where cid =$i;";
            $getUser = $db->query($getUser_sql);

            foreach($getUser as $user){
                $u = $user['username'];
                $f = $user['Fname'];
                $l = $user['Lname'];
            } 

            $db->beginTransaction();

            $dis_sql ="SET FOREIGN_KEY_CHECKS=0;";
            $dis = $db->exec($dis_sql);

            //add customer to staff
            $transfer_sql = "insert into staff (username,Fname,Lname,type) value('$u','$f','$l','C');";
            $transfer = $db->exec($transfer_sql);

            //delete customer information
            $delete_sql = "DELETE FROM customer WHERE cid=$i;";
            $address_delete_sql = "DELETE FROM address WHERE cid=$i;";
            $contact_delete_sql = "DELETE FROM contact WHERE cid=$i;";
            $d_address = $db->exec($address_delete_sql);
            $d_contact = $db->exec($contact_delete_sql);
            $delete= $db->exec($delete_sql);


            $en_sql = "SET FOREIGN_KEY_CHECKS=1;";
            $en = $db->exec($en_sql);

            $db->commit();

            header('location: AdminDashBoard.php');
            die();    


        }

        if($t == 's'){
            $getUser_sql = "select username,Fname,Lname from staff where sid =$i;";
            $getUser = $db->query($getUser_sql);

            foreach($getUser as $user){
                $u = $user['username'];
                $f = $user['Fname'];
                $l = $user['Lname'];
            } 

            $db->beginTransaction();

            $dis_sql ="SET FOREIGN_KEY_CHECKS=0;";
            $dis = $db->exec($dis_sql);

            //add staff to customer
            $transfer_sql = "insert into customer (username,Fname,Lname) value('$u','$f','$l');";
            $transfer = $db->exec($transfer_sql);

            //delete staff information
            $delete_sql = "DELETE FROM staff WHERE sid=$i;";
            $delete= $db->exec($delete_sql);


            $en_sql = "SET FOREIGN_KEY_CHECKS=1;";
            $en = $db->exec($en_sql);

            $db->commit();

            header('location: AdminDashBoard.php');
            die();    


        }




    }

    
            $db = null;
    

}

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
   

?>