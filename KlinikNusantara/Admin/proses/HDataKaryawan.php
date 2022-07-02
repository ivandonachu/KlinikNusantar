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


$id_karyawan = htmlspecialchars($_POST['id_karyawan']);


	
		if($id_karyawan == 'adm1'){
			echo "<script>alert('Data Karyawan adm1 tidak bisa dihapus'); window.location='../view/VKaryawan';</script>";exit;
		}
		

		$query = mysqli_query($koneksi,"DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'");



	
		echo "<script>alert('Data Karyawan Berhasil Di Hapus'); window.location='../view/VKaryawan';</script>";exit;
	