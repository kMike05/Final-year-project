<?php
session_start();
include('config1.php');
$id = mysqli_real_escape_string($conn, $_GET['id']);
$current_admin_id = $_SESSION['id'];
echo "ID from URL: " . $id . "<br>";
echo "Current Admin ID: " . $current_admin_id . "<br>";

if ($id == $current_admin_id) {
    $_SESSION['delete'] = "<div class='error'>You cannot delete your own account!</div>";
} else {
    $sql = "DELETE FROM tbl_mainadmin WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['delete'] = "<div class='success'>Admin deleted successfully!!</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. Try again later!</div>";
    }
}
header('location:'.SITEURL.'HallerAdmin/manage-mainadmin.php');
exit();
?>
