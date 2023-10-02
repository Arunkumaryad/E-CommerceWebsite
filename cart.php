<!-- Connection file -->
<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Websites cart-details</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/75e668eaf0.js" crossorigin="anonymous"></script>
    <!-- Css link -->
    <link rel="stylesheet" href="style.css">
    <style>
        .cart_img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        
    </style>

</head>

<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="./images/logo.jpeg" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="display_all.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./users_area/user_registration.php">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
                        </li>

                    </ul>
                    <div class="ml-auto">

                    </div>
                </div>
            </div>
        </nav>
        <!-- calling cart functions -->
        <?php
        cart();
        ?>
        <!-- second child -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                
                <?php
                 if (!isset($_SESSION['username'])) {
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='#'>Welcome Guest</a>
                    </li>";
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='./users_area/user_login.php'>Login</a>
                    </li>";
                } else {
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='#'>Welcome  " . $_SESSION['username'] . "</a>
                    </li>";
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='./users_area/logout.php'>Logout</a>
                    </li>";
                }
                // if(!isset($_SESSION['username'])){
                //     echo "<li class='nav-item'>
                //     <a class='nav-link' href='./user_login.php'>Login</a>
                // </li>";
                // }else{
                //     echo "<li class='nav-item'>
                //     <a class='nav-link' href='logout.php'>Logout</a>
                // </li>";
                // }
                 ?>

            </ul>
        </nav>
        <!-- Third Child -->
        <div class="bg-light">
            <h3 class="text-center">Hidden Store</h3>
            <p class="text-center">Communication is the heart of e-commerce and community.</p>
        </div>

        <!-- Fourth child-table -->
        <div class="container">
            <div class="row">
                <form action="" method="post">
                    <table class="table table-bordered text-center">
                      
                            <!-- php code to display dynamic data -->
                            <?php
                            global $con;
                            $get_ip_add = getIPAddress();
                            $total_price = 0;
                            $cart_query = "select * from `cart_details` where ip_address='$get_ip_add'";
                            $result = mysqli_query($con, $cart_query);
                            $result_count=mysqli_num_rows($result);
                            if($result_count>0){
                                echo "  <thead>
                                <tr>
                                    <th>Product Title</th>
                                    <th>Product Image</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Remove</th>
                                    <th colspan='2'>Operations</th>
                                </tr>
                            </thead>
                            <tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                $product_id = $row['product_id'];
                                $select_products = "select * from `products` where product_id='$product_id'";
                                $result_products = mysqli_query($con, $select_products);
                                while ($row_product_price = mysqli_fetch_array($result_products)) {
                                    $product_price = array($row_product_price['product_price']);
                                    $price_table = $row_product_price['product_price'];
                                    $product_title = $row_product_price['product_title'];
                                    $product_image1 = $row_product_price['product_image1'];
                                    $product_values = array_sum($product_price);
                                    $total_price += $product_values;


                            ?>
                                    <tr>
                                        <td><?php echo $product_title ?></td>
                                        <td><img src="./admin/product_images/<?php echo $product_image1 ?>" alt="" class="cart_img"></td>
                                        <td><input type="text" name="qty" class="form-input w-50"></td>

                                        <?php
                                        $get_ip_add = getIPAddress();
                                        if (isset($_POST['update_cart'])) {
                                            $quantity = $_POST['qty'];

                                            // Perform validation on $quantity to ensure it's a valid number

                                            // Use prepared statements to avoid SQL injection
                                            $update_cart_query = "UPDATE cart_details SET quantity = ? WHERE ip_address = ?";
                                            $stmt = mysqli_prepare($con, $update_cart_query);

                                            if ($stmt) {
                                                // Bind parameters and execute the statement
                                                mysqli_stmt_bind_param($stmt, "is", $quantity, $get_ip_add);
                                                mysqli_stmt_execute($stmt);

                                                // Check if any rows were affected by the update
                                                $rows_affected = mysqli_stmt_affected_rows($stmt);

                                                if ($rows_affected > 0) {
                                                    // Quantity updated successfully
                                                    // Recalculate the total price using the updated quantity
                                                    $total_price = $total_price * $quantity;
                                                } else {
                                                    // Quantity update failed or no matching record found
                                                    // Handle the error or provide appropriate feedback to the user
                                                }

                                                // Close the statement
                                                mysqli_stmt_close($stmt);
                                            } else {
                                                // Error preparing the statement
                                                // Handle the error or provide appropriate feedback to the user
                                            }
                                        }
                                        ?>
                                        <td><?php echo $price_table ?>/-</td>
                                        <td><input type="checkbox" name="removeitem[]" value="<?php  echo $product_id ?>"></td>
                                        <td>
                                            <!-- <button class="bg-info px-3 py-2 border-0 mx-3">Update</button> -->
                                            <input type="submit" value="Update Cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
                                            <!-- <button class="bg-info px-3 py-2 border-0 mx-3">Remove</button> -->
                                            <input type="submit" value="Remove Cart" class="bg-info px-3 py-2 border-0 mx-3" name="remove_cart">
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                        }
                        else{
                            echo "<div class='text-center'><h2 class='text-danger'>Cart is empty</h2></div>";
                        }
                            ?>
                        </tbody>
                    </table>
                    <!-- subtotal -->
                    <div class="d-flex mb-5">
                        <?php
                            $get_ip_add = getIPAddress();
                            $cart_query = "select * from `cart_details` where ip_address='$get_ip_add'";
                            $result = mysqli_query($con, $cart_query);
                            $result_count=mysqli_num_rows($result);
                            if($result_count>0){
                                echo "<h4 class='px-3'>Subtotal:<strong class='text-info'> $total_price /-</strong></h4>
                                <input type='submit' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>
                                <button class='bg-secondary px-3 py-2 border-0 '><a href='./users_area/checkout.php' class='text-light text-decoration-none'>Checkout</button>";
                            }
                            else{
                                echo "<input type='submit' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>";
                            }
                            if (isset($_POST['continue_shopping'])) {
                                echo "<script>window.open('index.php','_self')</script>";
                            }
                         ?>
                        
                    </div>
            </div>
        </div>
        </form>

        <!-- Function to remove itme -->
        <?php
        function remove_cart_item(){
            global $con;
            if(isset($_POST['remove_cart']))
            {
                foreach($_POST['removeitem'] as $remove_id){
                    echo $remove_id;
                    $delete_query="Delete  from `cart_details` where product_id=$remove_id ";
                    $run_delete=mysqli_query($con,$delete_query);
                    if($run_delete)
                    {
                        echo "<script>window.open('cart.php','_self')</script>";
                    }
                }
            }
        }
        echo $remove_item=remove_cart_item();
        
        ?>


        <!-- last child -->
        <!-- include footer -->
        <?php
        include('./includes/footer.php');
        ?>
    </div>
</body>

</html>