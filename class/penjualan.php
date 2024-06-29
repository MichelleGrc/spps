<?php
include_once '../koneksi.php';
$db = new Koneksi();
$konek = mysqli_connect('localhost','root','','db_spps_plm');

if (isset($_POST["simpan"])) {
    //mengambil data dari form
    $idPenjualan = $_POST['idPenjualan'];
    $idPengguna = $_POST['idPengguna'];
    $idPenjualans = $_POST['idPenjualans'];
    $idBarang = $_POST['idBarang'];
    $kuantitas = $_POST['kuantitas'];

    //cek apakah idBarang ada di tabel barang
    for($i = 0; $i < count($idBarang); $i++){
        $cek = mysqli_query($konek, "SELECT * FROM barang WHERE idBarang = '$idBarang[$i]'");
        if(mysqli_num_rows($cek) == 0){
            echo "<script>alert('ID barang $idBarang[$i] tidak ditemukan!');
            document.location='../form/form_tambah_penjualan.php'</script>";
            exit;
        }

        //cek juga apakah stok barang cukup
        $hasil = mysqli_fetch_assoc($cek);
        $stoksekarang = $hasil['stok'];
        $sisaStok = $stoksekarang - $kuantitas[$i]; 
        if($sisaStok < 0){
            echo "<script>alert('Stok barang $idBarang[$i] tidak cukup!');
            document.location='../form/form_tambah_penjualan.php'</script>";
            exit;
        }
    }

    //setelah cek bisa langsung insert
    $query = "INSERT INTO penjualan
    SET idPenjualan='$idPenjualan', idPengguna ='$idPengguna'";
    $hasil = $db->insert($query);

    //proses update stok dan insert untuk baris berulang di form
    foreach($idPenjualans as $index => $idP){
        $query = "SELECT * FROM barang WHERE idBarang = '$idBarang[$index]'";
        $hitung = mysqli_query($konek, $query);
        $hasil = mysqli_fetch_assoc($hitung);
        $stoksekarang = $hasil['stok'];
        $sisaStok = $stoksekarang - $kuantitas[$index];  //sisa stok adalah stok pada db dikurang jumlah penjualan
        
        //update stok di tabel barang
        $query3 = "UPDATE barang SET stok='$sisaStok' WHERE idBarang='$idBarang[$index]'";
        $sisaStok = mysqli_query($konek, $query3);

        $v_idPenjualan = $idP;
        $v_idBarang = $idBarang[$index];
        $v_kuantitas = $kuantitas[$index];

        //insert ke detail_penjualan
        $query = "INSERT INTO detail_penjualan
        SET idPenjualan='$v_idPenjualan', idBarang ='$v_idBarang', kuantitas='$v_kuantitas'";
        $hasil = $db->insert($query);

        //return pesan untuk alert
        if($hasil)
        {
            echo "<script>alert('Data berhasil ditambahkan!');
            document.location='../view/data_penjualan.php'</script>";
        }else{
            echo "<script>alert('Data gagal ditambahkan!');
            document.location='../view/data_penjualan.php'</script>";
        }
    }

}

class Penjualan
{
    private $db;        //atribut untuk object dari kelas koneksi()

    public function __construct()
    {
        $this->db = new Koneksi();  //object kelas Koneksi
    }

    public function tampilPenjualan()
    {
        $query = "SELECT * FROM penjualan INNER JOIN detail_penjualan 
        ON detail_penjualan.idPenjualan = penjualan.idPenjualan 
        INNER JOIN barang
        ON barang.idBarang = detail_penjualan.idBarang
        INNER JOIN pengguna
        ON penjualan.idPengguna = pengguna.idPengguna
        ORDER BY penjualan.idPenjualan";
        //$query = "SELECT * FROM penjualan ORDER BY idPenjualan";
        $hasil = $this->db->show($query);
        return $hasil;
    }

    public function getIDPenjualan($id)
    {
        //mengambil idPenjualan pada row tertentu
        $query = "SELECT * FROM penjualan WHERE idPenjualan = '$id'";
        $hasil = $this->db->show($query);
        return $hasil;
    }
}
?>