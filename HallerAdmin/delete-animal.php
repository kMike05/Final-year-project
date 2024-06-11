<?php
 include('config1.php');

 $id=$_GET['id'];

 $sql="DELETE FROM tbl_animal WHERE id=$id";
 $res=mysqli_query($conn, $sql);

 if($res==true){

    $_SESSION['delete_animal']= "<div class='success'>Animal deleted successfully!!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-animal.php');

 }
 else
 {
 
    $_SESSION['delete']= "<div class='error'>Failed to delete animal.Try again later!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-animal.php');

 }
?>