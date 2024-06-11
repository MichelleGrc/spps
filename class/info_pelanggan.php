<?php
include_once '../koneksi.php';

class InfoPelanggan
{
    private $db; //atribut untuk object dari kelas koneksi()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tambahInfoPelanggan($data)
    {
        //mengambil data dari form
        $id_pelanggan = $data['id_pelanggan'];
        $nama_pelanggan = $data['nama_pelanggan'];
        $alamat = $data['alamat'];
        $no_telp = $data['no_telp'];

        $query = "INSERT INTO tb_pelanggan SET id_pelanggan='$id_pelanggan', nama_pelanggan='$nama_pelanggan', 
        alamat='$alamat', no_telp='$no_telp'";

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

    public function tampilInfoPelanggan()
    {
        $query = "SELECT * FROM tb_pelanggan ORDER BY id_pelanggan";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDPelanggan($id)
    {
        //mengambil id_pelanggan pada row tertentu
        $query = "SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function editInfoPelanggan($data, $id)
    {
        //mengambil data dari form
        $id_pelanggan = $data['id_pelanggan'];
        $nama_pelanggan = $data['nama_pelanggan'];
        $alamat = $data['alamat'];
        $no_telp = $data['no_telp'];

        $query = "UPDATE tb_pelanggan SET id_pelanggan='$id_pelanggan', nama_pelanggan='$nama_pelanggan', 
        alamat='$alamat', no_telp='$no_telp' WHERE id_pelanggan='$id'";

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

    public function hapusInfoPelanggan($id)
    {
        $query = "DELETE FROM tb_pelanggan WHERE id_pelanggan='$id'";
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