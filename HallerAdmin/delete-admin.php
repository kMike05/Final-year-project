<?php
session_start(); 
include('config1.php');

$id = $_GET['id'];
$current_admin_id = $_SESSION['id'];

if($id == $current_admin_id){
    $_SESSION['delete'] = "<div class='error'>You cannot delete your own account!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-admin.php');
    exit(); 
}

$sql = "DELETE FROM tbl_admin WHERE id=$id";
$res = mysqli_query($conn, $sql);

if($res == true){
    $_SESSION['delete'] = "<div class='success'>Staff deleted successfully!!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-admin.php');
} else {
    $_SESSION['delete'] = "<div class='error'>Failed to delete Staff. Try again later!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-admin.php');
}
?>
