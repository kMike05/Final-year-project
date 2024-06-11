
<?php
require("script.php"); 
@include 'config.php';



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="images/logo.png" rel="icon">
	<title>Haller Park</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="css/pop.css">
	<style>
    #popupForm {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        z-index: 9999;
        width: 65%;
        max-width: 500px;
        backdrop-filter: blur(10px);
    }
    #popup-form {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        z-index: 9999;
        width: 65%;
        max-width: 500px;
        backdrop-filter: blur(10px);
    }
	#overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); 
        z-index: 9998; 
    }
	body.popup-open {
        overflow: hidden;
    }

.popup-form {
    position: relative;
}

.form-container {
    position: relative;
    padding-top: 40px;
}

.moving-message-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
}

.moving-message {
    padding: 10px 20px;
    
    color: #183d2e;
    font-size: 16px;
    border-radius: 5px;
    animation: moveMessage 10s linear infinite;
}

@keyframes moveMessage {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

#ticketPrice {
        border: none;
        padding: 8px;
        width: auto; 
        max-width: 150px;
        background-color: rgba(255, 255, 255, 0.8);
        margin-left: 1px; 
        font-weight: bold;

    }
.popup-form h2 {
    margin-top: 0;
    display: flex;
    align-items: center; 
}

.popup-form h2 select {
    margin-left: 10px; 
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


    .popup-form label {
        display: block;
        margin-bottom: 5px;
    }

	.popup-form input[type="date"],
	.popup-form input[type="text"],
    .popup-form input[type="number"],
    .popup-form input[type="email"],
    .popup-form select
    {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .popup-form #saveBtn {
        background-color: #183d2e;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        margin-right: 10px;
    }
    .popup-form #donateBtn {
        background-color: #183d2e;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        margin-right: 10px;
    }

    .popup-form .cancel {
        background-color: #ccc;
    }

    .popup-form button {
        display: inline-block;
        margin-right: 10px;
    }

    .popup-form .closeBtn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }
    body.popup-open {
    overflow: hidden;
}


    </style>

<style>
  .subMenu {
    display: none; 
  }

  .open-menu {
    display: block; 
  }
</style>
</head>
<body>

	<!-- header section start -->
	<header class="header" id="nav">
		
		<div>
			<h1>Haller Park <br></h1></div>

		<div class="links">
			<a href="#home">Home</a>
			<a href="#Ticket">Tickets</a>
			<a href="#project">Animals</a>
			<a href="#blog">Events</a>
			<a href="#contact">Contact Us</a>
		</div>
		

		<div class="icons">
			<div href="#" class="fab fa-facebook-f"></div>
			<div href="#" class="fab fa-twitter"></div>
			<div href="#" class="fab fa-instagram"></div>
			<div class="fas fa-bars" id="menu-btn"></div>
			<!--<a href="Aregister.php" class="btn1"><span>Register</span></a>
			<a href="Alogin.php" class="btn1"><span>Login</span></a>	-->	
		</div>
		<?php
        // PHP code for user session
        if(isset($_SESSION['user_name'])){
            echo '<img src="images/prof.jpeg" class="user-pic" onmouseover="toggleMenu()" ">';
            echo '<div class="sub-menu-wrap" id="subMenu">';
            echo '<div class="sub-menu">';
            echo '<div class="user-info">';
            echo '<img src="images/prof.jpeg">';
            echo '<h3>Hi, <span class="username">' . $_SESSION["user_name"] . '</span></h3>';
            echo '</div>';
            echo '<hr>';
            echo '<hr>';
            // echo '<a href="#" onclick="openPopup()" class="sub-menu-link">';
            // echo '<i class="fa-solid fa-right-from-bracket"></i><p>View Tickets</p>';
            // echo '<span>></span>';
            // echo '</a>';
            echo '<a href="logout.php" class="sub-menu-link">';
            echo '<i class="fa-solid fa-right-from-bracket"></i><p>logout</p>';
            echo '<span>></span>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<a href="Alogin.php" class="btn1"><span>Login</span></a>';
            echo '<a href="Aregister.php" class="btn1"><span>Register</span></a>';
        }
        ?>
          
    </div>
                 </nav>
            </div>
	</header>

    <div id="popup" class="popup">
  <div class="popup-content">
    <span class="close" onclick="closePopup()">&times;</span>
    <table>
  <thead>
    <tr>
      <th>Phone Number</th>
      <th>Ticket Type</th>
      <th>Ticket Price</th>
      <th>Visit Date</th>
    </tr>
  </thead>
  <tbody id="table-body">
    <!-- Table data will be populated here -->
  </tbody>
