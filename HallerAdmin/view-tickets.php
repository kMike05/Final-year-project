<?php include('config1.php')?>
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
			<li>
				<a href="admin-dashboard.php">
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
			<li class="active">
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

			<a href="view-pendingorders.php" class="notification" >
    <i class='bx bxs-bell'></i>
    <span class="num"><?php echo $total_orders_count; ?></span>
</a>

		</nav>
		<!-- NAVBAR -->

        <!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Tickets</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Tickets</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="admin-dashboard.php">Home</a>
						</li>
					</ul>
					<?php
                        if(isset($_SESSION['add'])){ 
							echo $_SESSION['add']; //Displaying Session Message
                        	unset($_SESSION['add']); //Removing Session Message

						}
						
						if(isset($_SESSION['delete'])){ 
							echo $_SESSION['delete']; //Displaying Session Message
                        	unset($_SESSION['delete']); //Removing Session Message

						}
						if(isset($_SESSION['update'])){ 
							echo $_SESSION['update']; //Displaying Session Message
                        	unset($_SESSION['update']); //Removing Session Message

						}
                        if(isset($_SESSION['update_ticket'])){ 
							echo $_SESSION['update_ticket']; //Displaying Session Message
                        	unset($_SESSION['update_ticket']); //Removing Session Message

						}
						
						if(isset($_SESSION['user-not-found'])){ 
							echo $_SESSION['user-not-found']; //Displaying Session Message
                        	unset($_SESSION['user-not-found']); //Removing Session Message

						}
						if(isset($_SESSION['pass-not-matched'])){ 
							echo $_SESSION['pass-not-matched']; //Displaying Session Message
                        	unset($_SESSION['pass-not-matched']); //Removing Session Message

						}
						
						
                       
                           

					?>

<br>
				</div>
                
   <div class="table-data">
				<div class="order">
                <div class="head">
						<h3>View Tickets</h3><br/>
						
					</div>
					<div class="search-container">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search... ">
				
            </div>
					<table>
						<thead>
							<tr>
							    <th> Ticket_ID</th>
								<th> Ticket_type</th>
								<th>Price</th>
                                <th> Description</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql="SELECT * FROM tbl_tickets";

							$res=mysqli_query($conn,$sql);
							if($res==TRUE){
								$count=mysqli_num_rows($res);
								$sn=1;
								if($count>0){
									while($rows=mysqli_fetch_assoc($res)){
										
										$id=$rows['Ticket_id'];
										$type=$rows['Ticket_type'];
										$price=$rows['Ticket_price'];
                                        $Description=$rows['Ticket_description'];
										?>
										<tr>
										<td>
									<?=$sn++?>
								</td>
										<td>
									<p><?=$type?></p>
								</td>
								<td><?=$price?></td>
                                <td><?=$Description?></td>
							</tr>
										<?php

									}

								}else
								{
									echo "no records found";

								}
							}
							
							?>

						</tbody>
					</table>
				</div><script src="script.js"></script>
				<link rel="stylesheet" type="text/css" href="css/main.css">
				<style>
					.success{
   						 color: #2ed573;
						}
					.error{
   						 color: #eb4d4b;
						}
						#content main .table-data .order table tr td .btn-pass {
    background-color: #2ed573; /* Blue color */
    color: #fff; /* White text */
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 3px;
    transition: background-color 0.3s ease;
}

#content main .table-data .order table tr td .btn-pass:hover {
    background-color: #7bed9f; /* Lighter shade of blue on hover */
}

				</style>
								<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this Ticket?");
    }
</script>
<script>
    function searchTable() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.querySelector(".table-data table");
        tr = table.getElementsByTagName("tr");

        
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2]; // Change index if the column of Full Name is different
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
<style>
	.search-container {
    margin-bottom: 20px;
}

.search-container input[type=text] {
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    width: 30%;
    border: 1px solid #ccc;
    border-radius: 50px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: white;
    padding-left: 40px; /* Add some padding to the left */
}

.search-container input[type=text]:focus {
    outline: none;
    border-color: #719ECE;
    box-shadow: 0 0 8px 0 #719ECE;
}

</style>

</body>
</html>
            