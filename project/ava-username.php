<?php

extract($_GET);
require('connection.php');

if(isset($str))
{
    $rs= $db->query("select cid,username from customer where username='$str'");
    $rd= $db->query("select sid,username from staff where username='$str'");
}
else
{
    echo "yes";
    die;   
}

    $db=null;
	$num=$rs->rowCount();
    $num2=$rd->rowCount();
if($num==0 && $num2==0){
    echo "no";
}
else{
    echo "yes";
}
?>
