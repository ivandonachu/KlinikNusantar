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
$id_karyawan = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Admin') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = htmlspecialchars($_POST['tanggal']);
$nama_alkes = htmlspecialchars($_POST['nama_alkes']);
$status = htmlspecialchars($_POST['status']);
$qty = htmlspecialchars($_POST['qty']);
$harga = htmlspecialchars($_POST['harga']);
$nama_file = $_FILES['file']['name'];

if ($nama_file == "") {
	$file = "";
}

else if ( $nama_file != "" ) {

	function upload(){
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_admin/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}



      $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$nama_alkes'");
      $data_alkes = mysqli_fetch_assoc($sql_alkes);

      $kode_alkes = $data_alkes['kode_alkes'];
      $stok_alkes = $data_alkes['stok_alkes'];
      

      //proses tambah stok alkes
      if($status == 'Penambahan Stok'){
        $stok_alkes_baru = $stok_alkes + $qty;
        $jumlah = $qty * $harga;
      }
      else{
        $stok_alkes_baru = $stok_alkes - $qty;
        $jumlah = $qty * $harga_obat;
      }

      $query = mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
      $query = mysqli_query($koneksi,"INSERT INTO riwayat_alkes VALUES('','$tanggal','$id_karyawan','$kode_alkes','$status','$qty','$harga','$jumlah','$file')");
               
       
      echo "<script>alert('Riwayat Alat Kesehatan Berhasil di Input'); window.location='../view/VAlatKesehatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        

  ?>