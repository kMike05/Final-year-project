<?php
include('dashboard.php');
include('config1.php');

// After successful authentication
if(isset($_POST['submit'])){
    $id = $_SESSION['id']; // Use the admin_id from the session instead of form input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Check if a new admin picture is uploaded
    if ($_FILES['admin_pic']['error'] === 0) {
        $admin_pic = $_FILES['admin_pic']['name'];
        $tmp_name = $_FILES['admin_pic']['tmp_name'];
        $folder = 'img/' . $admin_pic;

        // Move the uploaded file to the destination folder
        if(move_uploaded_file($tmp_name, $folder)) {
            echo "<h2>File uploaded successfully</h2>";
        } else {
            echo "<h2>File not uploaded</h2>";
        }
    } else {
        $admin_pic = $_POST['old_admin_pic'];
    }

    $sql = "UPDATE tbl_admin SET
        name='$name',
        email='$email',
        role='$role',
        admin_pic='$admin_pic'
        WHERE id='$id'";


    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['update'] = "<div class='success'>Profile updated successfully!!</div>";
        header('location:'.SITEURL.'HallerAdmin/profile.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update profile. Try again later!!</div>";
        header('location:'.SITEURL.'HallerAdmin/profile.php');
    }
}

// Retrieve admin details from session
$id = $_SESSION['id'];
$sql = "SELECT * FROM tbl_admin WHERE id=$id";
$res = mysqli_query($conn, $sql);

if($res == true){
    $count = mysqli_num_rows($res);

    if($count == 1){
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $email = $row['email'];
        $role = $row['role'];
        $admin_pic = $row['admin_pic'];
    } else {
        header('location:'.SITEURL.'HallerAdmin/profile.php');
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
    <link rel="stylesheet" href="main.css">
    <script defer src="/script.js"></script>
    <title>Admin</title>
</head>
<body>
    <div class="form-container">
        <h2>Update Profile</h2>
        <?php
        if(isset($_SESSION['update'])){
            echo $_SESSION['update']; // Display Session Message
            unset($_SESSION['update']); // Remove Session Message
        }
        ?>
        <form id="admin-form" action="" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter full name" value="<?php echo $name;?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email" value="<?php echo $email;?>" required>
            </div>
            <div class="form-group">
                <select name="role" class="form-select" required>
                    <option value="" disabled>Select role</option>
                    <option value="Zookeeper" <?php if($role == "Zookeeper") echo "selected"; ?>>Zookeeper</option>
                    <option value="Veterinary" <?php if($role == "Veterinary") echo "selected"; ?>>Veterinary</option>
                </select>
            </div>
            <div class="form-group">
                <label for="admin_pic">Admin Photo</label>
                <input type="file" id="admin_pic" name="admin_pic" accept="image/*">
                <input type="hidden" name="old_admin_pic" value="<?php echo $admin_pic; ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <button type="submit" name="submit" class="btn-primary">Update Admin</button>
        </form>
    </div>
</body>
</html>
