<?php

$myfile = fopen("data.txt", "r") or die("Unable to open file!");
$c= fgets($myfile);
$v = explode('#',$c);
fclose($myfile);

$address=array($v[0]);
$tel=array($v[1]);
$web=array($v[2]);

$data=array($address, $tel , $web)
?>