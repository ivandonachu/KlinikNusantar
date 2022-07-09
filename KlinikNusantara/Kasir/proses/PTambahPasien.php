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

$nama_pasien = htmlspecialchars($_POST['nama_pasien']);
$tempat_lahir = htmlspecialchars($_POST['tempat_lahir']);
$tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
$nik = htmlspecialchars($_POST['nik']);
$golongan_darah = htmlspecialchars($_POST['golongan_darah']);
$no_hp = htmlspecialchars($_POST['no_hp']);
$alamat = htmlspecialchars($_POST['alamat']);
$tgl_daftar = date("Y-m-d");

    $no_id = 1;
    

        $id_pasien = 'PSN';
        $id_rm = 'RM';
    

        $sql_data = mysqli_query($koneksi, "SELECT * FROM pasien  ");
        
        if(mysqli_num_rows($sql_data) == 0 ){
            $id_pasien_new = $id_pasien.$no_id;
            $id_rm_new = $id_rm.$no_id;
            mysqli_query($koneksi,"INSERT INTO rekam_medis VALUES('$id_rm_new')");
              mysqli_query($koneksi,"INSERT INTO pasien VALUES('$id_pasien_new','$id_rm_new','$nama_pasien','$tempat_lahir','$tanggal_lahir','$nik','$alamat','$golongan_darah','$no_hp','$tgl_daftar')");
              
               
                      echo "<script>alert('Data Pasien Berhasil di input'); window.location='../view/VDataPasien';</script>";exit;
        }

        while(mysqli_fetch_array($sql_data)){
            $no_id = $no_id + 1;
            $id_pasien_new = $id_pasien.$no_id;
            $id_rm_new = $id_rm.$no_id;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM pasien WHERE id_pasien = '$id_pasien_new' ");
            if(mysqli_num_rows($sql_cek) === 0 ){
              mysqli_query($koneksi,"INSERT INTO rekam_medis VALUES('$id_rm_new')");
              mysqli_query($koneksi,"INSERT INTO pasien VALUES('$id_pasien_new','$id_rm_new','$nama_pasien','$tempat_lahir','$tanggal_lahir','$nik','$alamat','$golongan_darah','$no_hp','$tgl_daftar')");
              
               
                       echo "<script>alert('Data Pasien Berhasil di input'); window.location='../view/VDataPasien';</script>";exit;
        
            }
            

        }


     
        

       


  ?>