<?php
include 'config.php';
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") 
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['id_number']);
    $donationAmount = mysqli_real_escape_string($conn, $_POST['donationAmount']);
    $mpesaCode = mysqli_real_escape_string($conn, $_POST['MpesaCode']);

    // Check if all fields are filled
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($donationAmount) && !empty($mpesaCode)) {
        $sql_insert = "INSERT INTO tbl_donation (name, email, Phone_number, amount, Mpesa_code)
                        VALUES ('$name', '$email', '$phone', '$donationAmount', '$mpesaCode')";

        if ($conn->query($sql_insert) === TRUE) {
            // Success, redirect to home page
            header('location:Home.php');
            exit; // Make sure to exit after redirection
        } else {
            $_SESSION['errorMsg'] = "Error inserting donation details: " . $conn->error;
        }
    } else {
        $_SESSION['errorMsg'] = "Please fill out all the required fields.";
    }

// If redirection doesn't happen, redirect to home page
header('location:Home.php');
exit;
?>
