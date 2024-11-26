<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/registerstyle.css">
</head>
<body>
<header>
        <div class="logo">
            <img src="Gambar/logo.png" alt="BizBalance Logo">
            <span>BizBalance</span>
        </div>
        <div class="auth-buttons">
            <a href="index.php"><button class="home">Home</button></a>
            <a href="register.php"><button class="sign-up">Sign Up</button></a>
            <a href="login.php"><button class="sign-in">Sign In</button></a>
        </div>
    </header>
    <div class="signup-container">
        <form class="signup-form" id="signupForm" method="post" action="register-proses.php">
            <h1>Sign Up</h1>
            <div class="input-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
                        <div class="input-field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="toggle-password"></span>
            </div>
            <button type="submit" id="signup-btn" class="signup-btn">Sign Up</button>
            <div class="signin-link">
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>
        </form>
    </div>

</body>
</html>
