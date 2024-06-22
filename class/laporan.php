<?php
include_once '../koneksi.php';

class Laporan
{
    private $db; //atribut untuk object dari kelas koneksi()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    // public function lapBarangMasuk($data)
    // {
    //     //mengambil data dari form
    //     $tgl = $data['tgl'];
    //     $tahun = $data['tahun'];
    //     return $tgl;
    // }

    public function showBarangMasuk($tgl, $tahun)
    {
        $query = "SELECT pembelian.idPembelian, namaSupplier, namaBarang, kuantitas, hargaBeli, kuantitas*hargaBeli as total
        FROM barang INNER JOIN supplier 
        ON barang.idSupplier = supplier.idSupplier 
        INNER JOIN detail_pembelian
        ON barang.idBarang = detail_pembelian.idBarang
        INNER JOIN pembelian
        ON detail_pembelian.idPembelian = pembelian.idPembelian
        WHERE tanggalPembelian LIKE '___{$tgl}_{$tahun}'
        ORDER BY pembelian.idPembelian";
        $hasil = $this->db->show($query);
        return $hasil;
    }
}
?>