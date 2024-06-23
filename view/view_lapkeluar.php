<?php
include_once '../class/laporan.php';      //menyertakan file laporan.php
$lap = new Laporan();              //membuat objek dari class Laporan()

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
    $bagian = $user['bagian'];
    if($bagian !== 'Bos' & $bagian !== 'Gudang'){
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
                <!-- <div class="row d-flex justify-content-center"> -->
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-3">
                                            <a class="btn btn-primary float-end" href='../view/export.php'>Export</a>                                   
                                        </div>
                                        <div class="col-6">
                                            <h2 class="text-center">LAPORAN BARANG KELUAR</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="view_lapkeluar.php" method="post">
                                        <div class="mb-3">
                                            <label for="input_tgl" class="form-label">Bulan</label>
                                            <select type="text" class="form-control" name="tgl" required>
                                                <option value="">Pilih Bulan</option>
                                                <option value="01">Januari</option>
                                                <option value="02">Februari</option>
                                                <option value="03">Maret</option>
                                                <option value="04">April</option>
                                                <option value="05">Mei</option>
                                                <option value="06">Juni</option>
                                                <option value="07">Juli</option>
                                                <option value="08">Agustus</option>
                                                <option value="09">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="input_tahun" class="form-label">Tahun</label>
                                            <input type="number" class="form-control" name="tahun" required>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <input type="submit" name="submit" value="Proses" class="btn btn-success form-control">
                                            </div>                    
                                        </div>
                                    </form>
                                    <br>
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Nama Barang</th>
                                                <th>Kuantitas</th>
                                                <th>Harga Jual</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            //menampilkan semua data dengan while
                                                if (isset($_POST["submit"])) {    
                                                    $tgl=$_POST['tgl'];
                                                    $tahun=$_POST['tahun'];
                                                    $tampil = $lap->showBarangKeluar($tgl, $tahun);
                                                
                                                    echo "Periode Bulan $tgl Tahun $tahun";
                                                
                                                $no=1;
                                                if($tampil)
                                                {
                                                    while($row = mysqli_fetch_assoc($tampil)){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row['idPenjualan']; ?></td>
                                                            <td><?php echo $row['namaBarang']; ?></td>
                                                            <td><?php echo $row['kuantitas']; ?></td>
                                                            <td><?php echo $row['hargaJual']; ?></td>
                                                            <td><?php echo ($row['kuantitas'])*($row['hargaJual']); ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                            }
                                                ?>
                                                <input type="hidden" name="tgl" value="<?php echo $tgl;?>">
                                                <input type="hidden" name="tahun" value="<?php echo $tahun;?>">
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