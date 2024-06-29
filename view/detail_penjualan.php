<?php
include_once '../class/penjualan.php';  //menyertakan file penjualan.php
$penjualan = new Penjualan();              //membuat objek dari class Penjualan()

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
    $bagian = $user['bagian'];
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

if(isset($_GET['idPenjualan']))
{
    //mendekode idPenjualan
    //tujuan dekode agar idPenjualan yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['idPenjualan']);
}

//fetch idPenjualan row tertentu
$getID = $penjualan->getIDPenjualan($id);
$row = mysqli_fetch_assoc($getID)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan</title>

    <!-- untuk menyambungkan file css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body class="bg-dark">
    <div class="container-fluid" style="padding: 60px;">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
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
                                    <h2 class="text-center"><?=$row['idPenjualan']?></h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='data_penjualan.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered table-responsive w-100 d-block d-md-table">
                                <thead>
                                    <tr class="text-center" style="background-color: #F5F5F5;">
                                        <th>No</th>
                                        <th>ID Barang</th>
                                        <th>Supplier</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Jual</th>
                                        <th>Kuantitas</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                        $id = $row['idPenjualan'];
                                        $tampil = mysqli_query($db->konek(), "SELECT barang.idBarang, namaSupplier, namaBarang, 
                                        hargaJual, sum(kuantitas) as kuantitas, sum(kuantitas)*hargaJual as tot
                                                    FROM penjualan INNER JOIN detail_penjualan 
                                                    ON detail_penjualan.idPenjualan = penjualan.idPenjualan 
                                                    INNER JOIN barang
                                                    ON barang.idBarang = detail_penjualan.idBarang
                                                    INNER JOIN supplier
                                                    ON supplier.idSupplier = barang.idSupplier
                                                    WHERE penjualan.idPenjualan = '$id'
                                                    GROUP BY idBarang
                                                    ORDER BY penjualan.idPenjualan
                                                    ");
                                        $no=1;
                                        $totalKuantitas = 0;
                                        $total = 0;
                                        while($row = mysqli_fetch_assoc($tampil)){
                                            $totalKuantitas += $row['kuantitas'];
                                            $total += $row['tot'];
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row['idBarang']; ?></td>
                                                <td><?php echo $row['namaSupplier']; ?></td>
                                                <td><?php echo $row['namaBarang']; ?></td>
                                                <td><?php echo 'Rp ' . number_format($row['hargaJual'],2,',','.'); ?></td>
                                                <td><?php echo $row['kuantitas']; ?></td>
                                                <td><?php echo 'Rp ' . number_format($row['tot'],2,',','.'); ?></td>
                                            </tr>
                                        <?php
                                        }
                                        
                                        ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-center">Total</th>
                                        <th class="text-center">
                                            <?php 
                                                echo $totalKuantitas; 
                                            ?>
                                        </th>
                                        <th class="text-center">
                                            <?php 
                                                echo 'Rp ' . number_format($total,2,',','.');; 
                                            ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>