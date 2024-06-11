<?php
require '../koneksi.php';  //menyertakan koneksi.php

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
}else{
     //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

$ubahPass = new UbahPass(); //object untuk class UbahPass() dari koneksi.php
?>

<!doctype html>
<html>

<head>
    <title>Ubah Password Ayamkoe</title>
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
                        $hasil = $ubahPass->ubahPass($_POST["username"], $_POST["pass_lama"], $_POST["pass_baru"], $_POST["cpass_baru"]);
                        //pemeriksaan ubah password pengguna, data dari form dimasukkan ke class UbahPass() --> buka koneksi.php

                        if ($hasil == 1) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Ubah Password Berhasil</h6>
                                </strong>
                            </div>
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
                        <h4 class="card-title text-center">Ubah Password</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" autocomplete="off">
                            <div class="form-group">
                                <label>Username</label>
                                <input name="username" class="form-control" type="text" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <label>Password Lama</label>
                                <input name="pass_lama" class="form-control" type="password" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input name="pass_baru" class="form-control" type="password" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="form-group">
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
                                <a href="../view/halaman_utama.php"> Kembali ke Halaman Utama </a>
                            </div> <!-- form-group//-->
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        </div>
        <br><br>
</body>

</html>