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
    <title>BizBalance - Entry Pencatatan</title>
    <link rel="stylesheet" href="../CSS/dashboardstyle.css">

    <script>
        function formatRupiah(input, prefix = "Rp.") {
            let numberString = input.value.replace(/[^,\d]/g, ""),
                [whole, fraction] = numberString.split(","),
                rupiah = whole.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            rupiah = fraction !== undefined ? `${rupiah},${fraction}` : rupiah;
            input.value = prefix ? `${prefix} ${rupiah}` : rupiah;
        }

        function formatInputRupiah(event) {
            formatRupiah(event.target);
        }
    </script>
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
            <h2>Pencatatan Keuangan</h2>
            <form method="POST" action="pencatatan-proses.php">
                <label for="tanggal">Pilih Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" required>

                <label for="pendapatan">Input Pendapatan</label>
                <input type="text" id="pendapatan" name="pendapatan" required oninput="formatInputRupiah(event)">

                <label for="pengeluaran">Input Pengeluaran</label>
                <input type="text" id="pengeluaran" name="pengeluaran" required oninput="formatInputRupiah(event)">

                <label for="kewajiban">Input Kewajiban</label>
                <input type="text" id="kewajiban" name="kewajiban" required oninput="formatInputRupiah(event)">
                
                <button type="submit" id="button">Simpan</button>
               
            </form>
        </section>
    </main>

    <div id="snackbar"></div>

</body>
</html>
