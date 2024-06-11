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

if(isset($_GET['id_barang']))
{
    //mendekode id_barang yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar id_barang yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['id_barang']);
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $editBarang = $barang->editBarang($_POST, $id);  //menggunakan method editBarang()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang Ayamkoe</title>

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
                            //muncul alert dengan pesan berhasil atau tidaknya proses edit
                            if(isset($editBarang)){
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$editBarang?></h2>
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
                                    <h2 class="text-center">EDIT BARANG</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_barang.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            //menampilkan semua data dengan while
                            $getID = $barang->getIDBarang($id);
                            if($getID)
                            {
                                while($row = mysqli_fetch_assoc($getID)){
                                    ?>
                                        <form action="" method="post" name="form_edit_barang" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="input_harga_beli" class="form-label">ID Barang</label>
                                                <input type="text" class="form-control" name="id_barang" value="<?=$row['id_barang']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_nama_barang" class="form-label">Nama Barang</label>
                                                <input type="text" class="form-control" name="nama_barang" value="<?=$row['nama_barang']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_harga_beli" class="form-label">Harga Beli</label>
                                                <input type="number" class="form-control" name="harga_beli" value="<?=$row['harga_beli']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_harga_jual" class="form-label">Harga Jual</label>
                                                <input type="number" class="form-control" name="harga_jual" value="<?=$row['harga_jual']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_satuan_barang" class="form-label">Satuan Barang</label>
                                                <select type="text" class="form-control" name="satuan_barang" value="<?=$row['satuan_barang']?>" required>
                                                    <option value="">Pilih Satuan</option>
                                                    <option value="PCS">PCS</option>
                                                    <option value="KG">KG</option>
                                                    <option value="Ekor">Ekor</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_stok" class="form-label">Stok</label>
                                                <input type="number" class="form-control" name="stok" value="<?=$row['stok']?>" required>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="submit" value="Edit" class="btn btn-success form-control">
                                                </div>                    
                                            </div>
                                        </form>
                                    <?php
                                }
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</body>
</html>