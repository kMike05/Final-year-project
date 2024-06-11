<?php
include('config1.php');
session_start(); 
// Confirming Order


if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "UPDATE tbl_payment SET status = 'approved', declined = 'no' WHERE id = $id";

    $res = mysqli_query($conn, $sql);

    if($res) {
        $_SESSION['confirm_order'] = "<div class='success'>Success!!</div>";

        header('location:ticket-orders.php');
        exit;
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed. Try again later!</div>";
    }
} else {
    $_SESSION['delete'] = "<div class='error'>Order ID not provided!</div>";
}
header('location: ticket-orders.php');
exit; 
?>
