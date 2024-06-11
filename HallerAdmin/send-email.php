<?php
@include('config1.php');

require "vendor/autoload.php";
require "dompdf/autoload.inc.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Dompdf\Dompdf;
use Dompdf\Options;

// Disable SSL verification for all future stream operations to prevent SSL certificate validation errors
stream_context_set_default(
    array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
        ),
    )
);

$id = $_GET['id'];

$sql = "SELECT email, Mpesa_code, Ticket_type, Ticket_price, Visit_date FROM tbl_payment WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row["email"];
    $code = $row["Mpesa_code"];
    $type = $row["Ticket_type"];
    $price = $row["Ticket_price"];
    $date = $row["Visit_date"];

    // Generate PDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf($options);

    $html = <<<HTML
<style>
body {
    font-family: Arial, sans-serif;
    position: relative;
    font-size: 10px;
}
.watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 80%;
    text-align: center;
    font-size: 4em;
    color: rgba(0, 0, 0, 0.2);
    transform: translate(-50%, -50%) rotate(-45deg);
    z-index: 0;
    pointer-events: none;
}
.ticket-container {
    border: 2px solid #009432;
    padding: 10px;
    width: 100%;
    text-align: center;
    position: relative;
    z-index: 1;
    background-color: #fff;
}
.ticket-logo {
    text-align: center;
    margin-bottom: 10px;
}
.ticket-logo img {
    max-width: 100px;
}
.ticket-details {
    text-align: left;
    margin: 0 auto;
    width: 90%;
}
.ticket-details h2 {
    text-align: center;
    margin-bottom: 10px;
    background-color: #009432;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    font-size: 1.2em;
}
.ticket-details table {
    width: 100%;
    border-collapse: collapse;
}
.ticket-details table, .ticket-details th, .ticket-details td {
    border: 1px solid #009432;
}
.ticket-details th {
    padding: 5px;
    background-color: #009432;
    color: #fff;
    text-align: left;
}
.ticket-details td {
    padding: 5px;
    text-align: left;
}
</style>

<div class='ticket-container'>
    <div class='watermark'>Haller Park</div>
    <div class='ticket-logo'>
        <img src='img/Haller.jpg'>
    </div>
    <div class='ticket-details'>
        <h2>Ticket Purchase Details</h2>
        <table>
            <tr>
                <th>Email</th>
                <td>$email</td>
            </tr>
            <tr>
                <th>Date of Visit</th>
                <td>$date</td>
            </tr>
            <tr>
                <th>Ticket Code</th>
                <td>$code</td>
            </tr>
            <tr>
                <th>Ticket Type</th>
                <td>$type</td>
            </tr>
            <tr>
                <th>Ticket Price</th>
                <td>$price</td>
            </tr>
        </table>
    </div>
</div>
HTML;

    $dompdf->loadHtml($html);
    $customPaperSize = array(0, 0, 298, 420); // Custom size: 105mm x 120mm
    $dompdf->setPaper($customPaperSize);
    $dompdf->render();
    
    // Save the PDF to a file
    $pdfOutput = $dompdf->output();
    $pdfFilePath = 'ticket_' . $id . '.pdf';
    file_put_contents($pdfFilePath, $pdfOutput);

    $mail = new PHPMailer(true);
    $mail->SMTPAutoTLS = false;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Username = "hallerpark1@gmail.com";
    $mail->Password = "xubr ccfb pwdr muzf";
    $mail->setFrom("kipmike18@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Ticket Purchase Details";
    $mail->Body = "Make sure to print and present this ticket when you visit us😊";

    // Attach the PDF
    $mail->addAttachment($pdfFilePath);

    try {
        $mail->send();
        $currentTimestamp = date('Y-m-d H:i:s');
        $updateSql = "UPDATE tbl_payment SET email_sent = '$currentTimestamp' WHERE id = $id";
        $conn->query($updateSql);
        
        $insertSql = "INSERT INTO tbl_email_sent (email, Mpesa_code, Ticket_type, Ticket_price, Visit_date) VALUES ('$email', '$code', '$type', '$price', '$date')";
        $conn->query($insertSql);

        $deleteSql = "DELETE FROM tbl_payment WHERE id = $id";
        $conn->query($deleteSql);

        // Delete the PDF file after sending the email
        unlink($pdfFilePath);

        $_SESSION['pass'] = "Email sent successfully to $email<br>";
        header('location:' . SITEURL . 'HallerAdmin/approved-orders.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
    }
} else {
    echo "No recipient found with the provided ID";
}
?>
