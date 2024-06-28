<?php
include_once '../class/barang.php';  //menyertakan file barang.php
$barang = new Barang();              //membuat objek dari class Barang()
$db = new Koneksi(); //menghubungkan ke tabel database

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

if(isset($_GET['hapus_barang']))
{
    //mendekode id_barang yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar id_barang yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['hapus_barang']);
    $hapusBarang = $barang->hapusBarang($id);
}
?>

<?php
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
                <h2>DATA BARANG</h2>
                <br><br>
            <!-- Alert barang habis -->
            <?php
            $ambildatastok = mysqli_query($db->konek(), "SELECT * FROM barang WHERE stok < 4");

            while($fetch=mysqli_fetch_array($ambildatastok)){
            $barang = $fetch['namaBarang'];
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Perhatian!</strong> Stok <?=$barang;?> Hampir Habis!
            </div>
            <?php
            }
            ?>

                <!-- <div class="row d-flex justify-content-center"> -->
                    <div class="row">
                        <div class="col">
                            
                                <?php
                                //muncul alert dengan pesan berhasil atau tidaknya proses hapus
                                if(isset($hapusBarang))
                                    echo "<script>alert('$hapusBarang');
                                    document.location='../view/data_barang.php'</script>";
                                ?>
                                
                                    <div class="row">
                                        <!-- <div class="col-3">
                                            <a class="btn btn-dark float-start" href='../view/halaman_utama.php'>Halaman Utama</a>
                                        </div> -->
                                        <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_tambah_barang.php'>Tambah Barang</a>                                   
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
                                        <!-- <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_tambah_barang.php'>Tambah Barang</a>                                   
                                        </div> -->
                                    </div>
                                    <br>
                                
                                
                                    <table class="table table-hover table-bordered table-responsive w-100 d-block d-md-table">
                                        <thead>
                                            <tr class="text-center" style="background-color: #F5F5F5;">
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Jenis</th>
                                                <th>Merk</th>
                                                <th>Satuan</th>
                                                <th>Stok</th>
                                                <th>Harga Beli</th>
                                                <th>Harga Jual</th>
                                                <th>Supplier</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            $dataHalaman = 10;
                                            $banyakData = mysqli_num_rows(mysqli_query($db->konek(), "SELECT * FROM barang INNER JOIN supplier ON barang.idSupplier = supplier.idSupplier ORDER BY barang.idBarang"));
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
                                                    $ambil = mysqli_query($db->konek(), "SELECT * FROM barang INNER JOIN supplier ON barang.idSupplier = supplier.idSupplier WHERE 
                                                    idBarang LIKE '%$keyword%' OR
                                                    namaBarang LIKE '%$keyword%' OR
                                                    jenisBarang LIKE '%$keyword%' OR
                                                    merk LIKE '%$keyword%'OR
                                                    satuan LIKE '%$keyword%' OR
                                                    stok LIKE '%$keyword%' OR
                                                    hargaBeli LIKE '%$keyword%' OR
                                                    hargaJual LIKE '%$keyword%' OR
                                                    namaSupplier LIKE '%$keyword%' 
                                                    ORDER BY barang.idBarang LIMIT $dataAwal, $dataHalaman"); 
                                                }else{
                                                    $ambil = mysqli_query($db->konek(), "SELECT * FROM barang INNER JOIN supplier ON barang.idSupplier = supplier.idSupplier ORDER BY barang.idBarang LIMIT $dataAwal, $dataHalaman"); 
                                                }
                                                    while($row = mysqli_fetch_assoc($ambil)){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row['idBarang']; ?></td>
                                                            <td><?php echo $row['namaBarang']; ?></td>
                                                            <td><?php echo $row['jenisBarang']; ?></td>
                                                            <td><?php echo $row['merk']; ?></td>
                                                            <td><?php echo $row['satuan']; ?></td>
                                                            <td><?php echo $row['stok']; ?></td>
                                                            <td><?php echo 'Rp ' . number_format($row['hargaBeli'],2,',','.'); ?></td>
                                                            <td><?php echo 'Rp ' . number_format($row['hargaJual'],2,',','.'); ?></td>
                                                            <td><?php echo $row['namaSupplier']; ?></td>
                                                            <td>
                                                                <a class="btn btn-warning" style="margin-bottom: 10px;" href="../form/form_edit_barang.php?idBarang=<?php echo base64_encode($row['idBarang'])?>">Edit</a>
                                                                <a class="btn btn-danger" style="margin-bottom: 10px;" href="?hapus_barang=<?=base64_encode($row['idBarang'])?>" 
                                                                onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?')"> Hapus </a>
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
                                    </nav><br><br>
                                
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