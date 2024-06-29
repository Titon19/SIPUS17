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
    $id = $_POST['id'];  // Ganti 'id' sesuai dengan nama kolom yang sesuai
    $id_buku = $_POST['id_buku'];
    $jumlah_lama = $_POST['jumlah_lama'];
    $jumlah_baru1 = $_POST['jumlah_baru'];
    $new_qty = $_POST['qty'];
    $status = $_POST['status'];

    date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan lokasi Anda
    $waktuSaatIni1 = date('Y-m-d H:i:s');


    $t_stok = mysqli_query($koneksi, "SELECT * FROM stok_opname WHERE id = '$id'");
    $d_stok = mysqli_fetch_array($t_stok);
    $qty_sekarang = $d_stok['qty'];

    $t_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id_buku'");
    $d_buku = mysqli_fetch_assoc($t_buku);
    $d_jumlah = $d_buku['jumlah'];

    $hitung = $d_jumlah + $qty_sekarang;

    $jumlah_barus = $hitung - $new_qty;
    if ($new_qty == $qty_sekarang) {
        echo "<script language='JavaScript'>alert('Qty tidak boleh sama');</script>";
    } else {
        // Update stok_opname with the new quantity and status
        $update_stok_opname = mysqli_query($koneksi, "UPDATE stok_opname SET jumlah_lama='$d_jumlah', jumlah_baru='$jumlah_barus', qty='$new_qty', status='$status', tgl_catat='$waktuSaatIni1' WHERE id = '$id'");

        if ($update_stok_opname) {

            // Calculate the difference in quantity
            $hitungs = $d_jumlah + $qty_sekarang;
            $hitung_j = $hitungs - $new_qty;

            // Update stok di tabel buku
            $update_buku = mysqli_query($koneksi, "UPDATE buku SET jumlah = '$hitung_j' WHERE id_buku = '$id_buku'");
            echo "<script language='JavaScript'>alert('Data Berhasil Diedit');document.location='tampil_stok_opname.php';</script>";

            if (!$update_buku) {
                // Handle error if failed to update stok in buku table
                echo "Gagal mengupdate stok buku: " . mysqli_error($koneksi);
            }
        } else {
            // Handle error if failed to update stok_opname table
            echo "Gagal mengupdate stok_opname: " . mysqli_error($koneksi);
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
    <title>Edit Data Stok Buku Opname</title>
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
                <h1 class="mt-4">Edit Stok Data Stok Buku Opname</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Edit Stok Data Stok Buku Opname
                    </div>
                    <div class="card-body">
                        <form action="" method="post">

                            <?php
                            if (isset($_GET["id"])) {
                                $id = $_GET['id'];
                                $t_opname = mysqli_query($koneksi, "SELECT
                                stok_opname.id,
                                stok_opname.id_buku, 
                                buku.judul,
                                buku.id_kategori, 
								kategori.kategori,
                                buku.rak, 
                                buku.jumlah, 
                                stok_opname.jumlah_baru, 
                                stok_opname.qty,
                                stok_opname.status,
                                stok_opname.tgl_catat
                            FROM
                                buku
                                INNER JOIN
									kategori
								INNER JOIN
                                stok_opname
                                ON 
                                    buku.id_buku = stok_opname.id_buku
                            WHERE 
                                 stok_opname.id = $id");
                            }

                            while ($t_data = mysqli_fetch_array($t_opname)) {
                                $id = $t_data["id"];
                                $id_buku = $t_data['id_buku'];
                                $judul = $t_data['judul'];
                                $kategori = $t_data['kategori'];
                                $rak = $t_data['rak'];
                                $jumlah = $t_data['jumlah'];
                                $j_buku_baru = $t_data['jumlah_baru'];
                                $qty = $t_data['qty'];
                                $status = $t_data['status'];
                                $tgl_catat = $t_data['tgl_catat'];
                            }
                            ?>

                            <input type="hidden" name="id" value="<?php echo $id ?>">

                            <label for="id_buku" class="mb-1 mt-1"><strong>Buku</strong></label>
                            <input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
                            <select disabled name="id_buku" class="form-select" id="single-select-field"
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

                            <label for="jumlah" class="mb-1 mt-1"><strong>Jumlah Lama</strong></label>
                            <input name="jumlah" disabled class="form-control form-control-sm" type="text"
                                value="<?php echo $jumlah ?>" aria-label=".form-control-sm example" required>

                            <label for="qty" class="mb-1 mt-1"><strong>Qty</strong></label>
                            <input name="qty" class="form-control form-control-sm" type="text"
                                value="<?php echo $qty ?>" placeholder="Masukkan Qty"
                                aria-label=".form-control-sm example" required>


                            <input name="jumlah_lama" class="form-control form-control-sm" type="hidden"
                                value="<?php echo $jumlah ?>" placeholder="Masukkan Jumlah"
                                aria-label=".form-control-sm example" required>

                            <input name="jumlah_baru" class="form-control form-control-sm" type="hidden"
                                value="<?php echo $j_buku_baru ?>" placeholder="Jumlah Baru"
                                aria-label=".form-control-sm example" required>

                            <br>
                            <select name="status" class="form-select" aria-label="Default select example">
                                <option value="<?php echo $status ?>">
                                    <?php echo $status ?>
                                </option>
                                <option value="Hilang">Hilang</option>
                                <option value="Rusak">Rusak</option>
                            </select>

                            <input type="submit" name="submit" value="Edit" class="btn btn-primary mt-1">
                            <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                            <a href="tampil_stok_opname.php"><input type="button" name="submit" value="Batal"
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