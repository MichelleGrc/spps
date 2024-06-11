<?php
include_once '../class/info_pelanggan.php';  //menyertakan file info_pelanggan.php
$infopel = new InfoPelanggan();              //membuat objek dari class InfoPelanggan()

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

if(isset($_GET['id_pelanggan']))
{
    //mendekode id_pelanggan yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar id_pelanggan yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['id_pelanggan']);
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $editInfopel = $infopel->editInfoPelanggan($_POST, $id); //menggunakan method editInfoPelanggan()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Informasi Pelanggan</title>

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
                            if(isset($editInfopel)){
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$editInfopel?></h2>
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
                                    <h2 class="text-center">EDIT INFORMASI</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_info_pelanggan.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            //menampilkan semua data dengan while
                            $getID = $infopel->getIDPelanggan($id);
                            if($getID)
                            {
                                while($row = mysqli_fetch_assoc($getID)){
                                    ?>
                                        <form action="" method="post" name="form_edit_infopel" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="input_id_pelanggan" class="form-label">ID Pelanggan</label>
                                                <input type="text" class="form-control" name="id_pelanggan" value="<?=$row['id_pelanggan']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                                <input type="text" class="form-control" name="nama_pelanggan" value="<?=$row['nama_pelanggan']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_alamat" class="form-label">Alamat</label>
                                                <input type="text" class="form-control" name="alamat" value="<?=$row['alamat']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_no_telp" class="form-label">No. Telp</label>
                                                <input type="number" class="form-control" name="no_telp" value="<?=$row['no_telp']?>" required>
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