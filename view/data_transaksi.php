<?php
include_once '../class/transaksi.php';  //menyertakan file transaksi.php
$transaksi = new Transaksi();           //membuat objek dari class Transaksi()

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

if(isset($_GET['hapus_transaksi']))
{
    //mendekode id_transaksi yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar id_transaksi yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['hapus_transaksi']);
    $hapusTransaksi = $transaksi->hapusTransaksi($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Ayamkoe</title>

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
                        <?php
                        //muncul alert dengan pesan berhasil atau tidaknya proses hapus
                        if(isset($hapusTransaksi))
                        { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center"><?=$hapusTransaksi?></h2>
                                </strong>
                            </div>
                        <?php }
                        ?>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <a class="btn btn-dark float-start" href='../view/halaman_utama.php'>Halaman Utama</a>
                                </div>
                                <div class="col-6">
                                    <h2 class="text-center">DATA TRANSAKSI</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../form/form_tambah_transaksi.php'>Tambah Transaksi</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>ID Transaksi</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>ID Pelanggan</th>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    //menampilkan semua data dengan while
                                        $tampil = $transaksi->tampilTransaksi();
                                        $no=1;
                                        if($tampil)
                                        {
                                            while($row = mysqli_fetch_assoc($tampil)){
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['id_transaksi']; ?></td>
                                                    <td><?php echo $row['tanggal_transaksi']; ?></td>
                                                    <td><?php echo $row['id_pelanggan']; ?></td>
                                                    <td><?php echo $row['id_barang']; ?></td>
                                                    <td><?php echo $row['nama_barang']; ?></td>
                                                    <td><?php echo 'Rp ' . number_format($row['harga_beli'],2,',','.')?></td>
                                                    <td><?php echo 'Rp ' . number_format($row['harga_jual'],2,',','.')?></td>
                                                    <td><?php echo $row['jumlah']; ?></td>
                                                    <td><?php echo 'Rp ' . number_format(($row['harga_jual'] * $row['jumlah']),2,',','.')?></td>
                                                    <td>
                                                        <a class="btn btn-warning" href="../form/form_edit_transaksi.php?id_transaksi=<?php echo base64_encode($row['id_transaksi'])?>">Edit</a>
                                                        <a class="btn btn-danger" href="?hapus_transaksi=<?=base64_encode($row['id_transaksi'])?>" 
                                                        onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?')">Hapus</a>
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