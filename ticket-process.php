<?php
include 'config.php';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Form data validation and sanitation
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $date = $_POST['date'];
    $mpesaCode = trim($_POST['MpesaCode']);
    $ticketType = $_POST['selectedTicketType'];
    $ticketPrice = $_POST['selectedTicketPrice'];

    // Check if M-Pesa code already exists in the database
    $sql_check = "SELECT * FROM tbl_payment WHERE Mpesa_code = '$mpesaCode'";
    $result_check = $conn->query($sql_check);
    if ($result_check === FALSE) {
        $_SESSION['errorMsg'] = "Error checking M-Pesa code: " . $conn->error;
    } else {
        if ($result_check->num_rows > 0) {
            $_SESSION['errorMsg'] = "M-Pesa code already used.";
            exit(); // Exit if M-Pesa code already exists
        }
    }

    // Insert payment details into tbl_payment table
    $sql_insert = "INSERT INTO tbl_payment (email, Phone_number, Visit_date, Mpesa_code, Ticket_type, Ticket_price)
                   VALUES ('$email', '$phone', '$date', '$mpesaCode', '$ticketType', '$ticketPrice')";
    if ($conn->query($sql_insert) === TRUE) {
        header('location:Home.php');
 
    } else {
        // Error occurred while inserting data
        $_SESSION['errorMsg'] = "Error inserting payment details: " . $conn->error;
    }
}

// Get error message from session
$errorMsg = isset($_SESSION['errorMsg']) ? $_SESSION['errorMsg'] : "";

// Clear error message from session
unset($_SESSION['errorMsg']);

header('location:Home.php');
exit;
?>
