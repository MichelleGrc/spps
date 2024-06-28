<?php
require '../koneksi.php';  //menyertakan koneksi.php

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

//membuat kode custom
//menghubungkan ke tabel database
$db = new Koneksi();
//mengambil nilai tertinggi pada tabel penjualan
$sql = mysqli_query($db->konek(), 'select max(idPengguna) as maxID from pengguna');
$data = mysqli_fetch_array($sql);
$kode = $data['maxID'];
$urut = (int) substr($kode,2,5);
$urut++; //setiap nilai tertinggi $kode ditambah 1
$ket = 'PG';
$kodeauto = $ket . sprintf('%05s', $urut); //menyisipkan 3 karakter 0

$register = new Register();
?>

<!doctype html>
<html>

<head>
    <title>Tambah Pengguna</title>
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

                        if ($hasil == 1) { 
                            echo "<script>alert('Registrasi berhasil!');
                            document.location='../view/data_pengguna.php'</script>";
                            ?>
                        <?php } elseif ($hasil == 10) {
                            echo "<script>alert('Username telah ada!');
                            document.location='form_registrasi.php'</script>";
                            ?>
                        <?php } elseif ($hasil == 100) {
                            echo "<script>alert('Password tidak cocok!');
                            document.location='form_registrasi.php'</script>";
                            ?>
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
                    </div>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        </div>
        <br><br>
</body>

</html>