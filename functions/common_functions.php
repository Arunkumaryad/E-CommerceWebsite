<?php
// Include the connection file to establish a database connection
include(__DIR__ . '/../includes/connect.php');

// Function to fetch and display products.
function getproducts()
{
    global $con;

    // Check if 'category' is set and is not empty
    if (!isset($_GET['category'])) {
        // Check if 'brand' is set and is not empty
        if (isset($_GET['brand']) && !empty($_GET['brand'])) {
            $brand_id = mysqli_real_escape_string($con, $_GET['brand']);

            $select_query = "SELECT * FROM `products` WHERE brand_id = $brand_id ORDER BY RAND() LIMIT 0, 9";
        } else {
            // If neither 'category' nor 'brand' is set, show random products
            $select_query = "SELECT * FROM `products` ORDER BY RAND() LIMIT 0, 9";
        }

        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);

        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger px-5'>No products available for this Brand</h2>";
        } else {
            // Display products
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_keywords = $row['product_keywords'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];

                echo "<div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price:  $product_price/-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to Cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                        </div>
                    </div>
                </div>";
            }
        }
    }
}

//Getting all products.
function get_all_products()
{
    global $con;

    // Check if 'category' is set and is not empty
    if (!isset($_GET['category'])) {
        // Check if 'brand' is set and is not empty
        if (isset($_GET['brand']) && !empty($_GET['brand'])) {
            $brand_id = mysqli_real_escape_string($con, $_GET['brand']);

            $select_query = "SELECT * FROM `products` WHERE brand_id = $brand_id ORDER BY RAND()";
        } else {
            // If neither 'category' nor 'brand' is set, show random products
            $select_query = "SELECT * FROM `products` ORDER BY RAND()";
        }

        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);

        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger'>No products available</h2>";
        } else {
            // Display products
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_keywords = $row['product_keywords'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];

                echo "<div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price:  $product_price/-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to Cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                        </div>
                    </div>
                </div>";
            }
        }
    }
}

// Function to get unique categories.
function get_unique_categories()
{
    global $con;

    // Check if 'category' is set and is not empty
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $category_id = mysqli_real_escape_string($con, $_GET['category']);

        $select_query = "SELECT * FROM `products` WHERE category_id = $category_id";
        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);

        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger px-5'>No Stock for this category</h2>";
        } else {
            // Display products for the selected category
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_keywords = $row['product_keywords'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];

                echo "<div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price:  $product_price/-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to Cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                        </div>
                    </div>
                </div>";
            }
        }
    }
}

// Function to get unique brands.
function get_unique_brands()
{
    global $con;

    // Check if 'brand' is set and is not empty
    if (isset($_GET['brand']) && !empty($_GET['brand'])) {
        $brand_id = mysqli_real_escape_string($con, $_GET['brand']);

        // Use prepared statement to prevent SQL injection
        $select_query = "SELECT * FROM `products` WHERE brand_id = ?";
        $stmt = mysqli_prepare($con, $select_query);
        mysqli_stmt_bind_param($stmt, "i", $brand_id);
        mysqli_stmt_execute($stmt);
        $result_query = mysqli_stmt_get_result($stmt);

        $num_of_rows = mysqli_num_rows($result_query);

        if ($num_of_rows == 0) {
            return "<h2 class='text-center text-danger'>This brand is not available for service</h2>";
        } else {
            $output = ""; // Initialize an empty variable to store the HTML output

            // Display products for the selected brand
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_keywords = $row['product_keywords'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];

                // Append the HTML for each product to the $output variable
                $output .= "<div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price:  $product_price/-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to Cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                        </div>
                    </div>
                </div>";
            }

            return $output; // Return the generated HTML
        }
    } else {
        return "<h2 class='text-center text-danger'>No brand selected</h2>";
    }
}

// Function to display brands in sidenav
function getbrands()
{
    global $con;
    $select_brands = "SELECT * FROM `brands`";
    $result_brands = mysqli_query($con, $select_brands);
    while ($row_data = mysqli_fetch_assoc($result_brands)) {
        $brand_title = $row_data['brand_title'];
        $brand_id = $row_data['brand_id'];
        echo "<li class='nav-item'>
        <a href='index.php?brand=$brand_id' class='nav-link text-light'>$brand_title</a>
    </li>";
    }
}

// Function to display categories in sidenav.
function getcategories()
{
    global $con;
    $select_categories = "SELECT * FROM `categories`";
    $result_categories = mysqli_query($con, $select_categories);
    while ($row_data = mysqli_fetch_assoc($result_categories)) {
        $category_title = $row_data['category_title'];
        $category_id = $row_data['category_id'];
        echo "<li class='nav-item'>
        <a href='index.php?category=$category_id' class='nav-link text-light'>$category_title</a>
    </li>";
    }
}


//Searching products functions.
function search_product()
{
    global $con;
    if (isset($_GET['search_data'])) {
        $search_data_value = $_GET['search_data'];

        $select_query = "SELECT * FROM `products` ORDER BY RAND() LIMIT 0, 9";
        $search_query = "SELECT * FROM `products` WHERE product_keywords LIKE '%$search_data_value%'";
        $result_query = mysqli_query($con, $search_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger px-5'>No results match. No products found on this category!</h2>";
        }

        while ($row = mysqli_fetch_assoc($result_query)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_keywords = $row['product_keywords'];
            $product_image1 = $row['product_image1'];
            $product_price = $row['product_price'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];

            echo "<div class='col-md-4 mb-2'>
                <div class='card'>
                    <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text'>$product_description</p>
                        <p class='card-text'>Price:  $product_price/-</p>
                        <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to Cart</a>
                        <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                    </div>
                </div>
            </div>";
        }
    }
}

