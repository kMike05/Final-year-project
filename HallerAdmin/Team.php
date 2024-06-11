<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="admin.css">
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
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="event.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Events</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Tickets</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Animals</span>
				</a>
			</li>
			<li class="active">
				<a href="Team.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
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



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
		</nav>
		<!-- NAVBAR -->

        <!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Team</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Team</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="index.php">Home</a>
						</li>
					</ul>
				</div>
                

<!--                <div class="table-data">
				<div class="order">
                <div class="head">
						<h3>Manage Admin</h3><br/>
						<a href="#" class="btn-primary">Add Admin</a>
					</div>
					<table>
						<thead>
							<tr>
								<th> Full Name</th>
								<th>Email</th>
								<th>ACtion</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<p>John Doe</p>
								</td>
								<td>John@gmail.com</td>
								<td><a href="#" class="btn-sec">Update Admin</a>
                                    Delete Admin</td>
							</tr>
							<tr>
								<td>
									<p>John Doe</p>
								</td>
								<td>John@gmail.com</td>
								<td>Update Admin
                                    Delete Admin
                                </span></td>
							</tr>
							<tr>
								<td>
									<p>John Doe</p>
								</td>
								<td>John@gmail.com</td>
								<td>Update Admin
                                    Delete Admin</span></td>
							</tr>
							<tr>
								<td>
									<p>John Doe</p>
								</td>
								<td>John@gmail.com</td>
								<td>Update Admin
                                    Delete Admin
                                </span></td>
							</tr>
							<tr>
								<td>
									<p>John Doe</p>
								</td>
								<td>John@gmail.com</td>
								<td>Update Admin
                                    Delete Admin
                                </span></td>
							</tr>
						</tbody>
					</table>
				</div>
                <!--<table>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </table>