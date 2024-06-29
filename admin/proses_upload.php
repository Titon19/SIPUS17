<?php

// menghubungkan dengan koneksi
include("../koneksi.php");
// menghubungkan dengan library excel reader
include "../admin/excel_reader.php";


// upload file xls
$target = basename($_FILES['fileexcel']['name']);
move_uploaded_file($_FILES['fileexcel']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
chmod($_FILES['fileexcel']['name'], 0777);

// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['name'], false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index = 0);

// jumlah default data yang berhasil di import

for ($i = 2; $i <= $jumlah_baris; $i++) {

    // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
    $nisn_nign = $data->val($i, 1);
    $nama = $data->val($i, 2);
    $jurusan = $data->val($i, 3);
    $jk = $data->val($i, 4);
    $tempat_lhir = $data->val($i, 5);
    $tgl_lahir = $data->val($i, 6);
    $tgl_lahir_php = date('Y-m-d', strtotime($tgl_lahir));
    $alamat = $data->val($i, 7);

    if ($nisn_nign != "" && $nama != "" && $jurusan != "" && $jk != "" && $tempat_lhir != "" && $tgl_lahir_php != "" && $alamat != "") {
        // input data ke database (table barang)
        mysqli_query($koneksi, "INSERT into pengunjung values('','$nisn_nign','$nama','$jurusan', '$jk', '$tempat_lhir', '$tgl_lahir_php', '$alamat')");
    }
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['fileexcel']['name']);

// alihkan halaman ke index.php
header("location:../admin/tampil_pengunjung.php");
?>