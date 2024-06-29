<?php
include_once '../koneksi.php';
$db = new Koneksi();
$konek = mysqli_connect('localhost','root','','db_spps_plm');

if (isset($_POST["simpan"])) {
    //mengambil data dari form
    $idPembelian = $_POST['idPembelian'];
    $idPengguna = $_POST['idPengguna'];
    $idPembelians = $_POST['idPembelians'];
    $kuantitas = $_POST['kuantitas'];
    $idBarang = $_POST['idBarang'];

    //cek apakah idBarang ada di tabel barang
    for($i = 0; $i < count($idBarang); $i++){
        $cek = mysqli_query($konek, "SELECT * FROM barang WHERE idBarang = '$idBarang[$i]'");
        if(mysqli_num_rows($cek) == 0){
            echo "<script>alert('ID barang $idBarang[$i] tidak ditemukan!');
            document.location='../form/form_tambah_pembelian.php'</script>";
            exit;
        }
    }
    
    //kalau ada bisa langsung insert
    $query = "INSERT INTO pembelian
    SET idPembelian='$idPembelian', idPengguna ='$idPengguna'";
    $hasil = $db->insert($query);

    //proses cek stok dan insert untuk baris berulang di form
    foreach($idPembelians as $index => $idP){
        //cek jumlah stok tiap barang
        $query = "SELECT * FROM barang WHERE idBarang = '$idBarang[$index]'";
        $hitung = mysqli_query($konek, $query);
        $hasil = mysqli_fetch_assoc($hitung);
        $stoksekarang = $hasil['stok'];
        $sisaStok = $stoksekarang + $kuantitas[$index];  //sisa stok adalah stok pada db ditambah jumlah pembelian

        //update stok di tabel barang
        $query3 = "UPDATE barang SET stok='$sisaStok' WHERE idBarang='$idBarang[$index]'";
        $sisaStok = mysqli_query($konek, $query3);

        $v_idPembelian = $idP;
        $v_idBarang = $idBarang[$index];
        $v_kuantitas = $kuantitas[$index];

        //setelah berhasil update stok, bisa langsung insert ke detail_pembelian
        $query = "INSERT INTO detail_pembelian
        SET idPembelian='$v_idPembelian', idBarang ='$v_idBarang', kuantitas='$v_kuantitas'";
        $hasil = $db->insert($query);

        //return pesan untuk alert
        if($hasil)
        {
            echo "<script>alert('Data berhasil ditambahkan!');
            document.location='../view/data_pembelian.php'</script>";
        }else{
            echo "<script>alert('Data gagal ditambahkan!');
            document.location='../view/data_pembelian.php'</script>";
        }  
    }
}

class Pembelian
{
    private $db; //atribut untuk object dari kelas koneksi()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
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
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDPembelian($id)
    {
        //mengambil idPembelian pada row tertentu
        $query = "SELECT * FROM pembelian WHERE idPembelian = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }
}
?>