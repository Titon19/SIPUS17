<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
include('koneksi.php');

// Pastikan variabel POST telah di-set sebelum digunakan
$tgl_mulai = isset($_POST['tgl_mulai']) ? $_POST['tgl_mulai'] : "";
$tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : "";

$mpdf = new \Mpdf\Mpdf();
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Kunjungan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        }

        th {
            padding: 5px;
            width: 50%;
        }

        .no {
            text-align: center;
        }

        .tengah {
            text-align: center;
        }

        .no_wa {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div align="center">
        <strong>LAPORAN DATA KUNJUNGAN PERPUSTAKAAN SMKS YP 17 KOTA SERANG</strong>
        <br>Jl. KH Amin Jasuta No. 26. A Kaloran Kota Serang
        <br>
        <?php echo $tgl_mulai . " s/d " . $tgl_akhir ?>
    </div>
    <hr>
    <table class="table" border="1" style="border-collapse:collapse;" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $t_kunjung = mysqli_query($koneksi, "SELECT *
                        FROM
                            kunjungan
                        WHERE
                            waktu BETWEEN '$tgl_mulai 00:00:00' AND '$tgl_akhir 23:59:59'");
            $no = 1;
            $totalJumlah = 0;
            while ($d_kunjung = mysqli_fetch_array($t_kunjung)) {
                $nama1 = $d_kunjung['nama'];
                $waktu1 = $d_kunjung['waktu'];
                ?>
                <tr>
                    <td class="no">
                        <?php echo $no++ ?>
                    </td>
                    <td class="tengah">
                        <?php echo $nama1 ?>
                    </td>
                    <td class="tengah">
                        <?php echo $waktu1 ?>
                    </td>
                </tr>
                <?php
                $totalJumlah++;
            } ?>
            <tr class="total">
                <td colspan="2" align="right"><strong>Total</strong></td>
                <td class="tengah">
                    <strong>
                        <?php echo $totalJumlah; ?>
                    </strong>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 200px;">
        <?php
        date_default_timezone_set('Asia/Jakarta'); // Set your timezone
        $tanggal = date('Y-m-d');
        function tgl_indo($tgl)
        {
            $bulan = array(
                1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $pecahkan = explode('-', $tgl);

            return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
        }
        ?>
        <p align="right">Serang,
            <?php echo tgl_indo($tanggal); ?>
        </p>
        <br><br><br><br>
        <p align="right">
            <?php

            if ($_SESSION['level'] == '0' || $_SESSION['level'] == '1') {
                echo $_SESSION['nama'];
            }

            ?> <br>
            <?php
            if ($_SESSION['level'] == '0') {
                echo "Administrator";
            } elseif ($_SESSION['level'] == '1') {
                echo "Petugas";
            }

            ?>
        </p>
    </div>
</body>

</html>

<?php
$tampil = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($tampil);
$mpdf->Output("LaporanKunjungan.pdf", "I");
?>