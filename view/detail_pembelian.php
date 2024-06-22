<?php
include_once '../class/pembelian.php';  //menyertakan file pembelian.php
$pembelian = new Pembelian();              //membuat objek dari class Pembelian()

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

if(isset($_GET['idPembelian']))
{
    //mendekode idBarang yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar idBarang yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['idPembelian']);
}

$getID = $pembelian->getIDPembelian($id);
$row = mysqli_fetch_assoc($getID)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembelian</title>

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
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <a class="btn btn-dark float-start" href='halaman_utama.php'>Halaman Utama</a>
                                </div>
                                <div class="col-6">
                                    <h2 class="text-center"><?=$row['idPembelian']?></h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='data_pembelian.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kuantitas</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    //menampilkan semua data dengan while
                                        $tampil = $pembelian->tampilPembelian();
                                        $no=1;
                                        if($tampil)
                                        {
                                            while($row = mysqli_fetch_assoc($tampil)){
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['idBarang']; ?></td>
                                                    <td><?php echo $row['namaBarang']; ?></td>
                                                    <td><?php echo $row['kuantitas']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</body>
</html>