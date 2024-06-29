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
// Ambil token yang sudah ada dari database
$getTokenQuery = "SELECT token FROM whatsapp WHERE id = 2";
$tokenResult = mysqli_query($koneksi, $getTokenQuery);
$tokenRow = mysqli_fetch_assoc($tokenResult);
$existingToken = $tokenRow['token'];


$t_agt = mysqli_query($koneksi, "SELECT * FROM anggota");
while ($d_agt = mysqli_fetch_array($t_agt)) {
    $no_wa = $d_agt['no_wa'];
    $curl = curl_init();
    $id_buku = $_GET['id_buku'];
    $p_judul = $_GET['judul'];
    $p_rak = $_GET['rak'];
    $pengarang = $_GET['pengarang'];
    $penerbit = $_GET['penerbit'];
    $tahun = $_GET['tahun'];
    $jumlah = $_GET['jumlah'];


    $target = $no_wa;
    $message = "
Halo, Ada Buku Baru di perpustakaan SMKS YP 17 Kota Serang
---------------------------------------------------------------
Informasi Buku :
ID Buku: $id_buku
Judul: $p_judul
Rak: $p_rak
Pengarang: $pengarang
Penerbit: $penerbit
Tahun: $tahun
Jumlah: $jumlah
----------------------------------------------------------------
*Anda dapat langsung melakukan peminjaman buku sekarang melalui Website SIPUS17!
----------------------------------------------------------------";

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
                'schedule' => '',
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $existingToken"
            ),
        )
    );

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);

    if (isset($error_msg)) {
        echo $error_msg;
    }
}
echo $response;


$callingPage = $_GET['calling_page'];

if ($callingPage == 'klik_tambah_pinjam') {
    header('Location:../admin/tampil_peminjaman.php');
} elseif ($callingPage == 'klik_perpanjang') {
    header('Location:../admin/tampil_peminjaman.php');
} elseif ($callingPage == 'klik_kembali') {
    header('Location:../admin/tampil_pengembalian.php');
} elseif ($callingPage == 'klik_terlambat') {
    header('Location:../admin/tampil_terlambat.php');
} elseif ($callingPage == 'klik_bukuBaru') {
    header('Location:../admin/tampil_buku.php');
}
?>