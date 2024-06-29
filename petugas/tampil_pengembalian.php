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
    <title>Data Transaksi Pengembalian Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../petugas/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Transaksi Pengembalian Buku</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Transaksi Pengembalian Buku
                    </div>
                    <div class="card-body">

                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Pinjam</th>
                                    <th>No Anggota</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <!-- <th>No Wa</th> -->
                                    <th>Kode Buku</th>
                                    <th>Judul</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tampilbuku = mysqli_query($koneksi, "SELECT
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
                                $no = 1;
                                while ($data = mysqli_fetch_array($tampilbuku)) {

                                    $id_pinjam = $data['id_pinjam'];
                                    $id_anggota = $data['id_anggota'];
                                    $nisn = $data['nisn'];
                                    $nama = $data['nama'];
                                    $no_wa = $data['no_wa'];
                                    $id_buku = $data['id_buku'];
                                    $judul = $data['judul'];
                                    $tgl_pinjam = $data['tgl_pinjam'];
                                    $tgl_kembali = $data['tgl_kembali'];
                                    $status = $data['status'];


                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++ ?>
                                        </td>
                                        <td>
                                            <?php echo $id_pinjam ?>
                                        </td>
                                        <td>
                                            <?php echo $id_anggota ?>
                                        </td>
                                        <td>
                                            <?php echo $nisn ?>
                                        </td>
                                        <td>
                                            <?php echo $nama . " | " . $no_wa ?>
                                        </td>
                                        <td>
                                            <?php echo $id_buku ?>
                                        </td>
                                        <td>
                                            <?php echo $judul ?>
                                        </td>
                                        <td>
                                            <?php echo $tgl_pinjam ?>
                                        </td>
                                        <td>
                                            <?php echo $tgl_kembali ?>
                                        </td>
                                        <td>
                                            <?php echo "<span class='badge rounded-pill text-bg-secondary'>$status</span>" ?>
                                        </td>

                                        <td><a href="detail_kembali.php?id_pinjam=<?php echo $id_pinjam; ?>"
                                                class="btn btn-warning">Lihat</a></td>
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