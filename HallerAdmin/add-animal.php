
    <?php
    include('dashboard.php');
    include('config1.php');

   if(isset($_POST['submit'])){
    $name=$_POST['animal_name'];
    $Animal_species=$_POST['Animal_species'];
    $Animal_count=$_POST['Animal_count'];
    $Description=$_POST['Description'];
    $Animal_pic=$_FILES['Animal_pic']['name'];
    $tmp_name=$_FILES['Animal_pic']['tmp_name'];
    $folder='img/'.$Animal_pic;

    if(move_uploaded_file($tmp_name, $folder)) {
        echo "<h2>File uploaded successfully</h2>";
    } else {
        echo "<h2>File not uploaded</h2>";
    }
    

    $sql="INSERT INTO tbl_animal SET 
    animal_name='$name',
    Animal_species='$Animal_species',
    Animal_count='$Animal_count',
    Animal_description='$Description',
    Animal_pic='$Animal_pic'
  

    ";
    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['add_animal'] = "<div class='success'>Animal added successfully!!</div>";
        
        //REDIRECT
        header('location:'.SITEURL.'HallerAdmin/manage-animal.php');
        exit(); // Exit after redirection
    } else {
        echo "<div class='error'>Failed to add Animal. Try again later!!</div>";
    }
   }?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="admin.css">
    <script defer src="/script.js"></script>

	<title>Staff</title>
</head>
<body>
        <div class="form-container">
        <h2>Add animal</h2>
     
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="animal_name">animal Name</label>
                <input type="text" id="animal_name" name="animal_name" placeholder="Enter animal name" value="" required>
            </div>
            <div class="form-group">
                <label for="Animal_species">Species</label>
                <input type="text" id="Animal_species" name="Animal_species" placeholder="Enter animal species" value="" required>
            </div>
            <div class="form-group">
                <label for="Animal_count">Animal Count</label>
                <input type="number" id="Animal_count" name="Animal_count" min="1" placeholder="Animal Count" required>
                <div id="animalCountError" class="error-message"></div> <!-- Error message placeholder -->
            </div>

            <div class="form-group">
                <label for="animal_name">Description</label>
                <textarea id="message" name="Description" placeholder="Description of the animal" cols="30" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="count">Picture</label>
                <input type="file" id="animal_pic" name="Animal_pic" min="1" placeholder="Animal_pic" required>
            </div>


            <input type="hidden" name="id" value="">
            <button type="submit" name="submit" class="btn-primary">Add animal</button>
        
        </form>
    </div>

<script>
    function validateForm() {
        var animalName = document.getElementById("animal_name").value.trim();
        var animalSpecies = document.getElementById("animal_species").value.trim();
        var description = document.getElementById("message").value.trim();
        var picture = document.getElementById("animal_pic").value.trim();

        // Regular expression to match only letters and spaces
        var lettersOnly = /^[A-Za-z\s]+$/;

        if (animalName === "") {
            alert("Please enter animal name");
            return false;
        }
        if (!animalName.match(lettersOnly)) {
            alert("Animal name should contain only letters");
            return false;
        }
        if (animalSpecies === "") {
            alert("Please enter animal species");
            return false;
        }
        // Check if description contains only letters and spaces
        if (description === "" || !description.match(lettersOnly)) {
            alert("Description should contain only letters");
            return false;
        }
        if (picture === "") {
            alert("Please select a picture");
            return false;
        }

        return true;
    }
</script>
<style>
        textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-family: Arial, sans-serif;
    resize: vertical; /* Allow vertical resizing */
    min-height: 150px; /* Set a minimum height */
    width: 100%; /* Set the width to 100% of the container */
    box-sizing: border-box; /* Ensure padding and border are included in the element's total width */
}

    </style>
</body>
</html>