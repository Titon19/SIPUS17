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
            /* background-color: #fcfcfc; */
            background-image: url("bg.png");
            background-size: 100%;
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
            margin-top: 70px;
            color: blue;
            -webkit-text-stroke-width: 2px;
            -webkit-text-stroke-color: yellow;
        }

        #layoutAuthentication_footer {
            margin-top: 15%;
        }

        .logo {
            width: 200px;
        }

        h1 {
            font-size: 60px;
        }

        .alamat {
            -webkit-text-stroke-width: 0;
            -webkit-text-stroke-color: 0;
            color: yellow;
            font-size: 30px;
        }
    </style>
</head>

<body>
    <?php include("nav.php"); ?>
    <div class="container">
        <div class="judul">
            <img class="logo" src="logosmk.png" alt="logo">
            <h1><strong>SELAMAT DATANG DI SIPUS17</strong></h1>
            <h2><strong>SISTEM INFORMASI PERPUSTAKAAN SMKS YP 17 KOTA SERANG</strong></h2>
            <h3 class="alamat"><strong>Jl. K.H. Amin Jasuta No. 26 A Kaloran, Kota Serang</strong></h3>
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