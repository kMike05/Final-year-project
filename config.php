<?php
session_start();

define('MAILHOST', "smtp.gmail.com");
define('USERNAME', "kipmike18@gmail.com");
define('PASSWORD', "zwjm vmlc fkhr ihxc");
define('SEND_FROM', "realmikey05@gmail.com");
define('SEND_FROM_NAME', "HALLERPARK");
define('REPLY_TO',"kipmike18@gmail.com");
define('REPLY_TO_NAME', "Mike");


define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'zms');
define('URL', 'http://localhost/FinalP/');

$conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error($conn));
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));;


?>
