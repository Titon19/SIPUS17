<?php
include("../koneksi.php");
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "1") {
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
    <title>Data Pengunjung</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Pengunjung</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Pengunjung
                    </div>
                    <div class="card-body">
                        <a href="tambah_pengunjung.php" class="btn btn-success mb-1">Tambah Data +</a>
                        <div class="mb-3">
                            <form method="post" enctype="multipart/form-data" action="proses_upload.php">
                                <label for="formFileSm" class="form-label">Pilih File .xls</label>
                                <input class="form-control form-control-sm" id="formFileSm" name="fileexcel"
                                    accept=".xls" type="file" required="required">
                                <button style="margin-top:10px;" type="submit"
                                    class="btn btn-outline-success btn-sm">Import
                                    .xls</button>
                            </form>
                        </div>

                        <br>
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN/NIGN</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>JK</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tgl Lahir</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('../koneksi.php');

                                $t_pengunjung = mysqli_query($koneksi, "SELECT * FROM pengunjung");
                                $no = 1;
                                while ($data = mysqli_fetch_array($t_pengunjung)) {
                                    $id_pengunjung = $data['id_pengunjung'];
                                    $nisn_nign = $data['nisn_nign'];
                                    $nama = $data['nama_lengkap'];
                                    $jurusan = $data['jurusan'];
                                    $tgl_lahir = $data['tgl_lahir'];
                                    $tempat_lhir = $data['tempat_lhir'];
                                    $jk = $data['jk'];
                                    $alamat = $data['alamat'];

                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++ ?>
                                        </td>
                                        <td>
                                            <?php echo $nisn_nign ?>
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
                                            <?php echo date('d/m/y', strtotime($tgl_lahir)) ?>
                                        </td>
                                        <td>
                                            <?php echo $alamat ?>
                                        </td>

                                        <td>
                                            <a href="edit_pengunjung.php?id_pengunjung=<?php echo $id_pengunjung ?>"
                                                class="btn btn-primary">Edit</a>
                                            <a href="hapus_pengunjung.php?id_pengunjung=<?php echo $id_pengunjung ?>"
                                                class="btn btn-danger">Hapus</a>
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