<?php
if (isset($_GET['edit_products'])) {
    $edit_id = mysqli_real_escape_string($con, $_GET['edit_products']); // Sanitize user input
    
    // Prepare a statement to select product data
    $get_data_query = "SELECT * FROM `products` WHERE product_id = ?";
    $stmt = mysqli_prepare($con, $get_data_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $edit_id); // Bind the parameter
        mysqli_stmt_execute($stmt); // Execute the statement

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            
            if ($row) {
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_keywords = $row['product_keywords'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];
                $product_image1 = $row['product_image1'];
                $product_image2 = $row['product_image2'];
                $product_image3 = $row['product_image3'];
                $product_price = $row['product_price'];

                // Fetch category using prepared statement
                $select_category_query = "SELECT category_title FROM `categories` WHERE category_id = ?";
                $stmt_category = mysqli_prepare($con, $select_category_query);
                mysqli_stmt_bind_param($stmt_category, "i", $category_id);
                mysqli_stmt_execute($stmt_category);
                $result_category = mysqli_stmt_get_result($stmt_category);
                $row_category = mysqli_fetch_assoc($result_category);
                $category_title = $row_category ? $row_category['category_title'] : "Category Not Found";

                // Fetch brand name using prepared statement
                $select_brand_query = "SELECT brand_title FROM `brands` WHERE brand_id = ?";
                $stmt_brand = mysqli_prepare($con, $select_brand_query);
                mysqli_stmt_bind_param($stmt_brand, "i", $brand_id);
                mysqli_stmt_execute($stmt_brand);
                $result_brand = mysqli_stmt_get_result($stmt_brand);
                $row_brand = mysqli_fetch_assoc($result_brand);
                $brand_title = $row_brand ? $row_brand['brand_title'] : "Brand Not Found";
            } else {
                echo "No product found with the given ID.";
            }
        } else {
            echo "Error in retrieving product data: " . mysqli_error($con);
        }
        
        mysqli_stmt_close($stmt); // Close the prepared statement
    } else {
        echo "Error in preparing product query: " . mysqli_error($con);
    }
} else {
    echo "edit_products parameter not set in the URL.";
}
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/75e668eaf0.js" crossorigin="anonymous"></script>
    <!-- css link -->
    <link rel="stylesheet" href="../style.css">
</head>


<div class="container mt-5">
    <h1 class="text-center">Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" id="product_title" value="<?php echo $product_title ?>" name="product_title" class="form-control" required="required">
        </div><br>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_description" class="form-label">Product Description</label>
            <input type="text" id="product_description" value="<?php echo $product_description ?>" name="product_description" class="form-control" required="required">
        </div><br>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" id="product_keywords" value="<?php echo $product_keywords ?>" name="product_keywords" class="form-control" required="required">
        </div><br>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_category" class="form-label">Product Categories</label>
            <select name="product_category" class="form-control">
                <option value="<?php echo $category_title ?>"><?php echo $category_title ?></option>
                <?php
                $select_category_all = "Select * from `categories`";
                $result_category_all = mysqli_query($con, $select_category_all);
                while ($row_category_all = mysqli_fetch_assoc($result_category_all)) {
                    $category_title = $row_category_all['category_title'];
                    $category_id = $row_category_all['category_id'];
                    echo " <option value='$category_id'>$category_title</option>";
                };
                ?>
            </select>
        </div><br>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_category" class="form-label">Product Brands</label>
            <select name="product_brands" class="form-control">
                <option value="<?php echo $brand_title ?>"><?php echo $brand_title ?></option>
                <?php
                $select_brands_all = "SELECT * FROM `brands`";
                $result_brands_all = mysqli_query($con, $select_brands_all);

                while ($row_brands_all = mysqli_fetch_assoc($result_brands_all)) {
                    $brand_title = $row_brands_all['brand_title']; 
                    $brand_id = $row_brands_all['brand_id']; 
                    echo "<option value='$brand_id'>$brand_title</option>";
                }
                ?>

            </select>
        </div><br>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image1" class="form-label">Product Image1</label>
            <div class="d-flex align-items-center">
                <input type="file" id="product_image1" name="product_image1" class="form-control" required="required">
                <img src="./product_images/<?php echo $product_image1 ?>" alt="" class="product_img">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image2" class="form-label">Product Image2</label>
            <div class="d-flex align-items-center">
                <input type="file" id="product_image2" name="product_image2" class="form-control" required="required">
                <img src="./product_images/<?php echo $product_image2 ?>" alt="" class="product_img">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image2" class="form-label">Product Image3</label>
            <div class="d-flex align-items-center">
                <input type="file" id="product_image3" name="product_image3" class="form-control" required="required">
                <img src="./product_images/<?php echo $product_image3 ?>" alt="" class="product_img">
            </div>
        </div><br>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="text" id="product_price" value="<?php echo $product_price ?>" name="product_price" class="form-control" required="required">
        </div><br>
        <div class="w-50 m-auto">
            <input type="submit" name="edit_product" value="update Product" class="btn btn-info px-3 mb-3">
        </div>
    </form>
</div>

<?php 
if(isset($_POST['edit_product'])){
    $product_title = $_POST['product_title']; // Remove $ in variable names
    $product_description = $_POST['product_description'];
    $product_keywords = $_POST['product_keywords'];
    $product_category = $_POST['product_category'];
    $product_brands = $_POST['product_brands'];
    $product_price = $_POST['product_price'];

    $product_image1 = $_FILES['product_image1']['name']; // Remove $ in variable names
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];

    $temp_image1 = $_FILES['product_image1']['tmp_name']; // Remove $ in variable names
    $temp_image2 = $_FILES['product_image2']['tmp_name'];
    $temp_image3 = $_FILES['product_image3']['tmp_name'];

    // Checking for empty fields
    if($product_title=='' or $product_description=='' or $product_keywords=='' or $product_category=='' or $product_brands=='' or $product_image1=='' or $product_image2=='' or $product_image3=='' or $product_price==''){
        echo "<script>alert('Please fill in all the fields and continue the process')</script>";
    } else {
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");
        move_uploaded_file($temp_image3, "./product_images/$product_image3");

        // Query to update products
        $update_products = "UPDATE `products` SET product_title='$product_title', product_description='$product_description', product_keywords='$product_keywords',
        category_id='$product_category', brand_id='$product_brands', product_image1='$product_image1', product_image2='$product_image2',
        product_image3='$product_image3', product_price='$product_price', date=NOW() WHERE product_id=$edit_id";
        
        $result_update = mysqli_query($con, $update_products);
        
        if($result_update){
            echo "<script>alert('Product updated Successfully')</script>";
            echo "<script>window.open('./insert_product.php','_self')</script>";
        }
    }
};
?>
