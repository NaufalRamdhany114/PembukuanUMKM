<?php
session_start();

if (!isset($_SESSION['userName'])) {
    header('Location: login.php');
    exit;
}

include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_laporan'])) {
    $id_laporan = $_POST['id_laporan'];

    if (!isset($_POST['confirm'])) {
        echo "
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .modal {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    max-width: 400px;
                    text-align: center;
                }
                .modal h3 {
                    margin-bottom: 20px;
                }
                .modal button {
                    margin: 5px;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                .modal .btn-yes {
                    background-color: #d9534f;
                    color: #fff;
                }
                .modal .btn-yes:hover {
                    background-color: #c9302c;
                }
                .modal .btn-no {
                    background-color: #5bc0de;
                    color: #fff;
                }
                .modal .btn-no:hover {
                    background-color: #31b0d5;
                }
            </style>

            <div class='modal'>
                <h3>Are you sure you want to delete this entry?</h3>
                <form action='pencatatan-hapus.php' method='post'>
                    <input type='hidden' name='id_laporan' value='" . htmlspecialchars($id_laporan) . "'>
                    <button type='submit' name='confirm' value='yes' class='btn-yes'>Yes, Delete</button>
                    <button type='submit' name='confirm' value='no' class='btn-no'>No, Cancel</button>
                </form>
            </div>
        ";
    } elseif ($_POST['confirm'] === 'yes') {
        $deleteKewajibanQuery = "DELETE FROM tb_kewajiban WHERE id_laporan = ?";
        $stmtKewajiban = mysqli_prepare($conn, $deleteKewajibanQuery);
        mysqli_stmt_bind_param($stmtKewajiban, 'i', $id_laporan);
        mysqli_stmt_execute($stmtKewajiban);

        $deletePemasukanQuery = "DELETE FROM tb_pemasukan WHERE id_laporan = ?";
        $stmtPemasukan = mysqli_prepare($conn, $deletePemasukanQuery);
        mysqli_stmt_bind_param($stmtPemasukan, 'i', $id_laporan);
        mysqli_stmt_execute($stmtPemasukan);

        $deletePengeluaranQuery = "DELETE FROM tb_pengeluaran WHERE id_laporan = ?";
        $stmtPengeluaran = mysqli_prepare($conn, $deletePengeluaranQuery);
        mysqli_stmt_bind_param($stmtPengeluaran, 'i', $id_laporan);
        mysqli_stmt_execute($stmtPengeluaran);

        $query = "DELETE FROM tb_laporan WHERE id_laporan = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id_laporan);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: pencatatan.php?status=success&message=" . urlencode("Data berhasil dihapus!"));
            exit;
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        header('Location: pencatatan.php');
        exit;
    }
} else {
    header('Location: pencatatan.php');
    exit;
}
?>
