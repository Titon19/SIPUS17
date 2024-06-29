<?php
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
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Buku
                                <?php
                                include("../koneksi.php");
                                $query1 = mysqli_query($koneksi, "SELECT * FROM buku");
                                $jumlah1 = mysqli_num_rows($query1);
                                echo "<h5 class='card-text'>" . $jumlah1 . "</h5>";

                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="tampil_buku.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-secondary text-white mb-4">
                            <div class="card-body">Buku Masuk
                                <?php
                                $query2 = mysqli_query($koneksi, "SELECT * FROM buku_masuk");
                                $jumlah2 = mysqli_num_rows($query2);
                                echo "<h5 class='card-text'>" . $jumlah2 . "</h5>";

                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="tampil_bukumasuk.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Anggota
                                <?php

                                $query2 = mysqli_query($koneksi, "SELECT * FROM anggota");
                                $jumlah2 = mysqli_num_rows($query2);
                                echo "<h5 class='card-text'>" . $jumlah2 . "</h5>";

                                ?>
                            </div>

                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <a class="small text-white stretched-link" href="tampil_anggota.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Peminjaman
                                <?php

                                $query3 = mysqli_query($koneksi, "SELECT
                                peminjaman.id_pinjam, 
                                peminjaman.id_anggota, 
                                anggota.nisn,
                                anggota.nama, 
                                anggota.no_wa,
                                buku.id_buku,
                                buku.judul, 
                                peminjaman.tgl_pinjam, 
                                peminjaman.tgl_kembali,
                                peminjaman.tgl_dikembalikan, 
                                peminjaman.terlambat,
                                peminjaman.denda,
                                peminjaman.`status`
                                
                            FROM
                                peminjaman
                                INNER JOIN
                                anggota
                                ON 
                                    peminjaman.id_anggota = anggota.id_anggota
                                INNER JOIN
                                buku
                                ON 
                                    peminjaman.id_buku = buku.id_buku
                                    WHERE peminjaman.status = 'Dipinjam' OR peminjaman.status = 'Diperpanjang'
                                    OR peminjaman.`status` = 'Tunggu Approve Perpanjang'");
                                $jumlah3 = mysqli_num_rows($query3);
                                echo "<h5 class='card-text'>" . $jumlah3 . "</h5>";

                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="tampil_peminjaman.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Pengembalian
                                <?php

                                $query4 = mysqli_query($koneksi, "SELECT
                                peminjaman.id_pinjam, 
                                peminjaman.id_anggota,
                                anggota.nisn, 
                                anggota.nama, 
                                anggota.no_wa,
                                buku.id_buku, 
                                buku.judul, 
                                peminjaman.tgl_pinjam, 
                                peminjaman.tgl_kembali, 
                                peminjaman.`status`
                            FROM
                                peminjaman
                                INNER JOIN
                                anggota
                                ON 
                                    peminjaman.id_anggota = anggota.id_anggota
                                INNER JOIN
                                buku
                                ON 
                                    peminjaman.id_buku = buku.id_buku
                                    WHERE peminjaman.status = 'DIkembalikan'");
                                $jumlah4 = mysqli_num_rows($query4);
                                echo "<h5 class='card-text'>" . $jumlah4 . "</h5>";

                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="tampil_pengembalian.php">View
                                    Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-black text-white mb-4">
                            <div class="card-body">Terlambat
                                <?php
                                $query5 = mysqli_query($koneksi, "SELECT
                                peminjaman.id_pinjam,
                                peminjaman.id_anggota,
                                anggota.nisn,
                                anggota.nama,
                                anggota.no_wa,
                                buku.id_buku,
                                buku.judul,
                                peminjaman.tgl_pinjam,
                                peminjaman.tgl_kembali,
                                peminjaman.tgl_dikembalikan,
                                peminjaman.terlambat,
                                peminjaman.denda,
                                peminjaman.`status`
                            FROM
                                peminjaman
                                INNER JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota
                                INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
                            WHERE
                                (peminjaman.`status` = 'Dipinjam' OR peminjaman.`status` = 'Diperpanjang')
                                AND (peminjaman.denda > 0 OR peminjaman.terlambat > 0)");
                                $jumlah5 = mysqli_num_rows($query5);
                                echo "<h5 class='card-text'>" . $jumlah5 . "</h5>";

                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="tampil_terlambat.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Kunjungan
                                <?php

                                $querys = mysqli_query($koneksi, "SELECT * FROM kunjungan");
                                $jumlahs = mysqli_num_rows($querys);
                                echo "<h5 class='card-text'>" . $jumlahs . "</h5>";

                                ?>
                            </div>

                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <a class="small text-white stretched-link" href="tampil_anggota.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body">Stok Buku Opname
                                <?php
                                $query5 = mysqli_query($koneksi, "SELECT * FROM stok_opname");
                                $jumlah5 = mysqli_num_rows($query5);
                                echo "<h5 class='card-text'>" . $jumlah5 . "</h5>";

                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="tampil_stok_opname.php">View
                                    Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-light text-dark mb-4 user">
                            <div class="card-body">Users
                                <?php
                                $query6 = mysqli_query($koneksi, "SELECT * FROM users");
                                $jumlah6 = mysqli_num_rows($query6);
                                echo "<h5 class='card-text'>" . $jumlah6 . "</h5>";

                                ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-dark stretched-link" href="tampil_users.php">View
                                    Details</a>
                                <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>