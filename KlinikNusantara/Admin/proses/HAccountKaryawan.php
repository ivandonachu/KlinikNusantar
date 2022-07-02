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


$username = htmlspecialchars($_POST['username']);



$sql_data = mysqli_query($koneksi, "SELECT * FROM account a INNER JOIN karyawan b on b.id_karyawan=a.id_karyawan WHERE a.username = '$username'");
$data = mysqli_fetch_array($sql_data);
$id_karyawan = $data['id_karyawan'];

      if($id_karyawan == 'adm1'){
        echo "<script>alert('Account Karyawan adm1 tidak bisa dihapus'); window.location='../view/Vaccount';</script>";exit;
      }



		$query = mysqli_query($koneksi,"DELETE FROM account WHERE username = '$username'");


        echo "<script>alert('Acoount Berhasil Di Hapus'); window.location='../view/VAccount';</script>";exit;
	
	