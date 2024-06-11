<?php
 include('config1.php');

 $id=$_GET['id'];

 $sql="DELETE FROM tbl_tickets WHERE Ticket_id=$id";
 $res=mysqli_query($conn, $sql);

 if($res==true){
    //echo "Ticket deleted";
    $_SESSION['delete']= "<div class='success'>Ticket deleted successfully!!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-tickets.php');

 }
 else
 {
    //echo "Failed to delete Ticket";
    $_SESSION['delete']= "<div class='error'>Failed to delete Ticket.Try again later!</div>";
    header('location:'.SITEURL.'HallerAdmin/manage-tickets.php');

 }
?>