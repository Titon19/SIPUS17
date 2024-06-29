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

    $query = mysqli_query($koneksi, "UPDATE anggota SET nisn='$nisn', nama='$nama', jurusan='$jurusan', jk='$jk', tempat_lhir='$tempat_lhir', tgl_lahir='$tgl_lahir', no_wa='$no_wa', alamat='$alamat', password='$password' WHERE id_anggota = '$no_anggota'");
    if ($query) {
        // Inputan berhasil disimpan
        echo "<script language='JavaScript'>alert('Data Berhasil Dedit');document.location='tampil_anggota.php';</script>";
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
    <title>Edit Data Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Data Anggota</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Edit Data Anggota
                    </div>
                    <div class="card-body">

                        <form action="" method="post">
                            <?php

                            if (isset($_GET['no_anggota'])) {
                                $no_anggota = $_GET['no_anggota'];


                                $t_agt = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '$no_anggota'");

                                while ($t_data = mysqli_fetch_array($t_agt)) {
                                    $no_anggota = $t_data['id_anggota'];
                                    $nisn = $t_data['nisn'];
                                    $nama = $t_data['nama'];
                                    $jurusan = $t_data['jurusan'];
                                    $jk = $t_data['jk'];
                                    $tempat_lhir = $t_data['tempat_lhir'];
                                    $tgl_lahir = $t_data['tgl_lahir'];
                                    $no_wa = $t_data['no_wa'];
                                    $alamat = $t_data['alamat'];
                                    $password = $t_data['password'];
                                }
                            }
                            ?>
                            <label for="" class="mb-1 mt-1"><strong>No Anggota</strong></label>
                            <input name="no_anggota" class="form-control form-control-sm" type="hidden"
                                value="<?php echo $no_anggota; ?>" aria-label=".form-control-sm example">
                            <input name="no_anggota_display" class="form-control form-control-sm" disabled type="input"
                                value="<?php echo $no_anggota; ?>" aria-label=".form-control-sm example">

                            <label for="" class="mb-1 mt-1"><strong>NISN</strong></label>
                            <input name="nisn" class="form-control form-control-sm" type="text"
                                value="<?php echo $nisn; ?>" placeholder="Masukkan NISN"
                                aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Nama</strong></label>
                            <input name="nama" class="form-control form-control-sm" type="text"
                                value="<?php echo $nama; ?>" placeholder="Masukkan Nama"
                                aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Jurusan</strong></label>
                            <select name="jurusan" class="form-select" aria-label="Default select example" required>
                                <option value="<?php echo $jurusan; ?>">
                                    <?php echo $jurusan; ?>
                                </option>
                                <option value="AK">Akuntansi</option>
                                <option value="AP">Aplikasi Perkantoran</option>
                                <option value="PM">Pemasaran</option>
                            </select>

                            <label for="" class="mb-1 mt-1"><strong>Jenis Kelamin</strong></label>
                            <select name="jk" class="form-select" aria-label="Default select example" required>
                                <option value="<?php echo $jk; ?>">
                                    <?php

                                    if ($jk == 'L') {
                                        echo $jk = "Laki-laki";
                                    } elseif ($jk == 'P') {
                                        echo $jk = 'Perempuan';
                                    }

                                    ?>
                                </option>

                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>

                            <label for="" class="mb-1 mt-1"><strong>Tempat Lahir</strong></label>
                            <input name="tempat_lhir" class="form-control form-control-sm" type="text"
                                value="<?php echo $tempat_lhir; ?>" placeholder="Masukkan Tempat Lahir"
                                aria-label=".form-control-sm example" required>


                            <label for="" class="mb-1 mt-1"><strong>Tanggal Lahir</strong></label>
                            <input name="tgl_lahir" class="form-control form-control-sm" type="date"
                                value="<?php echo $tgl_lahir; ?>" placeholder="Masukkan Tanggal Lahir"
                                aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>No Wa</strong></label>
                            <input name="no_wa" class="form-control form-control-sm" type="text"
                                value="<?php echo $no_wa; ?>" placeholder="Masukkan Nomor Whatsapp"
                                aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Alamat</strong></label>
                            <textarea class="form-control" name="alamat" placeholder="Masukkan alamat"
                                id="floatingTextarea" required><?php echo $alamat; ?></textarea>

                            <label for="" class="mb-1 mt-1"><strong>Password</strong></label>
                            <input name="pass" class="form-control form-control-sm" type="text"
                                value="<?php echo $password; ?>" placeholder="Masukkan password"
                                aria-label=".form-control-sm example" required>

                            <a href="tampil_anggota.php"><input type="submit" name="submit" value="Edit"
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