<?php
include_once '../koneksi.php';

class Transaksi
{
    private $db;        //atribut untuk object dari kelas koneksi()
    private $stok;      //atribut untuk object dari kelas cekStok()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tambahTransaksi($data)
    {
        //mengambil data dari form
        $id_transaksi = $data['id_transaksi'];
        $tanggal_transaksi = $data['tanggal_transaksi'];
        $id_pelanggan = $data['id_pelanggan'];
        $id_barang = $data['id_barang'];
        $jumlah = $data['jumlah'];

        //cek jumlah stok
        $query = "SELECT * FROM tb_barang WHERE id_barang = '$id_barang'";
        $this->stok = new cek();
        $stoksekarang = $this->stok->cekStok($query);

        //jika stok lebih besar dari jumlah, maka pembelian memungkinkan
        if($stoksekarang > $jumlah){
                $sisaStok = $stoksekarang - $jumlah;  //sisa stok adalah stok pada db dikurangi jumlah pembelian
                $query2 = "UPDATE tb_barang SET stok='$sisaStok' WHERE id_barang='$id_barang'";
                $sisaStok = $this->stok->sisaStok($query2);
                
                //setelah stok dikurangi, data transaksi bisa diinput ke tb_transaksi
                $query = "INSERT INTO tb_transaksi SET id_transaksi='$id_transaksi', tanggal_transaksi='$tanggal_transaksi', 
                id_pelanggan = '$id_pelanggan', id_barang = '$id_barang', jumlah='$jumlah'";
    
                $hasil = $this->db->insert($query);
    
                if($hasil && $sisaStok)
                {
                    $pesan = "Data Berhasil Ditambahkan";
                    return $pesan;
                }else{
                    $pesan = "Data Gagal Ditambahkan";
                    return $pesan;
                }
            }else{
                //jika stok lebih kecil dari jumlah, maka pembelian tidak memungkinkan
                $pesan = "Stok Tidak Cukup";
                return $pesan;
            }
    }

    public function tampilTransaksi()
    {
        //join antara ketiga tabel ini terlebih dahulu, baru data transaksi lengkap bisa ditampilkan
        $query = "SELECT * FROM tb_transaksi, tb_barang, tb_pelanggan 
        WHERE tb_transaksi.id_pelanggan = tb_pelanggan.id_pelanggan and 
        tb_transaksi.id_barang = tb_barang.id_barang ORDER BY id_transaksi";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDTransaksi($id)
    {
        //mengambil id_transaksi pada row tertentu
        $query = "SELECT * FROM tb_transaksi WHERE id_transaksi = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function editTransaksi($data, $id)
    {
        //mengambil data dari form
        $id_transaksi = $data['id_transaksi'];
        $tanggal_transaksi = $data['tanggal_transaksi'];
        $id_pelanggan = $data['id_pelanggan'];
        $id_barang = $data['id_barang'];
        $jumlah = $data['jumlah'];

        //cek jumlah stok
        $query = "SELECT * FROM tb_barang WHERE id_barang = '$id_barang'";
        $this->stok = new cek();
        $stoksekarang = $this->stok->cekStok($query);

        //jika stok lebih besar dari jumlah, maka pembelian memungkinkan
        if($stoksekarang > $jumlah){
            //mengambil row tertentu berdasarkan id_transaksi
            $query = "SELECT * FROM tb_transaksi WHERE id_transaksi='$id'";
            $hasil = $this->db->fetchID($query);
            if($row = mysqli_fetch_array($hasil))
            {
                $idbrgsebelumnya = $row['id_barang']; //mengambil data id_barang sebelumnya, sebelum diedit
                $jumlahsebelumnya = $row['jumlah'];   //mengambil data jumlah sebelumnya, sebelum diedit
            }
            
            //query untuk mengambil row tertentu berdasarkan data yang sebelumnya, sebelum diedit
            $q2 = "SELECT * FROM tb_barang WHERE id_barang = '$idbrgsebelumnya'";
            $stoksekarang2 = $this->stok->cekStok($q2); //cek stok untuk data sebelumnya, sebelum diedit
            
            if($id_barang == $idbrgsebelumnya)
            {
                //jika barang yang ingin diedit adalah barang yang sama, maka kurangkan stok sekarang
                //dengan (jumlah yang baru dimasukkan - jumlah yang sebelumnya, sebelum diedit)
                $sisaStok = $stoksekarang - ($jumlah - $jumlahsebelumnya);
                $query2 = "UPDATE tb_barang SET stok='$sisaStok' WHERE id_barang='$id_barang'";
                $sisaStok = $this->stok->sisaStok($query2);
            }else{
                //jika barang yang ingin diedit berbeda, maka:
                //untuk barang yang baru dipilih: stok sekarang dikurangi dengan jumlah yang baru dimasukkan
                $sisaStok = $stoksekarang - $jumlah;
                $query2 = "UPDATE tb_barang SET stok='$sisaStok' WHERE id_barang='$id_barang'";
                $sisaStok = $this->stok->sisaStok($query2);

                //untuk barang yang sebelumnya (tidak jadi dibeli): stok sebelumnya barang tersebut ditambah
                //kembali dengan jumlah yang sebelumnya dimasukkan untuk barang tersebut (stok dikembalikan)
                $sisaStok2 = $stoksekarang2 + $jumlahsebelumnya;
                $query3 = "UPDATE tb_barang SET stok='$sisaStok2' WHERE id_barang='$idbrgsebelumnya'";
                $sisaStok2 = $this->stok->sisaStok($query3);
            }

            //setelah stok dikurangi atau ditambahkan sesuai situasi, maka edit transaksi bisa dijalankan
            $query = "UPDATE tb_transaksi SET id_transaksi='$id_transaksi', tanggal_transaksi='$tanggal_transaksi', 
            id_pelanggan = '$id_pelanggan', id_barang = '$id_barang', jumlah='$jumlah' WHERE id_transaksi='$id'";

            $hasil = $this->db->edit($query);

            if($hasil)
            {
                $pesan = "Data Berhasil Diubah";
                return $pesan;
            }else{
                $pesan = "Data Gagal Diubah";
                return $pesan;
            }
        }else{
            //jika stok lebih kecil dari jumlah, maka pembelian tidak memungkinkan
            $pesan = "Stok Tidak Cukup";
            return $pesan;
        }
    }

    public function hapusTransaksi($id)
    {
        //mengambil row tertentu berdasarkan id_transaksi
        $query = "SELECT * FROM tb_transaksi WHERE id_transaksi='$id'";
        $hasil = $this->db->fetchID($query);
        if($row = mysqli_fetch_array($hasil))
        {
            $id_barang = $row['id_barang']; //mengambil data id_barang
            $jumlahsebelumnya = $row['jumlah']; //mengambil data jumlah sebelumnya
        }

        //cek jumlah stok
        $query = "SELECT * FROM tb_barang WHERE id_barang = '$id_barang'";
        $this->stok = new cek();
        $stoksekarang = $this->stok->cekStok($query);

        //setelah mengetahui stok sekarang, sisa stok adalah stok sekarang dikurangi dengan 
        //jumlah yang dimasukkan sebelumnya (stok dikembalikan)
        $sisaStok = $stoksekarang + $jumlahsebelumnya;
        $query2 = "UPDATE tb_barang SET stok='$sisaStok' WHERE id_barang='$id_barang'";
        $sisaStok = $this->stok->sisaStok($query2);

        //setelah stok dikembalikan seperti semula, data transaksi bisa dihapus
        $query = "DELETE FROM tb_transaksi WHERE id_transaksi='$id'";
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