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

$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$kode_alkes = htmlspecialchars($_POST['kode_alkes']);


	

		$query = mysqli_query($koneksi,"DELETE FROM alat_kesehatan WHERE kode_alkes = '$kode_alkes'");



	
		echo "<script>alert('Riwayat Alat Kesehatan Berhasil di Hapus'); window.location='../view/VAlatKesehatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	