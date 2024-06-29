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
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $level = $_POST['level'];

    $query = mysqli_query($koneksi, "INSERT INTO users (nama, username, password, level) 
                  VALUES ('$nama', '$username', '$pass', '$level')");
    if ($query) {
        // Inputan berhasil disimpan
        echo "<script language='JavaScript'>alert('Data Berhasil Disimpan');document.location='tampil_users.php';</script>";
    } else {
        // Menangani kesalahan
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
    <title>Tambah Data Users</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Data Users</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tambah Data Users
                    </div>
                    <div class="card-body">

                        <form action="" method="post">
                            <label for="" class="mb-1"><strong>Nama</strong></label>
                            <input name="nama" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan Nama" aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1"><strong>Username</strong></label>
                            <input name="username" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan Username" aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1"><strong>Password</strong></label>
                            <input name="pass" class="form-control form-control-sm" type="text"
                                placeholder="Masukkan Password" aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Level</strong></label>
                            <select name="level" class="form-select" aria-label="Default select example" required>
                                <option value="">--Pilih Level--</option>
                                <option value="0">Admin</option>
                                <option value="1">Petugas</option>
                            </select>

                            <a href="tampil_users.php"><input type="submit" name="submit" value="Simpan"
                                    class="btn btn-primary mt-1"></a>
                            <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                            <a href="tampil_users.php"><input type="button" name="submit" value="Batal"
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
</body>

</html>