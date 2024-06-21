<?php
include_once '../class/penjualan.php';  //menyertakan file penjualan.php
$penjualan = new Penjualan();              //membuat objek dari class Penjualan()

//membuat kode custom
//menghubungkan ke tabel database
$db = new Koneksi();
//mengambil nilai tertinggi pada tabel penjualan
$sql = mysqli_query($db->konek(), 'select max(idPenjualan) as maxID from penjualan');
$data = mysqli_fetch_array($sql);
$kode = $data['maxID'];
$urut = (int) substr($kode,2,5);
$urut++; //setiap nilai tertinggi $kode ditambah 1
$ket = 'PJ';
$kodeauto = $ket . sprintf('%05s', $urut); //menyisipkan 3 karakter 0

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

if($_SERVER['REQUEST_METHOD']=='POST'){
    $tambahPenjualan = $penjualan->tambahPenjualan($_POST);   //menggunakan method tambahPenjualan()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penjualan</title>

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
                            if(isset($tambahPenjualan)){
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$tambahPenjualan?></h2>
                                    </strong>
                                </div>
                            <?php
                            }
                        ?>
                        
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
                                    <h2 class="text-center">TAMBAH PENJUALAN</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_penjualan.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" name="form_tambah_penjualan" enctype="multipart/form-data">
                                <div class="mb-3">
                                <label for="input_id_penjualan" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="idPenjualan" value="<?php echo $kodeauto ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="input_id_pengguna" class="form-label">Pengguna</label>
                                    <input type="text" class="form-control" name="idPengguna" value="<?php echo $user["idPengguna"]; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="input_tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                                    <input type="text" class="form-control" name="tanggalPenjualan" value="<?php echo date('d-m-Y') ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="input_id_barang" class="form-label">ID Barang</label>
                                    <select class="form-control" name="idBarang" required>
                                        <option value="">Pilih Barang</option>
                                        <?php
                                        //karena data idBarang di form transaksi ini diambil dari tb supplier
                                        //maka query dari barang di-select dahulu sebagai berikut
                                            $query = "SELECT * FROM barang";
                                            $hasil = $db->fetchID($query);

                                            while($row = mysqli_fetch_array($hasil))
                                            { 
                                                //data idSupplier ditampilkan dengan while dalam option select
                                                $idBarang = $row['idBarang'];  //untuk menampilkan idBarang dalam option
                                                $stok = $row['stok'];  //untuk menampilkan stok dalam option
                                                $namaBarang = $row['namaBarang'];     //untuk menampilkan namaBarang dalam option    
                                                ?>
                                                <option value="<?=$idBarang?>"> <?= $namaBarang ?> (Stok: <?=$stok?>) </option>;
                                            <?php
                                            }
                                        ?>
                                    </select>
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