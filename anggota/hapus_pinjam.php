<?php
include('../koneksi.php');
session_start();
// cek apakah yang mengakses halaman ini sudah login
if (!isset($_SESSION['id_anggota'])) {
    header("location:../index.php?pesan=gagal");
    exit;
}

if (isset($_GET['id_pinjam'])) {
    $id_pinjam = $_GET['id_pinjam'];

    // Ambil id_buku sebelum menghapus data peminjaman
    $query_get_id_buku = "SELECT id_buku FROM peminjaman WHERE id_pinjam = '$id_pinjam'";
    $result_get_id_buku = mysqli_query($koneksi, $query_get_id_buku);
    $data_id_buku = mysqli_fetch_assoc($result_get_id_buku);
    $id_buku = $data_id_buku['id_buku'];

    // Hapus data peminjaman berdasarkan id_pinjam
    $query_delete_peminjaman = "DELETE FROM peminjaman WHERE id_pinjam = '$id_pinjam'";
    $result_delete_peminjaman = mysqli_query($koneksi, $query_delete_peminjaman);

    if ($result_delete_peminjaman) {
        // Tambahkan 1 ke kolom jumlah pada tabel buku berdasarkan id_buku
        $query_update_jumlah_buku = "UPDATE buku SET jumlah = jumlah + 1 WHERE id_buku = '$id_buku'";
        $result_update_jumlah_buku = mysqli_query($koneksi, $query_update_jumlah_buku);

        if ($result_update_jumlah_buku) {
            echo "<script language='JavaScript'>
                    if (confirm('Data berhasil dihapus. Apakah Anda ingin kembali ke halaman sebelumnya?')) {
                        document.location='tampil_peminjaman.php';
                    } else {
                        document.location='tampil_peminjaman.php';
                    }
                </script>";
        } else {
            echo "<script language='JavaScript'>
                    alert('Gagal menambahkan jumlah buku.');
                    document.location='tampil_peminjaman.php';
                </script>";
        }
    } else {
        echo "<script language='JavaScript'>
                alert('Gagal menghapus data peminjaman.');
                document.location='tampil_peminjaman.php';
            </script>";
    }
}
?>