<?php
session_start(); 
include('config1.php');

$id = $_GET['id'];

$sql = "DELETE FROM user_form WHERE id=$id";
$res = mysqli_query($conn, $sql);

if($res == true){
    $_SESSION['delete'] = "<div class='success'>User deleted successfully!!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-users.php');
} else {
    $_SESSION['delete'] = "<div class='error'>Failed to delete User. Try again later!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-users.php');
}
?>
