<?php
require '../koneksi.php';  //menyertakan koneksi.php

if(isset($_SESSION["id"]))
{
    header("Location: ../view/halaman_utama.php");
}

$register = new Register();
?>

<!doctype html>
<html>

<head>
    <title>Registrasi Ayamkoe</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body class="bg-dark">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <br /><br />
                <div class="card">
                    <?php
                    //dieksekusi jika pengguna menekan tombol register (submit)
                    if (isset($_POST["submit"])) {
                        $hasil = $register->registrasi($_POST["nama_pengguna"], $_POST["username"], $_POST["bagian"], $_POST["password"], $_POST["cpassword"]);
                        //pemeriksaan register pengguna, data dari form dimasukkan ke class Register() --> buka koneksi.php

                        if ($hasil == 1) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Registrasi Berhasil</h6>
                                </strong>
                            </div>
                        <?php } elseif ($hasil == 10) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Username Telah Ada</h6>
                                </strong>
                            </div>
                        <?php } elseif ($hasil == 100) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Password Tidak Cocok</h6>
                                </strong>
                            </div>
                        <?php }
                    }
                    ?>
                    <div class="card-header">
                        <h4 class="card-title text-center">Register</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" autocomplete="off">
                            <div class="form-group">
                                <label>Nama</label>
                                <input name="nama_pengguna" class="form-control" type="text" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <label>Username</label>
                                <input name="username" class="form-control" type="text" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <label>Bagian</label>
                                <select class="form-control" name="bagian" required>
                                    <option value="">Pilih Bagian</option>
                                    <option value="Bos">Bos</option>
                                    <option value="Penjualan">Penjualan</option>
                                    <option value="Gudang">Gudang</option>
                                </select> 
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <label>Password</label>
                                <input name="password" class="form-control" type="password" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input name="cpassword" class="form-control" type="password" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="row">
                                <div class="col">
                                    <input type="submit" name="submit" value="Register"
                                        class="btn btn-success form-control">
                                </div>
                                <div class="col">
                                    <input class="btn btn-danger form-control" type="reset" value="Reset">
                                </div>
                            </div> <!-- form-group// -->
                            <br>
                            <div class="form-group text-center">
                                <a href="../index.php"> Kembali ke Halaman Login? </a>
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