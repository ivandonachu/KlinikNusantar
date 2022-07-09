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
$nama_ruangan = htmlspecialchars($_POST['nama_ruangan']);
$nama_dokter = htmlspecialchars($_POST['nama_dokter']);
$keluhan_awal = htmlspecialchars($_POST['keluhan_awal']);
$status_antrian = 'Menunggu' ;
$tgl_antri = date("Y-m-d");

    $result = mysqli_query($koneksi, "SELECT * FROM antrian WHERE id_pasien ='$id_pasien' AND tanggal = '$tgl_antri' AND status_antrian != 'Selesai' ");
    if(mysqli_num_rows($result) == 1 ){
    

      echo "<script>alert('Pasien sudah dalam antrian hari ini'); window.location='../view/VDataPasien';</script>";exit;
        }

            //akses data dokter
        $sql_dokter = mysqli_query($koneksi, "SELECT id_karyawan FROM karyawan WHERE nama_karyawan = '$nama_dokter' ");
        $data_dokter = mysqli_fetch_assoc($sql_dokter);
        $id_dokter = $data_dokter['id_karyawan'];

        //akses data ruangan
        $sql_ruangan = mysqli_query($koneksi, "SELECT kode_ruangan FROM ruangan WHERE nama_ruangan = '$nama_ruangan' ");
        $data_ruangan = mysqli_fetch_assoc($sql_ruangan);
        $kode_ruangan = $data_ruangan['kode_ruangan'];


              mysqli_query($koneksi,"INSERT INTO antrian VALUES('','$tgl_antri','$id_pasien','$keluhan_awal','$id_dokter','$kode_ruangan','$status_antrian')");
               
                    echo "<script>alert('Antrian Berhasil di input'); window.location='../view/VDataPasien';</script>";exit;
     


                    
     
        

       


  ?>