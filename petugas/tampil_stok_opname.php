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
    <title>Data Stok Buku Opname</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <?php include("../petugas/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Stok Buku Opname</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Stok Buku Opname
                    </div>
                    <div class="card-body">
                        <a href="tambah_stok_opname.php" class="btn btn-success mb-1">Tambah Data +</a>
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Buku</th>
                                    <th>Judul</th>
                                    <th>Rak</th>
                                    <th>Jumlah Lama</th>
                                    <th>Jumlah Baru</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th>Tgl Catat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $tampilbuku = mysqli_query($koneksi, "SELECT
                                stok_opname.id,
                                stok_opname.id_buku, 
                                buku.judul, 
                                buku.rak, 
                                stok_opname.jumlah_lama, 
                                stok_opname.jumlah_baru, 
                                stok_opname.qty,
                                stok_opname.status,
                                stok_opname.tgl_catat
                            FROM
                                buku
                                INNER JOIN
                                stok_opname
                                ON 
                                    buku.id_buku = stok_opname.id_buku");
                                $no = 1;
                                while ($data = mysqli_fetch_array($tampilbuku)) {
                                    $id = $data['id'];
                                    $id_buku = $data['id_buku'];
                                    $judul = $data['judul'];
                                    $rak = $data['rak'];
                                    $jumlah_lama = $data['jumlah_lama'];
                                    $jumlah_baru = $data['jumlah_baru'];
                                    $qty = $data['qty'];
                                    $tgl_catat = $data['tgl_catat'];
                                    $status = $data['status'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++ ?>
                                        </td>
                                        <td>
                                            <?php echo $id_buku ?>
                                        </td>
                                        <td>
                                            <?php echo $judul ?>
                                        </td>
                                        <td>
                                            <?php echo $rak ?>
                                        </td>
                                        <td>
                                            <?php echo $jumlah_lama ?>
                                        </td>
                                        <td>
                                            <?php echo $jumlah_baru ?>
                                        </td>
                                        <td>
                                            <?php echo $qty ?>
                                        </td>
                                        <td>
                                            <?php echo $status ?>
                                        </td>
                                        <td>
                                            <?php echo $tgl_catat ?>
                                        </td>

                                        <td>
                                            <a href="edit_stok_opname.php?id=<?php echo $id ?>"
                                                class="btn btn-primary">Edit</a>
                                            <a href="hapus_stok_opname.php?id=<?php echo $id ?>&action=hapus"
                                                class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
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