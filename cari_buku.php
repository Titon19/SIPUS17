<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cari Buku</title>
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
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include("nav.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Cari Buku</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Cari Buku
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Buku</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th>ISBN</th>
                                    <th>Rak</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('koneksi.php');

                                $tampilbuku = mysqli_query($koneksi, "SELECT
                                buku.id_buku, 
                                buku.judul, 
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
                                    buku.id_kategori = kategori.id_kategori");
                                $no = 1;
                                while ($data = mysqli_fetch_array($tampilbuku)) {
                                    $id_buku = $data['id_buku'];
                                    $judul = $data['judul'];
                                    $kat = $data['kategori'];
                                    $pengarang = $data['pengarang'];
                                    $penerbit = $data['penerbit'];
                                    $tahun = $data['tahun'];
                                    $isbn = $data['isbn'];
                                    $rak = $data['rak'];
                                    $jumlah = $data['jumlah'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++ ?>
                                        </td>
                                        <td>
                                            <?php echo $id_buku ?>
                                        </td>
                                        <td>
                                            <?php echo $judul ?>
                                        </td>
                                        <td>
                                            <?php echo $kat ?>
                                        </td>
                                        <td>
                                            <?php echo $pengarang ?>
                                        </td>
                                        <td>
                                            <?php echo $penerbit ?>
                                        </td>
                                        <td>
                                            <?php echo $tahun ?>
                                        </td>
                                        <td>
                                            <?php echo $isbn ?>
                                        </td>
                                        <td>
                                            <?php echo $rak ?>
                                        </td>
                                        <td>
                                            <?php echo $jumlah ?>
                                        </td>
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
                    <div class="text-muted">Copyright &copy; SIPUS17 2024</div>

                </div>
            </div>
        </footer>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>