<?php
include('../koneksi.php');
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "0") {
    header("location:../index.php");
    session_destroy();
}

// Perbarui denda jika buku belum dikembalikan dan lewat dari tgl_kembali
$queryDenda = "SELECT id_pinjam, tgl_kembali, tgl_dikembalikan, denda FROM peminjaman WHERE `status` != 'Dikembalikan' AND tgl_kembali < NOW()";

$resultDenda = mysqli_query($koneksi, $queryDenda);
while ($rowDenda = mysqli_fetch_assoc($resultDenda)) {
    $id_pinjamDenda = $rowDenda['id_pinjam'];
    $tgl_kembaliDenda = $rowDenda['tgl_kembali'];
    $tgl_dikembalikanDenda = $rowDenda['tgl_dikembalikan'];

    // Periksa apakah buku sudah dikembalikan
    if ($tgl_dikembalikanDenda == null) {
        // Hitung selisih hari antara tgl_kembali dan sekarang
        $tgl_kembaliDenda = new DateTime($tgl_kembaliDenda);
        $sekarangDenda = new DateTime();
        $selisihDenda = $sekarangDenda->diff($tgl_kembaliDenda)->days;

        // Hitung denda (500 Rupiah per hari)
        $dendaDenda = $selisihDenda * 500;

        // Hitung terlambat berdasarkan besaran denda
        $terlambatDenda = floor($dendaDenda / 500); // 1 hari per 500 Rupiah

        // Update denda, terlambat, dan tanggal dikembalikan di database
        $updateDenda = mysqli_query($koneksi, "UPDATE peminjaman SET denda='$dendaDenda', terlambat='$terlambatDenda', tgl_dikembalikan=NOW() WHERE id_pinjam='$id_pinjamDenda'");

        if (!$updateDenda) {
            // Handle error jika gagal mengupdate denda, terlambat, dan tanggal dikembalikan
            echo "Gagal mengupdate denda, terlambat, dan tanggal dikembalikan untuk ID Pinjam: $id_pinjamDenda. Error: " . mysqli_error($koneksi);
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
    <title>Data Transaksi Terlambat</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../petugas/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Transaksi Terlambat</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Transaksi Terlambat
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Pinjam</th>
                                    <th>No Anggota</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <!-- <th>No Wa</th> -->
                                    <th>Kode Buku</th>
                                    <th>Judul</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tampilbuku = mysqli_query($koneksi, "SELECT
                                             peminjaman.id_pinjam,
                                             peminjaman.id_anggota,
                                             anggota.nisn,
                                             anggota.nama,
                                             anggota.no_wa,
                                             buku.id_buku,
                                             buku.judul,
                                             peminjaman.tgl_pinjam,
                                             peminjaman.tgl_kembali,
                                             peminjaman.tgl_dikembalikan,
                                             peminjaman.terlambat,
                                             peminjaman.denda,
                                             peminjaman.`status`
                                         FROM
                                             peminjaman
                                             INNER JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota
                                             INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
                                         WHERE
                                             (peminjaman.`status` = 'Dipinjam' OR peminjaman.`status` = 'Diperpanjang')
                                             AND (peminjaman.denda > 0 OR peminjaman.terlambat > 0)");
                                $no = 1;
                                while ($data = mysqli_fetch_array($tampilbuku)) {

                                    $id_pinjam = $data['id_pinjam'];
                                    $id_anggota = $data['id_anggota'];
                                    $nisn = $data['nisn'];
                                    $nama = $data['nama'];
                                    $no_wa = $data['no_wa'];
                                    $id_buku = $data['id_buku'];
                                    $judul = $data['judul'];
                                    $tgl_pinjam = $data['tgl_pinjam'];
                                    $tgl_kembali = $data['tgl_kembali'];
                                    $tgl_dikembalikan = $data['tgl_dikembalikan'];

                                    $status = $data['status'];
                                    $terlambat = $data['terlambat'];
                                    $denda1 = $data['denda'];
                                    $modalId = 'exampleModal' . $id_pinjam;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $no++ ?>
                                        </td>
                                        <td>
                                            <?php echo $id_pinjam ?>
                                        </td>
                                        <td>
                                            <?php echo $id_anggota ?>
                                        </td>
                                        <td>
                                            <?php echo $nisn ?>
                                        </td>
                                        <td>
                                            <?php echo $nama . " | " . $no_wa ?>
                                        </td>
                                        <td>
                                            <?php echo $id_buku ?>
                                        </td>
                                        <td>
                                            <?php echo $judul ?>
                                        </td>
                                        <td>
                                            <?php echo $tgl_pinjam ?>
                                        </td>
                                        <td>
                                            <?php echo $tgl_kembali ?>
                                        </td>
                                        <td>
                                            <?php

                                            if ($status == 'Dipinjam' || $status == 'Diperpanjang') {
                                                if ($status == "Dipinjam") {
                                                    echo "<span class='badge rounded-pill text-bg-success'>$status</span>" . "<br><span class='badge rounded-pill text-bg-danger'>Denda : Rp. $denda1</span>" . "<br><span class='badge rounded-pill text-bg-warning'>Terlambat: $terlambat hari</span>";
                                                } elseif ($status == "Diperpanjang") {
                                                    echo "<span class='badge rounded-pill text-bg-primary'>$status</span>" . "<br><span class='badge rounded-pill text-bg-danger'>Denda : Rp. $denda1</span>" . "<br><span class='badge rounded-pill text-bg-warning'>Terlambat: $terlambat hari</span>";
                                                }
                                            }
                                            ?>
                                        </td>

                                        <td>

                                            <?php
                                            if (isset($_POST['kirimWA'])) {
                                                $id_pinjam2 = $_POST['id_pinjam2'];
                                                $id_buku2 = $_POST['id_buku2'];
                                                $id_anggota2 = $_POST['id_anggota2'];



                                                $t_buku2 = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id_buku2'");
                                                $d_buku2 = mysqli_fetch_assoc($t_buku2);
                                                $p_judul2 = $d_buku2['judul'];
                                                $p_rak2 = $d_buku2['rak'];

                                                $query_nomor_wa2 = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '$id_anggota2'");
                                                $data_nomor_wa2 = mysqli_fetch_assoc($query_nomor_wa2);
                                                $nisn2 = $data_nomor_wa2['nisn'];
                                                $no_wa2 = $data_nomor_wa2['no_wa'];
                                                $p_nama2 = $data_nomor_wa2['nama'];
                                                $p_jurus2 = $data_nomor_wa2['jurusan'];
                                                $p_jk2 = $data_nomor_wa2['jk'];


                                                // Update tgl_pinjam dan tgl_kembali
                                                $query_status2 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_pinjam = '$id_pinjam2'");
                                                $data_status2 = mysqli_fetch_assoc($query_status2);
                                                $tgl_pinjam2 = $data_status2['tgl_pinjam'];
                                                $tgl_kembali2 = $data_status2['tgl_kembali'];
                                                $terlambat2 = $data_status2['terlambat'];
                                                $tgl_dikembalikan2 = $data_status2['tgl_dikembalikan'];
                                                $denda2 = $data_status2['denda'];
                                                $status2 = $data_status2['status'];



                                                if ($query_status2) {
                                                    // Inputan berhasil disimpan
                                                    // echo "<script language='JavaScript'>alert('Berhasil mengirim pesan whatsapp');document.location='whatsapp.php?id_pinjam=$id_pinjam2&id_anggota=$id_anggota2&nisn=$nisn2&no_wa=$no_wa2&id_buku=$id_buku2&tgl_pinjam=$tgl_pinjam2&tgl_kembali=$tgl_kembali2&judul=$p_judul2&rak=$p_rak2&status=$status2&tgl_dikembalikan=$tgl_dikembalikan2&denda=$denda2&nama=$p_nama2&kelas=$p_jurus2&jk=$p_jk2';</script>";
                                                    echo "<script language='JavaScript'>alert('Berhasil mengirim pesan whatsapp');document.location='whatsapp.php?calling_page=klik_terlambat&id_pinjam=$id_pinjam2&id_anggota=$id_anggota2&nisn=$nisn2&no_wa=$no_wa2&id_buku=$id_buku2&tgl_pinjam=$tgl_pinjam2&tgl_kembali=$tgl_kembali2&judul=$p_judul2&rak=$p_rak2&status=$status2&tgl_dikembalikan=$tgl_dikembalikan2&terlambat=$terlambat2&denda=$denda2&nama=$p_nama2&jurusan=$p_jurus2&jk=$p_jk2';</script>";

                                                } else {
                                                    // Menangani kesalahan saat memperpanjang peminjaman
                                                    echo "Gagal memperpanjang peminjaman: " . mysqli_error($koneksi);
                                                }
                                            }

                                            ?>

                                            <form action="" method="POST">
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#perpanjangModal<?php echo $id_pinjam; ?>">
                                                    WA
                                                </button>
                                                <div class="modal fade" id="perpanjangModal<?php echo $id_pinjam; ?>"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                    Notifikasi Whatsapp</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah anda ingin memberikan notifikasi pada peminjaman
                                                                    ini?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id_pinjam2"
                                                                    value="<?php echo $id_pinjam; ?>">
                                                                <input type="hidden" name="id_buku2"
                                                                    value="<?php echo $id_buku; ?>">
                                                                <input type="hidden" name="id_anggota2"
                                                                    value="<?php echo $id_anggota; ?>">
                                                                <button type="submit" class="btn btn-info btn-perpanjang"
                                                                    name="kirimWA">Kirim</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <a href="detail_terlambat.php?id_pinjam=<?php echo $id_pinjam; ?>"
                                                class="btn btn-warning">Lihat</a>

                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
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
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <!-- <script>
            document.addEventListener("DOMContentLoaded", function() {
                var kembalikanButtons = document.querySelectorAll(".btn-kembalikan");

                kembalikanButtons.forEach(function(button) {
                    button.addEventListener("click", function() {
                        // Menyembunyikan tombol setelah diklik
                        button.style.display = "none";
                    });
                });
            });
        </script> -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var kembalikanButtons = document.querySelectorAll(".btn-kembalikan");

            kembalikanButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    // Menyembunyikan tombol setelah diklik
                    button.style.display = "none";

                    // Memuat ulang halaman setelah mengembalikan buku
                    setTimeout(function () {
                        location.reload();
                    }, 1000); // Setelah 1 detik, sesuaikan jika perlu
                });
            });
        });
    </script>

</body>

</html>