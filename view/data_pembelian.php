<?php
include_once '../class/pembelian.php';      //menyertakan file pembelian.php
$pembelian = new Pembelian();              //membuat objek dari class Pembelian()
$db = new Koneksi();                        //menghubungkan ke tabel database

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
            <h2>DATA PEMBELIAN</h2>
            <br><br>
                <!-- <div class="row d-flex justify-content-center"> -->
                    <div class="row">
                        <div class="col">
                                    <div class="row">
                                        <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_tambah_pembelian.php'>Tambah Pembelian</a>                                   
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
                                                <th>Tanggal Pembelian</th>
                                                <th>Pengguna</th>
                                                <th>Kuantitas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            $dataHalaman = 10;
                                            $banyakData = mysqli_num_rows(mysqli_query($db->konek(), "SELECT pembelian.idPembelian, tanggalPembelian, namaPengguna, sum(kuantitas) as totKuantitas
                                            FROM pembelian INNER JOIN detail_pembelian 
                                            ON detail_pembelian.idPembelian = pembelian.idPembelian 
                                            INNER JOIN barang
                                            ON barang.idBarang = detail_pembelian.idBarang
                                            INNER JOIN pengguna
                                            ON pengguna.idPengguna = pembelian.idPengguna
                                            GROUP BY idPembelian
                                            ORDER BY pembelian.idPembelian DESC"));
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
                                                    $ambil = mysqli_query($db->konek(), 
                                                    "SELECT pembelian.idPembelian, tanggalPembelian, namaPengguna, sum(kuantitas) as totKuantitas
                                                    FROM pembelian INNER JOIN detail_pembelian 
                                                    ON detail_pembelian.idPembelian = pembelian.idPembelian 
                                                    INNER JOIN barang
                                                    ON barang.idBarang = detail_pembelian.idBarang
                                                    INNER JOIN pengguna
                                                    ON pengguna.idPengguna = pembelian.idPengguna
                                                    WHERE pembelian.idPembelian LIKE '%$keyword%' OR
                                                    tanggalPembelian LIKE '%$keyword%' OR
                                                    namaPengguna LIKE '%$keyword%'
                                                    GROUP BY idPembelian
                                                    ORDER BY pembelian.idPembelian DESC
                                                    LIMIT $dataAwal, $dataHalaman"); 
                                                }else{
                                                    $ambil = mysqli_query($db->konek(), 
                                                    "SELECT pembelian.idPembelian, tanggalPembelian, namaPengguna, sum(kuantitas) as totKuantitas
                                                    FROM pembelian INNER JOIN detail_pembelian 
                                                    ON detail_pembelian.idPembelian = pembelian.idPembelian 
                                                    INNER JOIN barang
                                                    ON barang.idBarang = detail_pembelian.idBarang
                                                    INNER JOIN pengguna
                                                    ON pengguna.idPengguna = pembelian.idPengguna
                                                    GROUP BY idPembelian
                                                    ORDER BY pembelian.idPembelian DESC
                                                    LIMIT $dataAwal, $dataHalaman"
                                                    ); 
                                                }
                                                    while($row = mysqli_fetch_assoc($ambil)){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row['idPembelian']; ?></td>
                                                            <td><?php echo date('d-m-Y h:m:s a', strtotime($row['tanggalPembelian'])); ?></td>
                                                            <td><?php echo $row['namaPengguna']; ?></td>
                                                            <td><?php echo $row['totKuantitas']; ?></td>
                                                            <td>
                                                                <a class="btn btn-warning" href="detail_pembelian.php?idPembelian=<?php echo base64_encode($row['idPembelian'])?>">Detail</a>
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