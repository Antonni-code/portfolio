<?php
session_start(); 
$_SESSION = array();
session_destroy();
session_start();
$_SESSION['STATUS'] = "LOGGED_OUT";
header("Location: ../../index.php");
exit();
?>
