<?php
    session_start(); //Start session
    include("connection.php"); //Connect to DB
    include("function.php"); //function file

    $user_data = check_login($con); //Check if a user is logged in

    //If user clicked logout button
    if(isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location:login.php');
    }

    if(filter_input(INPUT_POST, 'add_to_cart')){ //After clicking add to cart
        if(isset($_SESSION['cart'])){ //Check if SESSION cart already exists 
            $count = count($_SESSION['cart']); //How many product in shopping cart

            $product_ids = array_column($_SESSION['cart'], 'id'); //Isolate product ids in an array

            //pre_r($product_ids);

            if(!in_array(filter_input(INPUT_POST, 'ProductID'), $product_ids)){
                $_SESSION['cart'][$count] = array( //Start an array at SESSION cart[0]
                    'id' => $_POST['ProductID'],
                    'name' => $_POST['ProductName'],
                    'price' => $_POST['price'],
                    'quantity' => $_POST['quantity'],
                );
            }
            else{ //Product already exists increase quantity
                for($i =0; $i < count($product_ids); $i++){
                    if($product_ids[$i] == filter_input(INPUT_POST, 'ProductID')){ 
                        //add item quantity to the existing array
                        $_SESSION['cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                    }
                }
            }

        }else{
            $_SESSION['cart'][0] = array( //Start an array at SESSION cart[0]
                'id' => $_POST['ProductID'],
                'name' => $_POST['ProductName'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
            );
            
    
        }
        pre_r($_SESSION['cart']);
    }

    //Remove from cart button
    if(filter_input(INPUT_GET, 'action')=='delete'){
        foreach($_SESSION['cart'] as $key => $product){
            if($product['id'] == filter_input(INPUT_GET, 'id')){
                unset($_SESSION['cart'][$key]);
            }
        }
        //Reset session key
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <title>Home</title>
</head>
<body>

        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">311 Ecommerce</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                        <!-- <input type="submit" name="logout" class="btn btn-info" value="Log Out"> -->
                    </li>
                    <li class="nav-item">
                        <h4><?php echo $user_data['username']?></h4>
                    </li>
                </ul>
                <form class="d-flex">
                    <p class="fw-normal" style="color: white">Welcome <?php echo $user_data['username']?></p>
                </form>
                </div>
            </div>
        </nav>

    <!-- item list -->
    <div class="container">
        <?php
            // session_start();
            // include("connection.php");
            // include("function.php");
            // $user_data = check_login($con);
            // $_SESSION;
            $query = "Select * from products order by ProductID ASC";
            $result = mysqli_query($con, $query);
            if(mysqli_num_rows($result) > 0):
                while($product = mysqli_fetch_assoc($result)):
        ?>     
                    <div class="col-sm-2 col-md-2">
                        <form method="post" action="index.php?action=add&id= <?php echo $product['ProductID']; ?>">
                            <div class="row">
                                <div class="products">
                                    <img src="<?php echo $product['images']; ?>" class="img-thumbnail"/>
                                    <h4 class="text-info"><?php echo $product['ProductName']; ?></h4>
                                    <h4>$<?php echo $product['price']; ?></h4>
                                    <input type="text" name="quantity" class="form-control" value="1">
                                    <input type="hidden" name="ProductName" value="<?php echo $product['ProductName']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                    <input type="hidden" name="ProductID" value="<?php echo $product['ProductID']; ?>">
                                    <input type="submit" name="add_to_cart" class="btn btn-info" value="Add">
                                </div>
                            </div>
                        </form>
                    </div>
                <?php
                endwhile;
            endif;
            ?>

        <!-- CheckOut Part -->
        <div style="clear:both"></div>
        <br/>

        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th colspan="5"><h3>Order Detail</h3></th>
                </tr>
                <tr>
                    <th width="40%">Product Name</th>
                    <th width="10%">Quantity</th>
                    <th width="20%">Price</th>
                    <th width="15%">Total</th>
                    <th width="5%">Action</th>
                </tr>
                <?php
                    if(!empty($_SESSION['cart'])):
                        $total = 0;
                        foreach($_SESSION['cart'] as $key => $product):
                ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo number_format($product['quantity'] * $product['price'], 2) ?></td>
                    <td>
                        <a href="index.php?action=delete&id=<?php echo $product['id']; ?>">
                            <div class="btn-danger">Remove</div>
                        </a>
                    </td>
                </tr>

                <?php
                    $total = $total + ($product['quantity']) * $product['price'];
                        endforeach;
                ?>
                <tr>
                    <td colspan = "3" align="right">Total</td>
                    <td align="right"><?php echo number_format($total,2) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <!-- //Checkout button -->
                    <td colspan="5">
                        <?php
                        if(isset($_SESSION['cart'])):
                            if(count($_SESSION['cart']) > 0):
                        ?>
                        <a href="#" class="button">Checkout</a>         
                        <?php endif;
                            endif;
                        ?>
                    </td>
                </tr>
                <?php
                endif;
                    ?>
            </table>
        </div>
            
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

