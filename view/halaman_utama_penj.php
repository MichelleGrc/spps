<?php
include('header_penj.php');
?>

    <!-- Card -->
    <div id="layoutSidenav_content">
        <main>
    <div class="container-fluid" style="padding: 60px;">
        <!-- Alert barang habis -->
        <?php
        $ambildatastok = mysqli_query($db->konek(), "SELECT * FROM barang WHERE stok < 4 AND stok >= 1");
        $ambildatastok2 = mysqli_query($db->konek(), "SELECT * FROM barang WHERE stok = 0");

        while($fetch=mysqli_fetch_array($ambildatastok)){
        $barang = $fetch['namaBarang'];
        ?>
        <div style="margin-left: 25px; margin-right: 25px; margin-bottom: 30px;">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Perhatian!</strong> Stok <?=$barang;?> hampir habis!
            </div>
        </div>
        <?php
        }

        while($fetch=mysqli_fetch_array($ambildatastok2)){
            $barang = $fetch['namaBarang'];
            ?>
            <div style="margin-left: 50px; margin-right: 50px; margin-bottom: 30px;">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Perhatian!</strong> Stok <?=$barang;?> telah habis!
                </div>
            <div>
            <?php
            }
        ?>

        <div class="d-flex justify-content-around text-center">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="../assets/barang.jpg">
                <div class="card-body">
                    <h5>Total Barang</h5>
                    <?php
                    $query = "SELECT * FROM barang";
                    $jml = $db->getNumRows($query);
                    ?>
                    <h1><?php echo $jml?></h1>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="../assets/stok.jpg">
                <div class="card-body">
                    <h5>Total Stok</h5>
                    <?php
                    $query = "SELECT * FROM barang";
                    $jml = $stok->getStok($query);
                    ?>
                    <h1><?php echo $jml?></h1>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="../assets/pembelian.jpg">
                <div class="card-body">
                    <h5>Total Pembelian</h5>
                    <?php
                    $query = "SELECT * FROM pembelian";
                    $jml = $db->getNumRows($query);
                    ?>
                    <h1><?php echo $jml?></h1>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="../assets/penjualan.jpg">
                <div class="card-body">
                    <h5>Total Penjualan</h5>
                    <?php
                    $query = "SELECT * FROM penjualan";
                    $jml = $db->getNumRows($query);
                    ?>
                    <h1><?php echo $jml?></h1>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around text-center" >
            <div class="col" style="width: 50%; margin-left: 10px; margin-top: 60px;">
                <h4>Barang Terlaris</h4><br>
                <table class="table table-hover table-bordered table-responsive w-100 d-block d-md-table">
                    <thead>
                        <tr class="text-center" style="background-color: #F5F5F5;">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                            $no=1;
                                $ambil = mysqli_query($db->konek(), 
                                "SELECT barang.idBarang, namaBarang, sum(kuantitas) as totKuantitas
                                FROM barang
                                INNER JOIN detail_penjualan 
                                ON barang.idBarang = detail_penjualan.idBarang
                                GROUP BY idBarang
                                ORDER BY sum(kuantitas) DESC
                                LIMIT 5"
                                ); 
                                while($row = mysqli_fetch_assoc($ambil)){
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['idBarang']; ?></td>
                                        <td><?php echo $row['namaBarang']; ?></td>
                                        <td><?php echo $row['totKuantitas']; ?></td>
                                    </tr>
                                <?php
                                }
                            ?>
                    </tbody>
                </table>
            </div>
            <div class="col" style="width: 50%; margin-left: 10px; margin-top: 60px;">
                <h4>Stok Paling Sedikit</h4><br>
                <table class="table table-hover table-bordered table-responsive w-100 d-block d-md-table">
                    <thead>
                        <tr class="text-center" style="background-color: #F5F5F5;">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                            $no=1;
                                $ambil = mysqli_query($db->konek(), 
                                "SELECT barang.idBarang, namaBarang, stok
                                FROM barang
                                ORDER BY stok ASC
                                LIMIT 5"
                                ); 
                                while($row = mysqli_fetch_assoc($ambil)){
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['idBarang']; ?></td>
                                        <td><?php echo $row['namaBarang']; ?></td>
                                        <td><?php echo $row['stok']; ?></td>
                                    </tr>
                                <?php
                                }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-around text-center" >
            <div class="col" style="width: 50%; margin-left: 10px; margin-top: 60px;">
                <h4>Pembelian Terbaru</h4><br>
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
                            $no=1;
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
                                LIMIT 5"
                                ); 
                                while($row = mysqli_fetch_assoc($ambil)){
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['idPembelian']; ?></td>
                                        <td><?php echo $row['tanggalPembelian']; ?></td>
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
            </div>
            <div class="col" style="width: 50%; margin-left: 10px; margin-top: 60px;">
                <h4>Penjualan Terbaru</h4><br>
                <table class="table table-hover table-bordered table-responsive w-100 d-block d-md-table">
                    <thead>
                        <tr class="text-center" style="background-color: #F5F5F5;">
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
                            $no=1;
                                $ambil = mysqli_query($db->konek(), 
                                "SELECT penjualan.idPenjualan, tanggalPenjualan, namaPengguna, sum(kuantitas) as totKuantitas
                                FROM penjualan INNER JOIN detail_penjualan 
                                ON detail_penjualan.idPenjualan = penjualan.idPenjualan 
                                INNER JOIN barang
                                ON barang.idBarang = detail_penjualan.idBarang
                                INNER JOIN pengguna
                                ON pengguna.idPengguna = penjualan.idPengguna
                                GROUP BY idPenjualan
                                ORDER BY penjualan.idPenjualan DESC
                                LIMIT 5"
                                ); 
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
            </div>
        </div>
    </div> 
    </div>
    </main>
    <!-- End Card -->

<?php
include('footer.php');
?>