<?php
include_once '../class/laporan.php'; 
$db = new Koneksi(); //menghubungkan ke tabel database
?>
<html>
<head>
  <title>Laporan Stok Masuk</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<script>
$(document).ready(function() {
    $('#export').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } );
});
</script>
<div class="container">
    <br></br>
    <h2>Laporan Stok Masuk</h2>
    <h4>PD Libra Motor</h4>
    <div class="data-tables datatable-dark">
        <table class="table table-hover table-bordered" id="export">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama Supplier</th>
                    <th>Nama Barang</th>
                    <th>Kuantitas</th>
                    <th>Harga Beli</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                // Query to fetch data from the database
                $query = "SELECT pembelian.idPembelian, namaSupplier, namaBarang, kuantitas, hargaBeli, kuantitas*hargaBeli as total
                FROM barang INNER JOIN supplier 
                ON barang.idSupplier = supplier.idSupplier 
                INNER JOIN detail_pembelian
                ON barang.idBarang = detail_pembelian.idBarang
                INNER JOIN pembelian
                ON detail_pembelian.idPembelian = pembelian.idPembelian
                ORDER BY pembelian.idPembelian";
                $result = mysqli_query($db->konek(), $query);

                $totalHarga = 0;

                if(mysqli_num_rows($result) > 0){
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)){
                        $totalHarga+= $row['total'];
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['idPembelian']; ?></td>
                            <td><?php echo $row['namaSupplier']; ?></td>
                            <td><?php echo $row['namaBarang']; ?></td>
                            <td><?php echo $row['kuantitas']; ?></td>
                            <td><?php echo 'Rp ' . number_format($row['hargaBeli'],2,',','.'); ?></td>
                            <td><?php echo 'Rp ' . number_format($row['total'],2,',','.'); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak Ada Data</td></tr>";
                }
                ?>
            </tbody>
                <tr>
                    <th colspan="6" class="text-right">Total Harga</th>
                    <th class="text-center"><?php echo 'Rp ' . number_format($totalHarga,2,',','.'); ?></th>
                </tr>
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

</body>
</html>
