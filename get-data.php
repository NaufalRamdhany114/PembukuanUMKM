<?php
session_start();

if (!isset($_SESSION['userName'])) {
    die("Unauthorized access");
}

$userName = $_SESSION['userName'];

$conn = new mysqli("localhost", "root", "", "db_bizbalance");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT 
        tb_umkm.nama_umkm,
        COALESCE(SUM(tb_pemasukan.jumlah_pemasukan), 0) AS total_pendapatan,
        COALESCE(SUM(tb_pengeluaran.jumlah_pengeluaran), 0) AS total_pengeluaran,
        COALESCE(SUM(tb_kewajiban.jumlah_kewajiban), 0) AS total_kewajiban
    FROM 
        tb_pengguna
    JOIN 
        tb_laporan ON tb_pengguna.id_pengguna = tb_laporan.id_pengguna
    JOIN 
        tb_umkm ON tb_laporan.id_laporan = tb_umkm.id_laporan
    LEFT JOIN 
        tb_pemasukan ON tb_laporan.id_laporan = tb_pemasukan.id_laporan
    LEFT JOIN 
        tb_pengeluaran ON tb_laporan.id_laporan = tb_pengeluaran.id_laporan
    LEFT JOIN 
        tb_kewajiban ON tb_laporan.id_laporan = tb_kewajiban.id_laporan
    WHERE 
        tb_pengguna.username = ?
    GROUP BY 
        tb_umkm.nama_umkm
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userName); 
$stmt->execute();
$result = $stmt->get_result();

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
