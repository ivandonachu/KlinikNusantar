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


	


		$query = mysqli_query($koneksi,"DELETE FROM pasien WHERE id_pasien = '$id_pasien'");



	
		echo "<script>alert('Data Pasien Berhasil di Hapus'); window.location='../view/VDataPasien';</script>";exit;
	