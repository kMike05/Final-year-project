
<?php
    include('dashboard.php');
    include('config1.php');

   if(isset($_POST['submit'])){
    $type=$_POST['ticket_type'];
    $price=$_POST['ticket_price'];
    $icon=$_POST['icon'];
    $Description=$_POST['Description'];

    $sql="INSERT INTO tbl_tickets SET 
    Ticket_type='$type',
    Ticket_price='$price',
    font_awesome_icon='$icon',
    Ticket_description='$Description'

    ";
    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['add_ticket'] = "<div class='success'>Ticket added successfully!!</div>";
        
        //REDIRECT
        header('location:'.SITEURL.'HallerAdmin/manage-tickets.php');
        exit(); // Exit after redirection
    } else {
        echo "<div class='error'>Failed to add ticket. Try again later!!</div>";
    }
   }?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="admin.css">
    <script defer src="/script.js"></script>

	<title>Staff</title>
</head>
<body>
        <div class="form-container">
        <h2>Add Ticket</h2>
     
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="Ticket_type">Ticket_type</label>
                <input type="text" id="ticket_type" name="ticket_type" placeholder="Enter Ticket_type" value="" required>
            </div>
            <div class="form-group">
                <label for="ticket_price">Price</label>
                <input type="Text" id="ticket_price" name="ticket_price" placeholder="Enter Ticket price" value="" min="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
            <label for="icon">Font Awesome Icon:</label>
            <input type="text" id="icon" name="icon" placeholder="E.g., fa-solid fa-ticket-alt">
            </div>
            <div class="form-group">
                <label for="event_name">Description</label>
                <textarea id="message" name="Description" placeholder="Description of ticket" cols="30" rows="5"></textarea>
            </div>


            <input type="hidden" name="id" value="">
            <button type="submit" name="submit" class="btn-primary">Add Ticket</button>
        
        </form>
    </div>

<script>
    function validateForm() {
        var eventName = document.getElementById("event_name").value.trim();
        var eventdate = document.getElementById("event_date").value.trim();
        var description = document.getElementById("message").value.trim();
        var picture = document.getElementById("event_pic").value.trim();

        // Regular expression to match only letters and spaces
        var lettersOnly = /^[A-Za-z\s]+$/;

        if (eventName === "") {
            alert("Please enter event name");
            return false;
        }
        if (!eventName.match(lettersOnly)) {
            alert("event name should contain only letters");
            return false;
        }
        if (eventdate === "") {
            alert("Please enter event date");
            return false;
        }
        // Check if description contains only letters and spaces
        if (description === "" || !description.match(lettersOnly)) {
            alert("Description should contain only letters");
            return false;
        }


        return true;
    }
</script>
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