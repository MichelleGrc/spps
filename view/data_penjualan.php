<?php
include_once '../class/penjualan.php';      //menyertakan file penjualan.php
$penjualan = new Penjualan();              //membuat objek dari class Penjualan()

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
                                                <th>Pengguna</th>
                                                <th>Tanggal Penjualan</th>
                                                <th>Barang</th>
                                                <th>Kuantitas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            //menampilkan semua data dengan while
                                                $tampil = $penjualan->tampilPenjualan();
                                                $no=1;
                                                if($tampil)
                                                {
                                                    while($row = mysqli_fetch_assoc($tampil)){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row['idPenjualan']; ?></td>
                                                            <td><?php echo $row['namaPengguna']; ?></td>
                                                            <td><?php echo $row['tanggalPenjualan']; ?></td>
                                                            <td><?php echo $row['namaBarang']; ?></td>
                                                            <td><?php echo $row['kuantitas']; ?></td>
                                                            <td>
                                                                <a class="btn btn-warning" href="../detail_penjualan.php?idPenjualan=<?php echo base64_encode($row['idPenjualan'])?>">Detail</a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                        </tbody>
                                    </table>
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