<?php
session_start(); // Ensure the session is started
include('config.php');

if (!isset($_SESSION['admin_name'])) {
    header('location: admin-login.php');
    exit(); // Stop further execution
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    // Retrieve admin's email or username from the session
    $email_or_username = $_SESSION['admin_name'];

    // Sanitize and validate input
    $current_password = mysqli_real_escape_string($conn, $_POST['password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['newpass']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirmpass']);

    // Check if new passwords match
    if ($new_password === $confirm_password) {
        // Query to fetch user data based on email or username
        $query = "SELECT id, password FROM tbl_admin WHERE email = '$email_or_username' OR name = '$email_or_username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];
            $admin_id = $row['id'];

            // Verify if the current password matches the stored password
            if (password_verify($current_password, $stored_password)) {
                // Hash the new password and update the database
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE tbl_admin SET password='$hashed_password' WHERE id=$admin_id";
                
                // Debugging: Print the SQL query and check for errors
                echo "Update SQL: $update_sql<br>";

                $res2 = mysqli_query($conn, $update_sql);

                if ($res2) {
                    $_SESSION['pass'] = "Password changed successfully.";
                    header('location: admin-login.php');
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to update password: " . mysqli_error($conn);
                    header('location: change-password.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = "Current password is incorrect";
                header('location: change-password.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Failed to fetch user data: " . mysqli_error($conn);
            header('location: change-password.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Passwords do not match!";
        header('location: change-password.php');
        exit();
    }
}
?>
