<?php
include('../koneksi.php');
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "0") {
    header("location:../index.php");
    session_destroy();
}
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];

    // Lakukan penghapusan data berdasarkan $id_buku
    $query = mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$id_buku'");
    if ($query) {
        // Data berhasil dihapus
        echo "<script language='JavaScript'>alert('Data Berhasil Dihapus');document.location='tampil_buku.php';</script>";
    } else {
        // Menangani kesalahan
        echo "Gagal Menghapus data: " . mysqli_error($koneksi);
    }
}
?>