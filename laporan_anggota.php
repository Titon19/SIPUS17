<?php
session_start();
// if ($_SESSION['level'] == "") {
//     header("location:../index.php?pesan=gagal");
// } elseif ($_SESSION['validasi'] == "Valid" || $_SESSION['validasi'] == "Belum Valid" || $_SESSION['validasi'] == null) {
//     header("location:../index.php");
//     session_destroy();
// }
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
    <title>Laporan Data Anggota</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        }

        th {
            padding: 5px;
            width: 100%;
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
        <strong>LAPORAN DATA ANGGOTA PERPUSTAKAAN SMKS YP 17 KOTA SERANG</strong>
        <br>Jl. KH Amin Jasuta No. 26. A Kaloran Kota
        Serang

    </div>
    <hr>
    <table class="table" border="1" style="border-collapse:collapse;" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>No Anggota</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Jenis Kelamin</th>
                <th>Tempat Lhir</th>
                <th>Tgl Lahir</th>
                <th>No Wa</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('koneksi.php');

            $t_anggota = mysqli_query($koneksi, "SELECT
            anggota.id_anggota, 
            anggota.nisn, 
            anggota.nama, 
            anggota.jurusan, 
            anggota.jk, 
            anggota.tempat_lhir, 
            anggota.tgl_lahir, 
            anggota.no_wa, 
            anggota.`password`
        FROM
            anggota
        WHERE
            anggota.validasi = 'Valid'");
            $no = 1;
            $totalJumlah = 0;
            while ($data = mysqli_fetch_array($t_anggota)) {
                $no_anggota = $data['id_anggota'];
                $nisn = $data['nisn'];
                $nama = $data['nama'];
                $jurusan = $data['jurusan'];
                $tempat_lhir = $data['tempat_lhir'];
                $tgl_lahir = $data['tgl_lahir'];
                $jk = $data['jk'];
                $no_wa = $data['no_wa'];
                $password = $data['password'];
                $is_validated = $data['validasi']; // Anggap kolom ini ada
            
                ?>
                <tr>
                    <td class="no">
                        <?php echo $no++ ?>
                    </td>
                    <td class="tengah">
                        <?php echo $no_anggota ?>
                    </td>
                    <td class="tengah">
                        <?php echo $nisn ?>
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
                    <td class="tengah">
                        <?php echo $tempat_lhir ?>
                    </td>
                    <td class="tengah">
                        <?php echo $tgl_lahir ?>
                    </td>

                    <td class="no_wa">
                        <?php echo $no_wa ?>
                    </td>
                    <td class="tengah">
                        <?php echo $password ?>
                    </td>

                </tr>
                <?php
                $totalJumlah++;
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
$mpdf->Output("LaporanAnggota.pdf", "I");
?>