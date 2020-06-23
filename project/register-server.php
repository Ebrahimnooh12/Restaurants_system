<?php
require("connection.php");
extract($_GET);
extract($_POST);

if(isset($first)){

  $re3 = '/(^[a-zA-Z]{1,15}$)/m';
  $re4 ='/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
  $re5 = '/(^[A-z]\w{4,15}$)/';

  $m_fname = preg_match_all($re3, $first, $matches, PREG_SET_ORDER, 0);
  $m_lname = preg_match_all($re3, $last, $matches, PREG_SET_ORDER, 0);
  $m_email = preg_match_all($re4, $email, $matches, PREG_SET_ORDER, 0);
  $m_username = preg_match_all($re5, $un, $matches, PREG_SET_ORDER, 0);

  if($m_fname != 1 || $m_lname != 1 || $m_email != 1 || $m_username != 1) {

    header('location: register.php?error=1');
    die();
}

  try {  
    $db->beginTransaction();
    $emp=$db->prepare("INSERT INTO customer (cid,username, Fname, Lname,password, Email,profile_pic)
          values (NULL,:Username,:FName,:LName,:pas,:em,:pic)");
  
    $emp->bindParam(':Username', $un);
    $emp->bindParam(':FName', $first);
    $emp->bindParam(':LName', $last);
    $emp->bindParam(':em', $email);
	$pict="account-image.jpg";
	$emp->bindParam(':pic', $pict);
    if($ps==$ps1)
    {
        $ps=md5($ps);
        $emp->bindParam(':pas', $ps);
    }
    else{
        echo "Passwords are not matched";
        die;
    }

    $emp->execute();
    $db->commit();
    
    echo "yes";
	 header('location: login.php');
	die();

  } catch (Exception $e) {
    $db->rollBack();
    $msg=$e->getMessage();
    echo $msg;
	header('location: register.php');
  }

 
}

?>