<?php
@include('config1.php');

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

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
    $mail->Subject = "Ticket Payment Declined";
    $mail->Body = "Your Ticket Payment Was Declined😟\n Be Sure to Contact us!!!\nTicket code: $code";

    try {
        $mail->send();
        $currentTimestamp = date('Y-m-d H:i:s');
        $updateSql = "UPDATE tbl_payment SET email_sent = '$currentTimestamp' WHERE id = $id";
        $conn->query($updateSql);
        
        $declineSql = "UPDATE tbl_payment SET declined='yes' WHERE id = $id";
        $conn->query($declineSql);



        $_SESSION['pass'] ="Email sent successfully to $email<br>";
        header('location:'.SITEURL.'HallerAdmin/ticket-orders.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
    }
} else {
    echo "No recipient found with the provided ID";
}

?>

