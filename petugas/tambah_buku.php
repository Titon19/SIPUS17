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
if (isset($_POST['submit'])) {
    $id_buku = $_POST['id_buku'];
    $judul = $_POST['judul'];
    $id_kategori = $_POST['id_kategori'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $isbn = $_POST['isbn'];
    $rak = $_POST['rak'];
    $jumlah = $_POST['jumlah'];
    
    

    $query = mysqli_query($koneksi, "INSERT INTO buku (id_buku, judul, id_kategori, pengarang, penerbit, tahun, isbn, rak, jumlah) 
              VALUES ('$id_buku', '$judul', '$id_kategori', '$pengarang', '$penerbit', '$tahun', '$isbn', '$rak', '$jumlah')");
            if ($query) {
                // Inputan berhasil disimpan
               // echo "<script language='JavaScript'>alert('Data Berhasil Disimpan');document.location='tampil_buku.php';</script>";
                echo "<script language='JavaScript'>alert('Data Berhasil Disimpan');document.location='whatsapp_buku.php?calling_page=klik_bukuBaru&id_buku=$id_buku&judul=$judul&rak=$rak&pengarang=$pengarang&penerbit=$penerbit&tahun=$tahun&jumlah=$jumlah';</script>";
            } else {
                // Menangani kesalahan
                echo "Gagal menyimpan data: " . mysqli_error($koneksi);
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
        <title>Tambah Data Buku</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    < <?php include("../petugas/navbar.php"); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Buku</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Buku
                            </div>
                            <div class="card-body">
                                    
                                <form action="" method="post"> 
                                    <?php

                                    $kd_bku = mysqli_query($koneksi, "SELECT max(id_buku) as kodeTerbesar FROM buku");
                                    $data_bku = mysqli_fetch_array($kd_bku);
                                    $kodeBuku = $data_bku['kodeTerbesar'];
                                    $urutan = (int) substr($kodeBuku, 3, 3);
                                    $urutan++;

                                    $huruf = "BKU";
	                                $kodeBuku = $huruf . sprintf("%03s", $urutan);

                                    ?>
                                    <label for="" class="mb-1"><strong>Kode Buku</strong></label>
                                    <input name="id_bukuKeluar" class="form-control form-control-sm" type="text" disabled value="<?php echo $kodeBuku ?>" aria-label=".form-control-sm example">
                                    <input name="id_buku" class="form-control form-control-sm" type="hidden" value="<?php echo $kodeBuku ?>" aria-label=".form-control-sm example">
                                    
                                    <label for="" class="mb-1 mt-1"><strong>Judul Buku</strong></label>
                                    <input name="judul" class="form-control form-control-sm" type="text" placeholder="Masukkan Judul Buku" aria-label=".form-control-sm example" required>
                                    
                                    <label for="" class="mb-1 mt-1"><strong>Kategori</strong></label>
                                    <br>
                                    <select name="id_kategori" class="form-select" aria-label="Default select example" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php
                                        $tampilkategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                                        while ($datakategori = mysqli_fetch_array($tampilkategori)) {
                                            $id_kategori = $datakategori['id_kategori'];
                                            $kategori = $datakategori['kategori'];
                                            
                                        ?>
                                        <option value="<?php echo $id_kategori ?>"><?php echo $kategori?></option>

                                        <?php } ?>
                                    </select>
                                
                                    <label for="" class="mb-1 mt-1"><strong>Pengarang</strong></label>
                                    <input name="pengarang" class="form-control form-control-sm" type="text" placeholder="Masukkan Pengarang" aria-label=".form-control-sm example" required>
                                    
                                    <label for="" class="mb-1 mt-1"><strong>Penerbit</strong></label>
                                    <input name="penerbit" class="form-control form-control-sm" type="text" placeholder="Masukkan Penerbit" aria-label=".form-control-sm example" required>
                                    
                                    <label for="" class="mb-1 mt-1"><strong>Tahun</strong></label>
                                    <input name="tahun" class="form-control form-control-sm" type="text" placeholder="Masukkan Tahun Terbit" aria-label=".form-control-sm example" required>
                                    
                                    <label for="" class="mb-1 mt-1"><strong>ISBN</strong></label>
                                    <input name="isbn" class="form-control form-control-sm" type="text" placeholder="Masukkan Kode ISBN" aria-label=".form-control-sm example" required>
                                    
                                    <label for="" class="mb-1 mt-1"><strong>Rak</strong></label>
                                    <input name="rak" class="form-control form-control-sm" type="text" placeholder="Masukkan Rak" aria-label=".form-control-sm example" required>
                                    
                                    <label for="" class="mb-1 mt-1"><strong>Jumlah</strong></label>
                                    <input name="jumlah" class="form-control form-control-sm" type="text" placeholder="Masukkan Jumlah" aria-label=".form-control-sm example" required>
                                    
                                    <a href="tampil_buku.php" ><input type="submit" name="submit" value="Simpan" class="btn btn-primary mt-1"></a>
                                    <input type="reset" name="reset" value="Reset" class="btn btn-secondary mt-1">
                                    <a href="tampil_buku.php"><input type="button" name="submit" value="Batal" class="btn btn-danger mt-1"></a>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>
