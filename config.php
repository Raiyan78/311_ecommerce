<?php
// contains database config
define('DB_SERVER','localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', '311_ecommerce');
$conn = mysqli_connect(DB_SERVER,DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn == false){
    dif("Error: Can't connect");
}
?>

<!-- #redundant -->