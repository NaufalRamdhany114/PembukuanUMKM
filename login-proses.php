<?php 
include 'koneksi.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Process</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
</head>
<body>
<?php
if (isset($_POST['login'])) {
    $requestUsername = $_POST['username'];
    $requestPassword = $_POST['password'];

    $sql = "SELECT * FROM tb_pengguna WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, 's', $requestUsername);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($requestPassword, $row['password'])) {
            $_SESSION['userName'] = $row['username'];
            $_SESSION['id_pengguna'] = $row['id_pengguna']; 
            
            header('Location: dashboard.php');
            exit(); 
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: 'Username atau password Anda salah. Silahkan coba lagi.',
                        confirmButtonText: 'Coba Lagi'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'login.php';
                        }
                    });
                  </script>";
        }
    } else { 
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: 'Username atau password Anda salah. Silahkan coba lagi.',
                    confirmButtonText: 'Coba Lagi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'login.php';
                    }
                });
              </script>";
    }
}
?>
</body>
</html>
