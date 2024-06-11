<?php
 include('config1.php');

 $id=$_GET['id'];

 $sql="DELETE FROM tbl_species WHERE id=$id";
 $res=mysqli_query($conn, $sql);

 if($res==true){

    $_SESSION['delete_species']= "<div class='success'>Species deleted successfully!!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-species.php');

 }
 else
 {
 
    $_SESSION['delete']= "<div class='error'>Failed to delete Species.Try again later!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-species.php');

 }
?>