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
if (isset($_GET['id_kategori'])) {
    $id_kategori = $_GET['id_kategori'];

    if (isset($_GET['id_kategori']) && isset($_GET['action']) && $_GET['action'] == 'hapus') {
        $id_kategori = $_GET['id_kategori'];

        // Lakukan penghapusan data berdasarkan $id_buku
        $query = mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori='$id_kategori'");
        if ($query) {
            // Data berhasil dihapus
            echo "<script language='JavaScript'>alert('Data Berhasil Dihapus');document.location='tampil_kategori.php';</script>";
        } else {
            // Menangani kesalahan
            echo "Gagal Menghapus data: " . mysqli_error($koneksi);
        }
    }
}
?>