</table>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    fetchData();
});

function fetchData() {
    fetch('fetch_data.php')
        .then(response => response.json())
        .then(data => {
            populateTable(data);
        })
        .catch(error => console.error('Error fetching data:', error));
}

function populateTable(data) {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';

    data.forEach(rowData => {
        const row = document.createElement('tr');
        Object.values(rowData).forEach(value => {
            const cell = document.createElement('td');
            cell.textContent = value;
            row.appendChild(cell);
        });
        tableBody.appendChild(row);
    });
}

</script>
  </div>
</div>
<style>
    .popup {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.popup-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

</style>
<script>
    function openPopup() {
    document.getElementById('popup').style.display = 'block';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

</script>
    
    
<script>


// Function to hide the popup form
function hidePopupForm() {
    popupForm.style.display = 'none';
    dimmedBackground.style.display = 'none';
    document.body.classList.remove('modal-open'); // Remove class to enable scrolling
}




    
	function validatePhoneNumberInput(input) {
    input.value = input.value.replace(/\D/g, '');
}

function validateNameInput(input) {
    input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    input.value = input.value.replace(/\s{2,}/g, ' ');
    input.value = input.value.trim();
}
function validateForm() {
        var nameInput = document.getElementsByName("name")[0];
        var emailInput = document.getElementsByName("email")[0];
        var phoneInput = document.getElementById("phone");
        var dateInput = document.getElementById("date");
        var mpesaCodeInput = document.getElementsByName("MpesaCode")[0];

        // Validate name
        if (nameInput.value.trim() === "") {
            alert("Please enter your name.");
            return false;
        }

        // Validate email
        if (emailInput.value.trim() === "") {
            alert("Please enter your email.");
            return false;
        }

        // Validate phone number
        if (phoneInput.value.trim() === "") {
            alert("Please enter your id number.");
            return false;
        }

        // Validate date
        if (dateInput.value.trim() === "") {
            alert("Please select the date of visit.");
            return false;
        }

        // Validate Mpesa code
        if (mpesaCodeInput.value.trim() === "") {
            alert("Please enter the Mpesa code.");
            return false;
        }

        return true;
    }
    
    function confirmPay() {
        return confirm("You will receive an email after approval!! Click to confirm payment");
    }

    function confirmdonation() {
        var form = document.querySelector('.form-container');

        if (!form.checkValidity()) {
            form.reportValidity();
            return false;
        }
        return confirm(" Click to confirm your donation");
    }

</script>
<script>
    function validateMpesaCode(input) {
    input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 10);
}

function updateTicketPrice() {
    var ticketTypeSelect = document.getElementById("ticketType");
    var selectedOption = ticketTypeSelect.options[ticketTypeSelect.selectedIndex];
    var selectedPrice = selectedOption.value.split('|')[1]; // Split value to extract price
    var selectedType = selectedOption.value.split('|')[0]; // Split value to extract type

    // Update hidden input fields with selected type and price
    document.getElementById("selectedTicketType").value = selectedType;
    document.getElementById("selectedTicketPrice").value = selectedPrice;

    // Update ticket price textbox
    document.getElementById("ticketPrice").value = selectedPrice;
}
</script>


	<!-- header section ends -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div id="popupForm" class="popup-form">
        <span class="closeBtn" onclick="closePopupForm()">&times;</span>
        <?php
        
        $sql = "SELECT Ticket_type, Ticket_price FROM tbl_tickets";
        $result = $conn->query($sql);
        
        $ticketData = array();
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ticketData[$row["Ticket_type"]] = $row["Ticket_price"];
            }
        }
        
