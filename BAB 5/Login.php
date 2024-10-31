<?php
session_start();

if (isset($_SESSION['userName'])) {
    header('Location: dashboard.php');
    exit;
}

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $validUsers = [
        '2318032' => '12345678',
        'user2' => 'password2'
    ];

    if (isset($validUsers[$username]) && $validUsers[$username] === $password) {
        $_SESSION['userName'] = $username;
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const popupBox = document.getElementById('popup-box-success');
                popupBox.style.display = 'block';
            });
        </script>";
    } else {
        $errorMessage = "Username atau password salah";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const popupBox = document.getElementById('popup-box-error');
                popupBox.style.display = 'block';
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/loginstyle.css?v=1.0">
</head>

<body>
    <div class="container">
        <div class="left-panel">
            <h2>Hello Friends!</h2>
            <p>Register yourself and start using our services right away!</p>
            <a href="Register.php">
                <button class="signup-btn">Sign Up</button>
            </a>
        </div>

        <div class="right-panel">
            <form class="signin-form" id="signin-form" method="POST" action="">
                <div class="logo">
                    <img src="Gambar/logo.png" alt="Logo">
                </div>
                <h1>Sign In</h1>

                <div class="social-icons">
                    <a href="#"><img src="Gambar/x.svg" alt="X Icon"></a>
                    <a href="#"><img src="Gambar/fb.svg" alt="Facebook Icon"></a>
                    <a href="#"><img src="Gambar/ig.svg" alt="Instagram Icon"></a>
                </div>
                <p>or enter your username to sign in</p>
                
                <div class="input-field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="input-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="toggle-password"></span>
                </div>
                
                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="signin-btn">Sign In</button>
                
                <div class="divider">
                    <span>OR</span>
                </div>
                <button type="button" class="google-btn">
                    <img src="Gambar/google.svg" alt="Google Logo">
                    Sign With Google
                </button>
            </form>
        </div>
    </div>

    <div class="popup-box" id="popup-box-success" style="display: none;">
        <h3>Login Successful!</h3>
        <p>Welcome back, you've successfully signed in.</p>
        <button class="close-popup" id="close-popup-success">Close</button>
    </div>
    <div class="popup-box" id="popup-box-error" style="display: none;">
        <h3>Login Failed!</h3>
        <p><?php echo $errorMessage; ?></p>
        <button class="close-popup" id="close-popup-error">Close</button>
    </div>
    
    <script>
        document.getElementById('close-popup-success').addEventListener('click', function () {
            document.getElementById('popup-box-success').style.display = 'none';
            window.location.href = 'dashboard.php';
        });

        document.getElementById('close-popup-error').addEventListener('click', function () {
            document.getElementById('popup-box-error').style.display = 'none';
        });
    </script>
</body>
</html>
