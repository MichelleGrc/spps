<?php
include_once '../koneksi.php';

class Supplier
{
    private $db; //atribut untuk object dari kelas koneksi()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tambahSupplier($data)
    {
        //mengambil data dari form
        $id_supplier = $data['idSupplier'];
        $nama_supplier = $data['namaSupplier'];
        $alamat = $data['alamat'];
        $no_telp = $data['noTelp'];

        $query = "INSERT INTO supplier SET idSupplier='$id_supplier', namaSupplier='$nama_supplier',
        alamat='$alamat', noTelp='$no_telp'";

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

    public function tampilSupplier()
    {
        $query = "SELECT * FROM supplier ORDER BY idSupplier";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDSupplier($id)
    {
        //mengambil idSupplier pada row tertentu
        $query = "SELECT * FROM supplier WHERE idSupplier = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function editSupplier($data, $id)
    {
        //mengambil data dari form
        $id_supplier = $data['idSupplier'];
        $nama_supplier = $data['namaSupplier'];
        $alamat = $data['alamat'];
        $no_telp = $data['noTelp'];

        $query = "UPDATE supplier SET idSupplier='$id_supplier', namaSupplier='$nama_supplier',
        alamat='$alamat', noTelp='$no_telp'";

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

    public function hapusSupplier($id)
    {
        $query = "DELETE FROM supplier WHERE idSupplier='$id'";
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