?>





<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <form class="form-container" action="ticket-process.php" method="POST">
			<div class="moving-message-container">
        <div class="moving-message">Only Mpesa Payments are allowed</div>
    </div>
    <h2>Payment details:Till Number:222333 </h2>
    <select id="ticketType" name="ticketType" onchange="updateTicketPrice()" required>
            <option value="">Confirm Ticket Type</option>
            <?php
                foreach($ticketData as $type => $price) {
                 // Format the option value to contain both type and price, separated by a delimiter (e.g., "|")
                 $value = "$type|$price";
                echo "<option value='$value'>$type</option>";
}
?>

        </select>
            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter Name" name="name" oninput="validateNameInput(this)" required>
            <label for="email"><b>Email</b></label>
<input type="email" placeholder="Enter Email" name="email" value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>" required>
			<label for="phone"><b>ID Number</b></label>
            <input type="text" placeholder="Enter Your ID Number" name="phone" oninput="validatePhoneNumberInput(this)" maxlength="8" pattern="[0-9]*" required>
		<label for="date"><b>date of Visit</b></label>
		<input type="date" id="date" class="form-input" placeholder="Visit Date"  name="date" min="<?= date('Y-m-d') ?>">
        <label for="name"><b>Mpesa Code</b></label>
            <input type="text" placeholder="Enter Mpesa Code" name="MpesaCode" oninput="validateMpesaCode(this)" required>

			<button type="submit" id="saveBtn" onclick="return  confirmPay() " >Pay</button>
            <input type="text" id="ticketPrice" name="ticketPrice" placeholder="Ticket Price" readonly style=" border: none; padding: 8px;">
                <!-- Display error message if exists -->
    <?php if(!empty($errorMsg)): ?>
    <div class="error-message"><?php echo $errorMsg; ?></div>
    <?php endif; ?>
			<button type="submit" class="btn cancel" style="display: none;">Close</button>
            <input type="hidden" id="selectedTicketType" name="selectedTicketType">
            <input type="hidden" id="selectedTicketPrice" name="selectedTicketPrice">

        </form>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Check if there's a success message in the session and display SweetAlert
        <?php if (isset($_SESSION['success_message'])): ?>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '<?php echo $_SESSION['success_message']; ?>',
                showConfirmButton: false,
                timer: 1500
            });
            <?php unset($_SESSION['success_message']); // Unset the session variable after displaying the alert ?>
        <?php endif; ?>
    </script>
	<div id="overlay"></div>
   
 

	<!-- home section start -->

	<section class="home" id="home">
		<div class="content">
			<h1>WELCOME TO HALLER PARK.</h1>
			<p>Enjoy the jungle life and bring your friends to the Haller Park Zoo.Haller Park is a place where you can see nature in its Wildlife.
			</p>
		
		</div>
	</section>
	<!-- home section ends -->
	
            <?php 
            if(!isset($_SESSION['user_name'])){
    // User is not logged in, redirect to login page or display a message
  
    // header("Location: Alogin.php");
    // exit();
    echo "Please log in to access the Tickets and view all upcoming events.";
    exit();
}?>
	    <div id="formPopup" class="popup-form">
    <form class="form-container" action="donate-process.php" method="POST">
        <span class="closeBtn" onclick="closeFormPopup()">&times;</span>
        <div class="moving-message-container"></div>
        <h2 id="paytitle">Thank You For Donating!!</h2>
        <h3>Till Number: 222333</h3>
        <input type="text" placeholder="Enter Name" name="name" oninput="validateNameInput(this)" required>
        <input type="email" placeholder="Enter Email" name="email" required>
        <input type="text" placeholder="Enter Your ID Number" name="id_number" oninput="validatePhoneNumberInput(this)" maxlength="8" pattern="[0-9]*" required>
        <input type="number" id="donationAmount" name="donationAmount" placeholder="Enter Donation Amount" min="50">
        <input type="text" placeholder="Enter Mpesa Code" name="MpesaCode" oninput="validateMpesaCode(this)" required>
       <span></span>
       <button type="submit" id="donateBtn"  onclick="return  confirmDonate() "> >Donate</button>
        <!-- Display error message if exists -->
        <?php if(!empty($errorMsg)): ?>
            <div class="error-message"><?php echo $errorMsg; ?></div>
        <?php endif; ?>
    </form>
