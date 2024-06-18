<?php
include_once '../class/pembelian.php';  //menyertakan file pembelian.php
$pembelian = new Pembelian();              //membuat objek dari class Pembelian()
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

if($_SERVER['REQUEST_METHOD']=='POST'){
    $tambahPembelian = $pembelian->tambahPembelian($_POST);   //menggunakan method tambahPembelian()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembelian</title>

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
                            //muncul alert dengan pesan berhasil atau tidaknya proses tambah
                            if(isset($tambahPembelian)){
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$tambahPembelian?></h2>
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
                                    <h2 class="text-center">TAMBAH PEMBELIAN</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_pembelian.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" name="form_tambah_pembelian" enctype="multipart/form-data">
                                <div class="mb-3">
                                <label for="input_id_pembelian" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="idPembelian" value="<?php echo $kodeauto ?>" readonly>
                                </div>
                                <?php
                                $sql = mysqli_query($koneksi, "select max(id) as maxID from pembelian");
                                $data = mysqli_fetch_array($sql);
                                
                                $kode = $data['maxID'];
                                
                                $kode++;
                                $ket = "BK";
                                $kodeauto = $ket . sprintf("%03s", $kode);
                                ?>
                                <div class="mb-3">
                                    <label for="input_tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                                    <input type="date" class="form-control" name="tanggalPembelian" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_foto_pembelian" class="form-label">Foto</label>
                                    <input type="text" class="form-control" name="fotoPembelian" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_kuantitas" class="form-label">Kuantitas</label>
                                    <input type="text" class="form-control" name="kuantitas" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="submit" value="Submit" class="btn btn-success form-control">
                                    </div>
                                    <div class="col">
                                        <input class="btn btn-danger form-control" type="reset" value="Reset">
                                    </div>                                
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</body>
</html>