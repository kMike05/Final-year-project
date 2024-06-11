<?php
include('dashboard.php');
include('config1.php');

if(isset($_POST['submit'])){
    $id = $_POST['id']; // Ensure you retrieve the ID properly
    $name = $_POST['animal_name'];
    $Animal_species = $_POST['Animal_species'];
    $Animal_count = $_POST['Animal_count'];
    $Description = $_POST['Description'];
    $Animal_pic = $_FILES['Animal_pic']['name'];
    $tmp_name = $_FILES['Animal_pic']['tmp_name'];
    $folder = 'img/' . $Animal_pic;

    // Check if a new file is uploaded
    if(move_uploaded_file($tmp_name, $folder)) {
        echo "<h2>File uploaded successfully</h2>";
    } else {
        echo "<h2>File not uploaded</h2>";
    }

    // Update the database with the new data
    $sql = "UPDATE tbl_animal SET
        animal_name='$name',
        Animal_species='$Animal_species',
        Animal_count='$Animal_count',
        Animal_description='$Description'";

    // Check if a new file is uploaded, if yes, update the filename in the database
    if ($Animal_pic != "") {
        $sql .= ", Animal_pic='$Animal_pic'";
    }

    $sql .= " WHERE id='$id'";

    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['update'] = "<div class='success'>Animal updated successfully!!</div>";
        // REDIRECT
        header('location:' . SITEURL . 'HallerAdmin/manage-animal.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update animal. Try again later!!</div>";
        header('location:' . SITEURL . 'HallerAdmin/manage-animal.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="admin.css">
    <link rel="stylesheet"  href="main.css">
	<script defer src="/script.js"></script>

	<title>Admin</title>
</head>
<body>
        <div class="form-container">
        <h2>Update Animal</h2>
        <?php
        $id=$_GET['id'];
        
        $sql="SELECT * FROM tbl_animal WHERE id=$id";
        $res=mysqli_query($conn, $sql);

        if($res==true){
            $count= mysqli_num_rows($res);

            if($count==1){
                
                $row=mysqli_fetch_assoc($res);

                $pic=$row['Animal_pic'];
                $id=$row['id'];
                $name=$row['Animal_name'];
                $species=$row['Animal_species'];
                $count=$row['Animal_count'];
                $Description=$row['Animal_description'];

            }else{
                header('location:'.SITEURL.'HallerAdmin/manage-animal.php');
            }
        }

        ?>
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <?php
if(isset($_SESSION['update_animal']))
{
echo $_SESSION['update_animal']; //Display Session Message
unset($_SESSION['update_animal']); //Remove Session Message
}
?>
            <div class="form-group">
                <label for="animal_name">animal Name</label>
                <input type="text" id="animal_name" name="animal_name" placeholder="Enter animal name" value="<?php echo $name;?>" required>
            </div>
            <div class="form-group">
                <label for="Animal_species">Species</label>
                <input type="text" id="Animal_species" name="Animal_species" placeholder="Enter animal species" value="<?php echo $species;?>" required>
            </div>
            <div class="form-group">
                <label for="Animal_count">Animal Count</label>
                <input type="number" id="Animal_count" name="Animal_count" min="1" placeholder="Animal Count" value="<?php echo $count;?>" required>
                <div id="animalCountError" class="error-message"></div> <!-- Error message placeholder -->
            </div>
            <div class="form-group">
                <label for="animal_name">Description</label>
                <textarea id="message" name="Description" placeholder="Description of the animal" cols="30" rows="5"><?php echo $Description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="count">Picture</label>
                <input type="file" id="animal_pic" name="Animal_pic" min="1" placeholder="Animal_pic" >
            </div>

            
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <button type="submit" name="submit" class="btn-primary">Update animal</button>
        
        </form>
    </div>
    <script>
    document.querySelector('form').addEventListener('submit', function(event) {
        const animalNameInput = document.getElementById('animal_name').value;
        const speciesInput = document.getElementById('Animal_species').value;
        const animalCountInput = document.getElementById('Animal_count').value;

        const namePattern = /^[a-zA-Z\s]+$/; // Regular expression to allow only letters and spaces
        const countPattern = /^[1-9][0-9]*$/; // Regular expression to allow only positive integers

        if (!namePattern.test(animalNameInput)) {
            alert('Animal name must contain only letters and spaces.');
            event.preventDefault(); // Prevent form submission
        } else if (!namePattern.test(speciesInput)) {
            alert('Animal species must contain only letters and spaces.');
            event.preventDefault(); // Prevent form submission
        } else if (!countPattern.test(animalCountInput)) {
            document.getElementById('animalCountError').innerText = 'Animal count must be a positive integer.';
            event.preventDefault(); // Prevent form submission
        } else {
            document.getElementById('animalCountError').innerText = ''; // Clear any previous error message
        }
    });
</script>

    <!-- End Form -->
	<script src="script.js"></script>
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
