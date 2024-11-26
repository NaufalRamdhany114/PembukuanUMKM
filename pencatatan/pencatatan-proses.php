<?php
include '../koneksi.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengguna = $_SESSION['id_pengguna'];
    $tanggal = $_POST['tanggal'];
    $pendapatan = str_replace(['Rp.', '.', ','], '', $_POST['pendapatan']);
    $pengeluaran = str_replace(['Rp.', '.', ','], '', $_POST['pengeluaran']);
    $kewajiban = str_replace(['Rp.', '.', ','], '', $_POST['kewajiban']);

    if (!$conn) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    $queryLaporan = "INSERT INTO tb_laporan (id_pengguna, tanggal) VALUES ('$id_pengguna', '$tanggal')";
    if (mysqli_query($conn, $queryLaporan)) {
        $id_laporan = mysqli_insert_id($conn);

        $queryPemasukan = "INSERT INTO tb_pemasukan (id_laporan, jumlah_pemasukan) VALUES ('$id_laporan', '$pendapatan')";
        mysqli_query($conn, $queryPemasukan);

        $queryPengeluaran = "INSERT INTO tb_pengeluaran (id_laporan, jumlah_pengeluaran) VALUES ('$id_laporan', '$pengeluaran')";
        mysqli_query($conn, $queryPengeluaran);

        $queryKewajiban = "INSERT INTO tb_kewajiban (id_laporan, jumlah_kewajiban) VALUES ('$id_laporan', '$kewajiban')";
        mysqli_query($conn, $queryKewajiban);

        header('Location: pencatatan.php?status=success&message=' . urlencode('Data berhasil ditambahkan!'));
        exit;
    } else {
        header('Location: pencatatan.php?status=error&message=' . urlencode('Terjadi kesalahan saat menyimpan data.'));
        exit;
    }
}
?>
