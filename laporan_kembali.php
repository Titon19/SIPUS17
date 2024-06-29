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
    <title>Laporan Data Transaksi Peminjaman Buku</title>
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
            width: 10px;
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
        <strong>LAPORAN DATA TRANSAKSI PENGEMBALIAN BUKU PERPUSTAKAAN SMKS YP 17 KOTA SERANG</strong>
        <br>Jl. KH Amin Jasuta No. 26. A Kaloran Kota Serang
        <br>
        <?php echo $tgl_mulai . " s/d " . $tgl_akhir ?>
    </div>
    <hr>
    <table class="table" border="1" style="border-collapse:collapse;" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>No Pinjam</th>
                <th>No Anggota</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Tgl Dikembalikan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php


            $t_pinjam = mysqli_query($koneksi, "SELECT
            peminjaman.id_pinjam,
            peminjaman.id_anggota,
            anggota.nisn,
            anggota.nama,
            anggota.no_wa,
            peminjaman.id_buku,
            buku.judul,
            peminjaman.tgl_pinjam,
            peminjaman.tgl_kembali,
            peminjaman.tgl_dikembalikan,
            peminjaman.`status`,
            peminjaman.denda,
            peminjaman.terlambat
        FROM
            peminjaman
            INNER JOIN
            anggota
            ON
                peminjaman.id_anggota = anggota.id_anggota
            INNER JOIN
            buku
            ON
                peminjaman.id_buku = buku.id_buku
        WHERE
            (peminjaman.tgl_pinjam BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND
            (peminjaman.`status` = 'Dikembalikan')");
            $no = 1;
            $totalJumlah = 0;
            if ($t_pinjam) {
                while ($d_pinjam = mysqli_fetch_array($t_pinjam)) {
                    $id_pinjam = $d_pinjam['id_pinjam'];
                    $id_anggota = $d_pinjam['id_anggota'];
                    $nisn = $d_pinjam['nisn'];
                    $nama = $d_pinjam['nama'];
                    $no_wa = $d_pinjam['no_wa'];
                    $id_buku = $d_pinjam['id_buku'];
                    $judul = $d_pinjam['judul'];
                    $tgl_pinjam = $d_pinjam['tgl_pinjam'];
                    $tgl_kembali = $d_pinjam['tgl_kembali'];
                    $tgl_dikembalikan = $d_pinjam['tgl_dikembalikan'];

                    $status = $d_pinjam['status'];
                    $terlambat = $d_pinjam['terlambat'];
                    $denda1 = $d_pinjam['denda'];
                    ?>
                    <tr>
                        <td class="no">
                            <?php echo $no++ ?>
                        </td>
                        <td class="tengah">
                            <?php echo $id_pinjam ?>
                        </td>
                        <td class="tengah">
                            <?php echo $id_anggota ?>
                        </td class="tengah">
                        <td class="tengah">
                            <?php echo $nisn ?>
                        </td>
                        <td class="tengah">
                            <?php echo $nama . " | " . $no_wa ?>
                        </td>
                        <td class="tengah">
                            <?php echo $id_buku ?>
                        </td>
                        <td class="tengah">
                            <?php echo $judul ?>
                        </td>
                        <td class="tengah">
                            <?php echo $tgl_pinjam ?>
                        </td>
                        <td class="tengah">
                            <?php echo $tgl_kembali ?>
                        </td>
                        <td class="tengah">
                            <?php echo $tgl_dikembalikan ?>
                        </td>
                        <td class="tengah">
                            <?php echo $status . " <br>Denda : Rp. " . $denda1 . "<br>Terlambat: " . $terlambat . " hari"; ?>
                        </td>
                    </tr>
                    <?php $totalJumlah++;
                } ?>
                <tr class="total">
                    <td colspan="10" align="right"><strong>Total</strong></td>
                    <td class="tengah">
                        <strong>
                            <?php echo $totalJumlah; ?>
                        </strong>
                    </td>
                </tr>
                <?php
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
            ?>

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
$mpdf->Output("LaporanPengembalianBuku.pdf", "I");
?>