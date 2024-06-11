<?php
include('dashboard.php');
include('config1.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $current_password = $_POST['password'];
    $new_password = $_POST['newpass'];
    $confirm_password = $_POST['confirmpass'];

    // Validate and sanitize input
    $id = mysqli_real_escape_string($conn, $id);
    $current_password = mysqli_real_escape_string($conn, $current_password);
    $new_password = mysqli_real_escape_string($conn, $new_password);
    $confirm_password = mysqli_real_escape_string($conn, $confirm_password);

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Check if new passwords match
    if($new_password == $confirm_password) {
        $update_sql = "UPDATE tbl_admin SET password='$hashed_password' WHERE id=" . (int)$id;

        $res2=mysqli_query($conn, $update_sql);
        if($res2==true)
        {
            $_SESSION['pass'] = "Password changed successfully.";
            header('location: manage-admin.php');
            exit();
        }
        else
        {
            $_SESSION['error'] = "Failed to update password";
            header('location: manage-admin.php');
            exit();
        }   
    }
    else
    {
        $_SESSION['error'] = "Passwords do not match!";
        header('location: manage-admin.php');
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
    <title>Admin</title>
</head>
<body>
<div class="form-container">
    <h2>Change Password</h2>
    <?php
    if(isset($_SESSION['error'])) {
        echo $_SESSION['error']; // Display Session Error
        unset($_SESSION['error']); // Remove Session Error
    }
    ?>
    <form id="admin-form" action="" method="POST">
        <?php
        $id=$_GET['id'];
        
        $sql="SELECT * FROM tbl_admin WHERE id=$id";
        $res=mysqli_query($conn, $sql);

        if($res==true){
            $count= mysqli_num_rows($res);

            if($count==1){
                $row=mysqli_fetch_assoc($res);
                $name=$row['name'];
                $email=$row['email'];
            }else{
                header('location: manage-admin.php');
            }
        }
        ?>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter full name" value="<?php echo $name;?>" readonly>
        </div>
        <div class="form-group">
            <label for="newpass">New Password</label>
            <input type="password" id="newpass" name="newpass" placeholder="New Password" value="" required>
        </div>
        <div class="form-group">
            <label for="confirmpass">Confirm New Password</label>
            <input type="password" id="confirmpass" name="confirmpass" placeholder="Confirm Password" value="" required>
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" name="submit" class="btn-primary">Change Password</button>
    </form>
</div>
</body>
</html>
