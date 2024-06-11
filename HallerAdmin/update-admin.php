<?php
include('config1.php');

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        die("Name must contain only letters and spaces.");
    }

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
    $sql = "UPDATE tbl_admin SET
        name='$name',
        email='$email',
        role='$role',
        admin_pic='$admin_pic'
        WHERE id='$id'";

    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['update'] = "<div class='success'>Admin updated successfully!!</div>";
        header('location:'.SITEURL.'HallerAdmin/manage-admin.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update Admin. Try again later!!</div>";
        header('location:'.SITEURL.'HallerAdmin/manage-admin.php');
    }
}

$id = $_GET['id'];
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
        header('location:'.SITEURL.'HallerAdmin/manage-admin.php');
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
	<style>
        .error-border {
            border: 1px solid red !important;
        }
        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>
	<script defer src="/script.js"></script>

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
			<li>
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="manage-events.php">
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
				<a href="manage-species.php">
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

			<li>
			<a href="signout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
        <div id="profilePopup" class="popup">
  <span class="close-button" onclick="closePopup()">&times;</span>
  <?php
                        if(isset($_SESSION['error'])){ 
							echo $_SESSION['error']; 
                        	unset($_SESSION['error']); 

						}?>
  <h2>Change Password</h2>
  <form action="change-password.php" method="POST">
  <label for="oldpass">Old Password</label>
            <input type="password" id="oldpass" name="password" placeholder="Old Password" value="" required>	  
  <label for="newpass">New Password</label>
            <input type="password" id="newpass" name="newpass" placeholder="New Password" value="" required>
            <label for="confirmpass">Confirm New Password</label>
            <input type="password" id="confirmpass" name="confirmpass" placeholder="Confirm Password" value="" required>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" name="submit" class="btn-primary">Change Password</button>
  </form>
</div>
<div class="overlay" onclick="closePopup()"></div>
	</section>

<script>
  document.getElementById("profileButton").addEventListener("click", function() {
    document.getElementById("profilePopup").classList.add("active");
    document.querySelector(".overlay").classList.add("active");
	
  });

  function closePopup() {
    document.getElementById("profilePopup").classList.remove("active");
    document.querySelector(".overlay").classList.remove("active");
  }
</script>

	</section>
	<!-- SIDEBAR -->
	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<!-- <nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
		</nav> -->
		<!-- NAVBAR -->
        <main>
			<div class="head-title">
        <div class="left">
					<ul class="breadcrumb">	
						<li><i class='bx bx-chevron-left' ></i></li>
						<li>
							<a class="active" href="manage-admin.php">Back</a>
						</li>
					</ul>
    </div>
    </main>
        <div class="form-container">
        <h2>Update Admin</h2>
        <?php
        $id=$_GET['id'];
        
        $sql="SELECT * FROM tbl_admin WHERE id=$id";
        $res=mysqli_query($conn, $sql);

        if($res==true){
            $count= mysqli_num_rows($res);

            if($count==1){
                //echo "Admin Available";
                $row=mysqli_fetch_assoc($res);

                $name=$row['name'];
                $email=$row['email'];
                $role=$row['role'];
                $admin_pic=$row['admin_pic'];


            }else{
                header('location:'.SITEURL.'HallerAdmin/manage-admin.php');
            }
        }

        ?>
        <form id="admin-form" action="" enctype="multipart/form-data" method="POST">
		<?php
if(isset($_SESSION['update']))
{
echo $_SESSION['update'];
unset($_SESSION['update']); 
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <div class="form-group">
                
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter full name" value="<?php echo $name;?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email" value="<?php echo $email;?>">
            </div>
            <div class="form-group">
            <select name="role" required class="form-select">
        <option value="" disabled>Select role</option>
        <option value="Zookeeper" <?php if($role == "Zookeeper") echo "selected"; ?>>Zookeeper</option>
        <option value="Veterinary" <?php if($role == "Veterinary") echo "selected"; ?>>Veterinary</option>
    </select>
            </div>
		        <div class="form-group">
                <label for="count">Admin Photo</label>
                <input type="file" id="animal_pic" name="admin_pic" min="1" placeholder="admin_pic">
            </div>
            <input type="hidden" name="old_admin_pic" value="<?php echo $admin_pic; ?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <button type="submit" name="submit" id="updateAdminBtn" class="btn-primary">Update Admin</button>
</form>
<script>
    document.getElementById('updateAdminBtn').addEventListener('click', function(event) {
        const nameInput = document.getElementById('name').value;
        const namePattern = /^[a-zA-Z\s]+$/;

        if (!namePattern.test(nameInput)) {
            alert('Name must contain only letters and spaces.');
            event.preventDefault();
        }
    });
</script>

    <!-- End Form -->
	<script src="script.js"></script>
    <style>

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
