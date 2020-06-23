<?php

extract($_POST);

	session_start();
    $_SESSION['mycart'][$d]=array($name,$price,$qty,$pic,$d);
    header("location:single-dish.php?d=$d");
 
 ?>   


