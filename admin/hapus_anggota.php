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
if (isset($_GET['no_anggota'])) {
    $no_anggota = $_GET['no_anggota'];

    if (isset($_GET['no_anggota']) && isset($_GET['action']) && $_GET['action'] == 'hapus') {
        $no_anggota = $_GET['no_anggota'];


        // Lakukan penghapusan data berdasarkan $id_buku
        $query = mysqli_query($koneksi, "DELETE FROM anggota WHERE id_anggota='$no_anggota'");
        if ($query) {
            // Data berhasil dihapus
            echo "<script language='JavaScript'>alert('Data Berhasil Dihapus');document.location='tampil_anggota.php';</script>";
        } else {
            // Menangani kesalahan
            echo "Gagal Menghapus data: " . mysqli_error($koneksi);
        }
    }
}
?>