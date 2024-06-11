<?php
require 'koneksi.php'; //menyertakan koneksi.php
// if(isset($_SESSION["id"]))
// {
//     //jika login berhasil, pengguna akan dipindahkan ke halaman utama
//     header("Location: view/halaman_utama.php");  
// }

$login = new Login(); //membuat object untuk class Login()
?>

<!doctype html>
<html>

<head>
    <title>Login</title>
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
                    //dieksekusi jika pengguna menekan tombol login (submit)
                    if (isset($_POST["submit"])) {
                        $hasil = $login->login($_POST["username"], $_POST["password"]);
                        //pemeriksaan login pengguna, data dari form dimasukkan ke class Login() --> buka koneksi.php
                    
                        if ($hasil == 11) {
                            $_SESSION["login"] = true;
                            $_SESSION["id"] = $login->idUser();
                            header("Location: view/halaman_utama.php");
                            exit();
                        } elseif ($hasil == 12) {
                            $_SESSION["login"] = true;
                            $_SESSION["id"] = $login->idUser();
                            header("Location: view/halaman_utama_penj.php");
                            exit();
                        } elseif ($hasil == 13) {
                            $_SESSION["login"] = true;
                            $_SESSION["id"] = $login->idUser();
                            header("Location: view/halaman_utama_gudang.php");
                            exit();
                        } elseif ($hasil == 14) {?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Role Tidak Dikenali</h6>
                                </strong>
                            </div>
                        <?php } elseif ($hasil == 10) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Password Salah</h6>s
                                </strong>
                            </div>
                        <?php } elseif ($hasil == 100) { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center">Username Tidak Ditemukan</h6>
                                </strong>
                            </div>
                        <?php }
                    }
                    ?>
                    
                    <div class="card-header">
                        <h4 class="card-title text-center">Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" autocomplete="off">
                            <div class="form-group">
                                <label>Username</label>
                                <input name="username" class="form-control" type="text" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <label>Password</label>
                                <input name="password" class="form-control" type="password" required="required"
                                    autocomplete="off">
                            </div> <!-- form-group// -->
                            <div class="row">
                                <div class="col">
                                    <input type="submit" name="submit" value="Login"
                                        class="btn btn-success form-control">
                                </div>
                                <div class="col">
                                    <input class="btn btn-danger form-control" type="reset" value="Reset">
                                </div>
                            </div> <!-- form-group// -->
                            <br>
                            <div class="form-group text-center">
                                <a href="form/form_registrasi.php"> Belum Memiliki Akun? </a>
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