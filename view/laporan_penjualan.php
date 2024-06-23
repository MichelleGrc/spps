<?php
include_once '../class/laporan.php'; 
$db = new Koneksi(); //menghubungkan ke tabel database

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
            <script>
            $(document).ready(function() {
                $('#export').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf', 
                        {
                            extend: 'print',
                            customize: function(win){
                                $(win.document.body).prepend('<h2>PD Libra Motor<h2>');
                                $(win.document.body).prepend('<h4>Tanggal: <?php echo date('d-m-Y')?><h4>');
                            }
                        },
                    ]
                } );
            });
            </script>
            <div class="container">
                <br></br>
                <h2>Laporan Penjualan</h2>
                <h4>PD Libra Motor</h4>
                <div class="data-tables datatable-dark">
                    <Br>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col">
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
                            <div class="col">
                                <label for="input_tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control" name="tahun" required>
                            </div>
                            <div class="col">
                                <label> </label>
                                <input type="submit" name="submit" value="Proses" class="btn btn-success form-control">
                            </div>      
                        </div>
                    </form>
                    <br><br>
                    <table class="table table-hover table-bordered" id="export">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Supplier</th>
                                <th>Kuantitas</th>
                                <th>Total Modal</th>
                                <th>Total Pendapatan</th>
                                <th>Untung</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            if (isset($_POST["submit"])) {    
                                $tgl=$_POST['tgl'];
                                $tahun=$_POST['tahun'];
                                //$tampil = $lap->showBarangMasuk($tgl, $tahun);

                                // Query to fetch data from the database
                                $query = "SELECT tanggalPenjualan, namaSupplier, sum(kuantitas) as 'Kuantitas', hargaBeli*sum(kuantitas) as 'Total Modal',
                                        hargaJual*sum(kuantitas) as 'Total Pendapatan', (hargaJual*sum(kuantitas))-(hargaBeli*sum(kuantitas)) as 'Untung'
                                        FROM barang
                                        INNER JOIN supplier
                                        ON barang.idSupplier = supplier.idSupplier
                                        INNER JOIN detail_penjualan
                                        ON barang.idBarang = detail_penjualan.idBarang
                                        INNER JOIN penjualan
                                        ON detail_penjualan.idPenjualan = penjualan.idPenjualan
                                        WHERE tanggalPenjualan LIKE '___{$tgl}_{$tahun}'
                                        GROUP BY namaSupplier
                                        ORDER BY penjualan.idPenjualan;";
                                $result = mysqli_query($db->konek(), $query);

                                $totalKuantitas = 0;
                                $totalModal = 0;
                                $totalPend = 0;
                                $totalUnt = 0;

                                if(mysqli_num_rows($result) > 0){
                                    $no = 1;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $totalKuantitas += $row['Kuantitas'];
                                        $totalModal += $row['Total Modal'];
                                        $totalPend += $row['Total Pendapatan'];
                                        $totalUnt += $row['Untung'];
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['tanggalPenjualan']; ?></td>
                                            <td><?php echo $row['namaSupplier']; ?></td>
                                            <td><?php echo $row['Kuantitas']; ?></td>
                                            <td><?php echo 'Rp ' . number_format($row['Total Modal'],2,',','.'); ?></td>
                                            <td><?php echo 'Rp ' . number_format($row['Total Pendapatan'],2,',','.'); ?></td>
                                            <td><?php echo 'Rp ' . number_format($row['Untung'],2,',','.'); ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>Tidak Ada Data</td></tr>";
                                }
                            
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th class="text-center">
                                    <?php 
                                        echo $totalKuantitas; 
                                    ?>
                                </th>
                                <th class="text-center">
                                    <?php 
                                        echo 'Rp ' . number_format($totalModal,2,',','.'); 
                                    ?>
                                </th>
                                <th class="text-center">
                                    <?php 
                                        echo 'Rp ' . number_format($totalPend,2,',','.'); 
                                    ?>
                                </th>
                                <th class="text-center">
                                    <?php 
                                        echo 'Rp ' . number_format($totalUnt,2,',','.'); 
                                    ?>
                                </th>
                            </tr>
                        </tfoot>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

        </div>
    </main>
    <!-- End Card -->
</body>
</html>