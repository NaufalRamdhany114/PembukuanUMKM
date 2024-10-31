<?php
session_start();

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard BizBalance</title>
  <link rel="stylesheet" href="CSS/dashboardstyle.css?v=1.0">
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateClock() {
            const clockElement = document.getElementById('clock');
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            clockElement.textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
    });
  </script>
</head>
<body>
  <header>
    <div class="logo">
      <img src="Gambar/logo.png" alt="Logo BizBalance">
      <span>BizBalance</span>
    </div>
    <nav>
      <ul>
        <li><a href="dashboard.php"><img src="Gambar/dashboard.png" alt="" class="nav-logo">Dashboard</a></li>
        <li><a href="laporan.php"><img src="Gambar/laporan.png" alt="" class="nav-logo">Laporan</a></li>
        <li><a href="riwayat.php"><img src="Gambar/riwayat.png" alt="" class="nav-logo">Riwayat</a></li>
        <li><a href="logout.php"><img src="Gambar/logout.png" alt="" class="nav-logo">Logout</a></li>
      </ul>
    </nav>
    <div class="profil" id="profil-username">
      <?php echo htmlspecialchars($userName); ?>
    </div> 
  </header>

    <div class="dashboard">
      <h1>Selamat Datang <?php echo htmlspecialchars($userName); ?> Di BizBalance</h1>
    </div>

    <div class="kartu-container">
        <div id="clock" style="font-size: 1.5em; margin-top: 10px;"></div>
    </div>
  
  <footer>
    <div class="footer-dashboard">
      <p>© 2024 BizBalance. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
