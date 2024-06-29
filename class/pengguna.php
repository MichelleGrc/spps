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

        //update ke db
        $query = "UPDATE pengguna SET idPengguna='$idPengguna', namaPengguna='$namaPengguna',
        bagian='$bagian', username='$username' WHERE idPengguna='$id'";

        $hasil = $this->db->edit($query);

        //return pesan untuk alert
        if($hasil)
        {
            $pesan = "Data berhasil diubah!";
            return $pesan;
        }else{
            $pesan = "Data gagal diubah!";
            return $pesan;
        }
    }

    public function hapusPengguna($id)
    {
        //cek terlebih dahulu apakah ada tabrakan dengan FK tabel lain
        $cek = mysqli_query(
            $this->db->konek(),
            "SELECT * FROM pembelian, penjualan WHERE pembelian.idPengguna = '$id' OR penjualan.idPengguna = '$id'"
        );

        if(mysqli_num_rows($cek) > 0){
            echo "<script>alert('ID pengguna $id tidak bisa dihapus karena telah digunakan di tabel lain!');
            document.location='../view/data_pengguna.php'</script>";
            exit;
        }
        
        //kalau tidak ada bisa langsung hapus
        $query = "DELETE FROM pengguna WHERE idPengguna='$id'";
        $hasil = $this->db->hapus($query);

        //return pesan untuk alert
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