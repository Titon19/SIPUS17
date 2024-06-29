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
if (isset($_POST['submit'])) {
    $id_pengunjung = $_POST['id_pengunjung'];
    $nisn_nign = $_POST['nisn_nign'];
    $nama = $_POST['nama_lengkap'];
    $jurusan = $_POST['jurusan'];
    $jk = $_POST['jk'];
    $tempat_lhir = $_POST['tempat_lhir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "UPDATE pengunjung SET nisn_nign='$nisn_nign', nama_lengkap='$nama', jurusan='$jurusan', jk='$jk', tempat_lhir='$tempat_lhir', alamat='$alamat', tgl_lahir='$tgl_lahir' WHERE id_pengunjung='$id_pengunjung'");
    if ($query) {
        // Inputan berhasil Diedit
        echo "<script language='JavaScript'>alert('Data Berhasil DiEdit');document.location='tampil_pengunjung.php';</script>";
    } else {
        // Menangani kesalahan
        echo "Gagal mengedit data: " . mysqli_error($koneksi);
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
    <title>Edit Data Pengunjung</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

</head>

<body class="sb-nav-fixed">
    <?php include("../petugas/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Data Pengunjung</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Edit Data Pengunjung
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <!-- Tambahkan input untuk menyimpan id_buku -->
                            <?php
                            if (isset($_GET['id_pengunjung'])) {
                                $id_pengunjung = $_GET['id_pengunjung'];

                                $t_pengunjung = mysqli_query($koneksi, "SELECT * FROM pengunjung WHERE id_pengunjung = '$id_pengunjung'");

                                while ($tp = mysqli_fetch_array($t_pengunjung)) {

                                    $id_pengunjung = $tp['id_pengunjung'];
                                    $nisn_nign = $tp['nisn_nign'];
                                    $nama = $tp['nama_lengkap'];
                                    $jurusan = $tp['jurusan'];
                                    $jk = $tp['jk'];
                                    $tempat_lhir = $tp['tempat_lhir'];
                                    $tgl_lahir = $tp['tgl_lahir'];
                                    $alamat = $tp['alamat'];
                                }

                                ?>

                                <input type="hidden" name="id_pengunjung" value="<?php echo $id_pengunjung ?>">

                                <label for="" class="mb-1 mt-1"><strong>NISN/NIGN</strong></label>
                                <input name="nisn_nign" class="form-control form-control-sm" type="text"
                                    placeholder="Masukkan NISN/NIGN" value="<?php echo $nisn_nign ?>"
                                    aria-label=".form-control-sm example" required>

                                <label for="" class="mb-1 mt-1"><strong>Nama</strong></label>
                                <input name="nama_lengkap" class="form-control form-control-sm" type="text"
                                    placeholder="Masukkan Nama" value="<?php echo $nama ?>"
                                    aria-label=".form-control-sm example" required>

                                <label for="" class="mb-1 mt-1"><strong>Jurusan</strong></label>
                                <select name="jurusan" class="form-select" aria-label="Default select example" required>
                                    <option value="<?php echo $jurusan ?>">
                                        <?php echo $jurusan ?>
                                    </option>
                                    <option value="AK">Akuntansi</option>
                                    <option value="AP">Aplikasi Perkantoran</option>
                                    <option value="PM">Pemasaran</option>
                                </select>

                                <label for="" class="mb-1 mt-1"><strong>Jenis Kelamin</strong></label>
                                <select name="jk" class="form-select" aria-label="Default select example" required>
                                    <option value="<?php echo $jk ?>">
                                        <?php echo $jk ?>
                                    </option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>

                                <label for="" class="mb-1 mt-1"><strong>Tempat Lahir</strong></label>
                                <input name="tempat_lhir" value="<?php echo $tempat_lhir ?>"
                                    class="form-control form-control-sm" type="text" placeholder="Masukkan Tempat Lahir"
                                    aria-label=".form-control-sm example" required>

                                <label for="" class="mb-1 mt-1"><strong>Tanggal Lahir</strong></label>
                                <input value="<?php echo $tgl_lahir ?>" name="tgl_lahir"
                                    class="form-control form-control-sm" type="date" placeholder="Masukkan Tanggal Lahir"
                                    aria-label=".form-control-sm example" required>

                                <label for="" class="mb-1 mt-1"><strong>Alamat</strong></label>
                                <input name="alamat" value="<?php echo $alamat ?>" class="form-control form-control-sm"
                                    type="text" placeholder="Masukkan Alamat" aria-label=".form-control-sm example"
                                    required>

                            <?php } ?>
                            <input type="submit" name="submit" value="Edit" class="btn btn-primary mt-1">
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $('#single-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });


    </script>
</body>

</html>