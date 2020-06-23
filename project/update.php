<?php
session_start();
extract($_GET);
extract($_POST);

if(isset($info_u)) {
    $pex = explode('.',$pic);
    $ex = $pex[1]; 
    $st='uf';
}



try{
    require("connection.php");
    $userid=$_SESSION['activeuser'][1];
    $nodeletesql="select cid from address where cid =$userid;";

    $nodelete= $db->query($nodeletesql);
    $dc = $nodelete->rowCount();

    if(isset($address)){
        $adx = explode('!',$address);
        $id = $adx[0];
        $c  = $adx[1]; 
        $s = $adx[3];
        $b = $adx[2];
        
        $re1 = '/(^[0-9]{1,15}$)/m';
        $re2 = '/(^[a-zA-Z]{1,15}$)/m';
        
        $regx_c = $c;
        $regx_s = $s;
        $regx_b = $b;

        $m_city = preg_match_all($re2, $regx_c, $matches, PREG_SET_ORDER, 0);
        $m_street = preg_match_all($re1, $regx_s, $matches, PREG_SET_ORDER, 0);
        $m_building = preg_match_all($re1, $regx_b, $matches, PREG_SET_ORDER, 0);

        if($m_city != 1) {

            header('location: myaccount.php?err=2');
            die();
        }

        if($m_street != 1) {

            header('location: myaccount.php?err=4');
            die();
        }

        if($m_building != 1) {

            header('location: myaccount.php?err=3');
            die();
        }



          $updateinfosql = "UPDATE address
          SET city ='$c' , street ='$s' , building='$b'  
          WHERE lid ='$id' ;" ;
    
          $updateinfo = $db->query($updateinfosql);

          header('location: myaccount.php');
          die();

    }


    if($dc == 1)
    {   
        header('location: myaccount.php?err=1');
        die();

    }

    $db->beginTransaction();
    switch ($st) {
        case 'uf':

            //username - first name - last name - email vaildation
            $re3 = '/(^[a-zA-Z]{1,15}$)/m';
            $re4 ='/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
            $re5 = '/(^[A-z]\w{4,15}$)/';

            $m_fname = preg_match_all($re3, $fname, $matches, PREG_SET_ORDER, 0);
            $m_lname = preg_match_all($re3, $lname, $matches, PREG_SET_ORDER, 0);
            $m_email = preg_match_all($re4, $email, $matches, PREG_SET_ORDER, 0);
            $m_username = preg_match_all($re5, $username, $matches, PREG_SET_ORDER, 0);

            $check_sql = "select username from customer where cid != $userid and username='$username'";
            $check = $db->query($check_sql);
            $count = $check->rowCount();

            if($m_fname != 1) {

                header('location: myaccount.php?err=5');
                die();
            }
            if($m_lname != 1) {

                header('location: myaccount.php?err=6');
                die();
            }
            if($m_email != 1) {

                header('location: myaccount.php?err=7');
                die();
            }
            if($m_username != 1 && $count != 0) {

                header('location: myaccount.php?err=8');
                die();
            }

            $set_pic = $userid.'.'.$ex;
            $updateinfosql = "UPDATE customer
            SET username ='$username' , Fname ='$fname' , Lname='$lname'  , Email='$email', profile_pic='$set_pic' 
            WHERE cid ='$userid' ;" ;
            $stmt = $db->prepare("UPDATE contact SET tel=:tel WHERE cnt_id=:cntid");
            $stmt->bindParam(':tel', $Tel);
            $stmt->bindParam(':cntid', $Telid);



            for ($i=0; $i < count($tel) ; $i++) { 
                $Telid=$telid[$i];
                $Tel=$tel[$i];
                $count=$stmt->rowCount();
                $stmt->execute();
           

            }

            $updateinfo = $db->query($updateinfosql);
            break;

        case 'dl':
            $updateFODdql ="delete FROM orderdetail where oid in (SELECT oid FROM ordering WHERE location = $locid);";
            $updateFOsql = "DELETE FROM ordering WHERE location=$locid;";
            $updatesql = "DELETE FROM address WHERE lid=$locid;";

            $updateFOD = $db->exec($updateFODdql);
            $updateF= $db->exec($updateFOsql);
            $update = $db->exec($updatesql);

            break;
    }

    $db->commit();

    $db = null;
    

}

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

   header('location: myaccount.php');

   

?>