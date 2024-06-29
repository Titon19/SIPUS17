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
if (isset($_GET['id_masuk'])) {
    $id_masuk = $_GET['id_masuk'];

    // Ambil data qty dan id_buku dari buku_masuk
    $get_buku_masuk_data = mysqli_query($koneksi, "SELECT qty, id_buku FROM buku_masuk WHERE id_masuk='$id_masuk'");
    $buku_masuk_data = mysqli_fetch_assoc($get_buku_masuk_data);

    // Data yang akan dihapus dari buku_masuk
    $qty_to_delete = $buku_masuk_data['qty'];
    $id_buku = $buku_masuk_data['id_buku'];

    // Lakukan penghapusan data pada buku_masuk
    $query_delete_buku_masuk = mysqli_query($koneksi, "DELETE FROM buku_masuk WHERE id_masuk='$id_masuk'");

    if ($query_delete_buku_masuk) {
        // Update data di tabel buku
        $query_update_buku = mysqli_query($koneksi, "UPDATE buku SET jumlah = jumlah - $qty_to_delete WHERE id_buku='$id_buku'");

        if ($query_update_buku) {
            // Data berhasil dihapus dan diupdate
            echo "<script language='JavaScript'>alert('Data Berhasil Dihapus');document.location='tampil_bukumasuk.php';</script>";
        } else {
            // Menangani kesalahan saat mengupdate tabel buku
            echo "Gagal mengupdate stok buku: " . mysqli_error($koneksi);
        }
    } else {
        // Menangani kesalahan saat menghapus data di buku_masuk
        echo "Gagal Menghapus data buku_masuk: " . mysqli_error($koneksi);
    }
}
?>