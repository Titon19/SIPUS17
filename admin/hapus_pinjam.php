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

if (isset($_GET['id_pinjam'])) {
    $id_pinjam = $_GET['id_pinjam'];

    // Ambil id_buku sebelum menghapus data peminjaman
    $query_get_id_buku = "SELECT id_buku FROM peminjaman WHERE id_pinjam = '$id_pinjam'";
    $result_get_id_buku = mysqli_query($koneksi, $query_get_id_buku);
    $data_id_buku = mysqli_fetch_assoc($result_get_id_buku);
    $id_buku = $data_id_buku['id_buku'];
    if (isset($_GET['id_pinjam']) && isset($_GET['action']) && $_GET['action'] == 'hapus') {
        $id_pinjam = $_GET['id_pinjam'];

        // Hapus data peminjaman berdasarkan id_pinjam
        $query_delete_peminjaman = "DELETE FROM peminjaman WHERE id_pinjam = '$id_pinjam'";
        $result_delete_peminjaman = mysqli_query($koneksi, $query_delete_peminjaman);

        if ($result_delete_peminjaman) {
            // Tambahkan 1 ke kolom jumlah pada tabel buku berdasarkan id_buku
            $query_update_jumlah_buku = "UPDATE buku SET jumlah = jumlah + 1 WHERE id_buku = '$id_buku'";
            $result_update_jumlah_buku = mysqli_query($koneksi, $query_update_jumlah_buku);

            if ($result_update_jumlah_buku) {
                echo "<script language='JavaScript'>alert('Data Berhasil Dihapus');document.location='tampil_peminjaman.php';</script>";
            } else {
                header("Location: tampil_peminjaman.php");
            }
        } else {
            header("Location: tampil_peminjaman.php");
        }
    }
}
?>