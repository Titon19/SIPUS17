<?php
include ('../koneksi.php');
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=gagal");
} elseif ($_SESSION['level'] == "1") {
    header("location:../index.php");
    session_destroy();
}
if (isset($_POST['submit'])) {
    $no_pinjam = $_POST['id_pinjam'];
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $terlambat1 = '0';
    $denda1 = '0';
    $qty = 1;
    $tgl_dikembalikans = $_POST['tgl_kembalikan'] == '';

    // Periksa jika jumlah buku kurang dari atau sama dengan 0
    $t_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id_buku'");
    $d_buku = mysqli_fetch_assoc($t_buku);
    $jumlah_buku = $d_buku['jumlah'];

    if ($jumlah_buku <= 0) {
        echo "<script language='JavaScript'>alert('Maaf, stok buku habis. Transaksi peminjaman tidak dapat dilakukan.');</script>";
    } else {
        // Lanjutkan dengan transaksi
        $p_judul = $d_buku['judul'];
        $p_rak = $d_buku['rak'];

        // Dapatkan nomor WhatsApp berdasarkan id_anggota
        $query_nomor_wa = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '$id_anggota'");
        $data_nomor_wa = mysqli_fetch_assoc($query_nomor_wa);
        $nisn = $data_nomor_wa['nisn'];
        $no_wa = $data_nomor_wa['no_wa'];
        $p_nama = $data_nomor_wa['nama'];
        $p_jurusan = $data_nomor_wa['jurusan'];
        $p_jk = $data_nomor_wa['jk'];

        // Periksa jumlah peminjaman seorang anggota
        if (checkJumlahPeminjaman($koneksi, $id_anggota) >= 3) {
            echo "<script language='JavaScript'>alert('Maaf, anggota ini sudah mencapai batas maksimal 3 kali peminjaman.');</script>";
        } else {
            // Jika jumlah peminjaman masih dalam batas, lakukan peminjaman
            $query = mysqli_query($koneksi, "INSERT INTO peminjaman (id_pinjam, id_anggota, id_buku, tgl_pinjam, tgl_kembali, tgl_dikembalikan, terlambat, denda, status) 
                          VALUES ('$no_pinjam', '$id_anggota', '$id_buku', '$tgl_pinjam', '$tgl_kembali', $tgl_dikembalikans, '$terlambat1', '$denda1', 'Dipinjam')");

            if ($query) {
                $query_status = mysqli_query($koneksi, "SELECT tgl_dikembalikan, denda, terlambat, status FROM peminjaman WHERE id_pinjam = '$no_pinjam'");
                $data_status = mysqli_fetch_assoc($query_status);
                $status = $data_status['status'];
                $tgl_dikembalikan = $data_status['tgl_dikembalikan'];
                $denda = $data_status['denda'];
                $terlambat = $data_status['terlambat'];

                // Jika input berhasil disimpan
                echo "<script language='JavaScript'>alert('Data Berhasil Disimpan');document.location='whatsapp.php?calling_page=klik_tambah_pinjam&id_pinjam=$no_pinjam&id_anggota=$id_anggota&nisn=$nisn&no_wa=$no_wa&id_buku=$id_buku&tgl_pinjam=$tgl_pinjam&tgl_kembali=$tgl_kembali&judul=$p_judul&rak=$p_rak&status=$status&tgl_dikembalikan=$tgl_dikembalikan&terlambat=$terlambat&denda=$denda&nama=$p_nama&jurusan=$p_jurusan&jk=$p_jk';</script>";
                // Update stok di tabel buku
                $kurangi_jumlah = mysqli_query($koneksi, "UPDATE buku SET jumlah = jumlah - $qty WHERE id_buku = '$id_buku'");

                if (!$kurangi_jumlah) {
                    echo "Gagal mengurangi stok: " . mysqli_error($koneksi);
                }
            } else {
                echo "Gagal menyimpan data: " . mysqli_error($koneksi);
            }
        }
    }
}

// Fungsi untuk memeriksa jumlah peminjaman seorang anggota
function checkJumlahPeminjaman($koneksi, $id_anggota)
{
    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM peminjaman WHERE id_anggota = '$id_anggota' AND (status = 'Dipinjam' OR status = 'Diperpanjang')");
    $result = mysqli_fetch_assoc($query);
    return $result['jumlah'];
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
    <title>Tambah Data Data Transaksi Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

</head>

<body class="sb-nav-fixed">
    <?php include ("../admin/navbar.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Data Transaksi Peminjaman Buku</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tambah Data Transaksi Peminjaman Buku
                    </div>
                    <div class="card-body">

                        <form action="" method="post">
                            <?php
                            $cekno = mysqli_query($koneksi, "SELECT RIGHT(id_pinjam,3) AS nomor, MID(id_pinjam,2,4) AS ambil_bulan FROM peminjaman ORDER BY id_pinjam DESC LIMIT 1");
                            $cek_data = mysqli_fetch_array($cekno);
                            $jmlh_no = mysqli_num_rows($cekno);

                            $nomor = $cek_data['nomor'];
                            $ambil_bln = $cek_data['ambil_bulan'];

                            // Definisi variabel tanggal
                            $bln = date("ym");
                            if ($jmlh_no > 0 && $bln == $ambil_bln) {
                                $no_urut = sprintf("%03d", $nomor + 1);
                            } elseif ($jmlh_no > 0 && $bln <> $ambil_bln) {
                                $no_urut = "001";
                            } else {
                                $no_urut = "001";
                            }
                            $no_trans = "P" . $bln . "" . $no_urut . "";
                            ?>
                            <label for="" class="mb-1 mt-1"><strong>No Pinjam</strong></label>
                            <input name="id_pinjamKeluar" class="form-control form-control-sm" disabled type="input"
                                value="<?php echo $no_trans ?>" aria-label=".form-control-sm example">
                            <input name="id_pinjam" class="form-control form-control-sm" type="hidden"
                                value="<?php echo $no_trans ?>" aria-label=".form-control-sm example">

                            <label for="" class="mb-1 mt-1"><strong>Anggota</strong></label>
                            <select name="id_anggota" class="form-select" id="single-select-field"
                                data-placeholder="Cari Anggota" required>
                                <option value=""></option>
                                <?php
                                $tampil_anggota = mysqli_query($koneksi, "SELECT * FROM anggota");
                                while ($data_anggota = mysqli_fetch_array($tampil_anggota)) {
                                    $id_anggota = $data_anggota['id_anggota'];
                                    $nisn = $data_anggota['nisn'];
                                    $nama = $data_anggota['nama'];
                                    $jurusan = $data_anggota['jurusan'];
                                    $no_wa = $data_anggota['no_wa'];
                                    ?>
                                    <option value="<?php echo $id_anggota ?>">
                                        <?php echo $id_anggota . " | " . $nisn . " | " . $nama . " | " . $jurusan . " | " . $no_wa ?>
                                    </option>

                                <?php } ?>
                            </select>

                            <label for="" class="mb-1 mt-1"><strong>Buku</strong></label>
                            <select name="id_buku" class="form-select" id="single-select-field2"
                                aria-label="Default select example" required>
                                <option value="">-- Pilih Buku --</option>
                                <?php
                                $tampil_buku = mysqli_query($koneksi, "SELECT
                                                    buku.id_buku,
                                                    buku.judul, 
                                                    kategori.kategori, 
                                                    buku.rak
                                                FROM
                                                    buku
                                                    INNER JOIN
                                                    kategori
                                                    ON 
                                                        buku.id_kategori = kategori.id_kategori");

                                while ($data_buku = mysqli_fetch_array($tampil_buku)) {
                                    $id_buku = $data_buku['id_buku'];
                                    $judul = $data_buku['judul'];
                                    $kategori = $data_buku['kategori'];
                                    $rak = "Rak : " . $data_buku['rak'];
                                    ?>
                                    <option value="<?php echo $id_buku ?>">
                                        <?php echo $id_buku . " | " . $judul . " | " . $kategori . " | " . $rak ?></option>
                                <?php } ?>
                            </select>

                            <label for="" class="mb-1 mt-1"><strong>Tgl Pinjam</strong></label>
                            <input id="tgl_pinjam" name="tgl_pinjam" class="form-control form-control-sm" type="date"
                                placeholder="Masukkan Tgl Pinjam" aria-label=".form-control-sm example" required>

                            <label for="" class="mb-1 mt-1"><strong>Tgl Kembali</strong></label>
                            <input readonly id="tgl_kembali" name="tgl_kembali" class="form-control form-control-sm"
                                type="date" placeholder="Masukkan Tgl Kembali" aria-label=".form-control-sm example"
                                required>

                            <input name="tgl_kembalikan" class="form-control form-control-sm" type="hidden"
                                placeholder="Masukkan Tgl Kembali" aria-label=".form-control-sm example" required>


                            <input type="hidden" name="selected_no_wa" id="selected_no_wa" value="">
                            <a href="detail_pinjam.php"><input type="submit" name="submit" value="Simpan"
                                    class="btn btn-primary mt-1"></a>
                            <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                            <a href="tampil_peminjaman.php"><input type="button" name="submit" value="Batal"
                                    class="btn btn-danger mt-1"></a>
                        </form>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $('#single-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });

        $('#single-select-field2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>
    <script>
        // Fungsi JavaScript untuk memperbarui nilai input tersembunyi
        function updateSelectedNoWa() {
            var selectedOption = document.querySelector('select[name="nisn"] option:checked');
            var selectedNoWa = selectedOption ? selectedOption.text.split('|').pop().trim() : '';
            document.getElementById('selected_no_wa').value = selectedNoWa;
        }

        // Lampirkan fungsi ke acara 'change' elemen select
        document.querySelector('select[name="nisn"]').addEventListener('change', updateSelectedNoWa);
    </script>
    <script>
        // Fungsi untuk mengatur tanggal kembali menjadi 7 hari setelah tanggal pinjam
        function setTglKembali() {
            var tglPinjam = document.getElementById('tgl_pinjam').value;
            var tglKembali = new Date(tglPinjam);
            tglKembali.setDate(tglKembali.getDate() + 7);

            var yyyy = tglKembali.getFullYear();
            var mm = String(tglKembali.getMonth() + 1).padStart(2, '0');
            var dd = String(tglKembali.getDate()).padStart(2, '0');

            var formattedDate = yyyy + '-' + mm + '-' + dd;
            document.getElementById('tgl_kembali').value = formattedDate;
        }

        // Panggil fungsi setTglKembali saat nilai tgl_pinjam berubah
        document.getElementById('tgl_pinjam').addEventListener('change', setTglKembali);

        // Set tanggal kembali secara otomatis saat halaman dimuat
        setTglKembali();
    </script>


</body>

</html>