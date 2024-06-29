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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_akhir = $_POST['tgl_akhir'];

    // Lakukan pengecekan tanggal di sini
    if ($tgl_mulai == "" || $tgl_akhir == "") {
        echo '<script>alert("Silakan pilih tanggal periode terlebih dahulu.");</script>';
    } else {
        // Redirect atau lakukan aksi lain sesuai kebutuhan
        header("location:../laporan_kunjungan.php?tgl_mulai=$tgl_mulai&tgl_akhir=$tgl_akhir");
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
    <title>Cetak Laporan Data Kunjungan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Cetak Laporan Data Kunjungan</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Cetak Laporan Data Kunjungan
                    </div>
                    <div class="card-body">

                        <form method="POST" action="../laporan_kunjungan.php" target="_blank">
                            <label for="" class="mb-1 mt-1"><strong>Periode Tanggal</strong></label>
                            <label for="" class="mb-1 mt-1"><strong>Mulai :</strong></label>
                            <div>
                                <input name="tgl_mulai" class="form-control form-control-sm" type="date"
                                    aria-label=".form-control-sm example" required>
                                <label for="" class="mb-1 mt-1"><strong>s/d :</strong></label>
                                <input name="tgl_akhir" class="form-control form-control-sm" type="date"
                                    aria-label=".form-control-sm example" required>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-success">Cetak</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer class=" py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SIPUS17 2023</div>

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