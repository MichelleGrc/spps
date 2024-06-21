<?php
include_once '../class/pengguna.php';  //menyertakan file pengguna.php
$pengguna = new Pengguna();              //membuat objek dari class Pengguna()

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
                <!-- <div class="row d-flex justify-content-center"> -->
                    <div class="row">
                        <div class="col">
                            <div class="card">
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
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../form/form_registrasi.php'>Tambah Pengguna</a>                                   
                                        </div>
                                        <div class="col-6">
                                            <h2 class="text-center">DATA PENGGUNA</h2>
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
                                                <th>Bagian</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            //menampilkan semua data dengan while
                                                $tampil = $pengguna->tampilPengguna();
                                                $no=1;
                                                if($tampil)
                                                {
                                                    while($row = mysqli_fetch_assoc($tampil)){
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