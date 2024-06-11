<?php
date_default_timezone_set('Africa/Nairobi');
// Include mailer configuration
$mail = require __DIR__ . "/mailer.php";

// Check if email is set in $_POST
if (isset($_POST["email"])) {
    $email = $_POST["email"];

    $token = bin2hex(random_bytes(16)); // Generate a random token
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30); // Set expiry time to 30 minutes from now

    // Debugging: Output the calculated expiry time
    error_log("Calculated expiry time: $expiry");

    // Include database connection
    $mysqli = require __DIR__ . "/database.php";

    // Update database with reset token
    $sql = "UPDATE user_form
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        // Error handling for query preparation failure
        die("Error preparing query: " . $mysqli->error);
    }
    $stmt->bind_param("sss", $token, $expiry, $email);
    if (!$stmt->execute()) {
        // Error handling for query execution failure
        die("Error executing query: " . $stmt->error);
    }

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Add recipient email address
        $mail->addAddress($email);

        // Set sender email address
        $mail->setFrom("hallerpark1@gmail.com");

        // Set email subject
        $mail->Subject = "Password Reset";

        // Set email body
        $mail->Body = "Click <a href='http://localhost/FinalP/reset-password.php?token=$token'>here</a> to reset your password.";

        try {
            // Attempt to send email
            $mail->send();
            echo "Message sent, please check your inbox.";
        } catch (Exception $e) {
            // If an error occurs during email sending
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: Unable to update user record.";
    }

    // Close the statement and connection
    $stmt->close();
    $mysqli->close();
} else {
    echo "Email not provided.";
}
?>
