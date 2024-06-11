<?php
include_once '../class/transaksi.php';  //menyertakan file transaksi.php
$transaksi = new Transaksi();           //membuat objek dari class Transaksi()
$db = new Koneksi();

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $tambahTransaksi = $transaksi->tambahTransaksi($_POST);  //menggunakan method tambahTransaksi()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi Ayamkoe</title>

    <!-- untuk menyambungkan file css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body class="bg-dark">
    <br><br>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                        <?php
                            //muncul alert dengan pesan berhasil atau tidaknya proses tambah
                            if(isset($tambahTransaksi)){
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$tambahTransaksi?></h2>
                                    </strong>
                                </div>
                            <?php
                            }
                        ?>
                        
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <a class="btn btn-dark float-start" href='../view/halaman_utama.php'>Halaman Utama</a>
                                </div>
                                <div class="col-6">
                                    <h2 class="text-center">TAMBAH TRANSAKSI</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_transaksi.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" name="form_tambah_transaksi" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="input_id_transaksi" class="form-label">ID Transaksi</label>
                                    <input type="text" class="form-control" name="id_transaksi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                                    <input type="date" class="form-control" name="tanggal_transaksi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_id_pelanggan" class="form-label">ID Pelanggan</label>
                                    <select class="form-control" name="id_pelanggan" required>
                                        <option value="">Pilih ID Pelanggan</option>
                                        <?php
                                            $query = "SELECT * FROM tb_pelanggan";
                                            $hasil = $db->fetchID($query);
                                            
                                            while($row = mysqli_fetch_array($hasil))
                                            { 
                                                $id_pelanggan = $row['id_pelanggan'];
                                                ?>
                                                <option value="<?=$id_pelanggan?>"> <?=$id_pelanggan?> </option>;
                                            <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="input_id_barang" class="form-label">ID Barang</label>
                                    <select class="form-control" name="id_barang" required>
                                        <option value="">Pilih ID Barang</option>
                                        <?php
                                            $query = "SELECT * FROM tb_barang";
                                            $hasil = $db->fetchID($query);

                                            while($row = mysqli_fetch_array($hasil))
                                            { 
                                                $id_barang = $row['id_barang'];   
                                                $stok = $row['stok'];    
                                                ?>
                                                <option value="<?=$id_barang?>"> <?= $id_barang ?> (Stok: <?=$stok?>) </option>;
                                            <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="input_jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="submit" value="Submit" class="btn btn-success form-control">
                                    </div>
                                    <div class="col">
                                        <input class="btn btn-danger form-control" type="reset" value="Reset">
                                    </div>                                
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>