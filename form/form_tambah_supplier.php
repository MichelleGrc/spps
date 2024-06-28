<?php
include_once '../class/supplier.php';  //menyertakan file supplier.php
$supplier = new Supplier();              //membuat objek dari class Supplier()

//membuat kode custom
//menghubungkan ke tabel database
$db = new Koneksi();
//mengambil nilai tertinggi pada tabel penjualan
$sql = mysqli_query($db->konek(), 'select max(idSupplier) as maxID from supplier');
$data = mysqli_fetch_array($sql);
$kode = $data['maxID'];
$urut = (int) substr($kode,2,5);
$urut++; //setiap nilai tertinggi $kode ditambah 1
$ket = 'SP';
$kodeauto = $ket . sprintf('%05s', $urut); //menyisipkan 3 karakter 0

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

if($_SERVER['REQUEST_METHOD']=='POST'){
    $tambahSupplier = $supplier->tambahSupplier($_POST);   //menggunakan method tambahSupplier()
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Supplier</title>

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
                            if(isset($tambahSupplier)){
                            ?>
                                <!-- <div class="alert alert-warning" role="alert">
                                    <strong>
                                        <h6 class="text-center"><?=$tambahSupplier?></h2>
                                    </strong>
                                </div> -->
                            <?php
                                echo "<script>alert('$tambahSupplier');
                                document.location='../view/data_supplier.php'</script>";
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
                                    <h2 class="text-center">TAMBAH SUPPLIER</h2>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary float-end" href='../view/data_supplier.php'>Kembali</a>                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" name="form_tambah_supplier" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="input_id_supplier" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="idSupplier2" value="<?php echo $kodeauto ?>" disabled>
                                    <input type="hidden" class="form-control" name="idSupplier" value="<?php echo $kodeauto ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="input_nama_supplier" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="namaSupplier" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" required>
                                </div>
                                <div class="mb-3">
                                    <label for="input_no_telp" class="form-label">No. Telp</label>
                                    <input type="number" class="form-control" name="noTelp" required>
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