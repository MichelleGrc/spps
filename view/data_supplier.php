<?php
include_once '../class/supplier.php';  //menyertakan file supplier.php
$supplier = new Supplier();              //membuat objek dari class Supplier()

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
                                <?php
                                //muncul alert dengan pesan berhasil atau tidaknya proses hapus
                                if(isset($hapusSupplier))
                                { ?>
                                    <div class="alert alert-warning" role="alert">
                                        <strong>
                                            <h6 class="text-center"><?=$hapusSupplier?></h2>
                                        </strong>
                                    </div>
                                <?php }
                                ?>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_tambah_supplier.php'>Tambah Supplier</a>                                   
                                        </div>
                                        <div class="col-6">
                                            <h2 class="text-center">DATA SUPPLIER</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="text-center">
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
                                            //menampilkan semua data dengan while
                                                $tampil = $supplier->tampilSupplier();
                                                $no=1;
                                                if($tampil)
                                                {
                                                    while($row = mysqli_fetch_assoc($tampil)){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row['idSupplier']; ?></td>
                                                            <td><?php echo $row['namaSupplier']; ?></td>
                                                            <td><?php echo $row['alamat']; ?></td>
                                                            <td><?php echo $row['noTelp']; ?></td>
                                                            <td>
                                                                <a class="btn btn-warning" href="../form/form_edit_supplier.php?idSupplier=<?php echo base64_encode($row['idSupplier'])?>">Edit</a>
                                                                <a class="btn btn-danger" href="?hapus_supplier=<?=base64_encode($row['idSupplier'])?>" 
                                                                onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?')">Hapus</a>
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