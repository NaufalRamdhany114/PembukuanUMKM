<?php
session_start();

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['userName'];

include '../koneksi.php';

$query = "
    SELECT 
        tb_umkm.nama_umkm, 
        tb_umkm.alamat, 
        tb_umkm.status_keuangan, 
        COALESCE(SUM(tb_pemasukan.jumlah_pemasukan), 0) AS pendapatan, 
        COALESCE(SUM(tb_pengeluaran.jumlah_pengeluaran), 0) AS pengeluaran, 
        COALESCE(SUM(tb_kewajiban.jumlah_kewajiban), 0) AS kewajiban
    FROM tb_laporan
    JOIN tb_pengguna ON tb_laporan.id_pengguna = tb_pengguna.id_pengguna
    LEFT JOIN tb_pemasukan ON tb_laporan.id_laporan = tb_pemasukan.id_laporan
    LEFT JOIN tb_pengeluaran ON tb_laporan.id_laporan = tb_pengeluaran.id_laporan
    LEFT JOIN tb_kewajiban ON tb_laporan.id_laporan = tb_kewajiban.id_laporan
    LEFT JOIN tb_umkm ON tb_laporan.id_laporan = tb_umkm.id_laporan
    WHERE tb_pengguna.username = ?
      AND tb_umkm.id_umkm IS NOT NULL -- Menyaring hanya data dengan UMKM yang valid
    GROUP BY tb_umkm.id_umkm
";


$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $userName);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizBalance - Laporan Keuangan</title>
    <link rel="stylesheet" href="../CSS/dashboardstyle.css?v=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../Gambar/logo.png" alt="BizBalance Logo">
            <span>BizBalance</span>
        </div>
        <nav>
            <ul>
                <li><a href="../dashboard.php"><img src="../Gambar/dashboard.png" alt="" class="nav-logo">Dashboard</a></li>
                <li><a href="../pencatatan/pencatatan.php"><img src="../Gambar/laporan.png" alt="" class="nav-logo">Pencatatan</a></li>
                <li><a href="laporan.php"><img src="../Gambar/keuangan.png" alt="" class="nav-logo">Laporan</a></li>
                <li><a href="../logout.php"><img src="../Gambar/logout.png" alt="" class="nav-logo">Logout</a></li>
            </ul>
        </nav>
        <div class="profil" id="profil-username"><?php echo htmlspecialchars($userName); ?></div> 
    </header>
    
    <div class="dashboard">
        <h1>Laporan Keuangan</h1>
    </div>

    <div class="riwayat">
    <div class="tambah-data-container">
        <a href="laporan-cetak.php" class="tambah-data-button">Cetak Data</a>
    </div>
    <table>
    <tr>
        <th>Nama UMKM</th>
        <th>Alamat</th>
        <th>Pendapatan</th>
        <th>Pengeluaran</th>
        <th>Kewajiban</th>
        <th>Status Keuangan</th>
      </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['nama_umkm']); ?></td>
        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
        <td>Rp. <?php echo number_format($row['pendapatan'], 0, ',', '.'); ?></td>
        <td>Rp. <?php echo number_format($row['pengeluaran'], 0, ',', '.'); ?></td>
        <td>Rp. <?php echo number_format($row['kewajiban'], 0, ',', '.'); ?></td>
        <td><?php echo htmlspecialchars($row['status_keuangan']); ?></td>

    </tr>
    <?php endwhile; ?>
</table>

    </div>


<script>
function showAlert(message, type = "success") {
    Swal.fire({
        toast: true,
        position: "top-center",
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");
    const message = urlParams.get("message");

    if (message) {
        showAlert(decodeURIComponent(message), status === "success" ? "success" : "error");
    }

    if (status || message) {
        const newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});

</script>
</body>
</html>
