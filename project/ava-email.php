<?php

extract($_GET);
require('connection.php');

if(isset($str))
{
    $rs= $db->query("select Email from customer where email='$str'");
    //$rd= $db->query("select Email from staff where email='$str'");
}
else
{
    echo "yes";
    die;   
}

    
	$num=$rs->rowCount();
    //$num2=$rd->rowCount();
   // $num2=0;
if($num==0){
    echo "no";
}
else{
    echo "yes";
}
$db=null;
?>
