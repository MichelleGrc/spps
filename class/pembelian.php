<?php
include_once '../koneksi.php';

class Pembelian
{
    private $db; //atribut untuk object dari kelas koneksi()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tambahPembelian($data)
    {
        //mengambil data dari form
        $idPembelian = $data['idPembelian'];
        $fotoPembelian = $data['fotoPembelian'];
        $tanggalPembelian = $data['tanggalPembelian'];
        $kuantitas = $data['kuantitas'];

        $query = "INSERT INTO pembelian SET idPembelian='$idPembelian', 
        fotoPembelian='$fotoPembelian', tanggalPembelian='$tanggalPembelian', kuantitas='$kuantitas'";

        $hasil = $this->db->insert($query);

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
        $query = "SELECT * FROM pembelian ORDER BY idPembelian";
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

    public function hapusPembelian($id)
    {
        $query = "DELETE FROM pembelian WHERE idPembelian='$id'";
        $hasil = $this->db->hapus($query);
        if($hasil)
        {
            $pesan = "Data Berhasil Dihapus";
            return $pesan;
        }else{
            $pesan = "Data Gagal Dihapus";
            return $pesan;
        }
    }
}
?>