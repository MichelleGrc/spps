<?php
include_once '../koneksi.php';
$db = new Koneksi();

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
        $idSupplier = $data['idSupplier'];
        $namaSupplier = $data['namaSupplier'];
        $alamat = $data['alamat'];
        $noTelp = $data['noTelp'];

        $query = "INSERT INTO supplier SET idSupplier='$idSupplier', namaSupplier='$namaSupplier',
        alamat='$alamat', noTelp='$noTelp'";

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
        $idSupplier = $data['idSupplier'];
        $namaSupplier = $data['namaSupplier'];
        $alamat = $data['alamat'];
        $noTelp = $data['noTelp'];

        $query = "UPDATE supplier SET idSupplier='$idSupplier', namaSupplier='$namaSupplier',
        alamat='$alamat', noTelp='$noTelp' WHERE idSupplier='$id'";

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

    public function hapusSupplier($id)
    {
        $cek = mysqli_query($this->db->konek(), "SELECT * FROM barang WHERE idSupplier = '$id'");
        if(mysqli_num_rows($cek) > 0){
            echo "<script>alert('ID Supplier $id tidak bisa dihapus karena telah digunakan di tabel lain!');
            document.location='../view/data_supplier.php'</script>";
            exit;
        }

        $query = "DELETE FROM supplier WHERE idSupplier='$id'";
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