<?php
include_once '../class/info_pelanggan.php';  //menyertakan file info_pelanggan.php
$infopel = new InfoPelanggan();              //membuat objek dari class InfoPelanggan()

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

if(isset($_GET['hapus_infopel']))
{
    //mendekode id_pelanggan yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar id_pelanggan yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['hapus_infopel']);
    $hapusInfoPel = $infopel->hapusInfoPelanggan($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Ayamkoe</title>

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
                        if(isset($hapusInfoPel))
                        { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    <h6 class="text-center"><?=$hapusInfoPel?></h2>
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
                                    <h2 class="text-center">INFORMASI PELANGGAN</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../form/form_tambah_infopel.php'>Tambah Informasi Pelanggan</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>ID Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat</th>
                                        <th>No. Telp</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    //menampilkan semua data dengan while
                                        $tampil = $infopel->tampilInfoPelanggan();
                                        $no=1;
                                        if($tampil)
                                        {
                                            while($row = mysqli_fetch_assoc($tampil)){
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['id_pelanggan']; ?></td>
                                                    <td><?php echo $row['nama_pelanggan']; ?></td>
                                                    <td><?php echo $row['alamat']; ?></td>
                                                    <td><?php echo $row['no_telp']; ?></td>
                                                    <td>
                                                        <a class="btn btn-warning" href="../form/form_edit_infopel.php?id_pelanggan=<?php echo base64_encode($row['id_pelanggan'])?>">Edit</a>
                                                        <a class="btn btn-danger" href="?hapus_infopel=<?=base64_encode($row['id_pelanggan'])?>" 
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