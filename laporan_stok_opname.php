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
    <title>Laporan Data Buku Masuk</title>
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
        <strong>LAPORAN DATA STOK BUKU OPNAME PERPUSTAKAAN SMKS YP 17 KOTA SERANG</strong>
        <br>Jl. KH Amin Jasuta No. 26. A Kaloran Kota Serang
        <br>
        <?php echo $tgl_mulai . " s/d " . $tgl_akhir ?>
    </div>
    <hr>
    <table class="table" border="1" style="border-collapse:collapse;" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Rak</th>
                <th>Jumlah Lama</th>
                <th>Jumlah Baru</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Tgl Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $tampilbuku = mysqli_query($koneksi, "SELECT
            stok_opname.id,
            stok_opname.id_buku, 
            buku.judul, 
            buku.rak, 
            stok_opname.jumlah_lama, 
            stok_opname.jumlah_baru, 
            stok_opname.qty,
            stok_opname.status,
            stok_opname.tgl_catat
        FROM
            buku
            INNER JOIN
            stok_opname
            ON 
                buku.id_buku = stok_opname.id_buku");
            $no = 1;
            while ($data = mysqli_fetch_array($tampilbuku)) {
                $id = $data['id'];
                $id_buku = $data['id_buku'];
                $judul = $data['judul'];
                $rak = $data['rak'];
                $jumlah_lama = $data['jumlah_lama'];
                $jumlah_baru = $data['jumlah_baru'];
                $qty = $data['qty'];
                $tgl_catat = $data['tgl_catat'];
                $status = $data['status'];
                ?>
                <tr>
                    <td class="no">
                        <?php echo $no++ ?>
                    </td>
                    <td class="tengah">
                        <?php echo $id_buku ?>
                    </td>
                    <td class="tengah">
                        <?php echo $judul ?>
                    </td>
                    <td class="tengah">
                        <?php echo $rak ?>
                    </td>
                    <td class="tengah">
                        <?php echo $jumlah_lama ?>
                    </td>
                    <td class="tengah">
                        <?php echo $jumlah_baru ?>
                    </td>
                    <td class="tengah">
                        <?php echo $qty ?>
                    </td>
                    <td class="tengah">
                        <?php echo $status ?>
                    </td>
                    <td class="tengah">
                        <?php echo $tgl_catat ?>
                    </td>
                </tr>
                <?php $totalJumlah++;
            } ?>
            <tr class="total">
                <td colspan="8" align="right"><strong>Total</strong></td>
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
$mpdf->Output("LaporanBukuMasuk.pdf", "I");
?>