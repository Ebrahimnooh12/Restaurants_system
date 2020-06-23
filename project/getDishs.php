<?php
extract($_GET);
require('connection.php');

if(isset($str))
{
    $rs= $db->query("select did,name from dish where name LIKE '%".$str."%' LIMIT 0,10");
}
else
$rs= $db->query("select did,name from dish");
    $db=null;
    $i=0;
	$num=$rs->rowCount();

	foreach($rs as $row)
	{	
		$dish[$i]=array('name' => $row['name'],'id' => $row['did']);
		$i+=1;
	}
if($num==0){
    echo "no";
}
else{
    $response=json_encode($dish);
    echo $response;
}
?>

