<?php
include('config1.php');

if(isset($_POST['submit'])){
    $id = $_POST['id'];
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
        // No new admin picture uploaded, retain the original one
        $admin_pic = $_POST['old_admin_pic'];
    }

    // Update the admin information in the database
    $sql = "UPDATE tbl_mainadmin SET
        name='$name',
        email='$email',
        role='$role',
        admin_pic='$admin_pic'
        WHERE id='$id'";

    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['update'] = "<div class='success'>Admin updated successfully!!</div>";
        header('location:'.SITEURL.'HallerAdmin/manage-mainadmin.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update Admin. Try again later!!</div>";
        header('location:'.SITEURL.'HallerAdmin/manage-mainadmin.php');
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_mainadmin WHERE id=$id";
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
        header('location:'.SITEURL.'HallerAdmin/manage-mainadmin.php');
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
        <h2>Update Admin</h2>
        <?php
        $id=$_GET['id'];
        
        $sql="SELECT * FROM tbl_mainadmin WHERE id=$id";
        $res=mysqli_query($conn, $sql);

        if($res==true){
            $count= mysqli_num_rows($res);

            if($count==1){
                //echo "Admin Available";
                $row=mysqli_fetch_assoc($res);

                $name=$row['name'];
                $email=$row['email'];
                $admin_pic=$row['admin_pic'];
                $role=$row['role'];


            }else{
                header('location:'.SITEURL.'HallerAdmin/manage-mainadmin.php');
            }
        }

        ?>
        <form id="admin-form" action="" enctype="multipart/form-data" method="POST">
		<?php
if(isset($_SESSION['update']))
{
echo $_SESSION['update']; //Display Session Message
unset($_SESSION['update']); //Remove Session Message
}
?>
            <div class="form-group">
                
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter full name" value="<?php echo $name;?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email" value="<?php echo $email;?>">
                <input type="hidden" id="role" name="role" placeholder="Enter role" value="<?php echo $role;?>">
            </div>
		        <div class="form-group">
                <label for="count">Admin Photo</label>
                <input type="file" id="animal_pic" name="admin_pic" min="1" placeholder="admin_pic">
            </div>
            <input type="hidden" name="old_admin_pic" value="<?php echo $admin_pic; ?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <button type="submit" name="submit" class="btn-primary">Update Admin</button>
        
        </form>
    </div>

    <!-- End Form -->
	<script src="script.js"></script>
    <style>
/* CSS styles for the select element */
.form-select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-sizing: border-box;
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 18px 18px;
    cursor: pointer;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

/* CSS styles for select options */
.form-select option {
    padding: 10px;
    background-color: #ffffff;
    color: #000000;
}


</style>

</body>
</html>
