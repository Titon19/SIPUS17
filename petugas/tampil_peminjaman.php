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

$tgl_sekarang = strtotime(date("Y-m-d"));
$query = "SELECT * FROM peminjaman WHERE (tgl_kembali < '$tgl_sekarang' OR status = 'Dipinjam' OR status = 'Diperpanjang')";
$result1 = mysqli_query($koneksi, $query);

// Loop untuk memperbarui data peminjaman
while ($dataP = mysqli_fetch_assoc($result1)) {
    // Menghitung selisih hari antara tanggal sekarang dan tanggal kembali
    $tgl_kembali = strtotime($dataP['tgl_kembali']);
    $id_pinjamDenda = $dataP['id_pinjam'];
    $tgl_kembalibaru = $dataP['tgl_kembali'];

    $selisih_hari1 = ($tgl_sekarang - $tgl_kembali) / (60 * 60 * 24);

    // Menghitung denda kecuali pada hari Sabtu dan Minggu
    $denda1 = $selisih_hari1 * 500;
    for ($i = 0; $i <= $selisih_hari1; $i++) {
        $dayOfWeek = date("N", $tgl_kembali);
        if ($dayOfWeek == 6 || $dayOfWeek == 7) { // Bukan Sabtu (6) atau Minggu (7)
            $denda1 -= 500;
        }
        $tgl_kembali += (60 * 60 * 24);
    }

    $terlambat = $denda1 / 500;

    if ($dataP['tgl_kembali'] < date("Y-m-d")) {
        $queryUpdateDenda = "UPDATE peminjaman SET denda = '$denda1', terlambat = '$terlambat' WHERE id_pinjam = '$id_pinjamDenda'";
        mysqli_query($koneksi, $queryUpdateDenda);
    }
}
// $tgl_sekarang = date("Y-m-d");
// $query = "SELECT * FROM peminjaman WHERE (tgl_kembali < '$tgl_sekarang' OR status = 'Dipinjam' OR status = 'Diperpanjang')";
// $result1 = mysqli_query($koneksi, $query);

// // Loop untuk memperbarui data peminjaman
// while ($dataP = mysqli_fetch_assoc($result1)) {
//     // Menghitung selisih hari antara tanggal sekarang dan tanggal kembali
//     $tgl_kembali = date_create($dataP['tgl_kembali']);
//     $id_pinjamDenda = $dataP['id_pinjam'];
//     $tgl_kembalibaru = $dataP['tgl_kembali'];


//     $selisih_hari1 = date_diff(date_create($tgl_sekarang), $tgl_kembali)->format('%d');

//     // Menghitung denda kecuali pada hari Sabtu dan Minggu
//     $denda1 = $selisih_hari1 * 500;
//     // $denda1 = max(0, $selisih_hari1 * 500);
//     for ($i = 0; $i <= $selisih_hari1; $i++) {
//         $dayOfWeek = date_format($tgl_kembali, 'N');
//         if ($dayOfWeek == 6 || $dayOfWeek == 7) { // Bukan Sabtu (6) atau Minggu (7)
//             $denda1 -= 500;
//         }
//         $tgl_kembali->modify('+1 day');
//     }
//     // $denda1 = max(0, $denda1);
//     $terlambat = $denda1 / 500;

//     // if ($query) {
//     //     // Memperbarui kolom 'denda'
//     //     $queryUpdateDenda = "UPDATE peminjaman SET  denda = '$denda1', terlambat = '$terlambat' WHERE id_pinjam = '$id_pinjamDenda' AND tgl_kembali < '$tgl_sekarang'";
//     //     mysqli_query($koneksi, $queryUpdateDenda);
//     // }
//     if ($dataP['tgl_kembali'] < $tgl_sekarang) {
//         $queryUpdateDenda = "UPDATE peminjaman SET denda = '$denda1', terlambat = '$terlambat' WHERE id_pinjam = '$id_pinjamDenda'";
//         mysqli_query($koneksi, $queryUpdateDenda);
//     }
// }


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
                                             INNER JOIN
                                             anggota
                                             ON 
                                                 peminjaman.id_anggota = anggota.id_anggota
                                             INNER JOIN
                                             buku
                                             ON 
                                                 peminjaman.id_buku = buku.id_buku
                                                 WHERE peminjaman.status = 'Dipinjam' OR peminjaman.status = 'Diperpanjang'
                                                 OR peminjaman.status = 'Tunggu Approve Perpanjang' OR peminjaman.status = 'Tunggu Approve Peminjaman'");
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

}

