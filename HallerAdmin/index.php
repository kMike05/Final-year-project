<?php 
@include('config1.php');
if(!isset($_SESSION['admin_name'])){
    header('location:admin-login.php');
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

	<title>Staff</title>
	
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Staff</span>
		</a>
		
		
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
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
				<a href="manage-animal.php">
				<i class='bx bxl-baidu'></i>
					<span class="text">Animals</span>
				</a>
			</li>
			<li>
				<a href="view-admin.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
			<a href="id=<?php echo $id;?>" id="profileButton">
			<i class='bx bxs-key'></i>
					<span class="text">Change Pass</span>
				</a>
			</li>
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
			<a href="#" >
			<?php
			if(isset($_SESSION['admin_name'])){
				echo '<h4>Welcome, <span class="username">' . $_SESSION["admin_name"] . '</span></h4>';
			}
				?>
				</a>
			<a href="ticket-orders.php" class="notification" >
    <i class='bx bxs-bell'></i>
    <span class="num"><?php echo $total_orders_count; ?></span>
</a>

		</nav>
		</section>
		<!-- NAVBAR -->
		<section id="content">

		<!-- MAIN -->
		<?php
		$sql = "SELECT SUM(Animal_count) AS total_count FROM tbl_animal";
		$result = mysqli_query($conn, $sql);
		if($result) {
			$row = mysqli_fetch_assoc($result);
			$total_count = $row['total_count'];
		} else {
			$total_count = 0;
		}
		 ?>
<?php
$sql_users_count = "SELECT COUNT(*) AS total_users FROM user_form";
$result_users_count = $conn->query($sql_users_count);

if ($result_users_count && $result_users_count->num_rows > 0) {
    $row_users_count = $result_users_count->fetch_assoc();
    $total_users_count = $row_users_count['total_users'];
} else {
    $total_users_count = 0;
}
?>
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>

			</div>

			<ul class="box-info">
			<a href="ticket-orders.php" class="notification" >
				<li>
				<i class='bx bxs-dollar-circle'></i>
					<span class="text">
						<h3><?php echo $total_orders_count; ?></h3>
						<p>Ticket Orders</p>
					</span>
				</li></a>
				<a  id="users" href="manage-users.php">
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3><?php echo $total_users_count; ?></h3>
						<p>Visitors</p>
					</span>
				</li></a>
				<a href="manage-animal.php">
				<li>
					<i class='bx bxl-baidu'></i>
					<span class="text">
						<h3><?php echo $total_count; ?></h3>
						<p>Animals</p>
					</span>
				</li></a>
				
			</ul>


		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
<script>
  document.getElementById("profileButton").addEventListener("click", function() {
    document.getElementById("profilePopup").classList.add("active");
  });

  function closePopup() {
  document.getElementById("profilePopup").classList.remove("active");
  document.querySelector(".overlay").classList.remove("active");
}
</script>
	
<script>
var currentTotalOrdersCount = <?php echo $total_orders_count; ?>;

function showPopupNotification(newOrderCount) {
    var popup = document.getElementById("popupNotification");
    var newOrderCountSpan = document.getElementById("newOrderCount");
    newOrderCountSpan.textContent = newOrderCount;
    popup.style.display = "block";
    setTimeout(function() {
        popup.style.display = "none";
    }, 5000);
}
function closePopupNotification() {
    var popup = document.getElementById("popupNotification");
    popup.style.display = "none";
}
function checkAndUpdateOrdersCount() {
    $.ajax({
        url: 'ticket-orders.php',
        success: function(data) {
            var newTotalOrdersCount = parseInt(data);
            if (newTotalOrdersCount > currentTotalOrdersCount) {
                showPopupNotification(newTotalOrdersCount);
                currentTotalOrdersCount = newTotalOrdersCount;
            }
        }
    });
}

setInterval(checkAndUpdateOrdersCount, 5000);

</script>
	<script src="script.js"></script>
	<style>
  .popup {
	display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 10px;
        border-radius: 10px;
        z-index: 9999;
        width: 75%;
        max-width: 500px;
        backdrop-filter: blur(10px);
  }

  .overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
  display: none;
}

.popup.active, .overlay.active {
  display: block;
}

  .popup h2 {
    margin-top: 0;
    margin-bottom: 20px;
    text-align: center;
    font-size: 18px;
  }


  #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); 
        z-index: 9998; 
    }
  .popup label {
    display: block;
	text-align: left;
    margin-bottom: 2px;
    font-weight: bold;
  }

  input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}
form {
  display: grid;
  grid-gap: 10px;
}

label {
  color: #333;

}

button[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #009432;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #20bf6b;
}

  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
  }
</style>

</body>
</html>