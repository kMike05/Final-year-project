<?php
include('dashboard.php');
include('config1.php');

require "vendor/autoload.php";
require "dompdf/autoload.inc.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Dompdf\Dompdf;
use Dompdf\Options;

if(isset($_POST['submit'])){
    $name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $Description = $_POST['Description'];
    $event_pic = $_FILES['event_pic']['name'];
    $tmp_name = $_FILES['event_pic']['tmp_name'];
    $folder = 'img/' . $event_pic;

    if(move_uploaded_file($tmp_name, $folder)) {
        echo "<h2>File uploaded successfully</h2>";
    } else {
        echo "<h2>File not uploaded</h2>";
    }

    $sql = "INSERT INTO tbl_event SET 
    event_name = '$name',
    event_date = '$event_date',
    event_description = '$Description',
    event_pic = '$event_pic'
    ";
    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['add_event'] = "<div class='success'>Event added successfully!!</div>";

        // Fetch all user emails from the database
        $getEmailsSql = "SELECT email FROM user_form";
        $getEmailsResult = mysqli_query($conn, $getEmailsSql);

        if($getEmailsResult) {
            // Configure PHPMailer
            $mail = new PHPMailer(true);
            $mail->SMTPAutoTLS = false;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username = "hallerpark1@gmail.com";
            $mail->Password = "xubr ccfb pwdr muzf";
            $mail->setFrom("hallerpark1@gmail.com");
            $mail->Subject = "Upcoming Event!!: $name";
            
            // Set the email format to HTML
            $mail->isHTML(true);
            
            // Create the HTML content for the email
            $mail->Body = "
            <html>
            <head>
                <style>
                    .email-container {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                    }
                    .email-header {
                        background-color: #045f27;
                        color: #fff;
                        padding: 10px;
                        text-align: center;
                    }
                    .email-content {
                        padding: 20px;
                        background-color: #f9f9f9;
                    }
                    .email-footer {
                        background-color: #eee;
                        padding: 10px;
                        text-align: center;
                        font-size: 12px;
                        color: #999;
                    }
                    .event-title {
                        font-size: 20px;
                        margin: 10px 0;
                    }
                    .event-date {
                        font-size: 16px;
                        margin: 10px 0;
                    }
                    .event-description {
                        font-size: 14px;
                        margin: 10px 0;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <h1>New Event Announcement</h1>
                    </div>
                    <div class='email-content'>
                        <p class='event-title'><strong>Name:</strong> $name</p>
                        <p class='event-date'><strong>Date:</strong> $event_date</p>
                        <p class='event-description'><strong>Description:</strong> $Description</p>
                    </div>
                    <div class='email-footer'>
                        <p>&copy; 2024 Haller Park. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            ";

            // Add the event image as an inline attachment
            $mail->AddEmbeddedImage($folder, 'event_image');

            while($row = mysqli_fetch_assoc($getEmailsResult)) {
                $email = $row['email'];
                // Add each user's email address as a recipient
                $mail->addAddress($email);
                $mail->addBCC($email);
            }

            // Send email
            try {
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "<div class='error'>Failed to fetch user emails.</div>";
        }

        // Redirect
        header('location:'.SITEURL.'HallerAdmin/manage-events.php');
        exit(); // Exit after redirection
    } else {
        echo "<div class='error'>Failed to add event. Try again later!!</div>";
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
    <script defer src="/script.js"></script>

    <title>Staff</title>
</head>
<body>
    <div class="form-container">
        <h2>Add event</h2>
     
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="event_name">Event Name</label>
                <input type="text" id="event_name" name="event_name" placeholder="Enter event name" value="" required>
            </div>
            <div class="form-group">
                <label for="event_date">Date</label>
                <input type="date" id="event_date" name="event_date" placeholder="Enter event date" value="" min="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea id="message" name="Description" placeholder="Description of the event" cols="30" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="event_pic">Picture</label>
                <input type="file" id="event_pic" name="event_pic" min="1" placeholder="Event Picture" required>
            </div>

            <input type="hidden" name="id" value="">
            <button type="submit" name="submit" class="btn-primary">Add event</button>
        
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
                alert("Event name should contain only letters");
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
            if (picture === "") {
                alert("Please select a picture");
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

