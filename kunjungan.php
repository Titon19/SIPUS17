<?php
include("koneksi.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $nama1 = $_POST['nama'];
            date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan lokasi Anda

            $waktuSaatIni = date('Y-m-d H:i:s');

            $query = mysqli_query($koneksi, "INSERT INTO kunjungan (nama, waktu) VALUES ('$nama1', '$waktuSaatIni')");

            if ($query) {
                // Inputan berhasil disimpan
                header("Location: kunjungan.php");
                exit();
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
        <title>Kunjungan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
        .navbar {
            background: rgb(26, 26, 155);
            background: linear-gradient(180deg, rgba(26, 26, 155, 1) 100%, rgba(0, 212, 255, 1) 100%);
            box-shadow: 0px 0px 1px 0px;
        }

        .navbar-brand {
            color: white;

        }

        body {
            background-color: #fcfcfc;
        }

        strong {
            text-size-adjust: 5px;
        }

        .navbar-nav a {
            color: white;
        }

        .nav-link .active {
            color: white;
        }

        .judul {
            text-align: center;
            margin-top: 152px;
        }

        #layoutAuthentication_footer {
            margin-top: 15%;
        }
    </style>
    </head>
    <body class="sb-nav-fixed">
    <?php include("nav.php"); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Kunjungan</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Kunjungan
                            </div>
                            <div class="card-body">
                                    
                            <form action="" method="post">
                                    <label for="" class="mb-1 mt-1"><strong>Nama Lengkap</strong></label>
                                    <input name="nama" class="form-control form-control-sm" type="text" placeholder="Masukkan Nama Lengkap" aria-label=".form-control-sm example" required>
                                <input type="submit" name="submit" value="Berkunjung" class="btn btn-success mt-1">
                            </form>
                                <br>
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $t_kunjung = mysqli_query($koneksi, "SELECT * FROM kunjungan");
                                        $no = 1;
                                        while ($d_kunjung = mysqli_fetch_array($t_kunjung)) {
                                            $nama1 = $d_kunjung['nama'];
                                            $waktu1 = $d_kunjung['waktu'];
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $nama1 ?></td>
                                            <td><?php echo $waktu1 ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-warning mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; SIPUS17 2023</div>
            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        <script>
            $( '#single-select-field' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } );
        </script>
    </body>
</html>
