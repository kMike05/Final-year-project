<?php 
@include('config1.php');
if(!isset($_SESSION['admin_name'])){
    header('location:mainadmin-login.php');
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
			<li class="active">
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
				<a href="manage-donation.php">
				<i class='bx bxs-donate-heart'></i>
					<span class="text">Donations</span>
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
			<a href="#" >
			<?php
			if(isset($_SESSION['admin_name'])){
				echo '<h4>Welcome, <span class="username">' . $_SESSION["admin_name"] . '</span></h4>';
			}
				?>
				</a>
			<a href="view-pendingorders.php" class="notification" >
    <i class='bx bxs-bell'></i>
    <span class="num"><?php echo $total_orders_count; ?></span>
</a>
<div id="popupNotification" class="popup-notification">
    <span class="close" onclick="closePopupNotification()">&times;</span>
    <p>You have <span id="newOrderCount"></span> new orders!</p>
</div>

		</nav>
		<!-- NAVBAR -->

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
			<a  id="users" href="ticket-report.php">
				<li>
				<i class='bx bxs-bar-chart-alt-2'></i>
					<span class="text">
						<h4>Reports</4>
					</span>
				</li></a>
				<a  id="users" href="manage-admin.php">
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h4>Staff</h4>
					</span>
				</li></a>
				<a href="view-animal.php">
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
.popup-notification {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    z-index: 9999;
}

.popup-notification p {
    margin: 0;
}

.popup-notification .close {
    position: absolute;
    top: 5px;
    right: 5px;
    cursor: pointer;
}

	</style>
</body>
</html>