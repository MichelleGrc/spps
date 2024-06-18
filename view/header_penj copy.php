<?php
// session_start();
require '../koneksi.php'; //menyertakan koneksi.php

$db = new getNumRows();  //object untuk class getNumRow() dari koneksi.php

$select = new Select();
if(isset($_SESSION["id"]))
{
    //jika user berhasil login, proses dilanjutkan
    $user = $select->selectUserById($_SESSION["id"]);
    $bagian = $user['bagian'];
}else{
    //jika user belum login, pengguna langsung diarahkan lagi ke form login di index.php
    header("Location: ../index.php");
}

$login = new Login(); //membuat object untuk class Login()
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>

    <!-- untuk menyambungkan file css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <!-- Header -->
    <div class="bg-dark text-center text-light p-4">
        <div class="container">
            <h2>Halo, <?php echo $user["namaPengguna"]; ?>!</h2>
            <p>Selamat Datang di Sistem Pengelolaan Penjualan dan Stok PD Libra Motor</p>
        </div>
    </div>
    <!-- End Header -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand">PD Libra Motor</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="halaman_utama.php">Home</a>
                    <a class="nav-link" href="data_barang.php">Barang</a>
                    <a class="nav-link" href="data_pembelian.php">Pembelian</a>
                    <a class="nav-link" href="data_penjualan.php">Penjualan</a>
                    <a class="nav-link" href="data_barang.php">Lap. Penjualan</a>
                </div>
                <div class="collapse navbar-collapse justify-content-end"">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../form/form_ubah_pass.php">Ubah Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php" 
                            onclick="return confirm('Anda Yakin Ingin Logout?')">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>