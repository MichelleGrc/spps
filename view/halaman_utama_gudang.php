<?php
include('header_gudang.php');
?>

    <!-- Card -->
    <div class="container p-5">
        <div class="d-flex justify-content-around text-center">
            <div class="card text-bg-primary mb-3" style="width: 18rem;">
                <div class="card-header">Total Barang</div>
                <?php
                $query = "SELECT * FROM barang";
                $jml = $db->getNumRows($query);
                ?>
                <div class="card-body">
                    <h1 class="card-title display-1"><?php echo $jml ?></h1>
                    <a href="data_barang.php" class="btn btn-primary">Lihat Data Barang</a>
                </div>
            </div>
            <!-- <div class="card text-bg-success mb-3" style="width: 18rem;">
                <div class="card-header">Stok</div>
                <?php
                $query = "SELECT stok FROM barang";
                $hasil = $db->connect($query);
                $jml = explode(" ",(int)$query);
                ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo array_sum($jml) ?></h5>
                    <a href="data_barang.php" class="btn btn-success">Lihat Stok Barang</a>
                </div>
            </div> -->
            <!-- <div class="card text-bg-danger mb-3" style="width: 18rem;">
                <div class="card-header">Total Pelanggan</div>
                <?php
                $query = "SELECT * FROM tb_pelanggan";
                $jml = $db->getNumRows($query);
                ?>
                <div class="card-body">
                    <h1 class="card-title display-1"><?php echo $jml?></h1>
                    <a href="data_info_pelanggan.php" class="btn btn-danger">Lihat Data Pelanggan</a>
                </div>
            </div>
            <div class="card text-bg-warning mb-3" style="width: 18rem;">
                <div class="card-header">Total Transaksi</div>
                <?php
                $query = "SELECT * FROM tb_transaksi";
                $jml = $db->getNumRows($query);
                ?>
                <div class="card-body">
                    <h5 class="card-title display-1"><?php echo $jml ?></h5>
                    <a href="data_transaksi.php" class="btn btn-warning">Lihat Data Transaksi</a>
                </div>
            </div>    -->
        </div>
    </div> 
    <!-- End Card -->

<?php
include('footer.php');
?>