<?php include('../koneksi.php'); 
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "1") {
    header("location:../index.php");
    session_destroy();
}

if (isset($_GET['id_pinjam'])) {
    $id_pinjam = $_GET['id_pinjam'];
    
    $query = mysqli_query($koneksi, "SELECT
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
    buku.rak,
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
        WHERE peminjaman.id_pinjam = '$id_pinjam'");
    $no = 1;
    while ($data = mysqli_fetch_array($query)) {

       $id_pinjam = $data['id_pinjam'];
       $id_anggota = $data['id_anggota'];
       $nisn = $data['nisn'];
       $nama = $data['nama'];
       $no_wa = $data['no_wa'];
       $id_buku = $data['id_buku'];
       $judul = $data['judul'];
       $tgl_pinjam = $data['tgl_pinjam'];
       $tgl_kembali = $data['tgl_kembali'];
       $tgl_dikembalikan = $data['tgl_dikembalikan'];
       $rak = $data['rak'];
       $terlambat = $data['terlambat'];
       $denda = $data['denda'];
       $status = $data['status'];

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
        <title>Detail Transaksi Terlambat</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <!-- Or for RTL support -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    </head>
    <body class="sb-nav-fixed">
        <?php include("../admin/navbar.php"); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Detail Transaksi Terlambat</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Detail Transaksi Terlambat
                            </div>
                            <div class="card-body">
                                <form action="" method="post">      
                                    <label for="id_pinjam" class="mb-1 mt-1"><strong>No Pinjam</strong></label>
                                    <input id="id_pinjam" name="id_pinjam" class="form-control form-control-sm" type="text" value="<?php echo $id_pinjam ?>" disabled aria-label=".form-control-sm example">

                                    <label for="" class="mb-1 mt-1"><strong>Peminjam</strong></label>
                                    <select name="nisn" class="form-select" id="single-select-field" disabled data-placeholder="Cari Anggota">
                                    <?php 
                                        $tampilnisn = mysqli_query($koneksi, "SELECT nisn, nama, jurusan, no_wa FROM anggota");
                                        while ($data_anggota = mysqli_fetch_array($tampilnisn)) {
                                            $selected = ($data_anggota['nisn'] == $nisn) ? "selected" : "";
                                            echo "<option value='" . $data_anggota['nisn'] . "' $selected>" . $data_anggota['nisn'] . " | ". $data_anggota['nama'] . " | " . $data_anggota['jurusan'] . " | " . $data_anggota['no_wa'] . "</option>";
                                        }
                                        ?>
                                    </select>    

                                    <label for="tgl_pinjam" class="mb-1 mt-1"><strong>Tgl Pinjam</strong></label>
                                    <input id="tgl_pinjam" name="tgl_pinjam" class="form-control form-control-sm" disabled type="date" value="<?php echo $tgl_pinjam ?>" aria-label=".form-control-sm example">

                                    <label for="tgl_kembali" class="mb-1 mt-1"><strong>Tgl Kembali</strong></label>
                                    <input id="tgl_kembali" name="tgl_kembali" class="form-control form-control-sm" disabled type="date" value="<?php echo $tgl_kembali ?>" aria-label=".form-control-sm example">

                                    <label for="tgl_dikembalikan" class="mb-1 mt-1"><strong>Tgl Dikembalikan</strong></label>
                                    <input id="tgl_dikembalikan" name="tgl_dikembalikan" class="form-control form-control-sm" disabled type="date" value="<?php echo $tgl_dikembalikan ?>" aria-label=".form-control-sm example">
                                    
                                    <br>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Buku</th>
                                                <th>Judul</th>
                                                <th>Rak</th>
                                                <th>Denda</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                            
                                               ?>
                                           <tr>
                                               <td><?php echo $no++ ?></td>
                                               <td><?php echo $id_buku ?></td>
                                               <td><?php echo $judul ?></td>
                                               <td><?php echo $rak ?></td>
                                               <td>
                                                    <?php echo "<span class='badge rounded-pill text-bg-danger'>Denda : Rp. $denda</span>" . "<br><span class='badge rounded-pill text-bg-warning'>Terlambat: $terlambat hari</span>"; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if ($status == "Dipinjam") {
                                                            echo "<span class='badge rounded-pill text-bg-success'>$status</span>";
                                                        }elseif ($status == "Diperpanjang") {
                                                            echo "<span class='badge rounded-pill text-bg-primary'>$status</span>";
                                                        }
                                                    ?>
                                                </td>
                                           </tr>
                                           <?php } ?>
                                        </tbody>
                                    </table>                              
                                            <a href="tampil_terlambat.php"><input type="button"  value="Kembali" class="btn btn-danger mt-1"></a>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        
       
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>


        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
        <script>
            $( '#single-select-field' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } );
        </script>

    </body>
</html>
