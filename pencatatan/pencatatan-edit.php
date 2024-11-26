<?php
session_start();

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['userName'] ?? 'Guest';

include '../koneksi.php';

$id_laporan = $_GET['id_laporan'] ?? '';
if (empty($id_laporan)) {
    header('Location:laporan.php');
    exit;
}

$query = "
    SELECT tb_laporan.tanggal, 
           tb_pemasukan.jumlah_pemasukan, 
           tb_pengeluaran.jumlah_pengeluaran, 
           tb_kewajiban.jumlah_kewajiban 
    FROM tb_laporan
    LEFT JOIN tb_pemasukan ON tb_laporan.id_laporan = tb_pemasukan.id_laporan
    LEFT JOIN tb_pengeluaran ON tb_laporan.id_laporan = tb_pengeluaran.id_laporan
    LEFT JOIN tb_kewajiban ON tb_laporan.id_laporan = tb_kewajiban.id_laporan
    WHERE tb_laporan.id_laporan = ?
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id_laporan);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header('Location: laporan.php');
    exit;
}

function cleanRupiah($value) {
    return preg_replace('/[^\d]/', '', $value);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $pendapatan = cleanRupiah($_POST['pendapatan']);
    $pengeluaran = cleanRupiah($_POST['pengeluaran']);
    $kewajiban = cleanRupiah($_POST['kewajiban']);

    $updateTanggalQuery = "
        UPDATE tb_laporan 
        SET tanggal = ? 
        WHERE id_laporan = ?
    ";
    $stmtTanggal = mysqli_prepare($conn, $updateTanggalQuery);
    mysqli_stmt_bind_param($stmtTanggal, 'si', $tanggal, $id_laporan);
    mysqli_stmt_execute($stmtTanggal);

    $updatePemasukanQuery = "
        UPDATE tb_pemasukan 
        SET jumlah_pemasukan = ? 
        WHERE id_laporan = ?
    ";
    $stmtPemasukan = mysqli_prepare($conn, $updatePemasukanQuery);
    mysqli_stmt_bind_param($stmtPemasukan, 'di', $pendapatan, $id_laporan);
    mysqli_stmt_execute($stmtPemasukan);

    $updatePengeluaranQuery = "
        UPDATE tb_pengeluaran 
        SET jumlah_pengeluaran = ? 
        WHERE id_laporan = ?
    ";
    $stmtPengeluaran = mysqli_prepare($conn, $updatePengeluaranQuery);
    mysqli_stmt_bind_param($stmtPengeluaran, 'di', $pengeluaran, $id_laporan);
    mysqli_stmt_execute($stmtPengeluaran);

    $updateKewajibanQuery = "
        UPDATE tb_kewajiban 
        SET jumlah_kewajiban = ? 
        WHERE id_laporan = ?
    ";
    $stmtKewajiban = mysqli_prepare($conn, $updateKewajibanQuery);
    mysqli_stmt_bind_param($stmtKewajiban, 'di', $kewajiban, $id_laporan);
    mysqli_stmt_execute($stmtKewajiban);

    header("Location: pencatatan.php?status=success&message=" . urlencode("Data berhasil diperbarui!"));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizBalance - Edit Pencatatan Keuangan</title>
    <link rel="stylesheet" href="../CSS/dashboardstyle.css">
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
    <main>
        <section class="form-container">
            <h2>Edit Pencatatan Keuangan</h2>
            <form method="POST" action="">
                <label for="tanggal">Pilih Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal'] ?? ''); ?>" required>

                <label for="pendapatan">Input Pendapatan</label>
                <input type="text" id="pendapatan" name="pendapatan" value="<?php echo htmlspecialchars($data['jumlah_pemasukan'] ?? ''); ?>" required oninput="formatInputRupiah(event)">

                <label for="pengeluaran">Input Pengeluaran</label>
                <input type="text" id="pengeluaran" name="pengeluaran" value="<?php echo htmlspecialchars($data['jumlah_pengeluaran'] ?? ''); ?>" required oninput="formatInputRupiah(event)">

                <label for="kewajiban">Input Kewajiban</label>
                <input type="text" id="kewajiban" name="kewajiban" value="<?php echo htmlspecialchars($data['jumlah_kewajiban'] ?? ''); ?>" required oninput="formatInputRupiah(event)">

                <div class="form-buttons">
                    <button type="submit">Edit</button>
                    <a href="pencatatan.php" class="cancel-button">Batal</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
