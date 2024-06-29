<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
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

        .card {
            margin: 15px;
            /* Kurangi margin untuk memberikan ruang yang lebih baik di dua kolom */
        }
    </style>
</head>

<body>
    <?php include("nav.php"); ?>
    <div class="container">
        <div class="content">
            <div class="row">

                <div class="col-md-6">
                    <div class="card" style="width: 30rem;">
                        <div class="card-body">
                            <h5 class="card-title">Teknis Peminjaman Buku</h5>
                            <p class="card-text">
                                1. Login menggunakan no anggota dan password
                                <br>
                                2. Klik menu Transaksi > Peminjaman
                                <br>
                                3. Klik Tambah Transaksi Peminjaman
                                <br>
                                4. Anggota mengisi data peminjaman buku
                                <br>
                                4. Klik simpan
                                <br>
                                4. Informasi transaksi peminjaman buku terkirim ke nomor whatsapp anggota
                                <br>
                                4. Anggota diwajibkan mengambil buku yang dipinjam secepatnya ke parpustakaan
                                <br>
                                5. Selesai
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 30rem;">
                        <div class="card-body">
                            <h5 class="card-title">Teknis Pengembalian Buku</h5>
                            <p class="card-text">
                                1. Datang ke perpustakaan
                                <br>
                                2. Kembalikan buku yang dipinjam
                                <br>
                                3. Membayar denda, jika terkena denda
                                <br>
                                4. Admin atau Petugas akan melakukan proses transaksi pengembalian Buku
                                <br>
                                5. Informasi transaksi pengembalian buku terkirim ke nomor whatsapp anggota
                                <br>
                                6. Selesai
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 30rem;">
                        <div class="card-body">
                            <h5 class="card-title">Teknis Perpanjangan Buku</h5>
                            <p class="card-text">
                                1. Login dengan no anggota dan password
                                <br>
                                2. Klik menu transaksi > peminjaman
                                <br>
                                3. Klik tombol Perpanjang
                                <br>
                                4. Jika terkena denda, maka diharuskan untuk membayar denda setelah klik tombol
                                perpanjang sebelum Admin atau Petugas melakukan Approve Perpanjangan
                                <br>
                                5. Jika tidak terkena denda, maka Admin atau Petugas dapat langsung melakukan approve
                                perpanjangan
                                Buku
                                <br>
                                5. Informasi perpanjangan buku terkirim ke nomor whatsapp anggota
                                <br>
                                6. Selesai
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 30rem;">
                        <div class="card-body">
                            <h5 class="card-title">Teknis Berkunjung</h5>
                            <p class="card-text">
                                1. Pengunjung datang ke perpustakaan SMKS 17 Kota Serang
                                <br>
                                2. Membuka website dan pilih menu berkunjung
                                <br>
                                3. Input nama dan klik berkunjung
                                <br>
                                4. Selesai
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-warning mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SIPUS17 2024</div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>