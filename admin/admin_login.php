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
    <title>Admin Login</title>
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
    <style>
        body{
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center mb-5">Admin Login</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <img src="../images/admin.jpg" alt="admin Registration" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4">
                <form action="" method="post">
                    <div class="form-outline mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter Your username" required="required" class="form-control">
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Your password" required="required" class="form-control">
                    </div>
                    <div>
                        <input type="submit" class="bg-info py-2 px-3 border-0" name="admin_login" value="Login">
                        <p class="small font-weight-bold mt-2 pt-1">Don't you have an account? <a href="admin_registration.php" class="text-danger">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!-- php code -->

<?php
if (isset($_POST['admin_login'])) {
    $admin_name = $_POST['username']; // Use 'username' as the key
    $admin_password = $_POST['password']; // Use 'password' as the key

    // Assuming $con is a valid database connection
    $stmt = $con->prepare("SELECT * FROM `admin_table` WHERE admin_name=?");
    $stmt->bind_param("s", $admin_name); // Use $admin_name here
    $stmt->execute();
    $result = $stmt->get_result();
    $row_count = $result->num_rows;
    $row_data = $result->fetch_assoc();

    if ($row_count > 0 && password_verify($admin_password, $row_data['admin_password'])) {
        $_SESSION['admin_id'] = $row_data['admin_id'];
        $_SESSION['admin_name'] = $row_data['admin_name'];
        $_SESSION['admin_email'] = $row_data['admin_email'];

        // Redirect to the admin dashboard or any other admin page after successful login
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>
