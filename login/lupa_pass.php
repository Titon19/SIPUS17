<?php
include ('../koneksi.php');

if (isset($_POST['submit'])) {
    $no_anggota = $_POST['no_anggota'];
    $no_wa = $_POST['no_wa'];
    $password = md5($_POST['pass']);
    $passKonfirm = md5($_POST['pass_konfirm']);

    if ($password != $passKonfirm) {
        echo "<script language='JavaScript'>alert('Password baru dan konfirmasi password harus sama!');</script>";
    } else {

        $query = mysqli_query($koneksi, "UPDATE anggota SET no_wa='$no_wa', password='$password' WHERE id_anggota='$no_anggota'");
        if ($query) {
            // Inputan berhasil disimpan
            echo "<script language='JavaScript'>alert('Berhasil mengubah password dan No Whatsapp');document.location='index.php';</script>";
        } else {
            // Menangani kesalahan
            echo "Gagal menyimpan data: " . mysqli_error($koneksi);
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
    <title>Lupa Password & No Whatsapp</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5" style="width:60%;">
                <h1 class="mt-4">Lupa Password & No Whatsapp</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Lupa Password & No Whatsapp
                    </div>
                    <div class="card-body">

                        <form action="" method="post">

                            <label for="" class="mb-1 mt-1"><strong>No Anggota</strong></label>
                            <input name="no_anggota" class="form-control form-control-sm" type="input"
                                aria-label=".form-control-sm example" placeholder="Masukkan No Anggota" required>

                            <label for="" class="mb-1 mt-1"><strong>Nomor Whatsapp Baru</strong></label>
                            <input name="no_wa" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan password Baru, Jika Tidak diubah, masukkan nomor yang sama"
                                aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Password Baru</strong></label>
                            <input name="pass" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan password Baru" aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Konfirmasi Password</strong></label>
                            <input name="pass_konfirm" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan konfirmasi password" aria-label=".form-control-sm example"
                                required>

                            <a href="index.php"><input type="submit" name="submit" value="Ubah"
                                    class="btn btn-primary mt-1"></a>
                            <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                            <a href="index.php"><input type="button" name="submit" value="Batal"
                                    class="btn btn-danger mt-1"></a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
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
</body>

</html>