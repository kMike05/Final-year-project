<?php
session_start();
session_destroy();
header('location:mainadmin-login.php');
?>