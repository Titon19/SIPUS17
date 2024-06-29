<?php
include('../koneksi.php');
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "1") {
    header("location:../index.php");
    session_destroy();
}

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Lakukan penghapusan data berdasarkan $id_buku
    if (isset($_GET['id_user']) && isset($_GET['action']) && $_GET['action'] == 'hapus') {
        $id_user = $_GET['id_user'];

        // Lakukan penghapusan data berdasarkan $id_buku
        $query = mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$id_user'");
        if ($query) {
            echo "<script language='JavaScript'>alert('Data Berhasil Dihapus');document.location='tampil_users.php';</script>";
        } else {
            header("Location: tampil_users.php");
        }
    }

}

?>