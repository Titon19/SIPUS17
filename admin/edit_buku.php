<?php
include ('../koneksi.php');
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "1") {
    header("location:../index.php");
    session_destroy();
}
if (isset($_POST['submit'])) {
    $id_buku = $_POST['id_buku'];
    $judul = $_POST['judul'];
    $id_kategori = $_POST['kategori'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $isbn = $_POST['isbn'];
    $rak = $_POST['rak'];

    $query = mysqli_query($koneksi, "UPDATE buku SET judul='$judul', id_kategori='$id_kategori', pengarang='$pengarang', penerbit='$penerbit', tahun='$tahun', isbn='$isbn', rak='$rak' WHERE id_buku='$id_buku'");
    if ($query) {
        // Inputan berhasil Diedit
        echo "<script language='JavaScript'>alert('Data Berhasil DiEdit');document.location='tampil_buku.php';</script>";
    } else {
        // Menangani kesalahan
        echo "Gagal mengedit data: " . mysqli_error($koneksi);
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
    <title>Edit Data Buku</title>
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
    <?php include ("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Data Buku</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Edit Data Buku
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <!-- Tambahkan input untuk menyimpan id_buku -->
                            <?php
                            if (isset($_GET['id_buku'])) {
                                $id_buku = $_GET['id_buku'];

                                $t_buku = mysqli_query($koneksi, "SELECT
                                    buku.id_buku, 
                                    buku.judul,
                                    buku.id_kategori, 
                                    kategori.kategori, 
                                    buku.pengarang, 
                                    buku.penerbit, 
                                    buku.tahun, 
                                    buku.isbn, 
                                    buku.rak, 
                                    buku.jumlah
                                FROM
                                    buku
                                    INNER JOIN
                                    kategori
                                    ON 
                                        buku.id_kategori = kategori.id_kategori
                                WHERE
                                    buku.id_buku = '$id_buku'");

                                while ($t_data = mysqli_fetch_array($t_buku)) {

                                    $id_buku = $t_data['id_buku'];
                                    $judul = $t_data['judul'];
                                    $id_kategori = $t_data['id_kategori'];
                                    $kategori = $t_data['kategori'];
                                    $pengarang = $t_data['pengarang'];
                                    $penerbit = $t_data['penerbit'];
                                    $tahun = $t_data['tahun'];
                                    $isbn = $t_data['isbn'];
                                    $rak = $t_data['rak'];
                                    $jumlah = $t_data['jumlah'];
                                }

                                ?>
                                <label for="" class="mb-1"><strong>Kode Buku</strong></label>
                                <input name="id_buku" value="<?php echo $id_buku; ?>" readonly
                                    class="form-control form-control-sm" type="text" placeholder="Masukkan Kode Buku"
                                    aria-label=".form-control-sm example" required>

                                <label for="" class="mb-1 mt-1"><strong>Judul Buku</strong></label>
                                <input name="judul" value="<?php echo $judul; ?>" class="form-control form-control-sm"
                                    type="text" placeholder="Masukkan Judul Buku" aria-label=".form-control-sm example"
                                    required>

                                <label for="" class="mb-1 mt-1"><strong>Kategori</strong></label>
                                <br>
                                <select name="kategori" class="form-select" id="single-select-field"
                                    aria-label="Default select example" required>
                                    <option value="<?php echo $id_kategori; ?>">
                                        <?php echo $kategori; ?>
                                    </option>
                                    <?php
                                    $tampilkategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                                    while ($datakategori = mysqli_fetch_array($tampilkategori)) {
                                        $id_kategori = $datakategori['id'];
                                        $kategori = $datakategori['kategori'];
                                        ?>
                                        <option value="<?php echo $id_kategori; ?>">
                                            <?php echo $kategori; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <label for="" class="mb-1 mt-1"><strong>Pengarang</strong></label>
                                <input name="pengarang" value="<?php echo $pengarang; ?>"
                                    class="form-control form-control-sm" type="text" placeholder="Masukkan Pengarang"
                                    aria-label=".form-control-sm example" required>

                                <label for="" class="mb-1 mt-1"><strong>Penerbit</strong></label>
                                <input name="penerbit" value="<?php echo $penerbit; ?>" class="form-control form-control-sm"
                                    type="text" placeholder="Masukkan Penerbit" aria-label=".form-control-sm example"
                                    required>

                                <label for="" class="mb-1 mt-1"><strong>Tahun</strong></label>
                                <input name="tahun" value="<?php echo $tahun; ?>" class="form-control form-control-sm"
                                    type="text" placeholder="Masukkan Tahun Terbit" aria-label=".form-control-sm example"
                                    required>

                                <label for="" class="mb-1 mt-1"><strong>ISBN</strong></label>
                                <input name="isbn" value="<?php echo $isbn; ?>" class="form-control form-control-sm"
                                    type="text" placeholder="Masukkan Kode ISBN" aria-label=".form-control-sm example"
                                    required>

                                <label for="" class="mb-1 mt-1"><strong>Rak</strong></label>
                                <input name="rak" value="<?php echo $rak; ?>" class="form-control form-control-sm"
                                    type="text" placeholder="Masukkan Rak" aria-label=".form-control-sm example" required>

                                <label for="" class="mb-1 mt-1"><strong>Jumlah</strong></label>
                                <input name="jumlah" value="<?php echo $jumlah ?>" class="form-control form-control-sm"
                                    type="text" disabled placeholder="Masukkan Jumlah" aria-label=".form-control-sm example"
                                    required>

                                <input type="submit" name="submit" value="Edit" class="btn btn-primary mt-1">
                                <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                                <a href="tampil_buku.php"><input type="button" name="submit" value="Batal"
                                        class="btn btn-danger mt-1"></a>
                            <?php } ?>
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