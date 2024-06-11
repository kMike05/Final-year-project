<?php
// Include database connection
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date_of_visit = $_POST['date'];
    $mpesa_code = $_POST['MpesaCode'];
    $ticket_type = $_POST['ticketType'];
    $ticket_price = $_POST['ticketPrice'];

    // Insert data into tbl_payment table
    $sql = "INSERT INTO tbl_payment (name, email, Phone_number, Visit_date, Mpesa_code, Ticket_type, Ticket_price) VALUES ( '$name','$email', '$phone', '$date_of_visit', '$mpesa_code', '$ticket_type', '$ticket_price')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = 'Your Payment has been received';
        header('Location: ' . $_SERVER['HTTP_REFERER']); // Redirect to the referring page to avoid form resubmission
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Form submission failed.";
}

// Close database connection
$conn->close();
?>
