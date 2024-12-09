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
        tb_pengguna.username, 
        tb_laporan.id_laporan, 
        tb_laporan.tanggal, 
        COALESCE(SUM(tb_pemasukan.jumlah_pemasukan), 0) AS pendapatan, 
        COALESCE(SUM(tb_pengeluaran.jumlah_pengeluaran), 0) AS pengeluaran, 
        COALESCE(SUM(tb_kewajiban.jumlah_kewajiban), 0) AS kewajiban
    FROM tb_laporan
    JOIN tb_pengguna ON tb_laporan.id_pengguna = tb_pengguna.id_pengguna
    LEFT JOIN tb_pemasukan ON tb_laporan.id_laporan = tb_pemasukan.id_laporan
    LEFT JOIN tb_pengeluaran ON tb_laporan.id_laporan = tb_pengeluaran.id_laporan
    LEFT JOIN tb_kewajiban ON tb_laporan.id_laporan = tb_kewajiban.id_laporan
    WHERE tb_pengguna.username = ?
    GROUP BY tb_laporan.id_laporan
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
    <title>BizBalance - Pencatatan Keuangan</title>
    <link rel="stylesheet" href="../CSS/dashboardstyle.css?v=1.0">
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
                <li><a href="pencatatan.php"><img src="../Gambar/laporan.png" alt="" class="nav-logo">Pencatatan</a></li>
                <li><a href="../laporan/laporan.php"><img src="../Gambar/keuangan.png" alt="" class="nav-logo">Laporan</a></li>
                <li><a href="../logout.php"><img src="../Gambar/logout.png" alt="" class="nav-logo">Logout</a></li>
            </ul>
        </nav>
        <div class="profil" id="profil-username"><?php echo htmlspecialchars($userName); ?></div> 
    </header>
    
    <div class="dashboard">
        <h1>Pencatatan Keuangan</h1>
    </div>

    <div class="riwayat">
    <div class="tambah-data-container">
        <a href="pencatatan-entry.php" class="tambah-data-button">Tambah Data</a>
    </div>
        <table>
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Pendapatan</th>
                <th>Pengeluaran</th>
                <th>Kewajiban</th>
                <th>Aksi</th>
                <th>Hasil Keuangan</th>
            </tr>
            <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
            <td>Rp. <?php echo number_format($row['pendapatan'], 0, ',', '.'); ?></td>
            <td>Rp. <?php echo number_format($row['pengeluaran'], 0, ',', '.'); ?></td>
            <td>Rp. <?php echo number_format($row['kewajiban'], 0, ',', '.'); ?></td>
            <td class="action-buttons">
                <a href="pencatatan-edit.php?id_laporan=<?php echo $row['id_laporan']; ?>" class="edit-button">Edit</a>
                <form action="pencatatan-hapus.php" method="post" style="display: inline;">
                    <input type="hidden" name="id_laporan" value="<?php echo htmlspecialchars($row['id_laporan']); ?>">
                    <button type="submit" id="delete-button">Delete</button>
                </form>
            </td>
            <td class="laporan">
                <a href="../laporan/laporan-entry.php?id_laporan=<?php echo $row['id_laporan']; ?>" class="detail-button">Detail</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="7" style="text-align: center;">Tidak ada data</td>
    </tr>
<?php endif; ?>

        </table>
    </div>

    <div id="snackbar"></div>

    <script>
        function showSnackbar(message, type = "success") {
            var snackbar = document.getElementById("snackbar");
            snackbar.textContent = message;
            snackbar.className = `snackbar show ${type}`;
            setTimeout(function() {
                snackbar.className = snackbar.className.replace("show", "");
            }, 3000);
        }

        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get("status");
            const message = urlParams.get("message");

            if (status === "success" && message) {
                showSnackbar(decodeURIComponent(message), "success");
            } else if (status === "error" && message) {
                showSnackbar(decodeURIComponent(message), "error");
            }

            if (status || message) {
                const newUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
</body>
</html>
