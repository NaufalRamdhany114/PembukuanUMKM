<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/registerstyle.css">
</head>
<body>
    <div class="signup-container">
        <form class="signup-form" id="signupForm">
            <h1>Sign Up</h1>
            <div class="input-field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username">
            </div>
            <div class="input-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email">
            </div>
            <div class="input-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password">
                <span class="toggle-password"></span>
            </div>
            <button type="submit" id="signup-btn" class="signup-btn">Sign Up</button>
            <div class="signin-link">
                <p>Already have an account? <a href="Login.php">Sign In</a></p>
            </div>
        </form>
    </div>
    
    <div class="popup-box" id="popup-box">
        <h3>Sign Up Successful!</h3>
        <p>Your account has been created successfully.</p>
        <button class="close-popup" id="close-popup">Close</button>
    </div>
    
    <script>
        const signupForm = document.getElementById('signupForm');
        const popupBox = document.getElementById('popup-box');
        const closePopup = document.getElementById('close-popup');
    
        signupForm.addEventListener('submit', function (event) {
            event.preventDefault(); 
            const username = document.getElementById('username').value;
            sessionStorage.setItem('userName', username);
            popupBox.classList.add('active'); 
        });
    
        closePopup.addEventListener('click', function () {
            popupBox.classList.remove('active'); 
            window.location.href = 'dashboard.php';
        });
    </script>
</body>
</html>
