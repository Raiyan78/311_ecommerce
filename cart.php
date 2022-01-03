<?php
    session_start(); //Start session
    include("connection.php"); //Connect to DB
    include("function.php"); //function file

    $user_data = check_login($con); //Check if a user is logged in

    pre_r($_SESSION['cart']);

    if(isset($_SESSION['cart'])){
        if(count($_SESSION['cart']) > 0){
            //Create Random CartID
            $cart_id = rand(3666,99999);

            //Select username
            $username = $_SESSION['username'];

            //Insert CartID and username in Cart Table
            $query_cart = "INSERT INTO cart (CartID, username) values ('$cart_id', '$username')";
            mysqli_query($con, $query_cart);
            
            //Put the id column in a variable
            $product_ids = array_column($_SESSION['cart'], 'id');

            //Put quantity column in a variable
            $product_quantity = array_column($_SESSION['cart'], 'quantity');

            //Loop through each product
            for($i =0; $i < count($product_ids); $i++){
                $query_cart_has_products = "INSERT INTO cart_has_products (CartID, username, ProductID, Quantity) values ('$cart_id', '$username', $product_ids[$i], $product_quantity[$i])";
                mysqli_query($con, $query_cart_has_products);
                print_r($product_ids);
                print_r($product_quantity);
            }

            
        }
    }

    header("Location: logout.php")
?>
