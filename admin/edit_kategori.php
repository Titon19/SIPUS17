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
    $id_kategori = $_POST['id_kategori'];
    $kategori = $_POST['kategori'];

    $query = mysqli_query($koneksi, "UPDATE kategori SET kategori='$kategori' WHERE id_kategori='$id_kategori'");
    if ($query) {
        // Inputan berhasil Diedit
        echo "<script language='JavaScript'>alert('Data Berhasil DiEdit');document.location='tampil_kategori.php';</script>";
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
    <title>Edit Data kategori</title>
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
    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Data Kategori</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Edit Data Kategori
                    </div>
                    <div class="card-body">
                        <form action="" method="post">

                            <?php
                            if (isset($_GET['id_kategori'])) {
                                $id_kategori = $_GET['id_kategori'];

                                $t_kategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori = '$id_kategori'");

                                while ($t_data = mysqli_fetch_array($t_kategori)) {
                                    $id_kategori = $t_data['id_kategori'];
                                    $kategori = $t_data['kategori'];
                                }

                                ?>
                                <label for="" class="mb-1"><strong>Id Kategori</strong></label>
                                <input name="id_kategori" value="<?php echo $id_kategori; ?>" readonly
                                    class="form-control form-control-sm" type="text" placeholder=""
                                    aria-label=".form-control-sm example">

                                <label for="" class="mb-1 mt-1"><strong>Kategori</strong></label>
                                <input name="kategori" value="<?php echo $kategori; ?>" class="form-control form-control-sm"
                                    type="text" placeholder="Masukkan Kategori" aria-label=".form-control-sm example"
                                    required>

                                <input type="submit" name="submit" value="Edit" class="btn btn-primary mt-1">
                                <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                                <a href="tampil_kategori.php"><input type="button" name="submit" value="Batal"
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