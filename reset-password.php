<?php
include('config.php');
$mysqli = require __DIR__ . "/database.php";
// Check if token is provided in URL parameters

if (isset($_GET["token"])) {
    $token = $_GET["token"];
    echo "Token from URL: " . htmlspecialchars($token) . "<br>"; // Debugging line

    // Verify the token in the database
    $token_hash = hash("sha256", urldecode($token));
    $sql = "SELECT email, reset_token_expires_at FROM user_form WHERE reset_token_hash = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("Database error: " . $mysqli->error);
    }

    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $expiry = strtotime($row['reset_token_expires_at']);

        if ($expiry < time()) {
            die("Token has expired.");
        }
    } else {
        die("Token not found in database.");
    }
} else {
    echo "Token not provided in URL parameters.";
    exit();
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
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="passstyle.css">
    <style>
        .container {
            display: flex;
            position: relative;
        }
        .title {
            display: none;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-weight: bold;
            color: white;
            background-color: #045f27;
            text-align: center;
            padding: 10px;
            width: 100%;
            box-sizing: border-box; 
        }
        @media screen and (max-width: 768px) {
            .container {
                width: 80%;
            }
            .title {
                display: block; 
            }
            .left {
                display: none;
            }
            .right {
                max-width: 100%;
            }
            .formBox {
                padding: 0px;
                width: 100%;
            }
        }
    </style>
</head>
<body style="background: whitesmoke;">
    <div class="title">Haller Park</div>
    <div class="container">
        <div class="left"></div>
        <div class="right">
            <div class="formBox">
                <form action="process-reset-password.php" method="post">
                    <h4>CHANGE PASSWORD</h4>
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <p>New Password</p>
                    <div class="password">
                        <input type="password" placeholder="New Password" name="password" id="password" required />
                    </div>
                    <p>Confirm Password</p>
                    <div class="password">
                        <input type="password" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation" required />
                    </div>
                    <input type="submit" name="submit" value="Reset">
                    <?php
                    if (isset($error)) {
                        foreach ($error as $error) {
                            echo '<span class="error-msg">' . $error . '</span>';
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
