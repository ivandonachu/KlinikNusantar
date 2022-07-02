<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account a INNER JOIN karyawan b on b.id_karyawan=a.id_karyawan WHERE b.id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Admin') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$nama_alkes = htmlspecialchars($_POST['nama_alkes']);
$harga_alkes = htmlspecialchars($_POST['harga_alkes']);
$stok_awal = htmlspecialchars($_POST['stok_awal']);
$deskripsi = htmlspecialchars($_POST['deskripsi']);


    $no_kode = 0;
    

        $kode = 'ALK';

        $sql_data = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan  ");
        
        if(mysqli_num_rows($sql_data) == 0 ){
            $kode_new = $kode.$no_kode;
            mysqli_query($koneksi,"INSERT INTO alat_kesehatan VALUES('$kode_new','$nama_alkes','$harga_alkes','$stok_awal','$deskripsi')");
               
            echo "<script>alert('Riwayat Alat Kesehatan Berhasil di Input'); window.location='../view/VAlatKesehatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        }

        while(mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;
            $kode_new = $kode.$no_kode;

            $sql_alkes = mysqli_query($koneksi, "SELECT kode_alkes FROM alat_kesehatan WHERE kode_alkes = '$kode_new' ");
            $data_alkes = mysqli_fetch_assoc($sql_alkes);
            if(!isset($data_alkes['kode_alkes'])){
                mysqli_query($koneksi,"INSERT INTO alat_kesehatan VALUES('$kode_new','$nama_alkes','$harga_alkes','$stok_awal','$deskripsi')");
               
                echo "<script>alert('Riwayat Alat Kesehatan Berhasil di Input'); window.location='../view/VAlatKesehatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
            
            }

            

        }


     
        

       


  ?>