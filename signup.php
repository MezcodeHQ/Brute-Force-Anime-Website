<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>W.A.S</title>
<style>
    /* Basic Reset */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    /* Body Styling */
    body {
        position: relative;
        overflow: hidden;
        color: #eee;
        padding: 20px;
        height: 100vh; 
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    /* Video Background */
    .video-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
       
    }

    /* Overlay Container with Glow */
    .registration-container {
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

    /* Input Styling with Glow */
    .form-group input {
        width: 100%;
        padding: 12px;
        border: none;
        border-bottom: 2px solid #00adb5;
        background: transparent;
        color: #eee;
        outline: none;
        transition: all 0.3s;
        box-shadow: 0 0 5px #00adb5, 0 0 15px rgba(0, 255, 255, 0.5);
    }

    /* Hover and Focus Styling with Glow */
    .form-group input:hover {
        border-bottom: 2px solid #ff006e;
        box-shadow: 0 0 8px #ff006e, 0 0 20px rgba(255, 0, 110, 0.5);
    }

    .form-group input:focus {
        border-bottom: 2px solid #ff006e;
        background-color: rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 10px #ff006e, 0 0 25px rgba(255, 0, 110, 0.5);
    }

    .form-group label {
        position: absolute;
        top: 14px;
        left: 12px;
        font-size: 0.9em;
        color: #00adb5;
        transition: 0.3s;
    }

    .form-group input:focus ~ label,
    .form-group input:not(:placeholder-shown) ~ label {
        top: -10px;
        left: 10px;
        font-size: 0.8em;
        color: #ff006e;
    }

    /* Button Styling with Glow */
    .btn-submit {
        width: 100%;
        padding: 12px;
        background: #00adb5;
        border: none;
        border-radius: 10px;
        color: #222831;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s, box-shadow 0.3s;
        box-shadow: 0 0 8px #00adb5, 0 0 15px rgba(0, 255, 255, 0.5);
    }

    .btn-submit:hover {
        background: #ff006e;
        color: #eee;
        box-shadow: 0 0 10px #ff006e, 0 0 20px rgba(255, 0, 110, 0.7);
    }

    .error-message {
        color: #ff006e;
        font-size: 0.9em;
        display: none;
        margin-top: 5px;
    }

    .already-account {
        text-align: center;
        margin-top: 20px;
    }

    .already-account p {
        color: #eee;
        font-size: 0.9em;
    }

    .already-account a {
        color: #00adb5;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .already-account a:hover {
        color: #ff006e;
    }

    /* Responsive Adjustments */
    @media (max-width: 450px) {
        .registration-container {
            padding: 20px;
            box-shadow: 0 0 15px rgba(255, 0, 110, 0.3);
            margin-right: 2%;
        }

        h2 {
            font-size: 1.5em;
        }

        .form-group input {
            padding: 10px;
        }

        .btn-submit {
            font-size: 1em;
            padding: 10px;
        }
    }
</style>
</head>
<body>

<video autoplay muted loop class="video-background">
    <source src="22.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="registration-container">
    <h2>Register</h2>
    <form action="" method="POST" onsubmit="return validatePassword()">
        <div class="form-group">
            <input type="text" name="username" required placeholder=" ">
            <label>Username</label>
        </div>
        <div class="form-group">
            <input type="email" name="email" required placeholder=" ">
            <label>Email</label>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" required placeholder=" ">
            <label>Password</label>
            <div id="passwordError" class="error-message">Password must include at least 8 characters, an uppercase letter, a lowercase letter, a number, and a special character.</div>
        </div>
        <div class="form-group">
            <input type="password" id="confirm_password" name="confirm_password" required placeholder=" ">
            <label>Confirm Password</label>
            <div id="confirmPasswordError" class="error-message">Passwords do not match.</div>
        </div>
        <button type="submit" class="btn-submit">Register Now</button>
    </form>
    <div class="already-account">
        <p>Already have an account? <a href="signin.php">Sign in here</a></p>
    </div>
</div>

<script>
function validatePassword() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    let isValid = true;

    if (!strongPasswordPattern.test(password)) {
        passwordError.style.display = 'block';
        isValid = false;
    } else {
        passwordError.style.display = 'none';
    }

    if (password !== confirmPassword) {
        confirmPasswordError.style.display = 'block';
        isValid = false;
    } else {
        confirmPasswordError.style.display = 'none';
    }

    return isValid;
}
</script>

</body>
</html>



<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "was";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // Check if passwords match
    if ($pass === $confirm_pass) {
        // Check for duplicate username or email
        $check = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $user, $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username or email already exists. Please try a different one.');</script>";
        } else {
            // Hash the password
            $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

            // Insert into database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $user, $email, $hashed_pass);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href='signin.php';</script>";
            } else {
                echo "<script>alert('Registration failed. Please try again.');</script>";
            }

            $stmt->close();
        }
    } else {
        echo "<script>alert('Passwords do not match.');</script>";
    }
}

$conn->close();
?>
