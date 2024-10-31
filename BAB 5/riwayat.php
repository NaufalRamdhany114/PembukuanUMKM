<?php
session_start();

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizBalance - Riwayat</title>
    <link rel="stylesheet" href="CSS/dashboardstyle.css?v=1.0">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Gambar/logo.png" alt="BizBalance Logo">
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
        <div class="profil" id="profil-username"><?php echo htmlspecialchars($userName); ?></div> 
    </header>
    
    <div class="dashboard">
    <h1>Riwayat</h1>
  </div>
    <div class="riwayat">
    <table>
        <tr>
            <th>Nama</th>
            <th>Pendapatan</th>
            <th>Pengeluaran</th>
            <th>Kewajiban</th>
            <th>Status</th>
        </tr>
        <tr>
            <td>Agus</td>
            <td>Rp. 5.000.000</td>
            <td>Rp. 3.500.000</td>
            <td>Rp. 1.000.000</td>
            <td>Success</td>
        </tr>
        <tr>
            <td>Albert</td>
            <td>Rp. 7.000.000</td>
            <td>Rp. 6.200.000</td>
            <td>Rp. 1.200.000</td>
            <td>Success</td>
        </tr>
    </table>
</div>

    
<footer>
    <div class="footer-riwayat">
        <p>© 2024 BizBalance. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
