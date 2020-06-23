<?php
session_start();

unset($_SESSION['activeuser']);
unset($_SESSION['mycart']);

header('location: index.php');

?>