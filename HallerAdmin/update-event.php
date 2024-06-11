<?php
include('dashboard.php');
include('config1.php');

if(isset($_POST['submit'])){
    $id=$_POST['id']; // Retrieve the ID from the form

    $name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $Description = $_POST['event_description'];

    $event_pic = $_FILES['event_pic']['name'];
    $tmp_name = $_FILES['event_pic']['tmp_name'];
    $folder = 'img/' . $event_pic;

    if($event_pic != "") {
        // If a new file is uploaded, move it to the destination folder
        if(move_uploaded_file($tmp_name, $folder)) {
            echo "<h2>File uploaded successfully</h2>";
        } else {
            echo "<h2>File not uploaded</h2>";
        }
    }

    // Update the database with the new data
    $sql = "UPDATE tbl_event SET
    event_name='" . mysqli_real_escape_string($conn, $name) . "',
    event_date='" . mysqli_real_escape_string($conn, $event_date) . "',
    event_description='" . mysqli_real_escape_string($conn, $Description) . "'
    ";

// Check if a new file is uploaded, if yes, update the filename in the database
if ($event_pic != "") {
    $sql .= ", event_pic='" . mysqli_real_escape_string($conn, $event_pic) . "'";
}

$sql .= " WHERE id='" . mysqli_real_escape_string($conn, $id) . "'";

    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['update_event'] = "<div class='success'>Event updated successfully!!</div>";
        // REDIRECT
        header('location:' . SITEURL . 'HallerAdmin/manage-events.php');
    } else {
        $_SESSION['failed_event'] = "<div class='error'>Failed to update event. Try again later!!</div>";
        header('location:' . SITEURL . 'HallerAdmin/manage-event.php');
    }
} else {
    // Fetch event details for prefilling the form
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_event WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res == true) {
            $count = mysqli_num_rows($res);
            if($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $name = $row['event_name'];
                $event_date = $row['event_date'];
                $Description = $row['event_description'];
            } else {
                header('location:' . SITEURL . 'HallerAdmin/manage-events.php');
                exit();
            }
        }
    } else {
        header('location:' . SITEURL . 'HallerAdmin/manage-events.php');
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
        <h2>Update event</h2>
        <?php
        $id=$_GET['id'];
        
        $sql="SELECT * FROM tbl_event WHERE id=$id";
        $res=mysqli_query($conn, $sql);

        if($res==true){
            $count= mysqli_num_rows($res);

            if($count==1){
                
                $row=mysqli_fetch_assoc($res);

                $pic=$row['event_pic'];
                $id=$row['id'];
                $name=$row['event_name'];
                $Description=$row['event_description'];

            }else{
                header('location:'.SITEURL.'HallerAdmin/manage-events.php');
            }
        }

        ?>
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <?php
if(isset($_SESSION['update_event']))
{
echo $_SESSION['update_event']; //Display Session Message
unset($_SESSION['update_event']); //Remove Session Message
}
?>
    <div class="form-group">
        <label for="event_name">event Name</label>
        <input type="text" id="event_name" name="event_name" placeholder="Enter event name" value="<?php echo $name;?>" required>
    </div>
    <div class="form-group">
        <label for="event_date">Date</label>
        <input type="date" id="event_date" name="event_date" placeholder="Enter event date" value="<?php echo $event_date;?>" min="<?= date('Y-m-d') ?>" required>
    </div>
    <div class="form-group">
        <label for="event_name">Description</label>
        <textarea id="message" name="event_description" placeholder="Description of the event"  cols="30" rows="5" ><?php echo $Description; ?></textarea>
    </div>
    <div class="form-group">
        <label for="count">Picture</label>
        <input type="file" id="event_pic" name="event_pic" min="1" placeholder="event_pic" >
    </div>


    <input type="hidden" name="id" value="<?php echo $id;?>">
    <button type="submit" name="submit" class="btn-primary">Update event</button>

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
