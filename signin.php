<?php
session_start();
$servername = "sql12.freesqldatabase.com";
$username = "sql12760617";
$password = "MlT4me7z2n";
$dbname = "sql12760617";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$maxAttempts = 5;
$lockoutTime = 300;
$ip = $_SERVER['REMOTE_ADDR'];
$now = date('Y-m-d H:i:s');
$lockoutEnd = date('Y-m-d H:i:s', time() - $lockoutTime);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $attemptsStmt = $conn->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE ip_address = ?");
    $attemptsStmt->bind_param("s", $ip);
    $attemptsStmt->execute();
    $attemptsStmt->store_result();

    if ($attemptsStmt->num_rows > 0) {
        $attemptsStmt->bind_result($attempts, $lastAttempt);
        $attemptsStmt->fetch();

        if ($attempts >= $maxAttempts && $lastAttempt > $lockoutEnd) {
            die("Too many login attempts. Please try again later.");
        } elseif ($lastAttempt <= $lockoutEnd) {
            $conn->query("UPDATE login_attempts SET attempts = 1, last_attempt = '$now' WHERE ip_address = '$ip'");
        } else {
            $conn->query("UPDATE login_attempts SET attempts = attempts + 1, last_attempt = '$now' WHERE ip_address = '$ip'");
        }
    } else {
        $conn->query("INSERT INTO login_attempts (ip_address, attempts, last_attempt) VALUES ('$ip', 1, '$now')");
    }

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_pass);
        $stmt->fetch();

        if (password_verify($pass, $hashed_pass)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $user;
            $conn->query("DELETE FROM login_attempts WHERE ip_address = '$ip'");
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('Username not found.');</script>";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>W.A.S</title>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    body {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        height: 100vh;
        color: #eee;
        overflow: hidden;
        background-color: #111;
    }
    .video-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
       
    }
    .login-container {
        background: rgba(20, 20, 20, 0.9);
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 0 30px rgba(0, 255, 255, 0.3);
        max-width: 400px;
        width: 100%;
        z-index: 1;
        margin-right: 50px;
    }
    h2 {
        color: #00ffff;
        text-align: center;
        margin-bottom: 20px;
        text-shadow: 0 0 10px #00ffff;
    }
    .form-group {
        position: relative;
        margin-bottom: 25px;
    }
    .form-group input {
        width: 100%;
        padding: 12px;
        border: none;
        border-bottom: 2px solid #00ffff;
        background: transparent;
        color: #eee;
        outline: none;
        transition: all 0.3s;
    }
    .form-group label {
        position: absolute;
        top: 14px;
        left: 12px;
        font-size: 0.9em;
        color: #00ffff;
        transition: 0.3s;
    }
    .form-group input:focus ~ label,
    .form-group input:not(:placeholder-shown) ~ label {
        top: -10px;
        left: 10px;
        font-size: 0.8em;
        color: #ff006e;
    }
    .btn-submit {
        width: 100%;
        padding: 12px;
        background: #00ffff;
        border: none;
        border-radius: 10px;
        color: #111;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-submit:hover {
        background: #ff006e;
        color: #eee;
        box-shadow: 0 0 10px #ff006e;
    }
    .captcha-container {
        display: flex;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .captcha-checkbox {
        width: 20px;
        height: 20px;
        margin-right: 10px;
    }
    .captcha-label {
        color: #00ffff;
        font-size: 0.9em;
    }
    .register-link {
        text-align: center;
        margin-top: 15px;
    }
    .register-link a {
        color: #00ffff;
        text-decoration: none;
        font-size: 0.9em;
    }
    .register-link a:hover {
        color: #ff006e;
    }
</style>
<script>
    function validateCaptcha() {
        const captchaCheckbox = document.getElementById('captcha');
        if (!captchaCheckbox.checked) {
            alert("Please confirm you're not a robot.");
            return false;
        }
        return true;
    }
</script>
</head>
<body>

<video class="video-background" autoplay loop muted>
    <source src="22.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="login-container">
    <h2>Welcome Back!</h2>
    <form action="" method="POST" onsubmit="return validateCaptcha()">
        <div class="form-group">
            <input type="text" name="username" required placeholder=" " />
            <label>Username</label>
        </div>
        <div class="form-group">
            <input type="password" name="password" required placeholder=" " />
            <label>Password</label>
        </div>
        <div class="captcha-container">
            <input type="checkbox" id="captcha" class="captcha-checkbox" />
            <label for="captcha" class="captcha-label">I'm not a robot</label>
        </div>
        <button type="submit" class="btn-submit">Login</button>
    </form>
    <div class="register-link">
        <p>New user? <a href="signup.php">Create an account</a></p>
    </div>
</div>

</body>
</html>