</div>
<div id="overlay"></div>


<script>
    function confirmDonate() {
        return confirm("click to confirm your donation");
    }
</script>

 
	<!-- Ticket section start -->

	<section class="Ticket" id="Ticket">
    <a href="#" class="btn" onclick="toggleFormPopup(event)"><span>Donate</span></a>

		<h1 class="heading">Tickets</h1>
		<p class="paragraph">Book yourself a Ticket</p>


		<div class="box-container">
		<?php
// Fetch ticket details from the database
$sql = "SELECT * FROM tbl_tickets";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ticketType = $row['Ticket_type'];
        $ticketPrice = $row['Ticket_price'];
        $ticketDescription = $row['Ticket_description'];
		$fontAwesomeIcon = $row['font_awesome_icon'];
?>
        <div class="box">
			<i class="fa-solid <?php echo $fontAwesomeIcon; ?>"></i>
            <h3><?php echo $ticketType; ?></h3>
            <p><?php echo $ticketDescription; ?></p>
            <p class="price">Ksh<?php echo $ticketPrice; ?></p>

            <a href="#" class="Tbutton" onclick="togglePopupForm(event)">Get Ticket</a>
        </div>
<?php
    }
} else {
    echo "No tickets available";
}
?>

			

	</section>
	<!-- Ticket section ends -->
<style>
    /* Hide the form by default */
#formPopup {
    display: none;
    position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        border-radius: 10px;
        z-index: 9999;
        width: 65%;
        max-width: 500px;
        backdrop-filter: blur(10px);
}

/* Style for the form container within formPopup */
#formPopup .form-container {
    
    padding: 40px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Style for the form title within formPopup */
#formPopup .form-container h2 {
    margin-top: 0;
    font-size: 1.5rem;
}
#formPopup .form-container #closeBtn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
}

/* Style for the input fields within formPopup */
#formPopup .form-container input[type="text"],
#formPopup .form-container input[type="email"],
#formPopup .form-container input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

</style>
	


	

	<!-- blog section start -->

	<section class="blog" id="blog">
		<h1 class="heading">Events</h1>
		<p class="paragraph">
			read our latest news <br> stay updated for our Upcoming events!!
		</p>


		<div class="box-container">
			<?php
		$sql = "SELECT * FROM tbl_event";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $pic = $row['event_pic'];
            $name = $row['event_name'];
			$date=$row['event_date'];
            $Description = $row['event_description'];
    ?>
			<div class="box">
			<?php if ($pic == "") : ?>
                    <p>Image not available</p>
                <?php else : ?>
				<div class="image">
				<img src="images/<?php echo $pic ?>" alt="<?php echo $name ?>">
				</div>
                <?php endif; ?>
				<div class="content">
					<a href="#" class="cate"><?php echo $date ?></a>
					<span><?php echo $name ?></span>
					<p><?php echo $Description ?></p>
					<a href="#">read more</a>
				</div>
			</div>
			<?php
        }
    } else {
        echo "<div class='error'>No Events currently!!</div>";
    }
    ?>

		</div>
	</section>

	<!-- blog section ends -->

<!-- Animal section start -->


<section class="project" id="project">
		<h1 class="heading">Our Animals</h1>
		<p class="paragraph">
			Haller park has a wide range of Wildlife<br>
		</p>	
		
		<div class="box-container">
    <?php
    $sql = "SELECT * FROM tbl_animal";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $pic = $row['Animal_pic'];
            $name = $row['Animal_name'];
            $Description = $row['Animal_description'];
    ?>
            <div class="box">
                <?php if ($pic == "") : ?>
                    <p>Image not available</p>
                <?php else : ?>
                    <img src="images/<?php echo $pic ?>" alt="<?php echo $name ?>">
                <?php endif; ?>
                <div class="content">
                    <div>
                        <h3><?php echo $name ?></h3>
                        <span>Fun Fact:</span>
                        <p><?php echo $Description ?></p>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<div class='error'>No Animals found!!</div>";
    }
    ?>
