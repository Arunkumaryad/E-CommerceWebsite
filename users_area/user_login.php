<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
@session_start();

// Initialize variables from session if they exist
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/75e668eaf0.js" crossorigin="anonymous"></script>
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">User Login</h2>
        <div class="row d-flex align-items-center justify-content-center mt-5">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post">
                    <!-- username field -->
                    <div class="form-outline mb-2">
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" id="user_username" class="form-control" placeholder="Enter Username" autocomplete="off" required="required" name="user_username">
                    </div>

                    <!-- password field -->
                    <div class="form-outline mb-2">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" id="user_password" class="form-control" placeholder="Enter your password" autocomplete="off" required="required" name="user_password">
                    </div>

                    <div class=" text-center mt-4 pt-2">
                        <input type="submit" value="Login" class="bg-info py-2 px-3 border-0" name="user_login">
                        <p class="small font-weight-bold mt-2 pt-1 mb-0">Don't have an account ?<a href="./user_registration.php" class="text-danger"> Register</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>
<?php
if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    // Assuming $con is a valid database connection
    $stmt = $con->prepare("SELECT * FROM `user_table` WHERE username=?");
    $stmt->bind_param("s", $user_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row_count = $result->num_rows;
    $row_data = $result->fetch_assoc();

    if ($row_count > 0 && password_verify($user_password, $row_data['user_password'])) {
        $_SESSION['username'] = $row_data['username'];
        $_SESSION['user_email'] = $row_data['user_email'];
        $_SESSION['user_address'] = $row_data['user_address'];
        $_SESSION['user_mobile'] = $row_data['user_mobile'];
        $_SESSION['user_id'] = $row_data['user_id'];

        $user_ip = getIPAddress();

        // cart item
        $stmt_cart = $con->prepare("SELECT * FROM `cart_details` WHERE ip_address=?");
        $stmt_cart->bind_param("s", $user_ip);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();
        $row_count_cart = $result_cart->num_rows;

        if ($row_count_cart == 0) {
            echo "<script>alert('Login Successfully')</script>";
            echo "<script>window.open('profile.php','_self')</script>";
        } else {
            echo "<script>alert('Login Successfully')</script>";
            echo "<script>window.open('payment.php','_self')</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>