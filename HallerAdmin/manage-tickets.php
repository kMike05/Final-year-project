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
			<li class="active">
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
					<h1>Tickets</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Tickets</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="index.php">Home</a>
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
						<h3>Manage Tickets</h3><br/>
						
						<a href="add-ticket.php" class="btn-primary"><i class='bx bx-plus'></i></a>
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
								<th>Actions</th>
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
								<td>
									<a href="<?php echo SITEURL;?>HallerAdmin/update-ticket.php?id=<?php echo $id;?>" class="btn-sec"><i class='bx bx-edit' ></i></a>
									<a href="<?php echo SITEURL;?>HallerAdmin/delete-ticket.php?id=<?php echo $id;?>" class="btn-delete"  onclick="return confirmDelete()"><i class='bx bxs-trash-alt'></i></a>
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
            