</div>

			
	</section>
	<!-- animal section ends -->
	<!-- contact section start -->

	<section class="contact" id="contact">
		<h1 class="heading">contact us</h1>
		<p class="paragraph">feel free to contact us</p>

		<div class="row">
			<div class="content">
				<h1>let's talk</h1>
				<h3>HallerPark@gmail.com</h3>
				<p>If facing an issue with ticket booking feel free to contact us.</p>

				<div class="icons">
					<a href="#" class="fab fa-facebook-f"></a>
					<a href="#" class="fab fa-twitter"></a>
					<a href="#" class="fab fa-instagram"></a>
					<a href="#" class="fab fa-linkedin"></a>
					<a href="#" class="fab fa-tiktok"></a>

				</div>
			</div>

			<div class="form" >
            <form action="email-send.php" method="POST">
            <input type="text" name="name" placeholder="Your name" required>
            <input type="email" name="email" placeholder="Your email" required>
            <input type="text" name="subject" placeholder="Subject" class="subject" required>
            <textarea name="message" placeholder="Your message" required></textarea>
            <button type="submit" name="submit" class="btn">Send message</button>
        </form>
			</div>
		</div>
	</section>


	<!-- contact section ends -->

	<!-- footer section start -->
	<section class="footer">
		<div class="credit">
			created by <span>Mike</span> | all rights reserved.
		</div>


	</section>
	<!-- footer section ends -->

    <script>
    let subMenu = document.getElementById("subMenu");
    let isOpen = false;

    function toggleMenu() {
        if (isOpen) {
            subMenu.classList.remove("open-menu");
            isOpen = false;
        } else {
            subMenu.classList.add("open-menu");
            isOpen = true;
        }
    }

    // Add event listener to close submenu when clicking outside of it
    document.body.addEventListener('click', function(event) {
        const isClickInsideSubMenu = subMenu.contains(event.target);
        if (!isClickInsideSubMenu && isOpen) {
            subMenu.classList.remove("open-menu");
            isOpen = false;
        }
    });
</script>

    <script src="js/scripts.js"></script>
    	<script>
function togglePopupForm(event) {
    event.preventDefault(); 
    openPopupForm();
}

function openPopupForm() {
    var popupForm = document.getElementById("popupForm");
    var dimmedBackground = document.getElementById("overlay"); 
    var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0; 
    popupForm.style.display = "block";
    dimmedBackground.style.display = "block"; 
    document.body.style.overflow = "hidden"; 
    window.scrollTo(0, scrollPos);
}

function closePopupForm() {
    var popupForm = document.getElementById("popupForm");
    var dimmedBackground = document.getElementById("overlay"); 
    var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    popupForm.style.display = "none";
    dimmedBackground.style.display = "none"; 
    document.body.style.overflow = "auto"; // Enable scrolling
    window.scrollTo(0, scrollPos);
}



</script>
<script>
    function toggleFormPopup(event) {
    event.preventDefault(); 
    openFormPopup();
}
    function openFormPopup() {
    var formPopup = document.getElementById("formPopup");
    var dimmedBackground = document.getElementById("overlay");
    var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    formPopup.style.display = "block";
    dimmedBackground.style.display = "block";
    document.body.style.overflow = "hidden";
    window.scrollTo(0, scrollPos);
}

function closeFormPopup() {
    var formPopup = document.getElementById("formPopup");
    var dimmedBackground = document.getElementById("overlay");
    var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    formPopup.style.display = "none";
    dimmedBackground.style.display = "none";
    document.body.style.overflow = "auto"; // Enable scrolling
    window.scrollTo(0, scrollPos);
}

</script>

</body>
</html>