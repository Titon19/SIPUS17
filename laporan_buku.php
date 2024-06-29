<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';


$mpdf = new \Mpdf\Mpdf();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Buku</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        }

        th {
            padding: 5px;
            width: 110%;
        }

        .no {
            text-align: center;
        }

        .tengah {
            text-align: center;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div align="center">
        <strong>LAPORAN DATA BUKU PERPUSTAKAAN SMKS YP 17 KOTA SERANG</strong>
        <br>Jl. KH Amin Jasuta No. 26. A Kaloran Kota
        Serang

    </div>
    <hr>
    <table class="table" border="1" style="border-collapse:collapse;" align="center">
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
            $totalJumlah = 0;
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
                $totalJumlah = $totalJumlah + $jumlah;
                ?>
                <tr>
                    <td class="no">
                        <?php echo $no++ ?>
                    </td>
                    <td class="tengah">
                        <?php echo $id_buku ?>
                    </td>
                    <td>
                        <?php echo $judul ?>
                    </td>
                    <td class="tengah">
                        <?php echo $kat ?>
                    </td>
                    <td class="tengah">
                        <?php echo $pengarang ?>
                    </td>
                    <td class="tengah">
                        <?php echo $penerbit ?>
                    </td>
                    <td class="tengah">
                        <?php echo $tahun ?>
                    </td>
                    <td class="tengah">
                        <?php echo $isbn ?>
                    </td>
                    <td class="tengah">
                        <?php echo $rak ?>
                    </td>
                    <td class="tengah">
                        <?php echo $jumlah ?>
                    </td>
                </tr>
            <?php
            } ?>
            <tr class="total">
                <td colspan="9" align="right"><strong>Total</strong></td>
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

            // variabel pecahkan 0 = tanggal
            // variabel pecahkan 1 = bulan
            // variabel pecahkan 2 = tahun
        
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
$mpdf->Output("LaporanBuku.pdf", "I");
?>