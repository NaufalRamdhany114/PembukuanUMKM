<?php 
session_start();

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit();
}

$userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard BizBalance</title>
  <link rel="stylesheet" href="CSS/dashboardstyle.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    
    <div id="chartContainer">
  <div>
    <p class="chart-title">Pendapatan, Pengeluaran, dan Kewajiban UMKM</p>
    <canvas id="barChart"></canvas>
  </div>
</div>

   <footer>
    <div class="footer-dashboard">
      <p>© 2024 BizBalance. All Rights Reserved.</p>
    </div>
  </footer>

  <script>
  fetch('get-data.php')
  .then(response => response.json())
  .then(data => {
    const labels = data.map(item => item.nama_umkm);
    const pendapatan = data.map(item => parseInt(item.total_pendapatan || 0));
    const pengeluaran = data.map(item => parseInt(item.total_pengeluaran || 0));
    const kewajiban = data.map(item => parseInt(item.total_kewajiban || 0));

    const ctx = document.getElementById('barChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Pendapatan',
            data: pendapatan,
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
          },
          {
            label: 'Pengeluaran',
            data: pengeluaran,
            backgroundColor: 'rgba(255, 99, 132, 0.8)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
          },
          {
            label: 'Kewajiban',
            data: kewajiban,
            backgroundColor: 'rgba(255, 206, 86, 0.8)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 2,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          tooltip: {
            callbacks: {
              label: function (tooltipItem) {
                return `${tooltipItem.dataset.label}: Rp ${tooltipItem.raw.toLocaleString()}`;
              },
            },
          },
        },
        scales: {
          x: { grid: { display: false } },
          y: { beginAtZero: true },
        },
        animation: {
          duration: 1500,
          easing: 'easeInOut',
        },
      },
    });
  })
  .catch(error => console.error('Error:', error));

</script>

</body>
</html>
