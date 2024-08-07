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
    $id_buku = mysqli_real_escape_string($koneksi, $_POST['id_buku']);
    $jumlah_lama = mysqli_real_escape_string($koneksi, $_POST['jumlah_lama']);
    $jumlah_baru = mysqli_real_escape_string($koneksi, $_POST['jumlah_baru']);
    $qty = mysqli_real_escape_string($koneksi, $_POST['qty']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan lokasi Anda

    $waktuSaatIni = date('Y-m-d H:i:s');
    $t_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id_buku'");
    $d_buku = mysqli_fetch_assoc($t_buku);
    $d_jumlah = $d_buku['jumlah'];

    $jumlah_baru = $d_jumlah - $qty;

    $query = mysqli_query($koneksi, "INSERT INTO stok_opname (id_buku, jumlah_lama, jumlah_baru, qty, status, tgl_catat) 
              VALUES ('$id_buku', '$d_jumlah', '$jumlah_baru', '$qty', '$status', '$waktuSaatIni')");
              
    if ($query) {
        // Jika input berhasil disimpan
        echo "<script language='JavaScript'>alert('Data Berhasil Disimpan');document.location='tampil_stok_opname.php';</script>";
     
        // Update stok di tabel buku
        $tambah_jumlah = mysqli_query($koneksi, "UPDATE buku SET jumlah = jumlah - $qty WHERE id_buku = '$id_buku'");
 
        if (!$tambah_jumlah) {
            // Tangani kesalahan jika gagal mengurangi stok
            echo "Gagal menambah stok: " . mysqli_error($koneksi);
        }
    } else {
        // Tangani kesalahan jika gagal menyimpan data peminjaman
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
        <title>Tambah Data Stok Buku Opname</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <!-- Or for RTL support -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    </head>
    <body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Tambah Data Stok Buku Opname</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tambah Data Stok Buku Opname
                            </div>
                            <div class="card-body">
                                    
                            <form action="" method="post">
                                <label for="id_buku" class="mb-1 mt-1"><strong>Buku</strong></label>
                                <select name="id_buku" class="form-select" id="single-select-field" aria-label="Default select example">
                                    <option value="">-- Pilih Buku --</option>
                                        <?php
                                                    $tampil_buku = mysqli_query($koneksi, "SELECT
                                                    buku.id_buku,
                                                    buku.judul, 
                                                    kategori.kategori, 
                                                    buku.rak
                                                FROM
                                                    buku
                                                    INNER JOIN
                                                    kategori
                                                    ON 
                                                        buku.id_kategori = kategori.id_kategori");
                                                    
                                                    while ($data_buku = mysqli_fetch_array($tampil_buku)) {
                                                        $id_buku = $data_buku['id_buku'];
                                                        $judul = $data_buku['judul'];
                                                        $kategori = $data_buku['kategori'];
                                                        $rak = "Rak : " . $data_buku['rak'];
                                                    ?>
                                                    <option value="<?php echo $id_buku ?>"><?php echo $id_buku . " | " . $judul. " | " . $kategori. " | " . $rak ?></option>
                                                    <?php }?>
                                                </select>

                                                
                                                <input name="jumlah_lama" class="form-control form-control-sm" type="hidden" placeholder="Masukkan Jumlah" aria-label=".form-control-sm example" required>

                                                <input name="jumlah_baru" class="form-control form-control-sm" type="hidden" placeholder="Jumlah Baru" aria-label=".form-control-sm example" required>

                                                <label for="qty" class="mb-1 mt-1"><strong>Qty</strong></label>
                                                <input name="qty" class="form-control form-control-sm" type="text" placeholder="Masukkan Qty" aria-label=".form-control-sm example" required>
                                                <br>
                                                <select name="status" class="form-select" aria-label="Default select example">
                                                    <option value="">--Pilih Status--</option>
                                                    <option value="Hilang">Hilang</option>
                                                    <option value="Rusak">Rusak</option>
                                                </select>

                    
                                                <a href="tampil_stok_opname.php" ><input type="submit" name="submit" value="Simpan" class="btn btn-primary mt-1"></a>
                                                <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                                                <a href="tampil_stok_opname.php"><input type="button" name="submit" value="Batal" class="btn btn-danger mt-1"></a>
                                               
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
