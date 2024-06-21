<?php
include_once '../class/barang.php';  //menyertakan file barang.php
$barang = new Barang();              //membuat objek dari class Barang()
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

if(isset($_GET['idBarang']))
{
    //mendekode idBarang yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar idBarang yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['idBarang']);
    $bagian = $user['bagian'];
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
    <title>Edit Barang</title>

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
                                <?php
                                if($bagian == 'Bos'){ ?>
                                    <a class="btn btn-dark float-start" href='../view/halaman_utama.php'>Halaman Utama</a>
                                <?php }else if($bagian == 'Penjualan'){ ?>
                                    <a class="btn btn-dark float-start" href='../view/halaman_utama_penj.php'>Halaman Utama</a>
                                <?php }else if($bagian == 'Gudang'){ ?>
                                    <a class="btn btn-dark float-start" href='../view/halaman_utama_gudang.php'>Halaman Utama</a>
                                <?php }else{
                                    echo 'Bagian Tidak Dikenali!';
                                }
                                ?>
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
                                                <label for="input_id_barang" class="form-label">ID</label>
                                                <input type="text" class="form-control" name="idBarang" value="<?=$row['idBarang']?>" required readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_nama_barang" class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="namaBarang" value="<?=$row['namaBarang']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_jenis_barang" class="form-label">Jenis</label>
                                                <select type="text" class="form-control" name="jenisBarang" value="<?=$row['jenisBarang']?>" required>
                                                    <option value="">Pilih Jenis</option>
                                                    <option value="Ori">Ori</option>
                                                    <option value="Non Ori">Non Ori</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_merk" class="form-label">Merk</label>
                                                <input type="text" class="form-control" name="merk" value="<?=$row['merk']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_satuan" class="form-label">Satuan</label>
                                                <select type="text" class="form-control" name="satuan" value="<?=$row['satuan']?>" required>
                                                    <option value="">Pilih Satuan</option>
                                                    <option value="PCS">PCS</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_stok" class="form-label">Stok</label>
                                                <input type="number" class="form-control" name="stok" value="<?=$row['stok']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_harga_beli" class="form-label">Harga Beli</label>
                                                <input type="number" class="form-control" name="hargaBeli" value="<?=$row['hargaBeli']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_harga_jual" class="form-label">Harga Jual</label>
                                                <input type="number" class="form-control" name="hargaJual" value="<?=$row['hargaJual']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_id_supplier" class="form-label">Supplier</label>
                                                <select class="form-control" name="idSupplier" required>
                                                    <option value="">Pilih ID Supplier</option>
                                                    <?php
                                                    //karena data idSupplier di form transaksi ini diambil dari tb supplier
                                                    //maka query dari supplier di-select dahulu sebagai berikut
                                                        $query = "SELECT * FROM supplier";
                                                        $hasil = $db->fetchID($query);

                                                        while($row = mysqli_fetch_array($hasil))
                                                        { 
                                                            //data idSupplier ditampilkan dengan while dalam option select
                                                            $idSupplier = $row['idSupplier'];  //untuk menampilkan idSupplier dalam option
                                                            $namaSupplier = $row['namaSupplier'];     //untuk menampilkan namaSupplier dalam option
                                                            ?>
                                                            <option value="<?=$idSupplier?>"> <?= $namaSupplier ?> (ID: <?=$idSupplier?>) </option>;
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
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