<?php
include_once '../koneksi.php';

class Penjualan
{
    private $db;        //atribut untuk object dari kelas koneksi()
    private $stok;      //atribut untuk object dari kelas cekStok()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tambahPenjualan($data)
    {
        //mengambil data dari form
        $idPenjualan = $data['idPenjualan'];
        $idBarang = $data['idBarang'];
        $tanggalPenjualan = $data['tanggalPenjualan'];
        $kuantitas = $data['kuantitas'];
        $idPengguna = $data['idPengguna'];

        //cek jumlah stok
        $query = "SELECT * FROM penjualan INNER JOIN detail_penjualan 
        ON detail_penjualan.idPenjualan = penjualan.idPenjualan 
        INNER JOIN barang
        ON barang.idBarang = detail_penjualan.idBarang
        ORDER BY penjualan.idPenjualan";
        $this->stok = new cek();
        $stoksekarang = $this->stok->cekStok($query);

        //jika stok lebih besar dari jumlah, maka pembelian memungkinkan
        if($stoksekarang > $kuantitas){
            $sisaStok = $stoksekarang - $kuantitas;  //sisa stok adalah stok pada db dikurang jumlah penjualan
            $query3 = "UPDATE barang SET stok='$sisaStok' WHERE idBarang='$idBarang'";
            $sisaStok = $this->stok->sisaStok($query3);

            $query = "INSERT INTO penjualan
            SET idPenjualan='$idPenjualan', idPengguna ='$idPengguna', tanggalPenjualan='$tanggalPenjualan'";
            $query2 = "INSERT INTO detail_penjualan
            SET idPenjualan='$idPenjualan', idBarang='$idBarang', kuantitas='$kuantitas';";

            $hasil = $this->db->insert($query);
            $hasil = $this->db->insert($query2);

            if($hasil)
            {
                $pesan = "Data Berhasil Ditambahkan";
                return $pesan;
            }else{
                $pesan = "Data Gagal Ditambahkan";
                return $pesan;
            }
        }else{
            //jika stok lebih kecil dari jumlah, maka pembelian tidak memungkinkan
            $pesan = "Stok Tidak Cukup";
            return $pesan;
        }
    }

    public function tampilPenjualan()
    {
        $query = "SELECT * FROM penjualan INNER JOIN detail_penjualan 
        ON detail_penjualan.idPenjualan = penjualan.idPenjualan 
        INNER JOIN barang
        ON barang.idBarang = detail_penjualan.idBarang
        INNER JOIN pengguna
        ON penjualan.idPengguna = pengguna.idPengguna
        ORDER BY penjualan.idPenjualan";
        //$query = "SELECT * FROM penjualan ORDER BY idPenjualan";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDPenjualan($id)
    {
        //mengambil idPenjualan pada row tertentu
        $query = "SELECT * FROM penjualan WHERE idPenjualan = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }
}
?>