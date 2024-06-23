<?php
include_once '../class/pengguna.php';     //menyertakan file pengguna.php
$pengguna = new Pengguna();              //membuat objek dari class Pengguna()
$db = new Koneksi();
$idP = $_GET['idPengguna'];

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
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
    $bagian = $user['bagian'];
    if($bagian !== 'Bos'){
        header("Location: ../index.php");
    }
}

$ubahPass = new UbahPass(); //object untuk class UbahPass() dari koneksi.php
?>

<!doctype html>
<html>

<head>
    <title>Ubah Password</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body class="bg-dark">
    <br><br>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-5">
                <div class="card">
                <?php
                //dieksekusi jika pengguna menekan tombol ubah (submit)
                    if (isset($_POST["submit"])) {
                        $hasil = $ubahPass->ubahPass($_POST["id"], $_POST["pass_lama"], $_POST["pass_baru"], $_POST["cpass_baru"]);
                        //pemeriksaan ubah password pengguna, data dari form dimasukkan ke class UbahPass() --> buka koneksi.php

                        if ($hasil == 1) { 
                            echo "<script>alert('Password Berhasil Diubah!');
                            document.location='../view/data_pengguna.php'</script>";
                            ?>
                            <!-- <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Ubah Password Berhasil</h6>
                                </strong>
                            </div> -->
                        <?php } elseif ($hasil == 10) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Password Baru Tidak Cocok</h6>
                                </strong>
                            </div>
                        <?php } elseif ($hasil == 100) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Password Lama Salah</h6>
                                </strong>
                            </div>
                        <?php } elseif ($hasil == 1000) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Username Tidak Ditemukan</h6>
                                </strong>
                            </div>
                        <?php }
                    }
                    ?>
                    <div class="card-header">
                            <div >
                                <h2 class="text-center">UBAH PASSWORD</h2>
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
                            <form method="post" autocomplete="off">
                                <div class=" mb-3">
                                    <label>ID</label>
                                    <input name="id2" class="form-control" type="text" required="required"
                                        autocomplete="off" value="<?=$row['idPengguna']?>" disabled>
                                    <input name="id" class="form-control" type="hidden" required="required"
                                    value="<?=$row['idPengguna']?>">
                                </div> <!-- form-group// -->    
                                <div class="mb-3">
                                    <label>Username</label>
                                    <input name="namaPengguna2" class="form-control" type="text" required="required"
                                        autocomplete="off" value="<?=$row['namaPengguna']?>" disabled>
                                    <input name="namaPengguna" class="form-control" type="hidden" required="required"
                                        autocomplete="off" value="<?=$row['namaPengguna']?>" >
                                </div> <!-- form-group// -->
                                <div class="mb-3">
                                    <label>Password Lama</label>
                                    <input name="pass_lama" class="form-control" type="password" required="required"
                                        autocomplete="off" >
                                </div> <!-- form-group// -->
                                <div class="mb-3">
                                    <label>Password Baru</label>
                                    <input name="pass_baru" class="form-control" type="password" required="required"
                                        autocomplete="off" >
                                </div> <!-- form-group// -->
                                <div class="mb-3">
                                    <label>Konfirmasi Password Baru</label>
                                    <input name="cpass_baru" class="form-control" type="password" required="required"
                                        autocomplete="off">
                                </div> <!-- form-group// -->
                                <div class="row">
                                    <div class="col">
                                        <input type="submit" name="submit" value="Ubah"
                                            class="btn btn-success form-control">
                                    </div>
                                    <div class="col">
                                        <input class="btn btn-danger form-control" type="reset" value="Reset">
                                    </div>
                                </div> <!-- form-group// -->
                                <br>
                                <div class="form-group text-center">
                                <?php
                                if($bagian == 'Bos'){ ?>
                                    <a href="../view/halaman_utama.php"> Kembali ke Halaman Utama </a>
                                <?php }else if($bagian == 'Penjualan'){ ?>
                                    <a href="../view/halaman_utama_penj.php"> Kembali ke Halaman Utama </a>
                                <?php }else if($bagian == 'Gudang'){ ?>
                                    <a href="../view/halaman_utama_gudang.php"> Kembali ke Halaman Utama </a>
                                <?php }else{
                                    echo 'Bagian Tidak Dikenali!';
                                }
                                ?>
                                </div>
                                <div class="form-group text-center">
                                    <a href='../view/data_pengguna.php'> Kembali ke Data Pengguna </a>
                                </div> 
                            </form>
                         <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        </div>
        <br><br>
</body>

</html>