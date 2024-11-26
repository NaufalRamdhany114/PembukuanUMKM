<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/loginstyle.css?v=1.0">
</head>

<body>
<header>
        <div class="nav-logo">
            <img src="Gambar/logo.png" alt="BizBalance Logo">
            <span>BizBalance</span>
        </div>
        <div class="auth-buttons">
            <a href="index.php"><button class="home">Home</button></a>
            <a href="register.php"><button class="sign-up">Sign Up</button></a>
            <a href="login.php"><button class="sign-in">Sign In</button></a>
        </div>
    </header>
    <div class="container">
        <div class="left-panel">
            <h2>Hello Friends!</h2>
            <p>Register yourself and start using our services right away!</p>
            <a href="register.php">
                <button class="signup-btn">Sign Up</button>
            </a>
        </div>

        <div class="right-panel">
            <form class="signin-form" id="signin-form" method="POST" action="login-proses.php">
                <div class="logo">
                    <img src="Gambar/logo.png" alt="Logo">
                </div>
                <h1>Sign In</h1>
                <p>enter your username to sign in</p>
                
                <div class="input-field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="input-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="toggle-password"></span>
                </div>
                <button type="submit" name="login" class="signin-btn">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
