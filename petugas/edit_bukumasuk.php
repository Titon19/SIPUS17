<?php
include('../koneksi.php');
session_start();
// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "0") {
    header("location:../index.php");
    session_destroy();
}

if (isset($_POST['submit'])) {
    // Handle the edit process
    $id_masuk = mysqli_real_escape_string($koneksi, $_POST['id_masuk']);
    $id_buku = mysqli_real_escape_string($koneksi, $_POST['id_buku']);
    $new_qty = mysqli_real_escape_string($koneksi, $_POST['qty']);

    date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan lokasi Anda

    $waktuSaatIni1 = date('Y-m-d H:i:s');

    // Get the existing quantity in buku_masuk
    $get_existing_qty = mysqli_query($koneksi, "SELECT qty FROM buku_masuk WHERE id_masuk = '$id_masuk'");
    $existing_qty = mysqli_fetch_assoc($get_existing_qty)['qty'];

    // Update buku_masuk with the new quantity
    $update_buku_masuk = mysqli_query($koneksi, "UPDATE buku_masuk SET qty = '$new_qty', tgl_masuk='$waktuSaatIni1' WHERE id_masuk = '$id_masuk'");

    if ($update_buku_masuk) {
        // Calculate the difference in quantity
        $qty_difference = $new_qty - $existing_qty;

        // Update stok di tabel buku
        $update_buku = mysqli_query($koneksi, "UPDATE buku SET jumlah = jumlah + $qty_difference WHERE id_buku = '$id_buku'");
        echo "<script language='JavaScript'>alert('Data Berhasil Diedit');document.location='tampil_bukumasuk.php';</script>";

        if (!$update_buku) {
            // Handle error if failed to update stok in buku table
            echo "Gagal mengupdate stok buku: " . mysqli_error($koneksi);
        }
    } else {
        // Handle error if failed to update buku_masuk table
        echo "Gagal mengupdate buku_masuk: " . mysqli_error($koneksi);
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
    <title>Edit Data Buku Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

</head>

<body class="sb-nav-fixed">
    <?php include("../petugas/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Stok Data Buku Masuk</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Edit Stok Data Buku Masuk
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <?php
                            if (isset($_GET["id_masuk"])) {
                                $id_masuk = $_GET['id_masuk'];
                                $t_masuk = mysqli_query($koneksi, "SELECT
                                buku_masuk.id_buku, 
                                buku.judul,  
                                kategori.kategori,
                                buku.rak, 
                                buku.jumlah, 
                                buku_masuk.qty,
                                buku_masuk.tgl_masuk
                            FROM
                                buku
                                INNER JOIN
                                buku_masuk
                                ON 
                                    buku.id_buku = buku_masuk.id_buku
                                INNER JOIN
                                kategori
                                ON 
                                    buku.id_kategori = kategori.id_kategori
                            WHERE 
                                 buku_masuk.id_masuk = $id_masuk");
                            }

                            while ($t_data = mysqli_fetch_array($t_masuk)) {
                                $id_buku = $t_data['id_buku'];
                                $judul = $t_data['judul'];
                                $kategori = $t_data['kategori'];
                                $rak = $t_data['rak'];
                                $jumlah = $t_data['jumlah'];
                                $qty = $t_data['qty'];
                                $tgl_masuk = $t_data['tgl_masuk'];
                            }
                            ?>
                            <input type="hidden" name="id_masuk" value="<?php echo $id_masuk; ?>">
                            <label for="id_buku" class="mb-1 mt-1"><strong>Buku</strong></label>
                            <input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">

                            <select name="id_buku" disabled class="form-select" id="single-select-field"
                                data-placeholder="Cari Buku" required>
                                <option value="<?php echo $id_buku ?>">
                                    <?php echo $id_buku . " | " . $judul . " | " . $kategori . " | Rak: " . $rak ?>
                                </option>
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
                                    <option value="<?php echo $id_buku ?>">
                                        <?php echo $id_buku . " | " . $judul . " | " . $kategori . " | " . $rak ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <label for="jumlah" class="mb-1 mt-1"><strong>Jumlah</strong></label>
                            <input name="jumlah" disabled class="form-control form-control-sm" type="text"
                                value="<?php echo $jumlah ?>" aria-label=".form-control-sm example" required>

                            <label for="qty" class="mb-1 mt-1"><strong>Qty</strong></label>
                            <input name="qty" class="form-control form-control-sm" type="text"
                                value="<?php echo $qty ?>" placeholder="Masukkan Qty"
                                aria-label=".form-control-sm example" required>

                            <input type="submit" name="submit" value="Edit" class="btn btn-primary mt-1">
                            <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                            <a href="tampil_bukumasuk.php"><input type="button" name="submit" value="Batal"
                                    class="btn btn-danger mt-1"></a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('#single-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });


    </script>
</body>

</html>