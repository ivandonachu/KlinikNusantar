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


$no_antrian = htmlspecialchars($_POST['no_antrian']);
$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);


	


		$query = mysqli_query($koneksi,"DELETE FROM antrian WHERE no_antrian = '$no_antrian'");



	
		echo "<script>alert('Hapus Antrian Berhasil'); window.location='../view/VAntrian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	