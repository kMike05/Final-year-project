<?php
session_start();

@include 'config.php';

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $selectAdmin = "SELECT * FROM tbl_mainadmin WHERE email='$email'";
    $resultAdmin = mysqli_query($conn, $selectAdmin);

    if(mysqli_num_rows($resultAdmin) > 0) {
        $rowAdmin = mysqli_fetch_assoc($resultAdmin);
        if(password_verify($password, $rowAdmin['password'])) {
            $_SESSION['admin_name'] = $rowAdmin['name']; 
            header('location: admin-dashboard.php');
            exit();
        }
    }

    $error[] = '*Incorrect email or password!';
}

if(isset($_POST['submit'])){
    // Clear the textboxes by setting their values to an empty string
    $_POST['email'] = '';
    $_POST['password'] = '';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
       
        <script defer src="/style.js"></script>
        <title></title>
        <link rel="stylesheet" type="text/css" href="passstyle.css">

    </head>
  <body style="background: whitesmoke;" >
    
       <div class="container">
		<div class="left"> </div>
		<div class="right">
			<div class="formBox">
			<form action="" method="post">
                <h4>ADMIN LOGIN</h4>
            

			<p >Email</p>  
            <div class="email"><input type="text" name="email" placeholder="Email" id="email" required=""></div>
            <p>Password</p><div class="password">    
            <input type="password" placeholder="Password" name="password" id="password" required /></div>
			<input type="submit" name="submit" value="Login">
            <?php
                            if(isset($error)){
                                foreach($error as $error){
                                    echo '<span class="error-msg" >'.$error.'</span>';
                                }
                            };
                            
                            ?>
        </div>
        
</form></div>
		</div>
</div>

</body></div>
</html>