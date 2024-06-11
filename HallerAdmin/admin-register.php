<?php
@include 'config.php';
$error = array(); // Initialize the error array
if(isset($_POST['submit'])){
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $role=mysqli_real_escape_string($conn,$_POST['role']);
    $password=mysqli_real_escape_string($conn,$_POST['pass']);
    $cpassword=mysqli_real_escape_string($conn,$_POST['Cpass']);
    $user_type=$_POST['user_type'];
    $admin_pic=$_FILES['Admin_pic']['name'];
    $tmp_name=$_FILES['Admin_pic']['tmp_name'];
    $folder='img/'.$admin_pic;

    if(move_uploaded_file($tmp_name, $folder)) {
        echo "<h2>File uploaded successfully</h2>";
    } else {
        echo "<h2>File not uploaded</h2>";
    }


    $select="SELECT * FROM tbl_admin WHERE email='$email'";
    $result = mysqli_query($conn,$select);
    if(mysqli_num_rows($result)>0){
        $error[]='User already exists!';
        
    }else{
        if($password != $cpassword){
            $error[]='Passwords do not match!';
        }else{
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            if($user_type == 'user'){
                $insert = "INSERT INTO user_form (name, email, password, user_type) VALUES ('$name', '$email', '$hashedPassword', '$user_type')";
            } elseif($user_type == 'admin') {
                $insert = "INSERT INTO tbl_admin (name, email, role ,password, admin_pic) VALUES ('$name','$email','$role', '$hashedPassword', '$admin_pic')";
            }
            
            mysqli_query($conn,$insert);
            header('location:admin-login.php');
            exit(); // Exit after redirection
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>LOGIN</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" type="text/css" href="passstyle.css">
<style>
      body {
       background-color: #ffffff;
            }
        </style>
<script defer src="/style.js"></script>
<script>
      function validateNameInput(input) {
    // Remove non-alphabetic characters from the input value
    input.value = input.value.replace(/[^a-zA-Z]/g, '');
}
    function validateForm() {
        var fullName = document.getElementsByName("name")[0].value.trim();
        var password = document.getElementsByName("pass")[0].value.trim();

        var fullNameRegex = /^[a-zA-Z\s]+$/; // Only allow letters and spaces
        var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/; // Complex password pattern

        var errors = [];

        if (!fullNameRegex.test(fullName)) {
            errors.push("Full Name should contain only letters.");
        }

        if (!passwordRegex.test(password)) {
            errors.push("Password must be complex");
        }

        if (errors.length > 0) {
            var errorMessage = errors.join("<br>");
            document.getElementById("error-msg").innerHTML = errorMessage;
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
  

</script>
</head>
<body>
                <div class="containers">
                    
                    <div class="left"> </div>
                    <div class="right">
                        <div class="formBoxs">
                        <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <h4>REGISTER</h4>
                            <p>Full Names</p>
                            <input type="text" placeholder="Full Names" name="name" oninput="validateNameInput(this)" required>
                        <p>Email</p>
                        <input type="text" name="email" placeholder="Email" required>
                        <p>Role</p>
                        <select name="role" required>
                            <option value="" disabled selected>Select your role</option>
                            <option>Zookeeper</option>
                            <option>Veterinary</option>
                        </select>
                            <p>Upload Picture</p>
                            <input type="file" id="admin_pic" name="Admin_pic" min="1" placeholder="Admin_pic" required>
                        <p>Password</p>
                        <input type="password" placeholder="Password" name="pass" required>
                        <p>Confirm Password</p>
                        <input type="password" placeholder="Confirm Password" name="Cpass" required />
                        <input type="hidden" name="user_type" value="admin">
                     
                        <input type="submit" name="submit" value="Register">
                        <p id="error-msg" style="color: red;">
                            <?php
                            if(isset($error)){
                                foreach($error as $error){
                                    echo $error . "<br>";
                                }
                            }
                            ?>
                        </p>
                <p> existing user?<a id="a"href="admin-login.php"><i> click here</i> </a>to login</a></p>
		</div>
	   </form>
	</div></div>
    <style>
        .formBoxs input[type="submit"] {
    border: none;
    outline: none;
    height: 40px;
    color: #fff;
    background: #262626;
}
.formBoxs input[type="submit"]:hover {
    background: #045f27;
    color: #ffffff;
    transform: scale(1.1);
    outline: 2px solid #262626;
    box-shadow: 4px 5px 17px -4px #045f27;
}


    </style>
</body>
</html>