if (isset($_POST['bukuKembali'])) {
    $id_pinjam1 = $_POST['id_pinjam1'];
    $id_buku1 = $_POST['id_buku1'];
    $id_anggota1 = $_POST['id_anggota1'];

    $t_buku1 = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id_buku'");
    $d_buku1 = mysqli_fetch_assoc($t_buku1);
    $p_judul1 = $d_buku1['judul'];
    $p_rak1 = $d_buku1['rak'];

    $query_nomor_wa1 = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '$id_anggota1'");
    $data_nomor_wa1 = mysqli_fetch_assoc($query_nomor_wa1);
    $nisn1 = $data_nomor_wa1['nisn'];
    $no_wa1 = $data_nomor_wa1['no_wa'];
    $p_nama1 = $data_nomor_wa1['nama'];
    $p_jurus1 = $data_nomor_wa1['jurusan'];
    $p_jk1 = $data_nomor_wa1['jk'];

    // Mengubah status menjadi Dikembalikan
    $statusKembali = mysqli_query($koneksi, "UPDATE peminjaman SET status='Dikembalikan', tgl_dikembalikan=NOW() WHERE id_pinjam='$id_pinjam1'");

    if ($statusKembali) {
        $updateQtyBuku1 = mysqli_query($koneksi, "UPDATE buku SET jumlah = jumlah + 1 WHERE id_buku='$id_buku1'");

        if ($updateQtyBuku1) {
            $query_status1 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_pinjam = '$id_pinjam1'");

            $data_status1 = mysqli_fetch_assoc($query_status1);
            $status1 = $data_status1['status'];
            $tgl_dikembalikan1 = $data_status1['tgl_dikembalikan'];
            $terlambat1 = $data_status1['terlambat'];
            $denda1 = $data_status1['denda'];
            // Inputan berhasil disimpan

            echo "<script language='JavaScript'>alert('Buku Berhasil Dikembalikan');document.location='whatsapp.php?calling_page=klik_kembali&id_pinjam=$id_pinjam1&id_anggota=$id_anggota1&nisn=$nisn1&no_wa=$no_wa1&id_buku=$id_buku1&tgl_pinjam=$tgl_pinjam&tgl_kembali=$tgl_kembali&judul=$p_judul1&rak=$p_rak1&status=$status1&tgl_dikembalikan=$tgl_dikembalikan1&terlambat=$terlambat1&denda=$denda1&nama=$p_nama1&jurusan=$p_jurus1&jk=$p_jk1';</script>";
        } else {
            // Menangani kesalahan saat mengembalikan qty ke tabel buku
            echo "Gagal mengembalikan qty ke tabel buku: " . mysqli_error($koneksi);
        }
    } else {
        // Menangani kesalahan jika gagal mengubah status
        echo "Gagal mengubah status: " . mysqli_error($koneksi);
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
    <title>Data Transaksi Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include("../petugas/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Transaksi Peminjaman Buku</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Transaksi Peminjaman Buku
                    </div>
                    <div class="card-body">
                        <a href="tambah_pinjam.php" class="btn btn-success mb-1">Tambah Data +</a>
                        <!-- Menampilkan pesan status -->
                        <div id="pesan-status" style="display: none;">Pesan Terkirim</div>

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
                                             INNER JOIN
                                             anggota
                                             ON 
                                                 peminjaman.id_anggota = anggota.id_anggota
                                             INNER JOIN
                                             buku
                                             ON 
                                                 peminjaman.id_buku = buku.id_buku
                                                 WHERE peminjaman.status = 'Dipinjam' OR peminjaman.status = 'Diperpanjang'
                                                 OR peminjaman.status = 'Tunggu Approve Perpanjang' OR peminjaman.status = 'Tunggu Approve Peminjaman'");
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
                                            if ($status == "Dipinjam") {
                                                echo "<span class='badge rounded-pill text-bg-success'>$status</span>" . "<br><span class='badge rounded-pill text-bg-danger'>Denda : Rp. $denda1</span>" . "<br><span class='badge rounded-pill text-bg-warning'>Terlambat: $terlambat hari</span>";
                                            } elseif ($status == "Diperpanjang") {
                                                echo "<span class='badge rounded-pill text-bg-primary'>$status</span>" . "<br><span class='badge rounded-pill text-bg-danger'>Denda : Rp. $denda1</span>" . "<br><span class='badge rounded-pill text-bg-warning'>Terlambat: $terlambat hari</span>";
                                            } elseif ($status == "Tunggu Approve Peminjaman") {
                                                echo "<span class='badge rounded-pill text-bg-secondary'>$status</span>" . "<br><span class='badge rounded-pill text-bg-danger'>Denda : Rp. $denda1</span>" . "<br><span class='badge rounded-pill text-bg-warning'>Terlambat: $terlambat hari</span>";
                                            } elseif ($status == "Tunggu Approve Perpanjang") {
                                                echo "<span class='badge rounded-pill text-bg-secondary'>$status</span>" . "<br><span class='badge rounded-pill text-bg-danger'>Denda : Rp. $denda1</span>" . "<br><span class='badge rounded-pill text-bg-warning'>Terlambat: $terlambat hari</span>";
                                            }
                                            //echo $status . " <br>Denda : Rp. " . $denda1 . "<br>Terlambat: " . $terlambat . " hari"; 
                                            ?>
                                        </td>

                                        <td>

                                            <?php
                                            if ($status !== 'Dikembalikan') {
                                                // Tampilkan tombol kembalikan hanya jika status belum 'Dikembalikan'
                                                ?>
                                                <form action="" method="POST">
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#<?php echo $modalId; ?>">
                                                        Kembalikan
                                                    </button>
                                                    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        Kembalikan Buku</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Apakah anda yakin ingin mengembalikan buku ini?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="id_pinjam1"
                                                                        value="<?php echo $id_pinjam; ?>">
                                                                    <input type="hidden" name="id_buku1"
                                                                        value="<?php echo $id_buku; ?>">
                                                                    <input type="hidden" name="id_anggota1"
                                                                        value="<?php echo $id_anggota; ?>">
                                                                    <button type="submit" class="btn btn-success btn-kembalikan"
                                                                        name="bukuKembali">Kembalikan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <?php
                                                if (isset($_POST['perpanjangPeminjaman'])) {
                                                    $id_pinjam2 = $_POST['id_pinjam2'];
                                                    $id_buku2 = $_POST['id_buku2'];
                                                    $id_anggota2 = $_POST['id_anggota2'];

                                                    date_default_timezone_set('Asia/Jakarta');

                                                    // Mengatur tgl_pinjam ke tanggal sekarang
                                                    $tgl_pinjam_sekarang = date('Y-m-d');

                                                    // Mengatur tgl_kembali 7 hari ke depan
                                                    $perpanjanganKembali = date('Y-m-d', strtotime('+7 days', strtotime($tgl_pinjam_sekarang)));

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

                                                    // Memperpanjang peminjaman dengan mengubah tgl_pinjam, tgl_kembali, denda, dan terlambat
                                                    $perpanjangan = mysqli_query($koneksi, "UPDATE peminjaman SET tgl_pinjam='$tgl_pinjam_sekarang', tgl_kembali='$perpanjanganKembali', `status`='Diperpanjang', terlambat='0', denda='0' WHERE id_pinjam='$id_pinjam2'");

                                                    if ($perpanjangan) {
                                                        // Kirim pesan WhatsApp (jika diperlukan)
                                        
                                                        // Update tgl_pinjam dan tgl_kembali
                                                        $query_status2 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_pinjam = '$id_pinjam2'");
                                                        $data_status2 = mysqli_fetch_assoc($query_status2);
                                                        $status2 = $data_status2['status'];
                                                        $tgl_dikembalikan2 = $data_status2['tgl_dikembalikan'];

                                                        // Perbarui tgl_pinjam dan tgl_kembali sesuai perpanjangan (tanpa jam, menit, dan detik)
                                                        $tgl_pinjam2 = date('Y-m-d', strtotime($tgl_pinjam_sekarang));
                                                        $tgl_kembali2 = date('Y-m-d', strtotime($perpanjanganKembali));

                                                        // Inputan berhasil disimpan
                                                        echo "<script language='JavaScript'>alert('Peminjaman Berhasil Diperpanjang');document.location='whatsapp.php?calling_page=klik_perpanjang&id_pinjam=$id_pinjam2&id_anggota=$id_anggota2&nisn=$nisn2&no_wa=$no_wa2&id_buku=$id_buku2&tgl_pinjam=$tgl_pinjam2&tgl_kembali=$tgl_kembali2&judul=$p_judul2&rak=$p_rak2&status=$status2&tgl_dikembalikan=$tgl_dikembalikan2&terlambat=0&denda=0&nama=$p_nama2&jurusan=$p_jurus2&jk=$p_jk2';</script>";
                                                    } else {
                                                        // Menangani kesalahan saat memperpanjang peminjaman
                                                        echo "Gagal memperpanjang peminjaman: " . mysqli_error($koneksi);
                                                    }
                                                }
                                                ?>

                                                <form action="" method="POST">
                                                    <?php

                                                    if ($status == "Tunggu Approve Perpanjang" || $status == null) {
                                                        ?>
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#perpanjangModal<?php echo $id_pinjam; ?>"
                                                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; width:100%;">
                                                            Approve Perpanjang
                                                        </button>
                                                        <?php
                                                    } elseif ($status == "Diperpanjang") {
                                                        echo "";
                                                    }

                                                    ?>
                                                    <div class="modal fade" id="perpanjangModal<?php echo $id_pinjam; ?>"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        Perpanjang Peminjaman</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Apakah anda yakin ingin memperpanjang peminjaman ini?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="id_pinjam2"
                                                                        value="<?php echo $id_pinjam; ?>">
                                                                    <input type="hidden" name="id_buku2"
                                                                        value="<?php echo $id_buku; ?>">
                                                                    <input type="hidden" name="id_anggota2"
                                                                        value="<?php echo $id_anggota; ?>">
                                                                    <button type="submit" class="btn btn-info btn-perpanjang"
                                                                        name="perpanjangPeminjaman">Perpanjang</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>
                                                <a href="detail_pinjam.php?id_pinjam=<?php echo $id_pinjam; ?>"
                                                    class="btn btn-warning">Lihat</a>
                                                <a href="hapus_pinjam.php?id_pinjam=<?php echo $id_pinjam; ?>&action=hapus"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>

                                            </td>

                                        </tr>
                                    <?php }
                                } ?>
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