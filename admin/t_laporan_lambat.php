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
    <title>Cetak Laporan Transaksi Terlambat</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Cetak Laporan Transaksi Terlambat</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Cetak Laporan Transaksi Terlambat
                    </div>
                    <div class="card-body">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>--Pilih Data--</option>
                            <option value="1">Data Buku</option>
                            <option value="2">Data Buku Masuk</option>
                            <option value="3">Data Anggota</option>
                            <option value="4">Data Pengunjung</option>
                            <option value="5">Data Kunjungan</option>
                            <option value="6">Data Transaksi Peminjaman Buku</option>
                            <option value="7">Data Transaksi Pengembalian Buku</option>
                            <option value="8">Data Transaksi Terlambat</option>
                        </select>
                        <br>
                        <a href="#" id="cetakButton" class="btn btn-success">Cetak</a>
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
    <script>
        document.getElementById("cetakButton").addEventListener("click", function () {
            var selectedValue = document.getElementById("laporanSelect").value;
            if (selectedValue !== "--Pilih Data--") {
                window.open("../laporan_buku.php?data=" + selectedValue, "_blank");
            } else {
                alert("Pilih data terlebih dahulu.");
            }
        });
    </script>
</body>

</html>