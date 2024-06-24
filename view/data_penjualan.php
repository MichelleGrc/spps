<?php
include_once '../class/penjualan.php';      //menyertakan file penjualan.php
$penjualan = new Penjualan();              //membuat objek dari class Penjualan()
$db = new Koneksi(); //menghubungkan ke tabel database

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
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_tambah_penjualan.php'>Tambah Penjualan</a>                                   
                                        </div>
                                        <div class="col-6">
                                            <h2 class="text-center">DATA PENJUALAN</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Tanggal Penjualan</th>
                                                <th>Pengguna</th>
                                                <th>Kuantitas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            $dataHalaman = 10;
                                            $banyakData = mysqli_num_rows(mysqli_query($db->konek(), "SELECT penjualan.idPenjualan, tanggalPenjualan, namaPengguna, sum(kuantitas) as totKuantitas
                                            FROM penjualan INNER JOIN detail_penjualan 
                                            ON detail_penjualan.idPenjualan = penjualan.idPenjualan 
                                            INNER JOIN barang
                                            ON barang.idBarang = detail_penjualan.idBarang
                                            INNER JOIN pengguna
                                            ON pengguna.idPengguna = penjualan.idPengguna
                                            GROUP BY idPenjualan
                                            ORDER BY penjualan.idPenjualan "));
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
                                                    $ambil = mysqli_query($db->konek(), "SELECT penjualan.idPenjualan, tanggalPenjualan, namaPengguna, sum(kuantitas) as totKuantitas
                                                    FROM penjualan INNER JOIN detail_penjualan 
                                                    ON detail_penjualan.idPenjualan = penjualan.idPenjualan 
                                                    INNER JOIN barang
                                                    ON barang.idBarang = detail_penjualan.idBarang
                                                    INNER JOIN pengguna
                                                    ON pengguna.idPengguna = penjualan.idPengguna
                                                    WHERE 
                                                    penjualan.idPenjualan LIKE '%$keyword%' OR
                                                    namaPengguna LIKE '%$keyword%' OR
                                                    tanggalPenjualan LIKE '%$keyword%'
                                                    GROUP BY idPenjualan
                                                    ORDER BY penjualan.idPenjualan 
                                                    LIMIT $dataAwal, $dataHalaman"); 
                                                }else{
                                                    $ambil = mysqli_query($db->konek(), 
                                                    "SELECT penjualan.idPenjualan, tanggalPenjualan, namaPengguna, sum(kuantitas) as totKuantitas
                                                    FROM penjualan INNER JOIN detail_penjualan 
                                                    ON detail_penjualan.idPenjualan = penjualan.idPenjualan 
                                                    INNER JOIN barang
                                                    ON barang.idBarang = detail_penjualan.idBarang
                                                    INNER JOIN pengguna
                                                    ON pengguna.idPengguna = penjualan.idPengguna
                                                    GROUP BY idPenjualan
                                                    ORDER BY penjualan.idPenjualan 
                                                    LIMIT $dataAwal, $dataHalaman"
                                                    ); 
                                                }
                                                    while($row = mysqli_fetch_assoc($ambil)){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row['idPenjualan']; ?></td>
                                                            <td><?php echo $row['tanggalPenjualan']; ?></td>
                                                            <td><?php echo $row['namaPengguna']; ?></td>
                                                            <td><?php echo $row['totKuantitas']; ?></td>
                                                            <td>
                                                                <a class="btn btn-warning" href="detail_penjualan.php?idPenjualan=<?php echo base64_encode($row['idPenjualan'])?>">Detail</a>
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
            <br><br>
        </div>
    </main>
    <!-- End Card -->

<?php
include('footer.php');
?>