<!DOCTYPE html>
<html>

<head>
    <title>Insert categories</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <?php
    include('../includes/connect.php');

    if (isset($_POST['insert_cat'])) {
        $category_title = $_POST['cat-title'];
        $category_title = mysqli_real_escape_string($con, $category_title);

        // Select data from database.
        $select_query = "SELECT * FROM `categories` WHERE category_title='$category_title'";
        $result_select = mysqli_query($con, $select_query);
        $number = mysqli_num_rows($result_select);

        if ($number > 0) {
            echo "<script>alert('This category is already present in the database')</script>";
        } else {
            $insert_query = "INSERT INTO `categories` (category_title) VALUES ('$category_title')";
            $result = mysqli_query($con, $insert_query);

            if ($result) {
                echo "<script>alert('Category has been inserted successfully')</script>";
            }
        }
    }
    ?>
    <h2 class="text-center">Insert Categories</h2>

    <form action="" method="post" class="mb-2">
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1"><i class="fas fa-receipt"></i></span>
            <input type="text" class="form-control" name="cat-title" placeholder="Insert categories" aria-label="Categories" aria-describedby="basic-addon1">
        </div>
        <div class="input-group w-10 mb-2 m-auto">
            <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_cat" value="Insert Categories">
        </div>
    </form>
</body>

</html>