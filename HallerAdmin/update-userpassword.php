<?php
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
        $update_sql = "UPDATE user_form SET password='$hashed_password' WHERE id=" . (int)$id;

        $res2=mysqli_query($conn, $update_sql);
        if($res2==true)
        {
            $_SESSION['pass'] = "Password changed successfully.";
            header('location: manage-users.php');
            exit();
        }
        else
        {
            $_SESSION['error'] = "Failed to update password";
            header('location: manage-users.php');
            exit();
        }   
    }
    else
    {
        $_SESSION['error'] = "Passwords do not match!";
        header('location: manage-users.php');
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

	<title>Admin</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Admin</span>
		</a>
		
		
		<ul class="side-menu top">
			<li >
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="view-events.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Events</span>
				</a>
			</li>
			<li>
				<a href="view-tickets.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Tickets</span>
				</a>
			</li>
			<li>
				<a href="view-animal.php">
				<i class='bx bxl-baidu'></i>
					<span class="text">Animals</span>
				</a>
			</li>
			<li>
				<a href="manage-admin.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="profile.php">
					<i class='bx bxs-face' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<?php
$sql_orders_count = "SELECT COUNT(*) AS total_orders FROM tbl_payment WHERE status = 'unapproved'";
$result_orders_count = $conn->query($sql_orders_count);
$row_orders_count = $result_orders_count->fetch_assoc();
$total_orders_count = $row_orders_count['total_orders'];
?>

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>

			<form action="#">
				<div class="form-input">
					<input type="hidden" placeholder="Search...">
				
				</div>
			</form>


		</nav>
		<!-- NAVBAR -->
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
        
        $sql="SELECT * FROM user_form WHERE id=$id";
        $res=mysqli_query($conn, $sql);

        if($res==true){
            $count= mysqli_num_rows($res);

            if($count==1){
                $row=mysqli_fetch_assoc($res);
                $name=$row['name'];
                $email=$row['email'];
            }else{
                header('location: manage-users.php');
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
