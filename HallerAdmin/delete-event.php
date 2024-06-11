<?php
 include('config1.php');

 $id=$_GET['id'];

 $sql="DELETE FROM tbl_event WHERE id=$id";
 $res=mysqli_query($conn, $sql);

 if($res==true){

    $_SESSION['delete_event']= "<div class='success'>Event deleted successfully!!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-events.php');

 }
 else
 {
 
    $_SESSION['delete']= "<div class='error'>Failed to delete event.Try again later!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-event.php');

 }
?>