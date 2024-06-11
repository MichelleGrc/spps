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
        $id_barang = $data['idBarang'];
        $nama_barang = $data['namaBarang'];
        $foto_barang = $data['fotoBarang'];
        $jenis_barang = $data['jenisBarang'];
        $merk = $data['merk'];
        $satuan = $data['satuan'];
        $stok = $data['stok'];
        $harga_beli = $data['hargaBeli'];
        $harga_jual = $data['hargaJual'];
        $id_supplier = $data['idSupplier'];

        $query = "INSERT INTO barang SET idBarang='$id_barang', namaBarang='$nama_barang', 
        fotoBarang='$foto_barang', jenisBarang='$jenis_barang', merk='$merk', satuan='$satuan', 
        stok='$stok', harga_beli='$harga_beli', harga_jual='$harga_jual', idSupplier='$id_supplier'";

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
        $query = "SELECT * FROM barang ORDER BY idBarang";
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
        $id_barang = $data['idBarang'];
        $nama_barang = $data['namaBarang'];
        $foto_barang = $data['fotoBarang'];
        $jenis_barang = $data['jenisBarang'];
        $merk = $data['merk'];
        $satuan = $data['satuan'];
        $stok = $data['stok'];
        $harga_beli = $data['hargaBeli'];
        $harga_jual = $data['hargaJual'];
        $id_supplier = $data['idSupplier'];

        $query = "UPDATE tb_barang SET idBarang='$id_barang', namaBarang='$nama_barang', 
        fotoBarang='$foto_barang', jenisBarang='$jenis_barang', merk='$merk', satuan='$satuan', 
        stok='$stok', harga_beli='$harga_beli', harga_jual='$harga_jual', idSupplier='$id_supplier' 
        WHERE id_barang='$id'";

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