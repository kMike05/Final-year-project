<?php
include('dashboard.php');
include('config1.php');

if(isset($_POST['submit'])){
    $id=$_POST['id']; // Retrieve the ID from the form
    $type=$_POST['ticket_type'];
    $price=$_POST['ticket_price'];
    $icon=$_POST['icon'];
    $Description=$_POST['Description'];

 
    // Update the database with the new data
    $sql = "UPDATE tbl_tickets SET
     Ticket_type='" . mysqli_real_escape_string($conn, $type) . "',
    Ticket_price='" . mysqli_real_escape_string($conn, $price) . "',
    font_awesome_icon='" . mysqli_real_escape_string($conn,$icon)."',
    Ticket_description='" . mysqli_real_escape_string($conn,$Description) . "'
    WHERE Ticket_id = " . mysqli_real_escape_string($conn, $id);

    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['update_ticket'] = "<div class='success'>ticket updated successfully!!</div>";
        // REDIRECT
        header('location:' . SITEURL . 'HallerAdmin/manage-tickets.php');
    } else {
        $_SESSION['failed_ticket'] = "<div class='error'>Failed to update ticket. Try again later!!</div>";
        header('location:' . SITEURL . 'HallerAdmin/manage-tickets.php');
    }
} else {
    // Fetch tickets details for prefilling the form
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_tickets WHERE Ticket_id=$id";
        $res = mysqli_query($conn, $sql);

        if($res == true) {
            $count = mysqli_num_rows($res);
            if($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $type=$row['Ticket_type'];
                $price=$row['Ticket_price'];
                $icon=$row['font_awesome_icon'];
                $Description=$row['Ticket_description'];
            } else {
                header('location:' . SITEURL . 'HallerAdmin/manage-ticketss.php');
                exit();
            }
        }
    } else {
        header('location:' . SITEURL . 'HallerAdmin/manage-ticketss.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="admin.css">
    <link rel="stylesheet"  href="main.css">
	<script defer src="/script.js"></script>

	<title>Admin</title>
</head>
<body>
        <div class="form-container">
        <h2>Update Ticket</h2>
        <?php
        $id=$_GET['id'];
        
        $sql="SELECT * FROM tbl_tickets WHERE Ticket_id=$id";
        $res=mysqli_query($conn, $sql);

        if($res==true){
            $count= mysqli_num_rows($res);

            if($count==1){
                
                $row=mysqli_fetch_assoc($res);

                $type=$row['Ticket_type'];
                $price=$row['Ticket_price'];
                $icon=$row['font_awesome_icon'];
                $Description=$row['Ticket_description'];

            }else{
                header('location:'.SITEURL.'HallerAdmin/manage-tickets.php');
            }
        }

        ?>
        <form id="admin-form" action="" method="POST"  onsubmit="return validateForm()">
        <?php
if(isset($_SESSION['update_ticket']))
{
echo $_SESSION['update_ticket']; //Display Session Message
unset($_SESSION['update_ticket']); //Remove Session Message
}
?>
     <div class="form-group">
                <label for="Ticket_type">Ticket_type</label>
                <input type="text" id="ticket_type" name="ticket_type" placeholder="Enter Ticket_type" value="<?php echo $type;?>" required>
            </div>
            <div class="form-group">
                <label for="ticket_price">Price</label>
                <input type="Text" id="ticket_price" name="ticket_price" placeholder="Enter Ticket price" value="<?php echo $price;?>" required>
            </div>
            <div class="form-group">
            <label for="icon">Font Awesome Icon:</label>
            <input type="text" id="icon" name="icon" value="<?php echo $icon;?>" placeholder="E.g., fa-solid fa-ticket-alt">
            </div>
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea id="message" name="Description" placeholder="Description of ticket" cols="30" rows="5"><?php echo $Description; ?></textarea>
            </div>


    <input type="hidden" name="id" value="<?php echo $id;?>">
    <button type="submit" name="submit" class="btn-primary">Update Ticket</button>

</form>
</div>
   
    <!-- End Form -->
	<script src="script.js"></script>
    <style>
        textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-family: Arial, sans-serif;
    resize: vertical; /* Allow vertical resizing */
    min-height: 150px; /* Set a minimum height */
    width: 100%; /* Set the width to 100% of the container */
    box-sizing: border-box; /* Ensure padding and border are included in the element's total width */
}

    </style>
</body>
</html>
