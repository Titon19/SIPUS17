<?php
include ("../koneksi.php");

session_start();
if (isset($_SESSION['nomor_anggota_baru'])) {
    $nomorAnggotaBaru = $_SESSION['nomor_anggota_baru'];
    unset($_SESSION['nomor_anggota_baru']); // Hapus nomor anggota baru dari session agar tidak ditampilkan lagi setelah refresh
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Login sebagai Admin atau Petugas
    $login = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $cek = mysqli_num_rows($login);

    // Login sebagai Anggota
    $login_anggota = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota='$username' AND password='$password'");
    $cek_anggota = mysqli_num_rows($login_anggota);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($login);

        if ($data['level'] == "0") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "0";
            $_SESSION['nama'] = $data['nama'];
            header("location: ../admin");
        } elseif ($data['level'] == "1") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "1";
            $_SESSION['nama'] = $data['nama'];
            header("location: ../petugas");
        }
    } elseif ($cek_anggota > 0) {
        $data_anggota = mysqli_fetch_assoc($login_anggota);

        $_SESSION['id_anggota'] = $data_anggota['id_anggota'];
        $_SESSION['nama_agt'] = $data_anggota['nama'];
        header("location: ../anggota");

    } else {
        echo "<script>alert('Gagal login, username atau password salah!');</script>";
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
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        #layoutAuthentication {
            background-color: grey;
        }

        #layoutAuthentication_footer {
            margin-top: 27px;
        }

        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 130px;
        }
    </style>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <a href="../index.php" class="btn btn-warning">Kembali</a>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="card shadow-lg border-0 rounded-lg mt-4">
                                <div class="card-header">
                                    <img src="../logosmk.png" alt="smks17">
                                    <h3 class="text-center font-weight-light my-2">SIPUS17</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="mb-3">
                                            <?php
                                            if (isset($nomorAnggotaBaru)) {

                                                ?>
                                                <label for="">No Anggota Anda : </label>
                                                <input class="form-control form-control-sm" type="text" type="text" disabled
                                                    value="<?php echo $nomorAnggotaBaru ?>"
                                                    aria-label=".form-control-sm example">
                                                Silahkan isi kolom username dengan No Anggota<br>
                                            <?php }
                                            ?>
                                            <!-- <input class="form-control form-control-sm" name="username" id="inputEmail"
                                                type="text" placeholder="Username" aria-label=".form-control-sm example"
                                                required />
                                            <label for="inputEmail">Username</label> -->
                                            <input class="form-control form-control-sm" type="text" name="username"
                                                placeholder="Masukkan Username/No Anggota"
                                                aria-label=".form-control-sm example">
                                        </div>
                                        <div class="mb-3">
                                            <!-- <input class="form-control" name="password" id="inputPassword"
                                                type="password" placeholder="Password" required />
                                            <label for="inputPassword">Password</label> -->
                                            <input class="form-control form-control-sm" type="password" name="password"
                                                placeholder="Masukkan Password" aria-label=".form-control-sm example">
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                                            <button style="width:100%;" type="submit" name="submit"
                                                class="btn btn-success">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a class="btn btn-primary"
                                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                                            href="daftar_anggota.php">Daftar
                                            Anggota</a>
                                        <br>
                                        <a href="lupa_pass.php">Anggota lupa password & No Whatsapp?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
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
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>