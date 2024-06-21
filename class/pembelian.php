<?php
include_once '../koneksi.php';

class Pembelian
{
    private $db; //atribut untuk object dari kelas koneksi()
    private $stok;      //atribut untuk object dari kelas cekStok()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tambahPembelian($data)
    {
        //mengambil data dari form
        $idPembelian = $data['idPembelian'];
        $idBarang = $data['idBarang'];
        $tanggalPembelian = $data['tanggalPembelian'];
        $kuantitas = $data['kuantitas'];
        $idPengguna = $data['idPengguna'];

        //cek jumlah stok
        $query = "SELECT * FROM pembelian INNER JOIN detail_pembelian 
        ON detail_pembelian.idPembelian = pembelian.idPembelian 
        INNER JOIN barang
        ON barang.idBarang = detail_pembelian.idBarang
        ORDER BY pembelian.idPembelian";
        $this->stok = new cek();
        $stoksekarang = $this->stok->cekStok($query);

        $sisaStok = $stoksekarang + $kuantitas;  //sisa stok adalah stok pada db ditambah jumlah pembelian
        $query3 = "UPDATE barang SET stok='$sisaStok' WHERE idBarang='$idBarang'";
        $sisaStok = $this->stok->sisaStok($query3);
        
        // $query = "INSERT INTO pembelian, detail_pembelian SET pembelian.idPembelian='$idPembelian',
        // detail_pembelian.idPembelian='$idPembelian',
        // tanggalPembelian='$tanggalPembelian', kuantitas='$kuantitas',
        // idBarang = '$idBarang'";

        $query = "INSERT INTO pembelian
        SET idPembelian='$idPembelian', idPengguna ='$idPengguna', tanggalPembelian='$tanggalPembelian'";
        $query2 = "INSERT INTO detail_pembelian
        SET idPembelian='$idPembelian', idBarang='$idBarang', kuantitas='$kuantitas';";

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
    }

    public function tampilPembelian()
    {
        $query = "SELECT * FROM pembelian INNER JOIN detail_pembelian 
        ON detail_pembelian.idPembelian = pembelian.idPembelian 
        INNER JOIN barang
        ON barang.idBarang = detail_pembelian.idBarang
        INNER JOIN supplier
        ON barang.idSupplier = supplier.idSupplier
        INNER JOIN pengguna
        ON pengguna.idPengguna = pembelian.idPengguna
        ORDER BY pembelian.idPembelian";
        //$query = "SELECT * FROM pembelian ORDER BY idPembelian";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDPembelian($id)
    {
        //mengambil id_pembelian pada row tertentu
        $query = "SELECT * FROM pembelian WHERE idPembelian = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }
}
?>