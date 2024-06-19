<?php
include_once '../class/penjualan.php';      //menyertakan file penjualan.php
$penjualan = new Penjualan();              //membuat objek dari class Penjualan()

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>

    <!-- untuk menyambungkan file css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body class="bg-dark">
    <br><br>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <a class="btn btn-dark float-start" href='../view/halaman_utama.php'>Halaman Utama</a>
                                </div>
                                <div class="col-6">
                                    <h2 class="text-center">DATA PENJUALAN</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../form/form_tambah_penjualan.php'>Tambah Penjualan</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Pengguna</th>
                                        <th>Tanggal Penjualan</th>
                                        <th>Barang</th>
                                        <th>Kuantitas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    //menampilkan semua data dengan while
                                        $tampil = $penjualan->tampilPenjualan();
                                        $no=1;
                                        if($tampil)
                                        {
                                            while($row = mysqli_fetch_assoc($tampil)){
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['idPenjualan']; ?></td>
                                                    <td><?php echo $row['namaPengguna']; ?></td>
                                                    <td><?php echo $row['tanggalPenjualan']; ?></td>
                                                    <td><?php echo $row['namaBarang']; ?></td>
                                                    <td><?php echo $row['kuantitas']; ?></td>
                                                    <td>
                                                        <a class="btn btn-warning" href="../detail_penjualan.php?idPenjualan=<?php echo base64_encode($row['idPenjualan'])?>">Detail</a>
                                                    </td>
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