<?php
include('../koneksi.php');
session_start();

// cek apakah yang mengakses halaman ini sudah login
if (!isset($_SESSION['id_anggota'])) {
    header("location:../index.php?pesan=gagal");
    exit;
}
// Ambil token yang sudah ada dari database
$getTokenQuery = "SELECT token FROM whatsapp WHERE id = 2";
$tokenResult = mysqli_query($koneksi, $getTokenQuery);
$tokenRow = mysqli_fetch_assoc($tokenResult);
$existingToken = $tokenRow['token'];


$curl = curl_init();
$no_pinjam = $_GET['id_pinjam'];
$id_anggota = $_GET['id_anggota'];
$nisn = $_GET['nisn'];
$no_wa = $_GET['no_wa'];
$nama = $_GET['nama'];
$jurusan = $_GET['jurusan'];
$jk = $_GET['jk'];
$id_buku = $_GET['id_buku'];
$p_judul = $_GET['judul'];
$p_rak = $_GET['rak'];
$tgl_pinjam = $_GET['tgl_pinjam'];
$tgl_kembali = $_GET['tgl_kembali'];
$tgl_dikembalikan = $_GET['tgl_dikembalikan'];
$terlambat = $_GET['terlambat'];
$denda = $_GET['denda'];
$status = $_GET['status'];




$target = $no_wa;
$message = "
Halo Anda telah meminjam buku di perpustakaan SMKS YP 17 Kota Serang
---------------------------------------------------------------
No Transaksi Peminjaman: $no_pinjam 
No Anggota: $id_anggota
NISN: $nisn
Nama: $nama
Jurusan: $jurusan
Jenis Kelamin: $jk
---------------------------------------------------------------
Buku yang dipinjam:
ID Buku: $id_buku
Judul: $p_judul
Rak: $p_rak
Tanggal Pinjam: $tgl_pinjam
Tanggal Kembali: $tgl_kembali
Tanggal Dikembalikan: $tgl_dikembalikan
Terlambat: $terlambat Hari
Denda: Rp. $denda
Status: $status
----------------------------------------------------------------
*Silahkan kembalikan buku sebelum batas tanggal kembali berakhir!
*Dimohon kembalikan buku secepatnya apabila anda terlambat dan terkena denda!
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
echo $response;


$callingPage = $_GET['calling_page'];

if ($callingPage == 'klik_tambah_pinjam') {
    header('Location:../anggota/tampil_peminjaman.php');
} elseif ($callingPage == 'klik_perpanjang') {
    header('Location:../anggota/tampil_peminjaman.php');
} elseif ($callingPage == 'klik_kembali') {
    header('Location:../anggota/tampil_pengembalian.php');
} elseif ($callingPage == 'klik_terlambat') {
    header('Location:../anggota/tampil_terlambat.php');
}
?>