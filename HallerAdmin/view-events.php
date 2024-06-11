<?php
include('config1.php');
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
	<style>
		.btn-view{
			background-color: #2ed573; /* Blue color */
    color: #fff; /* White text */
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 3px;
    transition: background-color 0.3s ease;
		}
	</style>

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
			<li class="active">
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
			<li >
				<a href="view-animal.php" >
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
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
			<div class="form-input">
					<input type="hidden" placeholder="Search...">
				
				</div>
			</form>

			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num"><?php echo $total_orders_count; ?></span>
			</a>
		</nav>
		<!-- NAVBAR -->

        <!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Events</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">events</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="admin-dashboard.php">Home</a>
						</li>
					</ul>
                    <?php
                        if(isset($_SESSION['add_event'])){ 
							echo $_SESSION['add_event']; 
                        	unset($_SESSION['add_event']); 

						}
                        if(isset($_SESSION['update_event'])){ 
							echo $_SESSION['update_event']; 
                        	unset($_SESSION['update_event']); 

						}
                        if(isset($_SESSION['delete_event'])){ 
							echo $_SESSION['delete_event']; 
                        	unset($_SESSION['delete_event']); 

						}
						if(isset($_SESSION['update'])) {
							echo $_SESSION['update'];
							unset($_SESSION['update']);
						}
                        ?>
						
				</div>
                <div class="table-data">
				<div class="order">
                <div class="head">
						<h3>View events</h3><br/>
					</div>
					<div class="search-container">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search... ">
				
            </div>
					<table>
						<thead>
							<tr>
								<th> </th>
							    <th> ID</th>
								<th> event_Name</th>
								<th>event_date</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql="SELECT * FROM tbl_event";

							$res=mysqli_query($conn,$sql);
							if($res==TRUE){
								$count=mysqli_num_rows($res);
								$sn=1;
								if($count>0){
									while($rows=mysqli_fetch_assoc($res)){
										
										$pic=$rows['event_pic'];
										$id=$rows['id'];
										$name=$rows['event_name'];
										$date=$rows['event_date'];
										
										?>
										<tr>
										<td>
                                        <img src="img/<?php echo $pic?>">
								</td>
										<td>
									<?=$sn++?>
								</td>
										<td>
									<p><?=$name?></p>
								</td>
                                <td>
                                <p><?=$date?></p>
                                    </td>
								<td>
									

									<!-- <a href="<?php echo SITEURL;?>HallerAdmin/update-event.php?id=<?php echo $id;?>" class="btn-sec">Edit</a>
									<a href="<?php echo SITEURL;?>HallerAdmin/delete-event.php?id=<?php echo $id;?>" class="btn-delete" onclick="return confirmDelete()">Delete</a> -->
                                </span></td>
							</tr>
										<?php

									}

								}else
								{
									echo "<div class='error'>no records found!!</div>";

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
    background-color: #2ed573; 
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
				<script defer src="/script.js"></script>
				<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this event?");
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

    // Loop through all table rows, and hide those that don't match the search query
    for (i = 0; i < tr.length; i++) {
        var found = false; // Flag to determine if the search term is found in any column
        // Skip the header row
        if (i !== 0) {
            // Loop through all columns of each row
            for (var j = 0; j < tr[i].cells.length; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        // If the search term is found in any column, show the row
                        tr[i].style.display = "";
                        found = true;
                        break; // No need to check other columns once found
                    }
                }
            }
            // If the search term is not found in any column, hide the row
            if (!found) {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

</body>
</html>