//View Details functions.
function view_details()
{
    global $con;

    if (isset($_GET['product_id'])) {
        $product_id = mysqli_real_escape_string($con, $_GET['product_id']);

        // Fetch the product details based on the product_id
        $select_query = "SELECT * FROM `products` WHERE product_id = $product_id";
        $result_query = mysqli_query($con, $select_query);

        if (!$result_query) {
            // Error handling if the query fails
            echo "<h2 class='text-center text-danger'>Error retrieving product details</h2>";
            return;
        }

        $num_of_rows = mysqli_num_rows($result_query);

        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger'>Product not found</h2>";
            return;
        }

        // Display the product details
        $row = mysqli_fetch_assoc($result_query);
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_image1 = $row['product_image1'];
        $product_image2 = $row['product_image2'];
        $product_image3 = $row['product_image3'];
        $product_price = $row['product_price'];

        echo "<div class='col-md-4 mb-2'>
            <div class='card'>
                <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                <div class='card-body'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text'>$product_description</p>
                    <p class='card-text'>Price:  $product_price/-</p>
                    <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to Cart</a>
                    <a href='index.php' class='btn btn-secondary'>Go Home</a>
                </div>
            </div>
        </div>
        <div class='col-md-8'>
            <!-- related images -->
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='text-center text-info mb-5'>Related Products</h4>
                </div>
                <div class='col-md-6'>
                    <img src='./admin/product_images/$product_image2' class='card-img-top' alt='$product_title'>
                </div>
                <div class='col-md-6'>
                    <img src='./admin/product_images/$product_image3' class='card-img-top' alt='$product_title'>
                </div>
            </div>
        </div>";
    } else {
        echo "<h2 class='text-center text-danger'>Product ID not provided</h2>";
    }
}

//Get ip address Functions.
function getIPAddress() {  
    // whether IP is from the shared internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    // whether IP is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    // whether IP is from the remote address  
    else {  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}

// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;

//cart function
function cart(){
    if(isset($_GET['add_to_cart'])){
        global $con;
        $get_ip_add = getIPAddress(); 
        $get_product_id=$_GET['add_to_cart'];
        $select_query="select * from `cart_details` where ip_address='$get_ip_add' and product_id=$get_product_id";
        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if ($num_of_rows>0) {
            echo "<script>alert('This item is already present inside cart')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }else{
            $insert_query="insert into `cart_details` (product_id,ip_address,quantity) values($get_product_id,'$get_ip_add',0)";
            $result_query = mysqli_query($con,$insert_query);
            echo "<script>alert('Item is added to cart')</script>";
            echo "<script>window.open('index.php','_self')</script>";

        }

    }

}

//function to get cart item numbers.
function cart_item(){
    if(isset($_GET['add_to_cart'])){
        global $con;
        $get_ip_add = getIPAddress(); 
        
        $select_query="select * from `cart_details` where ip_address='$get_ip_add'";
        $result_query = mysqli_query($con, $select_query);
        $count_cart_items = mysqli_num_rows($result_query);
        }else{
            global $con;
        $get_ip_add = getIPAddress(); 
        
        $select_query="select * from `cart_details` where ip_address='$get_ip_add'";
        $result_query = mysqli_query($con, $select_query);
        $count_cart_items = mysqli_num_rows($result_query);

        }
        echo $count_cart_items;

    }

    //total price function.
    function total_cart_price(){
        global $con;
        $get_ip_add = getIPAddress(); 
        $total_price=0;
        $cart_query="select * from `cart_details` where ip_address='$get_ip_add'";
        $result=mysqli_query($con,$cart_query);
        while($row=mysqli_fetch_array($result)){
            $product_id=$row['product_id'];
            $select_products="select * from `products` where product_id='$product_id'";
            $result_products=mysqli_query($con,$select_products);
            while($row_product_price=mysqli_fetch_array($result_products))
            {
                $product_price=array($row_product_price['product_price']);
                $product_values=array_sum($product_price);
                $total_price+=$product_values;
            }
        }
        echo $total_price;
    }

    //get user order details.
    function get_user_order_details(){
        global $con;
        $username=$_SESSION['username'];
        $get_details="Select * from `user_table` where username='$username'";
        $result_query=mysqli_query($con,$get_details);
        while($row_query=mysqli_fetch_array($result_query)){
            $user_id=$row_query['user_id'];
            if(!isset($_GET['edit_account'])){
                if(!isset($_GET['my_orders'])){
                    if(!isset($_GET['delete_account'])){
                        $get_orders="Select * from `user_orders` where user_id=$user_id and order_status='pending'";
                        $result_orders_query=mysqli_query($con,$get_orders);
                        $row_count=mysqli_num_rows($result_orders_query);
                        if($row_count>0){
                            echo "<h3 class='text-center text-success mt-5 mb-2'>You have <span class='text-danger'>$row_count</span> pending orders</h3>
                            <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Order Details</a></p>";
                        }else{
                            echo "<h3 class='text-center text-success mt-5 mb-2'>You have zero pending orders</h3>
                            <p class='text-center'><a href='../index.php' class='text-dark'>Explore products</a></p>";
                        }
                    }
                }
            }
        }
    }

?>