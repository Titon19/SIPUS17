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
if (isset($_POST['submit'])) {
    $no_anggota = $_POST['no_anggota'];
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $jk = $_POST['jk'];
    $tempat_lhir = $_POST['tempat_lhir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $no_wa = $_POST['no_wa'];
    $alamat = $_POST['alamat'];
    $password = $_POST['pass'];

    $query = mysqli_query($koneksi, "INSERT INTO anggota (id_anggota, nisn, nama, jurusan, jk, tempat_lhir, tgl_lahir, no_wa, alamat, password) 
                  VALUES ('$no_anggota', '$nisn', '$nama', '$jurusan', '$jk', '$tempat_lhir', '$tgl_lahir', '$no_wa', '$alamat', '$password')");
    if ($query) {
        // Inputan berhasil disimpan
        echo "<script language='JavaScript'>alert('Berhasil mendaftar anggota');document.location.href='whatsapp_anggota.php?calling_daftar=klik_sistem&id_anggota=$no_anggota&nisn=$nisn&nama=$nama&jurusan=$jurusan&jk=$jk&tempat_lhir=$tempat_lhir&tgl_lahir=$tgl_lahir&no_wa=$no_wa&alamat=$alamat&password=$password';</script>";
    } else {
        // Menangani kesalahan
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tambah Data Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Data Anggota</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tambah Data Anggota
                    </div>
                    <div class="card-body">

                        <form action="" method="post">
                            <?php

                            $twoDigitYear = date('y');

                            // Membuat format nomor otomatis dengan A + dua digit terakhir tahun + urutan 0001
                            $nomorOtomatis = 'A' . $twoDigitYear;

                            // Mendapatkan urutan terakhir dari database untuk tahun ini
                            // Mendapatkan urutan terakhir dari database untuk tahun ini
                            $query = mysqli_query($koneksi, "SELECT MAX(SUBSTRING(id_anggota, 4, 4)) AS max_urutan FROM anggota WHERE SUBSTRING(id_anggota, 2, 2) = '$twoDigitYear'");

                            if (!$query) {
                                die("Query error: " . mysqli_error($koneksi));
                            }

                            $data = mysqli_fetch_assoc($query);

                            if (!$data) {
                                // Tidak ada data ditemukan, atur $maxUrutan menjadi null
                                $maxUrutan = null;
                            } else {
                                $maxUrutan = $data['max_urutan'];
                            }

                            // Jika tidak ada urutan untuk tahun ini, set urutan menjadi 1, jika ada, tambahkan 1
                            $nextUrutan = ($maxUrutan !== null) ? $maxUrutan + 1 : 1;

                            // Format urutan menjadi empat digit dengan leading zeros
                            $formattedUrutan = sprintf('%04d', $nextUrutan);

                            // Gabungkan nomor otomatis dan urutan untuk mendapatkan nomor anggota yang baru
                            $nomorAnggotaBaru = $nomorOtomatis . $formattedUrutan;

                            // Gunakan $nomorAnggotaBaru dalam proses penginputan data atau simpan ke database
                            
                            // Output nomor anggota baru
                            ?>
                            <label for="" class="mb-1 mt-1"><strong>No Anggota</strong></label>
                            <input name="no_anggota" class="form-control form-control-sm" type="hidden"
                                value="<?php echo $nomorAnggotaBaru; ?>" aria-label=".form-control-sm example">
                            <input name="no_anggota_display" class="form-control form-control-sm" disabled type="input"
                                value="<?php echo $nomorAnggotaBaru; ?>" aria-label=".form-control-sm example">

                            <label for="" class="mb-1 mt-1"><strong>NISN</strong></label>
                            <input name="nisn" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan NISN" aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Nama</strong></label>
                            <input name="nama" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan Nama" aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Jurusan</strong></label>
                            <select name="jurusan" class="form-select" aria-label="Default select example" required>
                                <option value="">--Pilih Jurusan--</option>
                                <option value="AK">Akuntansi</option>
                                <option value="AP">Aplikasi Perkantoran</option>
                                <option value="PM">Pemasaran</option>
                            </select>

                            <label for="" class="mb-1 mt-1"><strong>Jenis Kelamin</strong></label>
                            <select name="jk" class="form-select" aria-label="Default select example" required>
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>


                            <label for="" class="mb-1 mt-1"><strong>Tempat Lahir</strong></label>
                            <input name="tempat_lhir" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan Tempat Lahir" aria-label=".form-control-sm example" required>


                            <label for="" class="mb-1 mt-1"><strong>Tanggal Lahir</strong></label>
                            <input name="tgl_lahir" class="form-control form-control-sm" type="date"
                                placeholder="Masukkan Tanggal Lahir" aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>No Wa</strong></label>
                            <input name="no_wa" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan Nomor Whatsapp" aria-label=".form-control-sm example" required>
                            <label for="" class="mb-1 mt-1"><strong>Alamat</strong></label>

                            <textarea class="form-control" name="alamat" placeholder="Masukkan alamat"
                                id="floatingTextarea" required></textarea>

                            <label for="" class="mb-1 mt-1"><strong>Password</strong></label>
                            <input name="pass" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan password" aria-label=".form-control-sm example" required>



                            <a href="tampil_anggota.php"><input type="submit" name="submit" value="Simpan"
                                    class="btn btn-primary mt-1"></a>
                            <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                            <a href="tampil_anggota.php"><input type="button" name="submit" value="Batal"
                                    class="btn btn-danger mt-1"></a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SIPUS17 2024</div>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>