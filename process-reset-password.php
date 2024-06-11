<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || empty($_POST['token'])) {
        die("Token not provided.");
    }

    $token = $_POST['token'];
    echo "Token from POST: " . htmlspecialchars($token) . "<br>"; // Debugging line
    $token_hash = hash("sha256", urldecode($token));

    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user_form WHERE reset_token_hash = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $mysqli->error);
    }

    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (strtotime($user["reset_token_expires_at"]) <= time()) {
            die("Token has expired");
        }

        if (strlen($_POST["password"]) < 8) {
            die("Password must be at least 8 characters");
        }

        if (!preg_match("/[a-z]/i", $_POST["password"])) {
            die("Password must contain at least one letter");
        }

        if (!preg_match("/[0-9]/", $_POST["password"])) {
            die("Password must contain at least one number");
        }

        if ($_POST["password"] !== $_POST["password_confirmation"]) {
            die("Passwords must match");
        }

        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $sql = "UPDATE user_form SET password_hash = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE email = ?";
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            die("Error preparing statement: " . $mysqli->error);
        }

        $stmt->bind_param("ss", $password_hash, $user["email"]);

        if ($stmt->execute()) {
            echo "Password updated. You can now log in.";
        } else {
            die("Error executing query: " . $stmt->error);
        }
    } else {
        die("Token not found.");
    }

    $stmt->close();
    $mysqli->close();
}
?>
