<?php
include('config1.php');
$ticketTypes = array();
$query = "SELECT DISTINCT Ticket_type FROM tbl_payment WHERE status = 'approved'";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $ticketTypes[] = $row['Ticket_type'];
}

$ticketCounts = array();

foreach ($ticketTypes as $type) {
    $query = "SELECT COUNT(*) AS count FROM tbl_payment WHERE status = 'approved' AND Ticket_type = '$type'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $ticketCounts[$type] = $row['count'];
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
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


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
				<a href="ticket-report.php">
				<i class='bx bxs-bar-chart-alt-2' ></i>
					<span class="text">Ticket-Sales Report</span>
				</a>
			</li>
			<li class="active">
				<a href="tickettype-report.php">
                <i class='bx bx-bar-chart-alt' ></i>
					<span class="text">Ticket-Type Report</span>
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


		</nav>
        <<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="ticketTypesChart" width="100" height="40"></canvas>
<button id="btn-download" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download as PDF</span>
        </button>

<script>
    var ticketCounts = <?php echo json_encode($ticketCounts); ?>;
    var labels = Object.keys(ticketCounts);
    var data = Object.values(ticketCounts);

    var ctx = document.getElementById('ticketTypesChart').getContext('2d');

    var ticketTypesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ticket Types Sales',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{ ticks: { beginAtZero: true } }]
            }
        }
    });
	
	document.getElementById('btn-download').addEventListener('click', function() {
                html2canvas(document.getElementById('ticketTypesChart')).then(function(canvas) {
                    var imgData = canvas.toDataURL('image/png');
                    var pdf = new jspdf.jsPDF();
                    pdf.addImage(imgData, 'PNG', 10, 10);
                    pdf.save('ticket-sales-report.pdf');
                });
            });
</script>

</body>
</html>