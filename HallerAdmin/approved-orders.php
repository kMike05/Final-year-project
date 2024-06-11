<?php 
@include('config1.php');

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
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script defer src="/script.js"></script>


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
			<li >
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
			<li >
				<a href="view-admin.php">
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
			<a href="signout.php" class="logout">
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
			<form action="#">
				<div class="form-input">
					<input type="hidden" placeholder="Search...">
				
				</div>
			</form>
>
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
					<h1>Orders</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Orders</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="index.php">Home</a>
						</li>
					</ul>
					<?php
                        if(isset($_SESSION['add'])){ 
							echo $_SESSION['add']; 
                        	unset($_SESSION['add']); 

						}
						if(isset($_SESSION['pass'])){ 
							echo $_SESSION['pass']; 
                        	unset($_SESSION['pass']); 

						}
						
						if(isset($_SESSION['delete'])){ 
							echo $_SESSION['delete']; 
                        	unset($_SESSION['delete']); 

						}

						if(isset($_SESSION['update'])){ 
							echo $_SESSION['update']; 
                        	unset($_SESSION['update']); 

						}
						
						if(isset($_SESSION['user-not-found'])){ 
							echo $_SESSION['user-not-found']; 
                        	unset($_SESSION['user-not-found']);

						}
						if(isset($_SESSION['pass-not-matched'])){ 
							echo $_SESSION['pass-not-matched']; 
                        	unset($_SESSION['pass-not-matched']);

						}
						if(isset($_SESSION['confirm_order'])){ 
							echo $_SESSION['confirm_order']; 
                        	unset($_SESSION['confirm_order']); 

						}
						
						
                       
                           

					?>

<br>
				</div>
                
				<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Ticket Orders</h3><br/>

            <a href="ticket-orders.php" class="btn-primary">Pending Orders</a>
        </div>
		<div class="search-container">
		<input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search... ">
		<i class='bx bx-filter' onclick="toggleSelect()" style="font-size: 20px; color: #666; cursor: pointer;">Filter</i>

				
		<select id="rowCount" onchange="changeRowCount()">
        <option value="50">Filter</option>
		<option value="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
    </select>

</div>

        <table id="orderTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>MPESA CODE</th>
                    <th>ID Number</th>
                    <th>Ticket Type</th>
                    <th>Ticket Price</th>
                    <th>Date of Visit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT * FROM tbl_payment WHERE status = 'approved'";
                $res=mysqli_query($conn,$sql);
                if($res==TRUE){
                    $count=mysqli_num_rows($res);
                    $sn=1;
                    if($count>0){
                        while($rows=mysqli_fetch_assoc($res)){
                            $id=$rows['id'];
                            $code=$rows['Mpesa_code'];
                            $email=$rows['email'];
                            $number=$rows['Phone_number'];
                            $Tickettype=$rows['Ticket_type'];
                            $Ticketprice=$rows['Ticket_price'];
                            $date=$rows['Visit_date'];
                            ?>
                            <tr>
                                <td><?=$sn++?></td>
                                <td><?=$code?></td>
                                <td><?=$number?></td>
                                <td><?=$Tickettype?></td>
                                <td><?=$Ticketprice?></td>
                                <td><?=$date?></td>
                                <td>
                                    <a href="<?php echo SITEURL;?>HallerAdmin/send-email.php?id=<?php echo $id;?>" class="btn-sec"><i class='bx bx-envelope'></i></a>
                                    <a href="delete-order.php?id=<?php echo $id;?>" class="btn-delete" onclick="return confirmDelete()"><i class='bx bxs-trash-alt'></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<style>
.filter-icon {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 10px;
    cursor: pointer;
}

.filter-icon i {
    font-size: 20px;
    color: #666;
}

#rowCount {
    display: none;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background-color: white;
    color: #333;
}

#rowCount option {
    background-color: white;
    color: #333;
}

#rowCount {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background-color: white;
    color: #333;
}

#rowCount option {
    background-color: white;
    color: #333;
}

</style>
<script>
	function toggleSelect() {
    var select = document.getElementById("rowCount");
    if (select.style.display === "none") {
        select.style.display = "inline-block";
    } else {
        select.style.display = "none";
    }
}

	function changeRowCount() {
    var rowCount = document.getElementById("rowCount").value;
    var rows = document.getElementById("orderTable").rows;
    for (var i = 1; i < rows.length; i++) {
        rows[i].style.display = i <= rowCount ? "table-row" : "none";
    }
}

function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("orderTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // Change index to match the column you want to search (here it's the second column)
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
				<div class="table-data">
				<div class="order">
                <div class="head">
						<h3>Paid Tickets</h3><br/>
					</div>
					<div class="search-container">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search... ">
				
            </div>
					<table>
						<thead>
							<tr>
							 	<th> ID</th>
								<th>Email</th>
								<th> Ticket_Code</th>
                                <th> TicketType</th>
                                <th> TicketPrice</th>
								<th> Date_of_Visit</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql="SELECT * FROM tbl_email_sent ";

							$res=mysqli_query($conn,$sql);
							if($res==TRUE){
								$count=mysqli_num_rows($res);
								$sn=1;
								if($count>0){
									while($rows=mysqli_fetch_assoc($res)){
										$id=$rows['id'];
										$email=$rows['email'];
										$code=$rows['Mpesa_code'];
										$Tickettype=$rows['Ticket_type'];
										$Ticketprice=$rows['Ticket_price'];
										$date=$rows['Visit_date'];
										?>
										<tr>
										<td>
									<?=$sn++?>
								</td>
										<td><?=$code?></td>
											<td><?=$email?></td>
										<td>
									<?=$Tickettype?>
								</td>
										<td>
									<p><?=$Ticketprice?></p>
								</td>
								<td><?=$date?></td>
								<td>
									<a href="delete-order.php?id=<?php echo $id;?>" class="btn-delete"  onclick="return confirmDelete()"><i class='bx bxs-trash-alt'></i></a>
                               
								</span></td>
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
				</div>
				
				<script src="script.js"></script>
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
    color: #fff; 
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 3px;
    transition: background-color 0.3s ease;
}

#content main .table-data .order table tr td .btn-pass:hover {
    background-color: #7bed9f; 
}

				</style>
								<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this Order?");
    }
</script>
<script>
function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector(".table-data table");
    tr = table.getElementsByTagName("tr");

    
    for (i = 0; i < tr.length; i++) {
        td_mpesa = tr[i].getElementsByTagName("td")[1]; // MPESA CODE column
        td_id_number = tr[i].getElementsByTagName("td")[2]; // Id_Number column
        if (td_mpesa || td_id_number) {
            txtValue_mpesa = td_mpesa.textContent || td_mpesa.innerText;
            txtValue_id_number = td_id_number.textContent || td_id_number.innerText;
            if (txtValue_mpesa.toUpperCase().indexOf(filter) > -1 || txtValue_id_number.toUpperCase().indexOf(filter) > -1) {
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
    padding-left: 40px; 
}

.search-container input[type=text]:focus {
    outline: none;
    border-color: #719ECE;
    box-shadow: 0 0 8px 0 #719ECE;
}

</style>

</body>
</html>
            