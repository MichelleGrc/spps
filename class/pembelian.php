<?php
include_once '../koneksi.php';
$db = new Koneksi();

if (isset($_POST["simpan"])) {
    //mengambil data dari form
    $idPembelian = $_POST['idPembelian'];
    $tanggalPembelian = $_POST['tanggalPembelian'];
    $idPengguna = $_POST['idPengguna'];
    $idPembelians = $_POST['idPembelians'];
    $kuantitas = $_POST['kuantitas'];
    $idBarang = $_POST['idBarang'];

    for($i = 0; $i < count($idBarang); $i++){
        $cek = mysqli_query($this->db->konek(), "SELECT * FROM barang WHERE idBarang = '$idBarang[$i]'");
        if(mysqli_num_rows($cek) == 0){
            echo "<script>alert('ID Barang $idBarang[$i] Tidak Ditemukan!');
            document.location='../form/form_tambah_pembelian.php'</script>";
            exit;
        }
    }
        
    $query = "INSERT INTO pembelian
    SET idPembelian='$idPembelian', idPengguna ='$idPengguna', tanggalPembelian='$tanggalPembelian'";
    $hasil = $db->insert($query);

    foreach($idPembelians as $index => $idP){
        //cek jumlah stok
        $query = "SELECT * FROM barang WHERE idBarang = '$idBarang[$index]'";
        $hitung = mysqli_query($konek, $query);
        $hasil = mysqli_fetch_assoc($hitung);
        $stoksekarang = $hasil['stok'];

        $sisaStok = $stoksekarang + $kuantitas[$index];  //sisa stok adalah stok pada db ditambah jumlah pembelian
        $query3 = "UPDATE barang SET stok='$sisaStok' WHERE idBarang='$idBarang[$index]'";
        $sisaStok = mysqli_query($konek, $query3);

        $v_idPembelian = $idP;
        $v_idBarang = $idBarang[$index];
        $v_kuantitas = $kuantitas[$index];

        $query = "INSERT INTO detail_pembelian
        SET idPembelian='$v_idPembelian', idBarang ='$v_idBarang', kuantitas='$v_kuantitas'";
        $hasil = $db->insert($query);

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
    private $stok;      //atribut untuk object dari kelas cekStok()

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