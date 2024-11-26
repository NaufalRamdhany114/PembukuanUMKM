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
           tb_kewajiban.jumlah_kewajiban,
           tb_umkm.nama_umkm,
           tb_umkm.alamat
    FROM tb_laporan
    LEFT JOIN tb_pemasukan ON tb_laporan.id_laporan = tb_pemasukan.id_laporan
    LEFT JOIN tb_pengeluaran ON tb_laporan.id_laporan = tb_pengeluaran.id_laporan
    LEFT JOIN tb_kewajiban ON tb_laporan.id_laporan = tb_kewajiban.id_laporan
    LEFT JOIN tb_umkm ON tb_laporan.id_laporan = tb_umkm.id_laporan
    WHERE tb_laporan.id_laporan = ?
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id_laporan);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

function cleanRupiah($value) {
    return preg_replace('/[^\d]/', '', $value);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_umkm = $_POST['namaumkm'];
    $alamat = $_POST['alamat'];

    if (empty($nama_umkm) || empty($alamat)) {
        echo '<script>
                alert("Nama UMKM dan alamat tidak boleh kosong!");
                window.history.back();
              </script>';
        exit;
    }

    $checkUmkmQuery = "SELECT COUNT(*) AS count FROM tb_umkm WHERE id_laporan = ?";
    $stmtCheck = mysqli_prepare($conn, $checkUmkmQuery);
    mysqli_stmt_bind_param($stmtCheck, 'i', $id_laporan);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);
    $rowCheck = mysqli_fetch_assoc($resultCheck);

    if ($rowCheck['count'] > 0) {
        echo '<script>
                alert("Data untuk laporan ini sudah tercatat di UMKM. Silakan periksa kembali atau gunakan laporan lain.");
                window.history.back();
              </script>';
        exit;
    }

    $pendapatan = $data['jumlah_pemasukan'] ?? 0;
    $pengeluaran = $data['jumlah_pengeluaran'] ?? 0;
    $kewajiban = $data['jumlah_kewajiban'] ?? 0;
    $status_keuangan = ($pendapatan > ($pengeluaran + $kewajiban)) ? 'Untung' : 'Rugi';

    $insertUmkmQuery = "
        INSERT INTO tb_umkm (id_laporan, nama_umkm, alamat, status_keuangan)
        VALUES (?, ?, ?, ?)";
    $stmtUmkm = mysqli_prepare($conn, $insertUmkmQuery);
    mysqli_stmt_bind_param($stmtUmkm, 'isss', $id_laporan, $nama_umkm, $alamat, $status_keuangan);
    mysqli_stmt_execute($stmtUmkm);

    header("Location: laporan.php?status=success&message=" . urlencode("Data UMKM berhasil ditambahkan!"));
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizBalance -  Entry UMKM</title>
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
                <li><a href="../pencatatan/pencatatan.php"><img src="../Gambar/laporan.png" alt="" class="nav-logo">Pencatatan</a></li>
                <li><a href="laporan.php"><img src="../Gambar/keuangan.png" alt="" class="nav-logo">Laporan</a></li>
                <li><a href="../logout.php"><img src="../Gambar/logout.png" alt="" class="nav-logo">Logout</a></li>
            </ul>
        </nav>
        <div class="profil" id="profil-username"><?php echo htmlspecialchars($userName); ?></div>
    </header>
    <main>
        <section class="report-container">
            <h2>Laporan Keuangan</h2>
            <form class='report-form' method="POST" action="">
            <label for="namaumkm">Nama UMKM</label>
                <input type="text" id="namaumkm" name="namaumkm">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat">
                <label for="tanggal">Pilih Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal'] ?? ''); ?>" required>

                <label for="pendapatan">Input Pendapatan</label>
                <input type="text" id="pendapatan" name="pendapatan" value="<?php echo htmlspecialchars($data['jumlah_pemasukan'] ?? ''); ?>" required oninput="formatInputRupiah(event)">

                <label for="pengeluaran">Input Pengeluaran</label>
                <input type="text" id="pengeluaran" name="pengeluaran" value="<?php echo htmlspecialchars($data['jumlah_pengeluaran'] ?? ''); ?>" required oninput="formatInputRupiah(event)">

                <label for="kewajiban">Input Kewajiban</label>
                <input type="text" id="kewajiban" name="kewajiban" value="<?php echo htmlspecialchars($data['jumlah_kewajiban'] ?? ''); ?>" required oninput="formatInputRupiah(event)">
            <div class="report-buttons">
                    <button type="submit">Tambah</button>
                    <a href="../pencatatan/pencatatan.php" class="report-cancel-button">Batal</a>
                </div>
           </form>

        </section>
    </main>

</body>
</html>