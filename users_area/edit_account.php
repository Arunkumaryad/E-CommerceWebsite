<?php
include('../includes/connect.php');
// session_start();

// Check if the user is logged in and session variables are set
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_session_name = $_SESSION['username'];
    $select_query = "SELECT * FROM `user_table` WHERE username='$user_session_name'";
    $result_query = mysqli_query($con, $select_query);

    if ($result_query) {
        // Query executed successfully, proceed with fetching the data
        $row_fetch = mysqli_fetch_assoc($result_query);
        $user_id = $row_fetch['user_id'];
        $username = $row_fetch['username'];
        $user_email = $row_fetch['user_email'];
        $user_address = $row_fetch['user_address'];
        $user_mobile = $row_fetch['user_mobile'];
        $user_image = $row_fetch['user_image'];

        if (isset($_POST['user_update'])) {
            $update_id = $user_id;
            $new_username = mysqli_real_escape_string($con, $_POST['user_username']);
            $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
            $user_address = mysqli_real_escape_string($con, $_POST['user_address']);
            $user_mobile = mysqli_real_escape_string($con, $_POST['user_mobile']);
            $user_image = $_FILES['user_image']['name'];
            $user_image_tmp = $_FILES['user_image']['tmp_name'];
            move_uploaded_file($user_image_tmp, "./user_images/$user_image");

            //update query.
            $update_data = "UPDATE `user_table` SET username=?, user_email=?, user_image=?, user_address=?, user_mobile=? WHERE user_id=?";
            $stmt = mysqli_prepare($con, $update_data);
            mysqli_stmt_bind_param($stmt, "sssssi", $new_username, $user_email, $user_image, $user_address, $user_mobile, $update_id);
            $result_query_update = mysqli_stmt_execute($stmt);
            
            if ($result_query_update) {
                echo "<script>alert('Data updated successfully')</script>";
                echo "<script>window.open('logout.php','_self')</script>";
            } else {
                echo "Error updating data: " . mysqli_error($con);
            }
        }
    }
} else {
    header('Location: user_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit account</title>
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
</head>

<body>
    

    <h3 class="text-center text-success mb-4">Edit Account</h3>
    <form action="" method="post" enctype="multipart/form-data" class="text-center">
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $username; ?>" name="user_username">
        </div>
        <div class="form-outline mb-4">
            <input type="email" class="form-control w-50 m-auto" value="<?php echo $user_email; ?>" name="user_email">
        </div>
        <div class="form-outline mb-4 d-flex w-50 m-auto">
            <input type="file" class="form-control  m-auto" name="user_image">
            <img src="./user_images/<?php echo $user_image; ?>" alt="" class="edit_image">
        </div>
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $user_address; ?>" name="user_address">
        </div>
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $user_mobile; ?>" name="user_mobile">
        </div>
        <input type="submit" value="Update" class="bg-info py-2 px-3 border-0" name="user_update">
    </form>
</body>

</html>