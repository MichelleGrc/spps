<?php
include('header_bos.php');
?>

    <!-- Card -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container p-5">
                <div class="d-flex justify-content-around text-center">
                    <div class="card text-bg-danger mb-3" style="width: 18rem;">
                        <div class="card-header">Total Supplier</div>
                        <?php
                        $query = "SELECT * FROM supplier";
                        $jml = $db->getNumRows($query);
                        ?>
                        <div class="card-body">
                            <h1 class="card-title display-1"><?php echo $jml?></h1>
                            <a href="data_supplier.php" class="btn btn-danger">Lihat Data Supplier</a>
                        </div>
                    </div>
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
                    <div class="card text-bg-success mb-3" style="width: 18rem;">
                        <div class="card-header">Total Pembelian</div>
                        <?php
                        $query = "SELECT * FROM detail_pembelian";
                        $jml = $db->getNumRows($query);
                        ?>
                        <div class="card-body">
                            <h5 class="card-title display-1"><?php echo $jml ?></h5>
                            <a href="data_pembelian.php" class="btn btn-success">Lihat Data Pembelian</a>
                        </div>
                    </div>
                    <div class="card text-bg-warning mb-3" style="width: 18rem;">
                        <div class="card-header">Total Penjualan</div>
                        <?php
                        $query = "SELECT * FROM penjualan";
                        $jml = $db->getNumRows($query);
                        ?>
                        <div class="card-body">
                            <h5 class="card-title display-1"><?php echo $jml ?></h5>
                            <a href="data_penjualan.php" class="btn btn-warning">Lihat Data Penjualan</a>
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