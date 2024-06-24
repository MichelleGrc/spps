<?php
include_once '../koneksi.php';
// require '../form/form_tambah_pembelian.php';
// $db = new Koneksi();

// if (isset($_POST["submit"])) {
//     //mengambil data dari form
//     $konek = mysqli_connect('localhost','root','','spps_plm');
//     $jum = $_POST['jum'];

//     $idPembelian = $_POST['idPembelian'];
//     $idBarang = $_POST['idBarang'];
//     $tanggalPembelian = $_POST['tanggalPembelian'];
//     $kuantitas = $_POST['kuantitas'];
//     $idPengguna = $_POST['idPengguna'];

//     $query = "INSERT INTO pembelian
//     SET idPembelian='$idPembelian', idPengguna ='$idPengguna', tanggalPembelian='$tanggalPembelian'";
//     $hasil = $db->insert($query);
//             //cek jumlah stok
//             $query = "SELECT * FROM barang WHERE idBarang = '$idBarang[$i]'";
//             $hitung = mysqli_query($konek, $query);
//             $hasil = mysqli_fetch_assoc($hitung);
//             $stoksekarang = $hasil['stok'];
    
//             $sisaStok = $stoksekarang + $kuantitas[$i];  //sisa stok adalah stok pada db ditambah jumlah pembelian
//             $query3 = "UPDATE barang SET stok='$sisaStok[$i]' WHERE idBarang='$idBarang'";
//             $sisaStok = mysqli_query($konek, $query);

//     for ($i=1; $i<=$jum; $i++){


//         mysqli_query($konek, "INSERT INTO detail_pembelian SET idPembelian='$idPembelian[$i]', idBarang='$idBarang[$i]', kuantitas='$kuantitas[$i]");
//         // $hasil = $db->insert($query2);
//     }
    
//     if($hasil)
//     {
//         $pesan = "Data Berhasil Ditambahkan";
//         return $pesan;
//     }else{
//         $pesan = "Data Gagal Ditambahkan";
//         return $pesan;
//     }

// }

class Pembelian
{
    private $db; //atribut untuk object dari kelas koneksi()
    private $stok;      //atribut untuk object dari kelas cekStok()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tambahPembelian($data, $jum)
    {
        //mengambil data dari form
        $idPembelian = $data['idPembelian'];
        $tanggalPembelian = $data['tanggalPembelian'];
        $idPengguna = $data['idPengguna'];

        $query = "INSERT INTO pembelian
        SET idPembelian='$idPembelian', idPengguna ='$idPengguna', tanggalPembelian='$tanggalPembelian'";
        $hasil = $this->db->insert($query);

        for ($i=1; $i<=$jum; $i++){
            $idPembelian2 = $data['idPembelian2'];
            $idBarang = $data['idBarang'];
            $kuantitas = $data['kuantitas'];

            //cek jumlah stok
            $query = "SELECT * FROM barang WHERE idBarang = '$idBarang[$i]'";
            $this->stok = new cek();
            $stoksekarang = $this->stok->cekStok($query);

            $sisaStok = $stoksekarang + $kuantitas[$i];  //sisa stok adalah stok pada db ditambah jumlah pembelian
            $query3 = "UPDATE barang SET stok='$sisaStok' WHERE idBarang='$idBarang[$i]'";
            $sisaStok = $this->stok->sisaStok($query3);

            $query2 = "INSERT INTO detail_pembelian
            SET idPembelian='$idPembelian2[$i]', idBarang='$idBarang[$i]', kuantitas='$kuantitas[$i]'";
            $hasil = $this->db->insert($query2);
        }

        if($hasil)
        {
            $pesan = "Data Berhasil Ditambahkan!";
            return $pesan;
        }else{
            $pesan = "Data Gagal Ditambahkan!";
            return $pesan;
        }
    }

    public function tampilPembelian()
    {
        $query = "SELECT * FROM pembelian INNER JOIN detail_pembelian 
        ON detail_pembelian.idPembelian = pembelian.idPembelian 
        INNER JOIN barang
        ON barang.idBarang = detail_pembelian.idBarang
        INNER JOIN supplier
        ON barang.idSupplier = supplier.idSupplier
        INNER JOIN pengguna
        ON pengguna.idPengguna = pembelian.idPengguna
        ORDER BY pembelian.idPembelian";
        //$query = "SELECT * FROM pembelian ORDER BY idPembelian";
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
}
?>