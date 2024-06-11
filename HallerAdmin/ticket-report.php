<?php
include('config1.php');

$query = "SELECT YEAR(Visit_date) AS year, MONTH(Visit_date) AS month, SUM(Ticket_price) AS total_sales 
          FROM tbl_payment 
          WHERE status = 'approved' 
          GROUP BY YEAR(Visit_date), MONTH(Visit_date)";
$result = mysqli_query($conn, $query);

// Initialize arrays to store monthly sales data and yearly sales totals
$salesData = array();
$yearlySales = array();

while ($row = mysqli_fetch_assoc($result)) {
    // Convert numeric month to full month name
    $month = date("F", mktime(0, 0, 0, $row['month'], 1));
    $year = $row['year'];
    $salesData["$month $year"] = $row['total_sales'];

    // Accumulate sales for each year
    if (!isset($yearlySales[$year])) {
        $yearlySales[$year] = 0;
    }
    $yearlySales[$year] += $row['total_sales'];
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

	<style>
        #yearlySales {
            margin-top: 20px;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }

        #yearlySales h2 {
            margin-bottom: 10px;
            color: #333;
        }

        #yearlySales ul {
            list-style-type: none;
            padding: 0;
        }

        #yearlySales li {
            margin-bottom: 5px;
            color: #666;
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
				<a href="ticket-report.php">
                <i class='bx bxs-bar-chart-alt-2' ></i>
					<span class="text">Ticket-Sales Report</span>
				</a>
			</li>
			<li>
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
       <!-- Include Chart.js library for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <canvas id="ticketSalesChart" width="200" height="100"></canvas>

    <!-- Button to download the chart as a PDF -->
    <button id="btn-download" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download as PDF</span>
    </button>

    <!-- Section to display yearly sales totals -->
    <div id="yearlySales">
        <h2>Total Sales Per Year</h2>
        <ul>
            <?php foreach ($yearlySales as $year => $totalSales): ?>
                <li><?php echo "$year: $totalSales"; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script>
        // Get sales data and labels from PHP
        var salesData = <?php echo json_encode($salesData); ?>;
        var labels = Object.keys(salesData);
        var data = Object.values(salesData);

        // Initialize the chart
        var ctx = document.getElementById('ticketSalesChart').getContext('2d');
        var ticketSalesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ticket Sales',
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
                    yAxes: [{
                        ticks: { beginAtZero: true }
                    }]
                }
            }
        });

        // Event listener to download the chart as a PDF
        document.getElementById('btn-download').addEventListener('click', function() {
            html2canvas(document.getElementById('ticketSalesChart')).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var pdf = new jspdf.jsPDF();
                pdf.addImage(imgData, 'PNG', 10, 10);
                pdf.save('ticket-sales-report.pdf');
            });
        });
    </script>
</section>
</body>
</html>