<?php

include('config1.php');

// Handle form submission
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
	$role=$_POST['role'];
    $password = $_POST['password']; // Plain password

	$admin_pic=$_FILES['admin_pic']['name'];
    $tmp_name=$_FILES['admin_pic']['tmp_name'];
    $folder='img/'.$admin_pic;

    if(move_uploaded_file($tmp_name, $folder)) {
        echo "<h2>File uploaded successfully</h2>";
    } else {
        echo "<h2>File not uploaded</h2>";
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $user_type = $_POST['user_type'];


    $sql = "INSERT INTO tbl_admin SET
        name='$name',
        email='$email',
		role='$role',
        password='$hashed_password',
		admin_pic='$admin_pic'";
        
    $res = mysqli_query($conn, $sql);

    if($res == TRUE) {
        $_SESSION['add'] = "<div class='success'>Admin added successfully!!</div>";
        

        header('location:' . SITEURL . 'HallerAdmin/manage-admin.php');
        exit(); 
    } else {
        echo "<div class='error'>Failed to add Admin. Try again later!!</div>";
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
    <style>
   .popup {
	display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        z-index: 9999;
        width: 65%;
        max-width: 500px;
     
  }
  .overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    z-index: 998;
  }

  .popup.active,
  .overlay.active {
    display: block;
  }

  .popup h2 {
    margin-top: 0;
    margin-bottom: 20px;
    text-align: center;
    font-size: 24px;
  }

  .popup form {
    text-align: center;
  }

  .popup label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
  }

  .popup input[type="text"],
  .popup input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
  }

  .popup input[type="submit"] {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 15px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
  }
  .overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 998;
  }


  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
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
				<a href="admin-dashboard.php">
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
				<a href="manage-tickets.php">
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
				<i class='bx bxs-donate-heart'></i>
					<span class="text">Donations</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">

			<li>
			<a href="signout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<form action="#">
				<div class="form-input">
					
				</div>
			</form>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
		</nav>
		<!-- NAVBAR -->

        <!-- MAIN -->
        <div class="form-container">
        <h2>Add Admin</h2>
		
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
		<?php
if(isset($_SESSION['add']))
{
echo $_SESSION['add']; //Displaying Session Message
unset($_SESSION['add']); //Removing Session Message
}
?>
<script>
function validateNameInput(input) {
    // Remove non-alphabetic characters from the input value
    input.value = input.value.replace(/[^a-zA-Z]/g, '');
}

</script>
         <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter full name" oninput="validateNameInput(this)" required>
            <div id="nameError" class="error-message"></div> <!-- Error message placeholder -->
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter email" required>
        </div>
		<select name="role" required class="form-select">
    <option value="" disabled selected>Select role</option>
    <option>Zookeeper</option>
    <option>Veterinary</option>
</select>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
            <div id="passwordError" class="error-message"></div> <!-- Error message placeholder -->
        </div>
		<div class="form-group">

            </div>
		<div class="form-group">
                <label for="count">Admin Photo</label>
                <input type="file" id="animal_pic" name="admin_pic" min="1" placeholder="admin_pic" required>
            </div>
        <button type="submit" name="submit" class="btn-primary">Add Admin</button>
    </form>
</div>



    <!-- End Form -->
	<script src="script.js"></script>
	<script>
function validateForm() {
    var name = document.getElementById("name").value.trim();
    var password = document.getElementById("password").value.trim();

    var nameRegex = /^[a-zA-Z\s]+$/;
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;

    var errors = [];

    if (!nameRegex.test(name)) {
        errors.push("Name should contain only letters.");
        document.getElementById("name").classList.add('error-border');
        document.getElementById("nameError").innerText = "Name should contain only letters.";
    } else {
        document.getElementById("name").classList.remove('error-border');
        document.getElementById("nameError").innerText = "";
    }

    if (!passwordRegex.test(password)) {
        errors.push("Password must contain at least 8 characters including at least one uppercase letter, one lowercase letter, one number, and one special character.");
        document.getElementById("password").classList.add('error-border');
        document.getElementById("passwordError").innerText = "Password must contain at least 8 characters including at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } else {
        document.getElementById("password").classList.remove('error-border');
        document.getElementById("passwordError").innerText = "";
    }

    if (errors.length > 0) {
        return false;
    }

    return true;
}
</script>
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
    
	

           