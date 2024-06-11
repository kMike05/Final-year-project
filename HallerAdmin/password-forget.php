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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email from the POST data and sanitize it
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Debugging: Output the received email
    echo "Received email: $email<br>";

    // Validate the email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $mail = new PHPMailer(true);
        $mail->SMTPAutoTLS = false;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = "hallerpark1@gmail.com";
        $mail->Password = "xubr ccfb pwdr muzf";
        $mail->setFrom($email);
        $mail->addAddress("$email");
        $mail->Subject = "Request for Password Change";
        $mail->Body = "I am requesting for a password reset";

        try {
            $mail->send();
            echo "Email sent successfully to hallerpark1@gmail.com<br>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
        }
    } else {
        echo "Invalid email format<br>";
    }
} else {
    echo "No email provided<br>";
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forget Password</title>
    <link rel="stylesheet" href="passstyle.css">
</head>
<body>
    <div class="container">
        <div class="left"> </div>
        <div class="right">
            <div class="formBox">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <p>Email</p>
                    <input type="text" name="email" placeholder="Email" required>
                    <input type="submit" value="Forget Password">
                    <a href="Admin-login.php">Log In Again!</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
