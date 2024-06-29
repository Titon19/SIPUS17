<?php
include("../koneksi.php");
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "0") {
    header("location:../index.php");
    session_destroy();
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
    <title>Data Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../petugas/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Anggota</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Anggota
                    </div>
                    <div class="card-body">
                        <a href="tambah_anggota.php" class="btn btn-success mb-1">Tambah Data +</a>
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Anggota</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>JK</th>
                                    <th>Tempat Lhir</th>
                                    <th>Tgl Lahir</th>
                                    <th>No Wa</th>
                                    <th>Password</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('../koneksi.php');

                                $t_anggota = mysqli_query($koneksi, "SELECT * FROM anggota");
                                $no = 1;
                                while ($data = mysqli_fetch_array($t_anggota)) {
                                    $no_anggota = $data['id_anggota'];
                                    $nisn = $data['nisn'];
                                    $nama = $data['nama'];
                                    $jurusan = $data['jurusan'];
                                    $tempat_lhir = $data['tempat_lhir'];
                                    $tgl_lahir = $data['tgl_lahir'];
                                    $jk = $data['jk'];
                                    $no_wa = $data['no_wa'];
                                    $password = $data['password'];

                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++ ?>
                                        </td>
                                        <td>
                                            <?php echo $no_anggota ?>
                                        </td>
                                        <td>
                                            <?php echo $nisn ?>
                                        </td>
                                        <td>
                                            <?php echo $nama ?>
                                        </td>
                                        <td>
                                            <?php echo $jurusan ?>
                                        </td>
                                        <td>
                                            <?php echo $jk ?>
                                        </td>
                                        <td>
                                            <?php echo $tempat_lhir ?>
                                        </td>
                                        <td>
                                            <?php echo $tgl_lahir ?>
                                        </td>

                                        <td>
                                            <?php echo $no_wa ?>
                                        </td>
                                        <td>
                                            <?php echo $password ?>
                                        </td>
                                        <td>
                                            <a href="edit_anggota.php?no_anggota=<?php echo $no_anggota ?>"
                                                class="btn btn-primary"
                                                style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; width:100%;">Edit</a>
                                            <br>
                                            <a href="hapus_anggota.php?no_anggota=<?php echo $no_anggota ?>&action=hapus"
                                                class="btn btn-danger"
                                                style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; width:100%;"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                            <br>



                                            </form>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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