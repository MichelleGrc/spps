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
        $jenisBarang = $data['jenisBarang'];
        $stok = $data['stok'];
        $merk = $data['merk'];
        $satuan = $data['satuan'];
        $hargaBeli = $data['hargaBeli'];
        $hargaJual = $data['hargaJual'];
        $idSupplier = $data['idSupplier'];

        if($stok < 0){
            echo "<script>alert('Stok barang tidak boleh kurang dari 0!');
            document.location='../form/form_tambah_barang.php'</script>";
            exit;
        }

        $query = "INSERT INTO barang SET idBarang='$idBarang', namaBarang='$namaBarang', 
        stok='$stok', jenisBarang='$jenisBarang', merk='$merk', satuan='$satuan', 
        hargaBeli='$hargaBeli', hargaJual='$hargaJual', idSupplier='$idSupplier'";

        $hasil = $this->db->insert($query);

        if($hasil)
        {
            $pesan = "Data berhasil ditambahkan!";
            return $pesan;
        }else{
            $pesan = "Data gagal ditambahkan!";
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
        $jenisBarang = $data['jenisBarang'];
        $merk = $data['merk'];
        $satuan = $data['satuan'];
        $hargaBeli = $data['hargaBeli'];
        $hargaJual = $data['hargaJual'];
        $idSupplier = $data['idSupplier'];

        $query = "UPDATE barang SET idBarang='$idBarang', namaBarang='$namaBarang', 
        jenisBarang='$jenisBarang', merk='$merk', satuan='$satuan', 
        hargaBeli='$hargaBeli', hargaJual='$hargaJual', idSupplier='$idSupplier' 
        WHERE idBarang='$id'";

        $hasil = $this->db->edit($query);

        if($hasil)
        {
            $pesan = "Data berhasil diubah!";
            return $pesan;
        }else{
            $pesan = "Data gagal diubah!";
            return $pesan;
        }
    }

    public function hapusBarang($id)
    {
        $cek = mysqli_query(
            $this->db->konek(),
            "SELECT * FROM detail_pembelian, detail_penjualan 
            WHERE detail_pembelian.idBarang = '$id' OR detail_penjualan.idBarang = '$id'"
        );

        if(mysqli_num_rows($cek) > 0){
            echo "<script>alert('ID barang $id tidak bisa dihapus karena telah digunakan di tabel lain!');
            document.location='../view/data_barang.php'</script>";
            exit;
        }

        $query = "DELETE FROM barang WHERE idBarang='$id'";
        $hasil = $this->db->hapus($query);
        if($hasil)
        {
            $pesan = "Data berhasil dihapus!";
            return $pesan;
        }else{
            $pesan = "Data gagal dihapus!";
            return $pesan;
        }
    }
}
?>