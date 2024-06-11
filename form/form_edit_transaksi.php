<?php
include_once '../class/transaksi.php';     //menyertakan file transaksi.php
$transaksi = new Transaksi();              //membuat objek dari class Transaksi()
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

if(isset($_GET['id_transaksi']))
{
    //mendekode id_transaksi yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar id_transaksi yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['id_transaksi']);
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $editTransaksi = $transaksi->editTransaksi($_POST, $id);  //menggunakan method editTransaksi()
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
                            if(isset($editTransaksi)){
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$editTransaksi?></h2>
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
                                    <h2 class="text-center">EDIT TRANSAKSI</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_transaksi.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            //menampilkan semua data dengan while
                            $getID = $transaksi->getIDTransaksi($id);
                            if($getID)
                            {
                                while($row = mysqli_fetch_assoc($getID)){
                                    ?>
                                        <form action="" method="post" name="form_edit_transaksi" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="input_id_transaksi" class="form-label">ID Transaksi</label>
                                                <input type="text" class="form-control" name="id_transaksi" value="<?=$row['id_transaksi']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                                                <input type="date" class="form-control" name="tanggal_transaksi" value="<?=$row['tanggal_transaksi']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_id_pelanggan" class="form-label">ID Pelanggan</label>
                                                <select class="form-control" name="id_pelanggan" required>
                                                    <option value="">Pilih ID Pelanggan</option>
                                                    <?php
                                                    //karena data id_pelanggan di form transaksi ini diambil dari tb_pelanggan
                                                    //maka query dari tb_pelanggan di-select dahulu sebagai berikut
                                                        $query = "SELECT * FROM tb_pelanggan";
                                                        $hasil = $db->fetchID($query);
                                                        
                                                        while($row = mysqli_fetch_array($hasil))
                                                        { 
                                                            //data id_pelanggan ditampilkan dengan while dalam option select
                                                            $id_pelanggan = $row['id_pelanggan']; //untuk menampilkan id_pelanggan dalam option
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
                                                    //karena data id_barang di form transaksi ini diambil dari tb_barang
                                                    //maka query dari tb_barang di-select dahulu sebagai berikut
                                                        $query = "SELECT * FROM tb_barang";
                                                        $hasil = $db->fetchID($query);

                                                        while($row = mysqli_fetch_array($hasil))
                                                        { 
                                                            //data id_barang ditampilkan dengan while dalam option select
                                                            $id_barang = $row['id_barang'];  //untuk menampilkan id_barang dalam option
                                                            $stok = $row['stok'];            //untuk menampilkan stok dalam option
                                                            ?>
                                                            <option value="<?=$id_barang?>"> <?= $id_barang ?> (Stok: <?=$stok?>) </option>;
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_jumlah" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" name="jumlah" value=
                                                <?php
                                                //mengambil data jumlah dari tb_transaksi sesuai id_transaksi yang sedang diedit
                                                    $query = "SELECT * FROM tb_transaksi WHERE id_transaksi='$id'";
                                                    $hasil = $db->fetchID($query);
                                                    if($row = mysqli_fetch_array($hasil))
                                                    {
                                                        //menampilkan data jumlah dengan while
                                                        echo $row['jumlah'];
                                                    }
                                                ?>
                                                required>
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