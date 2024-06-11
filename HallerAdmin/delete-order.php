<?php
include('config1.php');
session_start(); 

if(isset($_GET['id'])) {
   
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM tbl_payment WHERE id='$id'";

    $res = mysqli_query($conn, $sql);

    if($res) {
        $_SESSION['delete_order'] = "<div class='success'>Order deleted successfully!</div>";
        header('location:'.SITEURL.'HallerAdmin/ticket-orders.php');
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete order. Try again later!</div>";
    }
} else {
    $_SESSION['delete'] = "<div class='error'>Order ID not provided!</div>";
}

header('location:' . SITEURL . 'HallerAdmin/ticket-orders.php');
exit; 
?>
