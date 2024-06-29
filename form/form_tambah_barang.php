<?php
include_once '../class/barang.php';  //menyertakan file barang.php
$barang = new Barang();              //membuat objek dari class Barang()

//membuat kode custom
//menghubungkan ke tabel database
$db = new Koneksi();
//mengambil nilai tertinggi pada tabel pembelian
$sql = mysqli_query($db->konek(), 'select max(idBarang) as maxID from barang');
$data = mysqli_fetch_array($sql);
$kode = $data['maxID'];
$urut = (int) substr($kode,2,5);
$urut++; //setiap nilai tertinggi $kode ditambah 1
$ket = 'BR';
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
    $tambahBarang = $barang->tambahBarang($_POST);   //menggunakan method tambahSupplier()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

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
                            if(isset($tambahBarang)){
                                echo "<script>alert('$tambahBarang');
                                document.location='../view/data_barang.php'</script>";
                            ?>
                                <!-- <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$tambahBarang?></h2>
                                    </strong>
                                </div> -->
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
                                    <h2 class="text-center">TAMBAH BARANG</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_barang.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" name="form_tambah_barang" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="input_id_barang" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="idBarang2" value="<?php echo $kodeauto ?>" disabled>
                                    <input type="hidden" class="form-control" name="idBarang" value="<?php echo $kodeauto ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="input_nama_barang" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="namaBarang" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_jenis_barang" class="form-label">Jenis</label>
                                    <select type="text" class="form-control" name="jenisBarang" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="Ori">Ori</option>
                                        <option value="Non Ori">Non Ori</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="input_merk" class="form-label">Merk</label>
                                    <input type="text" class="form-control" name="merk" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_satuan" class="form-label">Satuan</label>
                                    <input type="text" class="form-control" name="satuan2" value="PCS" disabled>
                                    <input type="hidden" class="form-control" name="satuan" value="PCS">
                                </div>
                                <div class="mb-3">
                                    <label for="input_stok" class="form-label">Stok Awal</label>
                                    <input type="number" class="form-control" name="stok" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_harga_beli" class="form-label">Harga Beli</label>
                                    <input type="number" class="form-control" name="hargaBeli" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_harga_jual" class="form-label">Harga Jual</label>
                                    <input type="number" class="form-control" name="hargaJual" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_id_supplier" class="form-label">Supplier</label>
                                    <select class="form-control" name="idSupplier" required>
                                        <option value="">Pilih ID Supplier</option>
                                        <?php
                                        //karena data idSupplier di form transaksi ini diambil dari tb supplier
                                        //maka query dari supplier di-select dahulu sebagai berikut
                                            $query = "SELECT * FROM supplier";
                                            $hasil = $db->fetchID($query);

                                            while($row = mysqli_fetch_array($hasil))
                                            { 
                                                //data idSupplier ditampilkan dengan while dalam option select
                                                $idSupplier = $row['idSupplier'];  //untuk menampilkan idSupplier dalam option
                                                $namaSupplier = $row['namaSupplier'];     //untuk menampilkan namaSupplier dalam option
                                                ?>
                                                <option value="<?=$idSupplier?>"> <?= $namaSupplier ?> (ID: <?=$idSupplier?>) </option>;
                                            <?php
                                            }
                                        ?>
                                    </select>
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