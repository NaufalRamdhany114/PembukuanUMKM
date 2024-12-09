<?php
session_start();
if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit();
}
$userName = $_SESSION['userName'];

include 'koneksi.php';

$queryUMKM = "SELECT COUNT(*) AS total FROM tb_umkm";
$resultUMKM = mysqli_query($conn, $queryUMKM);
$dataUMKM = mysqli_fetch_assoc($resultUMKM);
$totalUMKM = $dataUMKM['total']; 

$queryPendapatan = "SELECT SUM(jumlah_pemasukan) AS totalPendapatan FROM tb_pemasukan";
$resultPendapatan = mysqli_query($conn, $queryPendapatan);
$dataPendapatan = mysqli_fetch_assoc($resultPendapatan);
$totalPendapatan = $dataPendapatan['totalPendapatan'];

$queryPengeluaran = "SELECT SUM(jumlah_pengeluaran) AS totalPengeluaran FROM tb_pengeluaran";
$resultPengeluaran = mysqli_query($conn, $queryPengeluaran);
$dataPengeluaran = mysqli_fetch_assoc($resultPengeluaran);
$totalPengeluaran = $dataPengeluaran['totalPengeluaran'];

$queryKewajiban = "SELECT SUM(jumlah_kewajiban) AS totalKewajiban FROM tb_kewajiban";
$resultKewajiban = mysqli_query($conn, $queryKewajiban);
$dataKewajiban = mysqli_fetch_assoc($resultKewajiban);
$totalKewajiban = $dataKewajiban['totalKewajiban'];
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
                <li><a href="pencatatan/pencatatan.php"><img src="Gambar/laporan.png" alt="" class="nav-logo">Pencatatan</a></li>
                <li><a href="laporan/laporan.php"><img src="Gambar/keuangan.png" alt="" class="nav-logo">Laporan</a></li>
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

        <div class="data">
        <div class="UMKM">  
    <div class="dataContainer">
        <p>Total UMKM : <?php echo $totalUMKM; ?></p>
    </div>
    </div>
        <div class="row-container">
        <div class="dataContainer">
            <p>Total Pendapatan : <br>Rp <?php echo number_format($totalPendapatan, 0, ',', '.'); ?></p>
        </div>
        <div class="dataContainer">
            <p>Total Pengeluaran : <br>Rp <?php echo number_format($totalPengeluaran, 0, ',', '.'); ?></p>
        </div>
        <div class="dataContainer">
            <p>Total Kewajiban : <br>Rp <?php echo number_format($totalKewajiban, 0, ',', '.'); ?></p>
        </div>
    </div>
</div>
    </div>
    <footer>
        <div class="footer-dashboard">
            <p>© 2024 BizBalance. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>