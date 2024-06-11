<?php
    session_start();
    class Koneksi
    {
        //variabel host, user, pass, db
        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $database = "spps-plm";
        protected $koneksi;

        //class __contruct untuk menjalankan
        public function __construct()
        {
            //cek koneksi
            $this->koneksi = new mysqli($this->host, $this->user, $this->pass, $this->database);
            if($this->koneksi==false)die("Tidak dapat tersambung ke database".$this->koneksi->connect_error());
            return $this->koneksi;
        }

        //function insert
        public function insert($query)
        {   
            $hasil = mysqli_query($this->koneksi, $query) or die($this->koneksi->error.__LINE__);
            if($hasil)
            {
                return $hasil;
            }else{
                return false;
            }
        }

        //function tampil
        public function show($query)
        {   
            $hasil = mysqli_query($this->koneksi, $query) or die($this->koneksi->error.__LINE__);
            
            //jika hasil ditemukan (>0) maka proses berjalan
            if(mysqli_num_rows($hasil) > 0)
            {
                return $hasil;
            }else{
                return false;
            }
        }

        //function edit
        public function edit($query)
        {   
            $hasil = mysqli_query($this->koneksi, $query) or die($this->koneksi->error.__LINE__);
            if($hasil)
            {
                return $hasil;
            }else{
                return false;
            }
        }

        //function hapus
        public function hapus($query)
        {   
            $hasil = mysqli_query($this->koneksi, $query) or die($this->koneksi->error.__LINE__);
            if($hasil)
            {
                return $hasil;
            }else{
                return false;
            }
        }

        //function untuk menyambungkan query sql dengan koneksi db
        public function fetchID($query)
        {
            $hasil = mysqli_query($this->koneksi, $query);
            return $hasil;
        }
    }

    class Register extends Koneksi
    {
        public function registrasi($namaPengguna, $username, $bagian, $password, $cpassword)
        {
            //mengecek apakah username ada pada database
            $query = "SELECT * FROM pengguna WHERE username = '$username'";
            $hasil = mysqli_query($this->koneksi, $query);

            if (mysqli_num_rows($hasil) > 0) {
                return 10; //artinya username sudah ada
            } else {
                //jika hasil ditemukan (>0) maka login bisa dilanjutkan
                if ($password == $cpassword) {
                    //jika password yang dimasukkan sama dengan konfirmasinya, registrasi berhasil
                    $query = "INSERT INTO pengguna VALUES('', '$namaPengguna', '$bagian', '$username', MD5('$password'))";
                    mysqli_query($this->koneksi, $query);
                    return 1; //artinya registrasi berhasil
                } else {
                    return 100; //artinya password tidak sama dengan konfirmasinya
                }
            }
        }
    }

    class Login extends Koneksi
    {
        public $id;
        public function login($username, $password)
        {
            //mengecek apakah username ada pada database
            $query = "SELECT * FROM pengguna WHERE username = '$username'";
            $hasil = mysqli_query($this->koneksi, $query);
            $row = mysqli_fetch_assoc($hasil);

            //jika hasil ditemukan (>0) maka login bisa dilanjutkan
            if(mysqli_num_rows($hasil) > 0)
            {
                if(md5($password) == $row["password"])
                {
                    $this->id = $row["idPengguna"];
                    if ($row['bagian'] == 'Bos'){
                        return 11; //login sebagai bos
                    }else if($row['bagian'] == 'Penjualan'){
                        return 12; //login sebagai karyawan penjualan
                    }else if($row['bagian'] == 'Gudang'){
                        return 13; //login sebagai karyawan gudang
                    }else{
                        return 14; //role tidak dikenali
                    }
                }else{
                    return 10; //artinya password salah
                }
            }else{
                return 100; //artinya username tidak ada di database
            }
        }

        public function idUser()
        {
            return $this->id;
        }
    }

    class Select extends Koneksi
    {
        //function untuk mengambil id user pada pengguna, nantinya digunakan 
        //untuk SESSION login yaitu menentukan apakah pengguna sudah login atau belum
        public function selectUserById($id)
        {
            $query = "SELECT * FROM pengguna WHERE idPengguna = $id";
            $hasil = mysqli_query($this->koneksi, $query);
            return mysqli_fetch_assoc($hasil);
        }
    }

    class UbahPass extends Koneksi
    {
        public function ubahPass($username, $pass_lama, $pass_baru, $cpass_baru)
        {
            //mengecek apakah username ada pada database
            $query = "SELECT * FROM pengguna WHERE username = '$username'";
            $hasil = mysqli_query($this->koneksi, $query);

            // menghitung jumlah data yang ditemukan
            if (mysqli_num_rows($hasil) > 0) {
                // jika hasil yang ditemukan lebih besar dari 0, artinya username sudah ada
                // dan ubah password berhasil dijalankan
                
                //mencari apakah pass lama yang dimasukkan ada pada database
                $queryPass = "SELECT * FROM pengguna WHERE password = '$pass_lama'";
                $passCocok = mysqli_query($this->koneksi, $queryPass);

                if (mysqli_num_rows($passCocok) > 0){
                    // jika hasil yang ditemukan lebih besar dari 0, artinya pass cocok
                    
                    if ($pass_baru == $cpass_baru) {
                        $query = "UPDATE pengguna set password = '$pass_baru' WHERE username='$username'";
                        mysqli_query($this->koneksi, $query);
                        return 1; //artinya registrasi berhasil
                    } else {
                        return 10; //artinya password baru tidak sama dengan konfirmasinya
                    }
                }else{
                    return 100; //artinya password lama yang dimasukkan tidak ditemukan dalam database
                }
            } else {
                return 1000; //artinya username tidak ada di database
            }
        }
    }

    class getNumRows extends Koneksi
    {
        //function untuk mengembalikan jumlah baris untuk query sql tertentu
        public function getNumRows($query)
        {
            $hasil = mysqli_query($this->koneksi, $query);    
            $jml = mysqli_num_rows($hasil);
            return $jml;
        }

        public function connect($query)
        {
            $hasil = mysqli_query($this->koneksi, $query);
        }
    }

    class cek extends Koneksi
    {
        //function untuk mengecek stok sekarang untuk sebuah barang
        public function cekStok($query)
        {
            $hitung = mysqli_query($this->koneksi, $query);
            $hasil = mysqli_fetch_assoc($hitung);
            $stoksekarang = $hasil['stok'];
            return $stoksekarang;
        }

        //function untuk menyambungkan query sql dengan koneksi db
        public function sisaStok($query)
        {
            $hasil = mysqli_query($this->koneksi, $query);
            return $hasil;
        }
    }
?>