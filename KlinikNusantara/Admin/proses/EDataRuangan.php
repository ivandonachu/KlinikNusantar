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
$kode_ruangan = htmlspecialchars($_POST['kode_ruangan']);
$nama_ruangan = htmlspecialchars($_POST['nama_ruangan']);




                mysqli_query($koneksi,"UPDATE ruangan SET nama_ruangan = '$nama_ruangan' WHERE kode_ruangan =  '$kode_ruangan'");
       
       
                echo "<script>alert('Data Ruangan Berhasil di Edit'); window.location='../view/VRuangan';</script>";exit;
        


     
        

       


  ?>