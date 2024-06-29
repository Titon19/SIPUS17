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


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $nama1 = $_POST['nama'];
            date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan lokasi Anda

            $waktuSaatIni = date('Y-m-d H:i:s');

            $query = mysqli_query($koneksi, "INSERT INTO kunjungan (nama, waktu) VALUES ('$nama1', '$waktuSaatIni')");

            if ($query) {
                // Inputan berhasil disimpan
                header("Location: tampil_kunjungan.php");
                exit();
            } else {
                // Menangani kesalahan
                echo "Gagal menyimpan data: " . mysqli_error($koneksi);
            }
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
        <title>Data Kunjungan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
       
    </head>
    <body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Kunjungan</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Kunjungan
                            </div>
                            <div class="card-body">
                                    
                            <form action="" method="post">
                                    <label for="" class="mb-1 mt-1"><strong>Nama Lengkap</strong></label>
                                    <input name="nama" class="form-control form-control-sm" type="text" placeholder="Masukkan Nama Lengkap" aria-label=".form-control-sm example" required>
                                <input type="submit" name="submit" value="Berkunjung" class="btn btn-success mt-1">
                            </form>
                                <br>
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $t_kunjung = mysqli_query($koneksi, "SELECT * FROM kunjungan");
                                        $no = 1;
                                        while ($d_kunjung = mysqli_fetch_array($t_kunjung)) {
                                            $nama1 = $d_kunjung['nama'];
                                            $waktu1 = $d_kunjung['waktu'];
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $nama1 ?></td>
                                            <td><?php echo $waktu1 ?></td>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>

    </body>
</html>
