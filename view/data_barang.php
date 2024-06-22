<?php
include_once '../class/barang.php';  //menyertakan file barang.php
$barang = new Barang();              //membuat objek dari class Barang()

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
            <br><br>
            <div class="container">
                <!-- Search -->
            <form action="" method="post" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" name="keyword" placeholder="Search..." autocomplete="off" autofocus/>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="cari"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <br><br>
                <!-- <div class="row d-flex justify-content-center"> -->
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <?php
                                //muncul alert dengan pesan berhasil atau tidaknya proses hapus
                                if(isset($hapusBarang))
                                { ?>
                                    <div class="alert alert-warning" role="alert">
                                        <strong>
                                            <h6 class="text-center"><?=$hapusBarang?></h2>
                                        </strong>
                                    </div>
                                <?php }
                                ?>
                                <div class="card-header">
                                    <div class="row">
                                        <!-- <div class="col-3">
                                            <a class="btn btn-dark float-start" href='../view/halaman_utama.php'>Halaman Utama</a>
                                        </div> -->
                                        <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_tambah_barang.php'>Tambah Barang</a>                                   
                                        </div>
                                        <div class="col-6">
                                            <h2 class="text-center">DATA BARANG</h2>
                                        </div>
                                        <!-- <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_tambah_barang.php'>Tambah Barang</a>                                   
                                        </div> -->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="text-center">
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
                                            $konek = mysqli_connect('localhost','root','','spps_plm');
                                            $dataHalaman = 10;
                                            $banyakData = mysqli_num_rows(mysqli_query($konek, "SELECT * FROM barang INNER JOIN supplier ON barang.idSupplier = supplier.idSupplier ORDER BY barang.idBarang"));
                                            $banyakHalaman = ceil($banyakData / $dataHalaman);
                                            if(isset($_GET['halaman'])){
                                                $halaman = $_GET['halaman'];
                                            }else{
                                                $halaman = 1;
                                            }
                                            $dataAwal = ($halaman * $dataHalaman)-$dataHalaman;

                                            //menampilkan semua data dengan while
                                                // $tampil = $barang->tampilBarang();
                                                $no=1;
                                                // if($tampil)
                                                // {

                                                // Search
                                                if(isset($_POST['cari'])){
                                                    $keyword=$_POST['keyword'];
                                                    $ambil = mysqli_query($konek, "SELECT * FROM barang INNER JOIN supplier ON barang.idSupplier = supplier.idSupplier WHERE 
                                                    idBarang LIKE '%$keyword%' OR
                                                    namaBarang LIKE '%$keyword%' OR
                                                    jenisBarang LIKE '%$keyword%' OR
                                                    merk LIKE '%$keyword%'OR
                                                    namaSupplier LIKE '%$keyword%' 
                                                    ORDER BY barang.idBarang LIMIT $dataAwal, $dataHalaman"); 
                                                }else{
                                                    $ambil = mysqli_query($konek, "SELECT * FROM barang INNER JOIN supplier ON barang.idSupplier = supplier.idSupplier ORDER BY barang.idBarang LIMIT $dataAwal, $dataHalaman"); 
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
                                                                <a class="btn btn-warning" href="../form/form_edit_barang.php?idBarang=<?php echo base64_encode($row['idBarang'])?>">Edit</a>
                                                                <a class="btn btn-danger" href="?hapus_barang=<?=base64_encode($row['idBarang'])?>" 
                                                                onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?')"> Hapus </a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                //}
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
            <br><br>
        </div>
    </main>
    <!-- End Card -->

<?php
include('footer.php');
?>