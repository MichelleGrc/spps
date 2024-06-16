<?php
include_once '../koneksi.php';

class Pengguna
{
    private $db; //atribut untuk object dari kelas koneksi()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tampilPengguna()
    {
        $query = "SELECT * FROM pengguna ORDER BY idPengguna";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDPengguna($id)
    {
        //mengambil idSupplier pada row tertentu
        $query = "SELECT * FROM pengguna WHERE idPengguna = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function editPengguna($data, $id)
    {
        //mengambil data dari form
        $idPengguna = $data['idPengguna'];
        $namaPengguna = $data['namaPengguna'];
        $bagian = $data['bagian'];
        $username = $data['username'];

        $query = "UPDATE pengguna SET idPengguna='$idPengguna', namaPengguna='$namaPengguna',
        bagian='$bagian', username='$username' WHERE idPengguna='$id'";

        $hasil = $this->db->edit($query);

        if($hasil)
        {
            $pesan = "Data Berhasil Diubah";
            return $pesan;
        }else{
            $pesan = "Data Gagal Diubah";
            return $pesan;
        }
    }

    public function hapusPengguna($id)
    {
        $query = "DELETE FROM pengguna WHERE idPengguna='$id'";
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