<?php
    session_start();
    include("connection.php");
    include("function.php");

    $user_data = check_login($con);
    $product_id = array();

    if(filter_input(INPUT_POST, 'Add')){
        if(isset($_SESSION['shopping_cart'])){

        }else{ //if shoppin cart doesnt exist create first product with array key -> 0
            $_SESSION['shopping_cart'][0] = array(
                'Product_ID' => filter_input(INPUT_GET, 'ProductID'),
                'Product_Name' =>filter_input(INPUT_GET, 'ProductNa'),
                'Product_Price'=> filter_input(INPUT_GET, 'price'),
                'Product_Stock'=> filter_input(INPUT_GET, 'Stock'),
            );


        }
    }
    print_r($_SESSION);
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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">311 Ecommerce</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
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
                                    <input type="hidden" name="ProductName" value="<?php $product['ProductName']; ?>">
                                    <input type="hidden" name="ProductIDe" value="<?php $product['price']; ?>">
                                    <input type="submit" name="add_to_cart" class="btn btn-info" value="Add">
                                </div>
                            </div>
                        </form>
                    </div>
                <?php
                endwhile;
            endif;
            ?>
                
            
    </div>
</body>
</html>