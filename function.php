<?php
    function check_login($con){
        if(isset($_SESSION["username"])){
            $username = ($_SESSION["username"]);
            $query = "select * from users where username = '$username' limit 1";

            $result = mysqli_query($con, $query);
            if($result && mysqli_num_rows($result) > 0){
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
            }
        }

        //redirect to login page
        else{
            header("Location: login.php");
            die;
        }
    }

    function logout(){
        session_start();
        session_destroy();
        unset($_SESSION['username']);
        header('location:login.php');
        echo "You have been logged out";
    }

    
    function cartElement($productimg, $productname, $productprice, $productid){
        $element = "
        
        <form action=\"cart.php?action=remove&id=$productid\" method=\"post\" class=\"cart-items\">
                        <div class=\"border rounded\">
                            <div class=\"row bg-white\">
                                <div class=\"col-md-3 pl-0\">
                                    <img src=$productimg alt=\"Image1\" class=\"img-fluid\">
                                </div>
                                <div class=\"col-md-6\">
                                    <h5 class=\"pt-2\">$productname</h5>
                                    <small class=\"text-secondary\">Seller: dailytuition</small>
                                    <h5 class=\"pt-2\">$$productprice</h5>
                                    <button type=\"submit\" class=\"btn btn-warning\">Save for Later</button>
                                    <button type=\"submit\" class=\"btn btn-danger mx-2\" name=\"remove\">Remove</button>
                                </div>
                                <div class=\"col-md-3 py-5\">
                                    <div>
                                        <button type=\"button\" class=\"btn bg-light border rounded-circle\"><i class=\"fas fa-minus\"></i></button>
                                        <input type=\"text\" value=\"1\" class=\"form-control w-25 d-inline\">
                                        <button type=\"button\" class=\"btn bg-light border rounded-circle\"><i class=\"fas fa-plus\"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
        
        ";
        echo  $element;
    }
    function pre_r($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    