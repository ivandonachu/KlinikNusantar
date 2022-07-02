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
$no_riwayat = htmlspecialchars($_POST['no_riwayat']);

    //akses data riwayat alkes
    $sql_ri_alkes = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes a INNER JOIN alat_kesehatan b ON b.kode_alkes=a.kode_alkes INNER JOIN karyawan c ON c.id_karyawan=a.id_karyawan WHERE no_riwayat = '$no_riwayat'");
    $data_ri_alkes = mysqli_fetch_assoc($sql_ri_alkes);
    $qty_alkes_ri = $data_ri_alkes['qty'];
    $kode_alkes_ri = $data_ri_alkes['kode_alkes'];
    $status = $data_ri_alkes['status'];


      //akses data alkes yang di input
      $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE kode_alkes = '$kode_alkes_ri'");
      $data_alkes = mysqli_fetch_assoc($sql_alkes);

      $stok_alkes = $data_alkes['stok_alkes'];
   
	
      if($status == 'Penambahan Stok'){
        $stok_alkes_baru = $stok_alkes - $qty_alkes_ri;
        mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_ri'");
        $query = mysqli_query($koneksi,"DELETE FROM riwayat_alkes WHERE no_riwayat = '$no_riwayat'");
      }
      else{
        $stok_alkes_baru = $stok_alkes + $qty_alkes_ri;
        mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_ri'");
        $query = mysqli_query($koneksi,"DELETE FROM riwayat_alkes WHERE no_riwayat = '$no_riwayat'");
   
      }

		



	
		echo "<script>alert('Riwayat Alat Kesehatan Berhasil di Hapus'); window.location='../view/VAlatKesehatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	