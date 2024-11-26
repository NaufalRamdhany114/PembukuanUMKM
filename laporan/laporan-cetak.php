<?php
session_start();
include('../koneksi.php');
require_once("../dompdf/autoload.inc.php");

use Dompdf\Dompdf;

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['userName'];

$queryUser = mysqli_query($koneksi, "SELECT id_pengguna FROM tb_pengguna WHERE username = '$userName'");
$userData = mysqli_fetch_assoc($queryUser);
$idPengguna = $userData['id_pengguna'];

$dompdf = new Dompdf();

$query = mysqli_query($koneksi, "
    SELECT 
        tb_laporan.tanggal,
        tb_umkm.nama_umkm,
        tb_umkm.alamat,
        COALESCE(SUM(tb_pemasukan.jumlah_pemasukan), 0) AS pendapatan,
        COALESCE(SUM(tb_pengeluaran.jumlah_pengeluaran), 0) AS pengeluaran,
        COALESCE(SUM(tb_kewajiban.jumlah_kewajiban), 0) AS kewajiban,
        tb_umkm.status_keuangan
    FROM tb_laporan
    LEFT JOIN tb_umkm ON tb_laporan.id_laporan = tb_umkm.id_laporan
    LEFT JOIN tb_pemasukan ON tb_laporan.id_laporan = tb_pemasukan.id_laporan
    LEFT JOIN tb_pengeluaran ON tb_laporan.id_laporan = tb_pengeluaran.id_laporan
    LEFT JOIN tb_kewajiban ON tb_laporan.id_laporan = tb_kewajiban.id_laporan
    WHERE tb_laporan.id_pengguna = '$idPengguna'
    GROUP BY tb_umkm.id_umkm, tb_laporan.tanggal
");

$html = '<center><h3>Laporan Keuangan UMKM</h3></center><hr/><br>';
$html .= '<table border="1" width="100%">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama UMKM</th>
                <th>Alamat</th>
                <th>Pendapatan</th>
                <th>Pengeluaran</th>
                <th>Kewajiban</th>
                <th>Status</th>
            </tr>';

$no = 1;
while ($row = mysqli_fetch_array($query)) {
    $html .= "<tr>
                <td>" . $no . "</td>
                <td>" . $row['tanggal'] . "</td>
                <td>" . $row['nama_umkm'] . "</td>
                <td>" . $row['alamat'] . "</td>
                <td>Rp. " . number_format($row['pendapatan'], 0, ',', '.') . "</td>
                <td>Rp. " . number_format($row['pengeluaran'], 0, ',', '.') . "</td>
                <td>Rp. " . number_format($row['kewajiban'], 0, ',', '.') . "</td>
                <td>" . $row['status_keuangan'] . "</td>
            </tr>";
    $no++;
}

$html .= "</table>";
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('laporan-keuangan-umkm.pdf');
?>
