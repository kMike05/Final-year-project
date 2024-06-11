<?php
include('dashboard.php');
include('config1.php');

if(isset($_POST['submit'])){
    $name = $_POST['species_name'];
    $animal_count = $_POST['Animal_count'];

    // Your database insertion code here
    $sql = "INSERT INTO tbl_species SET 
        species_name='$name',
        Animal_count='$animal_count'";

    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['add_species'] = "<div class='success'>Species added successfully!!</div>";
        
        //REDIRECT
        header('location:'.SITEURL.'HallerAdmin/manage-species.php');
        exit(); // Exit after redirection
    } else {
        echo "<div class='error'>Failed to add Species. Try again later!!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Species</title>
    <style>
        .error-border {
            border: 1px solid red !important;
        }
        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>
        <div class="form-container">
        <h2>Add species</h2>
     
        <form id="admin-form" action="" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
            <div class="form-group">
                <label for="species_name">Species Name</label>
                <input type="text" id="species_name" name="species_name" placeholder="Enter Species name" required>
                <div id="speciesNameError" class="error-message"></div> <!-- Error message placeholder -->
            </div>
            <div class="form-group">
                <label for="Animal_count">Animal Count</label>
                <input type="number" id="Animal_count" name="Animal_count" min="1" placeholder="Animal Count" required>
                <div id="animalCountError" class="error-message"></div> <!-- Error message placeholder -->
            </div>
            <button type="submit" name="submit" class="btn-primary">Add Species</button>
        </form>
    </div>
    <script src="script.js"></script>
    <script>
            function validateForm() {
        var speciesName = document.getElementById("species_name").value.trim();
        var animalCount = document.getElementById("Animal_count").value.trim();

        var speciesNameRegex = /^[a-zA-Z\s]+$/; // Only allow letters and spaces

        var errors = [];

        if (speciesName === "") {
            errors.push("Species Name is required.");
            document.getElementById("species_name").classList.add('error-border');
            document.getElementById("speciesNameError").innerText = "Species Name is required.";
        } else if (!speciesNameRegex.test(speciesName)) {
            errors.push("Species Name should contain only letters.");
            document.getElementById("species_name").classList.add('error-border');
            document.getElementById("speciesNameError").innerText = "Species Name should contain only letters.";
        } else {
            document.getElementById("species_name").classList.remove('error-border');
            document.getElementById("speciesNameError").innerText = "";
        }

            if (errors.length > 0) {
                return false;
            }

            return true;
        }
    </script>
</body>
</html>