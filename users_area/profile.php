<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

// Check if the user is logged in and session variables are set
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect to login page if the user is not logged in
    header('Location: user_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $_SESSION['username'] ?></title>
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
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            overflow-x: hidden;
        }

        .profile_img {
            width: 90%;
            margin: auto;
            display: block;
            /* height: 100%; */
            object-fit: contain;
        }

        .edit_image {
            width: 100px;
            height: 100px;
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
                <img src="../images/logo.jpeg" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../display_all.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">My Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Total Price: <?php total_cart_price(); ?>/-</a>
                        </li>
                    </ul>
                    <div class="ml-auto">
                        <form class="form-inline" role="search" action="../search_product.php" method="get">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                            <input type="submit" value="Search" class="btn btn-outline-danger" name="search_data-product">
                        </form>
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
                        <a class='nav-link' href='../users_area/logout.php'>Logout</a>
                    </li>";
                }

                ?>
            </ul>
        </nav>
        <!-- Third Child -->
        <div class="bg-light">
            <h3 class="text-center">Hidden Store</h3>
            <p class="text-center">Communication is the heart of e-commerce and community.</p>
        </div>

        <!-- fourth child -->
        <div class="row">
            <div class="col-md-2">
                <ul class="navbar-nav bg-secondary text-center" style="height:100vh">
                    <li class="nav-item bg-info">
                        <a class="nav-link text-light" href="#">
                            <h4>Your Profile</h4>
                        </a>
                    </li>
                    <?php
                    $username = $_SESSION['username'];
                    $user_image = "Select * from `user_table` where username='$username'";
                    $result_image = mysqli_query($con, $user_image);
                    $row_image = mysqli_fetch_array($result_image);
                    $user_image = $row_image['user_image'];
                    echo "<li class='nav-item'>
                    <img src='./user_images/$user_image' alt='' class='profile_img my-4'>
                </li>";

                    ?>

                    <li class="nav-item">
                        <a class="nav-link text-light" href="profile.php">
                            Pending Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="profile.php?edit_account">
                            Edit Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="profile.php?my_orders">
                            My Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="profile.php?delete_account">
                            Delete Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="logout.php">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 text-center">
                <?php get_user_order_details();
                if (isset($_GET['edit_account'])) {
                    include('edit_account.php');
                }
                if (isset($_GET['my_orders'])) {
                    include('users_order.php');
                }
                if (isset($_GET['delete_account'])) {
                    include('delete_account.php');
                }

                ?>
            </div>
        </div>


        <!-- last child -->
        <!-- include footer -->
        <?php
        include('../includes/footer.php');
        ?>
    </div>
</body>

</html>