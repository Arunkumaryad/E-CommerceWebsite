<?php
if(isset($_GET['list_orders'])){
    $delete_brands=$_GET['list_orders'];
    $delete_query="Delete from `user_orders` where order_id=$delete_brands";
    $result=mysqli_query($con,$delete_query);
    if($result){
        echo "<script>alert('Brands has been Deleted Successfully')</script>";
        echo "<script>window.open('./index.php?view_brands','_self')</script>";
    }
}




?>