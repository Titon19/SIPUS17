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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newToken = $_POST['newToken'];
    
        // Perbarui token dalam database
        $updateTokenQuery = "UPDATE whatsapp SET token = '$newToken' WHERE id = 2";
        $result = mysqli_query($koneksi, $updateTokenQuery);
    
        if ($result) {
            echo "Token berhasil diperbarui!";
        } else {
            echo "Error updating token: " . mysqli_error($koneksi);
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
        <title>API Whatsapp</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <?php include("../admin/navbar.php"); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">API Whatsapp</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                API Whatsapp
                            </div>
                            <div class="card-body">
                                    
                                <form action="" method="post"> 
                                <!-- <label for="newToken">New Token:</label>
                                <input type="text" name="newToken" required>
                                <button type="submit" name="submit">Update Token</button> -->
                                    <label for="newToken" class="mb-1 mt-1"><strong>Token :</strong></label>
                                    <input name="newToken" class="form-control form-control-sm" type="text" placeholder="Masukkan Token" aria-label=".form-control-sm example" required>
                                    
                                    <a href="wa_token.php" ><input type="submit" name="submit" value="Simpan" class="btn btn-success mt-1"></a>
                                </form>
                                <br>
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Token</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                             $token = mysqli_query($koneksi, "SELECT * FROM whatsapp WHERE id = 2");
                                             $no = 1;
                                             while ($data = mysqli_fetch_array($token)) {
                                                $isi_token = $data['token'];
                                            ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $isi_token ?></td>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>
