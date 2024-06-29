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
if (isset($_GET['id_pengunjung'])) {
    $id_pengunjung = $_GET['id_pengunjung'];

    // Lakukan penghapusan data berdasarkan $id_buku
    $query = mysqli_query($koneksi, "DELETE FROM pengunjung WHERE id_pengunjung='$id_pengunjung'");
    if ($query) {
        // Data berhasil dihapus
        echo "<script language='JavaScript'>alert('Data Berhasil Dihapus');document.location='tampil_pengunjung.php';</script>";
    } else {
        // Menangani kesalahan
        echo "Gagal Menghapus data: " . mysqli_error($koneksi);
    }
}
?>