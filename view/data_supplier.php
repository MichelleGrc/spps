<?php
include_once '../class/supplier.php';  //menyertakan file supplier.php
$supplier = new Supplier();              //membuat objek dari class Supplier()
$db = new Koneksi(); //menghubungkan ke tabel database

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
    $bagian = $user['bagian'];

    //cek hak akses
    if($bagian !== 'Bos'){
        header("Location: ../index.php");
    }
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

if(isset($_GET['hapus_supplier']))
{
    //mendekode idSupplier yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar idSupplier yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['hapus_supplier']);
    $hapusSupplier = $supplier->hapusSupplier($id);
}
?>

<?php
//navbar sesuai hak akses
if($bagian == 'Bos'){
    include('header_bos.php');
}else if($bagian == 'Penjualan'){
    include('header_penj.php');
}else if($bagian == 'Gudang'){
    include('header_gudang.php');
}else{
    echo 'Bagian Tidak Dikenali!';
}
?>

    <!-- Card -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid" style="padding: 60px;">
            <h2>DATA SUPPLIER</h2>
            <br><br>
                <!-- <div class="row d-flex justify-content-center"> -->
                    <div class="row">
                        <div class="col">
                            
                                <?php
                                //muncul alert dengan pesan berhasil atau tidaknya proses hapus
                                if(isset($hapusSupplier))
                                    echo "<script>alert('$hapusSupplier');
                                    document.location='../view/data_supplier.php'</script>";
                                ?>
                                
                                    <div class="row">
                                        <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_tambah_supplier.php'>Tambah Supplier</a>                                   
                                        </div>
                                        <!-- Search -->
                                        <form action="" method="post" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="keyword" placeholder="Search..." autocomplete="off" autofocus/>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit" name="cari"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <br>
                                
                                    <table class="table table-hover table-bordered table-responsive w-100 d-block d-md-table">
                                        <thead>
                                            <tr class="text-center" style="background-color: #F5F5F5;">
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>No. Telp</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            $dataHalaman = 10;
                                            $banyakData = mysqli_num_rows(mysqli_query($db->konek(), "SELECT * FROM supplier ORDER BY idSupplier"));
                                            $banyakHalaman = ceil($banyakData / $dataHalaman);
                                            if(isset($_GET['halaman'])){
                                                $halaman = $_GET['halaman'];
                                            }else{
                                                $halaman = 1;
                                            }
                                            $dataAwal = ($halaman * $dataHalaman)-$dataHalaman;

                                                $no=1;

                                                // Search
                                                if(isset($_POST['cari'])){
                                                    $keyword=$_POST['keyword'];
                                                    $ambil = mysqli_query($db->konek(), "SELECT * FROM supplier WHERE 
                                                    idSupplier LIKE '%$keyword%' OR
                                                    namaSupplier LIKE '%$keyword%' OR
                                                    alamat LIKE '%$keyword%' OR
                                                    noTelp LIKE '%$keyword%' 
                                                    ORDER BY idSupplier LIMIT $dataAwal, $dataHalaman"); 
                                                }else{
                                                    $ambil = mysqli_query($db->konek(), "SELECT * FROM supplier ORDER BY idSupplier LIMIT $dataAwal, $dataHalaman"); 
                                                }
                                                    while($row = mysqli_fetch_assoc($ambil)){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row['idSupplier']; ?></td>
                                                            <td><?php echo $row['namaSupplier']; ?></td>
                                                            <td><?php echo $row['alamat']; ?></td>
                                                            <td><?php echo $row['noTelp']; ?></td>
                                                            <td>
                                                                <a class="btn btn-warning" style="margin-bottom: 10px;" href="../form/form_edit_supplier.php?idSupplier=<?php echo base64_encode($row['idSupplier'])?>">Edit</a>
                                                                <a class="btn btn-danger" style="margin-bottom: 10px;" href="?hapus_supplier=<?=base64_encode($row['idSupplier'])?>" 
                                                                onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                ?>
                                        </tbody>
                                    </table>
                                    <nav>
                                        <ul class="pagination">
                                            <!-- Tombol Sebelumnya -->
                                            <?php if($halaman <= 1){?>
                                                <li class="page-item disabled"><a href="?halaman=<?php echo $halaman-1;?>" class="page-link"><</a></li>
                                            <?php }else{?>
                                                <li class="page-item"><a href="?halaman=<?php echo $halaman-1;?>" class="page-link"><</a></li>
                                            <?php }?>
                                            
                                            <?php for ($i = 1; $i <= $banyakHalaman; $i++){
                                            ?>
                                            <li class="page-item"><a href ="?halaman=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                                            <?php } ?>

                                            <!-- Tombol Selanjutnya -->
                                            <?php if($halaman >= $banyakHalaman){?>
                                                <li class="page-item disabled"><a href="?halaman=<?php echo $halaman+1;?>" class="page-link">></a></li>
                                            <?php }else{?>
                                                <li class="page-item"><a href="?halaman=<?php echo $halaman+1;?>" class="page-link">></a></li>
                                            <?php }?>
                                        </ul>
                                    </nav>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Card -->

<?php
include('footer.php');
?>