<?php
include_once '../class/pengguna.php';  //menyertakan file pengguna.php
$pengguna = new Pengguna();              //membuat objek dari class Pengguna()
$db = new Koneksi(); //menghubungkan ke tabel database

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

if(isset($_GET['hapus_pengguna']))
{
    //mendekode idPengguna yang ingin dihapus untuk pemrosesan 
    //setelah id tersebut dikode saat menekan tombol hapus
    //tujuan dekode agar idPengguna yang tampil di link hanya berbentuk kode saja
    $id = base64_decode($_GET['hapus_pengguna']);
    $hapusPengguna = $pengguna->hapusPengguna($id);
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
                <h2>DATA PENGGUNA</h2>
                <br><br>
                <!-- <div class="row d-flex justify-content-center"> -->
                    <div class="row">
                        <div class="col">
                                <?php
                                //muncul alert dengan pesan berhasil atau tidaknya proses hapus
                                if(isset($hapusPengguna))
                                { ?>
                                    <div class="alert alert-warning" role="alert">
                                        <strong>
                                            <h6 class="text-center"><?=$hapusPengguna?></h2>
                                        </strong>
                                    </div>
                                <?php }
                                ?>
                                    <div class="row">
                                        <div class="col-4">
                                            <a class="btn btn-primary float-end" href='../form/form_registrasi.php'>Tambah Pengguna</a>                                   
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
                                
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Bagian</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            $dataHalaman = 10;
                                            $banyakData = mysqli_num_rows(mysqli_query($db->konek(), "SELECT * FROM pengguna ORDER BY idPengguna"));
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
                                                    $ambil = mysqli_query($db->konek(), "SELECT * FROM pengguna WHERE 
                                                    idPengguna LIKE '%$keyword%' OR
                                                    namaPengguna LIKE '%$keyword%' OR
                                                    bagian LIKE '%$keyword%' OR
                                                    username LIKE '%$keyword%' 
                                                    ORDER BY idPengguna LIMIT $dataAwal, $dataHalaman"); 
                                                }else{
                                                    $ambil = mysqli_query($db->konek(), "SELECT * FROM pengguna ORDER BY idPengguna LIMIT $dataAwal, $dataHalaman"); 
                                                }
                                                    while($row = mysqli_fetch_assoc($ambil)){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row['idPengguna']; ?></td>
                                                            <td><?php echo $row['namaPengguna']; ?></td>
                                                            <td><?php echo $row['bagian']; ?></td>
                                                            <td><?php echo $row['username']; ?></td>
                                                            <td><?php echo $row['password']; ?></td>
                                                            <td>
                                                                <a class="btn btn-warning" href="../form/form_edit_pengguna.php?idPengguna=<?php echo base64_encode($row['idPengguna'])?>">Edit</a>
                                                                <a class="btn btn-success" href="../form/form_ubah_pass.php?idPengguna=<?php echo base64_encode($row['idPengguna'])?>">Ubah Pass</a>
                                                                <a class="btn btn-danger" href="?hapus_pengguna=<?=base64_encode($row['idPengguna'])?>" 
                                                                onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?')">Hapus</a>
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
    <br><br>
        </div>
    </main>
    <!-- End Card -->

<?php
include('footer.php');
?>