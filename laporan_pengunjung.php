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
    <title>Laporan Data Pengunjung</title>
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

        .tempat {
            padding: 10px;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div align="center">
        <strong>LAPORAN DATA PENGUNJUNG PERPUSTAKAAN SMKS YP 17 KOTA SERANG</strong>
        <br>Jl. KH Amin Jasuta No. 26. A Kaloran Kota
        Serang

    </div>
    <hr>
    <table class="table" border="1" style="border-collapse:collapse;" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>NISN/NIGN</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>JK</th>
                <th>Tempat Lahir</th>
                <th>Tgl Lahir</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('koneksi.php');

            $t_pengunjung = mysqli_query($koneksi, "SELECT * FROM pengunjung");
            $no = 1;
            while ($data = mysqli_fetch_array($t_pengunjung)) {
                $id_pengunjung = $data['id_pengunjung'];
                $nisn_nign = $data['nisn_nign'];
                $nama = $data['nama_lengkap'];
                $jurusan = $data['jurusan'];
                $tgl_lahir = $data['tgl_lahir'];
                $tempat_lhir = $data['tempat_lhir'];
                $jk = $data['jk'];
                $alamat = $data['alamat'];

                ?>
                <tr>
                    <td class="no">
                        <?php echo $no++ ?>
                    </td>
                    <td class="tengah">
                        <?php echo $nisn_nign ?>
                    </td>
                    <td class="tengah">
                        <?php echo $nama ?>
                    </td>
                    <td class="tengah">
                        <?php echo $jurusan ?>
                    </td>
                    <td class="tengah">
                        <?php echo $jk ?>
                    </td>
                    <td class="tengah tempat">
                        <?php echo $tempat_lhir ?>
                    </td>
                    <td class="tengah">
                        <?php echo date('d/m/y', strtotime($tgl_lahir)) ?>
                    </td>
                    <td class="tengah">
                        <?php echo $alamat ?>
                    </td>
                </tr>
            <?php } ?>
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
$mpdf->Output("LaporanPengunjung.pdf", "I");
?>