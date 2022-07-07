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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}
$id_pasien = htmlspecialchars($_POST['id_pasien']);
$nama_pasien = htmlspecialchars($_POST['nama_pasien']);
$tempat_lahir = htmlspecialchars($_POST['tempat_lahir']);
$tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
$nik = htmlspecialchars($_POST['nik']);
$golongan_darah = htmlspecialchars($_POST['golongan_darah']);
$no_hp = htmlspecialchars($_POST['no_hp']);
$alamat = htmlspecialchars($_POST['alamat']);





                mysqli_query($koneksi,"UPDATE pasien SET nama_pasien = '$nama_pasien' , tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', nik = '$nik', golongan_darah = '$golongan_darah', no_hp = '$no_hp', alamat = '$alamat' WHERE id_pasien =  '$id_pasien'");
       
       
                echo "<script>alert('Data Pasien Berhasil di Edit'); window.location='../view/VDataPasien';</script>";exit;
        
                
                 
          
                  

     
        

       


  ?>