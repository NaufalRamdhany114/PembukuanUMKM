<?php 
session_start();

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit();
}

$userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard BizBalance</title>
  <link rel="stylesheet" href="CSS/dashboardstyle.css">
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
        <li><a href="laporan/laporan.php"><img src="Gambar/laporan.png" alt="" class="nav-logo">Laporan</a></li>
        <li><a href="logout.php"><img src="Gambar/logout.png" alt="" class="nav-logo">Logout</a></li>
      </ul>
    </nav>
    <div class="profil" id="profil-username">
      <?php echo htmlspecialchars($userName); ?>
    </div> 
  </header>

  <div class="dashboard">
    <h1>Selamat Datang, <?php echo htmlspecialchars($userName); ?> di BizBalance</h1>
    <p>BizBalance adalah solusi pembukuan untuk UMKM yang memudahkan pelacakan keuangan.</p>
  </div>

  <div class="kartu-container">
    <div class="kartu">
      <img src="Gambar/salary.png" alt="Pendapatan">
      <h2>Pendapatan</h2>
      <p>Catat dan pantau pendapatan bisnis Anda dengan mudah.</p>
    </div>
    <div class="kartu">
      <img src="Gambar/spending.png" alt="Pengeluaran">
      <h2>Pengeluaran</h2>
      <p>Kendalikan pengeluaran bisnis untuk memaksimalkan keuntungan.</p>
    </div>
    <div class="kartu">
      <img src="Gambar/budget.png" alt="Laporan">
      <h2>Laporan Keuangan</h2>
      <p>Analisis performa bisnis Anda melalui laporan keuangan otomatis.</p>
    </div>
  </div>
  
  <footer>
    <div class="footer-dashboard">
      <p>© 2024 BizBalance. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
