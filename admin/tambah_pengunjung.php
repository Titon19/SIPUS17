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
    $nisn_nign = $_POST['nisn_nign'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $jk = $_POST['jk'];
    $tempat_lhir = $_POST['tempat_lhir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "INSERT INTO pengunjung (nisn_nign, nama_lengkap, jurusan, jk, tempat_lhir, tgl_lahir, alamat) 
                  VALUES ('$nisn_nign', '$nama', '$jurusan', '$jk', '$tempat_lhir', '$tgl_lahir', '$alamat')");
    if ($query) {
        // Inputan berhasil disimpan
        echo "<script language='JavaScript'>alert('Data Berhasil Disimpan');document.location='tampil_pengunjung.php';</script>";
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
    <title>Tambah Data Pengunjung</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Data Pengunjung</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tambah Data Pengunjung
                    </div>
                    <div class="card-body">

                        <form action="" method="post">

                            <label for="" class="mb-1 mt-1"><strong>NISN/NIGN</strong></label>
                            <input name="nisn_nign" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan NISN/NIGN" aria-label=".form-control-sm example" required>

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

                            <label for="" class="mb-1 mt-1"><strong>Alamat</strong></label>
                            <input name="alamat" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan Alamat" aria-label=".form-control-sm example" required>


                            <a href="tampil_pengunjung.php"><input type="submit" name="submit" value="Simpan"
                                    class="btn btn-primary mt-1"></a>
                            <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                            <a href="tampil_pengunjung.php"><input type="button" name="submit" value="Batal"
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