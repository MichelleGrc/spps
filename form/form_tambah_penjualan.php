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
    if($bagian !== 'Bos' & $bagian !== 'Penjualan'){
        header("Location: ../index.php");
    }
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
                                echo "<script>alert('$tambahPenjualan');</script>";
                            ?>
                                <!-- <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$tambahPenjualan?></h2>
                                    </strong>
                                </div> -->
                            <?php
                            }
                        ?>
                        
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <a class="btn btn-dark float-start" href='../view/data_penjualan.php'>Kembali</a>                                   
                                </div>
                                <div class="col-6">
                                    <h2 class="text-center">TAMBAH PENJUALAN</h2>
                                </div>
                                <div class="col-3">
                                    <a href="javascript:void(0)" class="form-tambah-barang float-end btn btn-primary">Tambah Barang</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        <form action="../class/penjualan.php" method="POST">
                                <div class="mb-3">
                                    <label for="">ID</label>
                                    <input type="text" class="form-control" name="idPenjualan2" value="<?php echo $kodeauto ?>" disabled>
                                    <input type="hidden" class="form-control" name="idPenjualan" value="<?php echo $kodeauto ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="">Pengguna</label>
                                    <input type="text" class="form-control" name="idPengguna2" value="<?php echo $user["idPengguna"]; ?>" disabled>
                                    <input type="hidden" class="form-control" name="idPengguna" value="<?php echo $user["idPengguna"]; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="">Tanggal Penjualan</label>
                                    <input type="text" class="form-control" name="tanggalPenjualan2" value="<?php echo date('d-m-Y') ?>" disabled>
                                    <input type="hidden" class="form-control" name="tanggalPenjualan" value="<?php echo date('d-m-Y') ?>">
                                </div>

                                <div class="main-form mt-3 border-bottom">
                                    <div class="row">
                                        <div class="col">
                                            <input type="hidden" class="form-control" name="idPenjualans[]" value="<?php echo $kodeauto ?>">
                                            <div class="form-group mb-2">
                                                <label class="form-label">ID Barang</label>
                                                <select class="form-control" name="idBarang[]" required>
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
                                        </div>
                                        <div class="col">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Kuantitas</label>
                                                <input type="text" class="form-control" name="kuantitas[]" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="paste-form-baru"></div>

                                <br><br>
                                <div class="row">
                                    <div class="col">
                                        <input type="submit" class="btn btn-success form-control" name="simpan"></button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function(){
            $(document).on('click','.remove-btn', function(){
                $(this).closest('.main-form').remove();
            });

            $(document).on('click','.form-tambah-barang', function(){
                $('.paste-form-baru')
                .append('<div class="main-form mt-3 border-bottom">\
                            <div class="row">\
                                <div class="col-5">\
                                    <input type="hidden" class="form-control" name="idPenjualans[]" value="<?php echo $kodeauto ?>">\
                                    <div class="form-group mb-2">\
                                        <label class="form-label">ID Barang</label>\
                                        <select class="form-control" name="idBarang[]" required>\
                                            <option value="">Pilih Barang</option>\
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
                                                    ?>\
                                                    <option value="<?=$idBarang?>"> <?= $namaBarang ?> (Stok: <?=$stok?>) </option>;\
                                                <?php
                                                }
                                            ?>
                                        </select>\
                                    </div>\
                                </div>\
                                <div class="col-5">\
                                    <div class="form-group mb-2">\
                                        <label class="form-label">Kuantitas</label>\
                                        <input type="text" class="form-control" name="kuantitas[]" required>\
                                    </div>\
                                </div>\
                                <div class="col-2">\
                                    <div class="form-group mb-2">\
                                        <br>\
                                        <button type="button" class="remove-btn btn btn-danger form-control">Hapus</button>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>');
            });
        });
    </script>
</body>
</html>