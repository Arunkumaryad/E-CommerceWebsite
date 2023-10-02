<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();
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
<style>
    body{
        overflow-x: hidden;
    }
    .product_img{
        width: 100px;
        object-fit: contain;

    }
</style>

<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/logo.jpeg" alt="" class="logo">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <?php
                        if (!isset($_SESSION['admin_name'])) {
                          echo "<li class='nav-item'>
                              <a class='nav-link' href='#'>Welcome Guest</a>
                          </li>";
                          echo "<li class='nav-item'>
                              <a class='nav-link' href='admin_login.php'>Login</a>
                          </li>";
                      } else {
                          echo "<li class='nav-item'>
                              <a class='nav-link' href='#'>Welcome " . $_SESSION['admin_name'] . "</a>
                          </li>";
                          echo "<li class='nav-item'>
                              <a class='nav-link' href='admin_logout.php'>Logout</a>
                          </li>";
                      }
                       ?>
                    </ul>
                </nav>
            </div>
        </nav>
        <!-- second child -->
        <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
        </div>
        <!-- third child -->
        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="px-5">
                    <a href="#"><img src="../images/pineapplejuice.webp" alt="" class="admin_image"></a>
                    <p class="text-light text-center">Admin Name</p>
                </div>
                <div class="button text-center">
                    <button class="my-3"><a href="insert_product.php" class="nav-link text-light bg-info my-1">Insert Products</a></button>
                    <button><a href="index.php?view_products" class="nav-link text-light bg-info my-1">View Products</a></button>
                    <button><a href="index.php?insert_category" class="nav-link text-light bg-info my-1">Insert Categories</a></button>
                    <button><a href="index.php?view_categories" class="nav-link text-light bg-info my-1">View Categories</a></button>
                    <button><a href="index.php?insert_brand" class="nav-link text-light bg-info my-1">Insert Brands</a></button>
                    <button><a href="index.php?view_brands" class="nav-link text-light bg-info my-1">View Brands</a></button>
                    <button><a href="index.php?list_orders" class="nav-link text-light bg-info my-1">All Orders</a></button>
                    <button><a href="index.php?list_payments" class="nav-link text-light bg-info my-1">All Payments</a></button><br>
                    <button><a href="index.php?list_users" class="nav-link text-light bg-info my-1">List Users</a></button>
                    <button><a href="admin_logout.php" class="nav-link text-light bg-info my-1">Logout</a></button>
                </div>
            </div>
        </div>
        <!-- fourth child -->
        <div class="container my-3">
            <?php 
            if(isset($_GET['insert_category'])){
              include('insert_categories.php');
            }
            if(isset($_GET['insert_brand'])){
                include('insert_brands.php');
              }
              if(isset($_GET['view_products'])){
                include('view_products.php');
              }
              if(isset($_GET['edit_products'])){
                include('edit_products.php');
              }
              if(isset($_GET['delete_product'])){
                include('delete_product.php');
              }
              if(isset($_GET['view_categories'])){
                include('view_categories.php');
              }
              if(isset($_GET['view_brands'])){
                include('view_brands.php');
              }
              if(isset($_GET['edit_category'])){
                include('edit_category.php');
              }
              if(isset($_GET['edit_brands'])){
                include('edit_brands.php');
              }
              if(isset($_GET['delete_category'])){
                include('delete_category.php');
              }
              if(isset($_GET['delete_brands'])){
                include('delete_brands.php');
              }
              if(isset($_GET['list_orders'])){
                include('list_orders.php');
              }
              if(isset($_GET['list_payments'])){
                include('list_payments.php');
              }
              if(isset($_GET['list_users'])){
                include('list_users.php');
              }
            ?>
        </div>


        <!-- last child -->
        <!-- <div class="bg-info p-3 text-center footer">
            <p>All rights reserved 0- Designed by Arun-2023</p>
        </div> -->
        <?php
        include('../includes/footer.php');
        ?>
    </div>
</body>

</html>