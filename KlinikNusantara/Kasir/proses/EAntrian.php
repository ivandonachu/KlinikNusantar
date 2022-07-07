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

$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$no_antrian = htmlspecialchars($_POST['no_antrian']);
$nama_ruangan = htmlspecialchars($_POST['nama_ruangan']);
$nama_dokter = htmlspecialchars($_POST['nama_dokter']);
$keluhan_awal = htmlspecialchars($_POST['keluhan_awal']);

//akses data dokter
$sql_dokter = mysqli_query($koneksi, "SELECT id_karyawan FROM karyawan WHERE nama_karyawan = '$nama_dokter' ");
$data_dokter = mysqli_fetch_assoc($sql_dokter);
$id_dokter = $data_dokter['id_karyawan'];

//akses data ruangan
$sql_ruangan = mysqli_query($koneksi, "SELECT kode_ruangan FROM ruangan WHERE nama_ruangan = '$nama_ruangan' ");
$data_ruangan = mysqli_fetch_assoc($sql_ruangan);
$kode_ruangan = $data_ruangan['kode_ruangan'];


                mysqli_query($koneksi,"UPDATE antrian SET kode_ruangan = '$kode_ruangan' , id_dokter = '$id_dokter', keluhan_awal = '$keluhan_awal' WHERE no_antrian =  '$no_antrian'");
       
       
                echo "<script>alert('Data Antrian Berhasil di Edit'); window.location='../view/VAntrian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        
                
                 
          
                  

     
        

       


  ?>