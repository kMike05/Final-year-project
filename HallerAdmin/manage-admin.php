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
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
			<li >
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
					<h1>Staff</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Staff</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="admin-dashboard.php">Home</a>
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
						if(isset($_SESSION['change-pwd'])){ 
							echo $_SESSION['change-pwd']; 
                        	unset($_SESSION['change-pwd']); 

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
						
						
                       
                           

					?>

<br>
				</div>
                
   <div class="table-data">
				<div class="order">
                <div class="head">
						<h3>Manage Admin</h3><br/>
						
						<a href="add-admin.php" class="btn-primary"><i class='bx bx-user-plus' ></i></a>
					</div>
					<div class="search-container">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search... ">
				
            </div>
					<table>
						<thead>
							<tr>
								<th> </th>
							    <th> ID</th>
								<th> Full Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql="SELECT * FROM tbl_admin";

							$res=mysqli_query($conn,$sql);
							if($res==TRUE){
								$count=mysqli_num_rows($res);
								$sn=1;
								if($count>0){
									while($rows=mysqli_fetch_assoc($res)){
										$pic=$rows['admin_pic'];
										$id=$rows['id'];
										$name=$rows['name'];
										$email=$rows['email'];
										$role=$rows['role'];
										?>
										<tr>
											<td><img src="img/<?php echo $pic?>"></td>
										<td>
									<?=$sn++?>
								</td>
										<td>
									<p><?=$name?></p>
								</td>
								<td><?=$email?></td>
								<td><?=$role?></td>
								<td>
									<a href="<?php echo SITEURL;?>HallerAdmin/update-password.php?id=<?php echo $id;?>" class="btn-pass"><i class='bx bxs-key' ></i></a>
									<a href="<?php echo SITEURL;?>HallerAdmin/update-admin.php?id=<?php echo $id;?>" class="btn-sec"><i class='bx bx-edit' ></i></a>
									<a href="<?php echo SITEURL;?>HallerAdmin/delete-admin.php?id=<?php echo $id;?>" class="btn-delete"  onclick="return confirmDelete()"><i class='bx bxs-trash-alt'></i></a>
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
        return confirm("Are you sure you want to delete this Admin?");
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
            