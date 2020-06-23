<?php
extract($_POST);



if(!isset($old)){
    header('location: login.php');
    die();
}



    try{
        require("connection.php");

        if(isset($dish_up)){
               
            $pex = explode('.',$old_pic);
            $ex = $pex[1]; 

            $set_pic = $dish.'.'.$ex;   
            $v= explode('!',$cat);
            $cat_id = $v[0];
            $cat_name = $v[1];
            
            $set_pic = $dish.'.'.$ex;   
            $sql="UPDATE dish
            SET name='$dish'  , description ='$desc' , ct_id='$cat_id'  , price='$price', pic='$set_pic' 
            WHERE did =$old;";

            $r= $db->exec($sql);
        
            $old_url = 'assets/images/pic/category/'.$old_cat.'/'.$old_pic;
            $new_url = 'assets/images/pic/category/'.$cat_name.'/'.$set_pic;
        
            echo $old_url.'----'.$new_url;
            rename($old_url, $new_url);

            $db = null;
        
        // header('location: adminview.php?v=d');
        }


        //update customer info
        if(isset($cus_up)){
            $db->beginTransaction();

            $update_cus_sql = $db->prepare("UPDATE customer
            SET username=:u  , Fname =:f , Lname=:l  , Email=:e
            WHERE username ='$old' ;");

            $update_cus_sql->bindParam(':u', $username);
            $update_cus_sql->bindParam(':f', $Fname);
            $update_cus_sql->bindParam(':l', $Lname);
            $update_cus_sql->bindParam(':e', $Email);

            $update_cus_sql->execute();

            $db->commit();

            $db = null;

            header('location: adminview.php?v=c');


        }

        //update staff info
        if(isset($stf)){
            $db->beginTransaction();
            echo $job;
            $update_stf_sql = $db->prepare("UPDATE staff
            SET username=:u  , Fname =:f , Lname=:l  , type=:t
            WHERE username ='$old';");

            $update_stf_sql->bindParam(':u', $username);
            $update_stf_sql->bindParam(':f', $Fname);
            $update_stf_sql->bindParam(':l', $Lname);
            $update_stf_sql->bindParam(':t', $job);

            $update_stf_sql->execute();

            $db->commit();

            $db = null;

           header('location: adminview.php?v=s');


        }

    }

    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }





