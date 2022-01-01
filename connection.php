<?php
    define('DB_SERVER','localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', '311_ecommerce');
    $con = mysqli_connect(DB_SERVER,DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($con == false){
        dif("Error: Can't connect");
    }