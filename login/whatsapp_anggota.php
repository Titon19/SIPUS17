<?php
include('../koneksi.php');
session_start();

// Ambil token yang sudah ada dari database
$getTokenQuery = "SELECT token FROM whatsapp WHERE id = 2";
$tokenResult = mysqli_query($koneksi, $getTokenQuery);
$tokenRow = mysqli_fetch_assoc($tokenResult);
$existingToken = $tokenRow['token'];


$curl = curl_init();
$id_anggota = $_GET['id_anggota'];
$nisn = $_GET['nisn'];
$nama = $_GET['nama'];
$jurusan = $_GET['jurusan'];
$jk = $_GET['jk'];
$tempat_lhir = $_GET['tempat_lhir'];
$tgl_lahir = $_GET['tgl_lahir'];
$no_wa = $_GET['no_wa'];
$alamat = $_GET['alamat'];
$pass = $_GET['password'];

$target = $no_wa;
$message = "
Anda berhasil melakukan pendaftaran Anggota di perpustakaan SMKS YP 17 Kota Serang
Berikut adalah isi data dari yang anda daftarkan :
---------------------------------------------------------------
No Anggota: $id_anggota
NISN: $nisn
Nama: $nama
Jurusan: $jurusan
Jenis Kelamin: $jk
Tempat Lahir: $tempat_lhir
Tanggal Lahir: $tgl_lahir
Nomor Whatsapp: $no_wa
Alamat: $alamat
Password: $pass
----------------------------------------------------------------
*Anda dapat langsung melakukan login dengan menggunakan no anggota dan password!
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

$callingPage = $_GET['calling_daftar'];
if ($callingPage == 'klik_sistem') {
    header('Location:index.php');
} elseif ($callingPage == 'klik_anggota') {
    header('Location:index.php');
}
?>