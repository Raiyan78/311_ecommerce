<?php 
session_start();
session_destroy();
    unset($_SESSION['username']);
    header('location:login.php');
    echo "You have been logged out";

?>