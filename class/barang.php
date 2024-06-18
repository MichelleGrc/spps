<?php
include_once '../koneksi.php';

class Barang
{
    private $db; //atribut untuk object dari kelas koneksi()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tambahBarang($data)
    {
        //mengambil data dari form
        $idBarang = $data['idBarang'];
        $namaBarang = $data['namaBarang'];
        $fotoBarang = $data['fotoBarang'];
        $jenisBarang = $data['jenisBarang'];
        $merk = $data['merk'];
        $satuan = $data['satuan'];
        $stok = $data['stok'];
        $hargaBeli = $data['hargaBeli'];
        $hargaJual = $data['hargaJual'];
        $idSupplier = $data['idSupplier'];

        $query = "INSERT INTO barang SET idBarang='$idBarang', namaBarang='$namaBarang', 
        fotoBarang='$fotoBarang', jenisBarang='$jenisBarang', merk='$merk', satuan='$satuan', 
        stok='$stok', hargaBeli='$hargaBeli', hargaJual='$hargaJual', idSupplier='$idSupplier'";

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

    public function tampilBarang()
    {
        $query = "SELECT * FROM barang INNER JOIN supplier ON barang.idSupplier = supplier.idSupplier ORDER BY barang.idBarang";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDBarang($id)
    {
        //mengambil id_barang pada row tertentu
        $query = "SELECT * FROM barang WHERE idBarang = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function editBarang($data, $id)
    {
        //mengambil data dari form
        $idBarang = $data['idBarang'];
        $namaBarang = $data['namaBarang'];
        $fotoBarang = $data['fotoBarang'];
        $jenisBarang = $data['jenisBarang'];
        $merk = $data['merk'];
        $satuan = $data['satuan'];
        $stok = $data['stok'];
        $hargaBeli = $data['hargaBeli'];
        $hargaJual = $data['hargaJual'];
        $idSupplier = $data['idSupplier'];

        $query = "UPDATE barang SET idBarang='$idBarang', namaBarang='$namaBarang', 
        fotoBarang='$fotoBarang', jenisBarang='$jenisBarang', merk='$merk', satuan='$satuan', 
        stok='$stok', hargaBeli='$hargaBeli', hargaJual='$hargaJual', idSupplier='$idSupplier' 
        WHERE idBarang='$id'";

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

    public function hapusBarang($id)
    {
        $query = "DELETE FROM barang WHERE idBarang='$id'";
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