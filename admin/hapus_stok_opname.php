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
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data qty dan id_buku dari buku_masuk
    $t_stokopname = mysqli_query($koneksi, "SELECT qty, id_buku FROM stok_opname WHERE id='$id'");
    $d_stokopname = mysqli_fetch_assoc($t_stokopname);

    // Data yang akan dihapus dari buku_masuk
    $qty_to_delete = $d_stokopname['qty'];
    $id_buku = $d_stokopname['id_buku'];

    if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'hapus') {
        $id = $_GET['id'];

        // Lakukan penghapusan data pada buku_masuk
        $query_delete_stokopname = mysqli_query($koneksi, "DELETE FROM stok_opname WHERE id='$id'");

        if ($query_delete_stokopname) {
            // Update data di tabel buku
            $query_update_buku = mysqli_query($koneksi, "UPDATE buku SET jumlah = jumlah + $qty_to_delete WHERE id_buku='$id_buku'");

            if ($query_update_buku) {
                // Data berhasil dihapus dan diupdate
                echo "<script language='JavaScript'>alert('Data Berhasil Dihapus');document.location='tampil_stok_opname.php';</script>";
            } else {
                // Menangani kesalahan saat mengupdate tabel buku
                echo "Gagal mengupdate stok buku: " . mysqli_error($koneksi);
            }
        } else {
            // Menangani kesalahan saat menghapus data di buku_masuk
            echo "Gagal Menghapus data stok_opname: " . mysqli_error($koneksi);
        }
    }
}
?>