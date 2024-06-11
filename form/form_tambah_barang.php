<?php
include_once '../class/barang.php';  //menyertakan file barang.php
$barang = new Barang();              //membuat objek dari class Barang()

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
    $tambahBarang = $barang->tambahBarang($_POST);   //menggunakan method tambahBarang()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

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
                            if(isset($tambahBarang)){
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$tambahBarang?></h2>
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
                                    <h2 class="text-center">TAMBAH BARANG</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_barang.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" name="form_tambah_barang" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="input_id_barang" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="id_barang" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_nama_barang" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_barang" required>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <label for="input_jenis_barang" class="form-label">Jenis</label>
                                            <input type="text" class="form-control" name="jenis_barang" required>  
                                        </div>
                                        <div class="col">
                                            <label for="input_merk_barang" class="form-label">Merk</label>
                                            <input type="text" class="form-control" name="merk_barang" required>   
                                        </div>                                
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <label for="input_satuan_barang" class="form-label">Satuan</label>
                                            <select type="text" class="form-control" name="satuan_barang" required>
                                                <option value="">Pilih Satuan</option>
                                                <option value="PCS">PCS</option>
                                            </select> 
                                        </div>
                                        <div class="col">
                                            <label for="input_nama_barang" class="form-label">Stok</label>
                                            <input type="text" class="form-control" name="nama_barang" required> 
                                        </div>                                
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <label for="input_harga_beli" class="form-label">Harga Beli</label>
                                            <input type="number" class="form-control" name="harga_beli" required>
                                        </div>
                                        <div class="col">
                                            <label for="input_harga_jual" class="form-label">Harga Jual</label>
                                            <input type="number" class="form-control" name="harga_jual" required>
                                        </div>                                
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="submit" value="Submit" class="btn btn-success form-control">
                                    </div>
                                    <div class="col">
                                        <input class="btn btn-danger form-control" type="reset" value="Reset">
                                    </div>                                
                                </div>
                                <div class="mb-3">
                                    <label for="input_id_pelanggan" class="form-label">ID Supplier</label>
                                    <select class="form-control" name="id_pelanggan" required>
                                        <option value="">Pilih ID Supplier</option>
                                        <?php
                                            $query = "SELECT * FROM supplier";
                                            $hasil = $db->fetchID($query);
                                            
                                            while($row = mysqli_fetch_array($hasil))
                                            { 
                                                $id_pelanggan = $row['idSupplier'];
                                                ?>
                                                <option value="<?=$id_pelanggan?>"> <?=$id_pelanggan?> </option>;
                                            <?php
                                            }
                                        ?>
                                    </select>
                                </div>

                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</body>
</html>