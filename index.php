<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizBalance</title>
    <link rel="stylesheet" href="CSS/indexstyle.css?v=1.0">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const signUpButton = document.querySelector('.sign-up');
            signUpButton.addEventListener('click', () => {
                console.log('Sign Up button clicked');
            });
            const signInButton = document.querySelector('.sign-in');
            signInButton.addEventListener('click', () => {
                console.log('Sign In button clicked');
            });
            const heroHeading = document.querySelector('.hero h1');
            console.log('Original Hero Heading:', heroHeading.textContent);
            const highlights = document.querySelectorAll('.highlight');
            highlights.forEach(highlight => {
                highlight.addEventListener('mouseover', () => {
                    console.log('Mouse over highlight:', highlight.textContent);
                });
            });
        });
    </script>
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
    <main>
    <section class="hero">
    <div class="text-content">
        <h1>
            Laporan Keuangan <span class="highlight">Akurat</span>,<br>
            Keputusan Bisnis <span class="highlight">Tepat</span>.<br>
            Arus Kas <span class="highlight">Lancar</span>,<br>
            Bisnis Makin <span class="highlight">Kuat</span>.
        </h1>
        <p class="text-content">
            Cara mencatat keuangan kita sekarang masih manual, <br class="line-break">seringkali telat, dan kadang-kadang salah hitung.
        </p>
        <h2>#BizBalance-inAja</h2>
    </div>
    <div class="gambar">
        <img src="Gambar/ilustrasi.png" alt="ilustrasi">
    </div>
    </section>

    </main>
</body>
    </html>
