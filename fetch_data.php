<?php
@include 'config.php';
// Assuming you have a session with logged-in user's email
if (!isset($_SESSION['email'])) {
    // Redirect if not logged in
    header("Location: Alogin.php");
    exit();
}


// Fetch data for the logged-in user
$email = $_SESSION['email'];
$sql = "SELECT Phone_number, Ticket_type, Ticket_price, Visit_date FROM tbl_payment WHERE email = '$email'";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close connection
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
