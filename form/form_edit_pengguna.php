<?php
include_once '../class/pengguna.php';     //menyertakan file pengguna.php
$pengguna = new Pengguna();              //membuat objek dari class Pengguna()
$db = new Koneksi();

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
    $bagian = $user['bagian'];
    if($bagian !== 'Bos'){
        header("Location: ../index.php");
    }
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

if(isset($_GET['idPengguna']))
{
    //mendekode idPengguna yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar idPengguna yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['idPengguna']);
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $editPengguna = $pengguna->editPengguna($_POST, $id);  //menggunakan method editPengguna()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>

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
                            if(isset($editPengguna)){
                                echo "<script>alert('$editPengguna');
                                document.location='../view/data_pengguna.php'</script>";
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
                                    <h2 class="text-center">EDIT PENGGUNA</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_pengguna.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            //menampilkan semua data dengan while
                            $getID = $pengguna->getIDPengguna($id);
                            if($getID)
                            {
                                while($row = mysqli_fetch_assoc($getID)){
                                    ?>
                                        <form action="" method="post" name="form_edit_pengguna" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="input_id_pengguna" class="form-label">ID</label>
                                                <input type="text" class="form-control" name="idPengguna2" value="<?=$row['idPengguna']?>" disabled>
                                                <input type="hidden" class="form-control" name="idPengguna" value="<?=$row['idPengguna']?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_nama_pengguna" class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="namaPengguna" value="<?=$row['namaPengguna']?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_bagian" class="form-label">Bagian</label>
                                                <select class="form-control" name="bagian" required>
                                                    <option value="" <?php if ($row['bagian'] == 'PCS') echo ' selected="selected"'?>>Pilih Bagian</option>
                                                    <option value="Bos" <?php if ($row['bagian'] == 'Bos') echo ' selected="selected"'?>>Bos</option>
                                                    <option value="Penjualan" <?php if ($row['bagian'] == 'Penjualan') echo ' selected="selected"'?>>Penjualan</option>
                                                    <option value="Gudang" <?php if ($row['bagian'] == 'Gudang') echo ' selected="selected"'?>>Gudang</option>
                                                </select> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="input_username" class="form-label">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?=$row['username']?>" required>
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