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

    //akses data riwayat obat
    $sql_ri_obat = mysqli_query($koneksi, "SELECT * FROM riwayat_obat a INNER JOIN obat b ON b.kode_obat=a.kode_obat INNER JOIN karyawan c ON c.id_karyawan=a.id_karyawan WHERE no_riwayat = '$no_riwayat'");
    $data_ri_obat = mysqli_fetch_assoc($sql_ri_obat);
    $qty_obat_ri = $data_ri_obat['qty'];
    $kode_obat_ri = $data_ri_obat['kode_obat'];
    $status = $data_ri_obat['status'];


      //akses data obat yang di input
      $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE kode_obat = '$kode_obat_ri'");
      $data_obat = mysqli_fetch_assoc($sql_obat);

      $stok_obat = $data_obat['stok_obat'];
   
	
      if($status == 'Penambahan Stok'){
        $stok_obat_baru = $stok_obat - $qty_obat_ri;
        mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_ri'");
        $query = mysqli_query($koneksi,"DELETE FROM riwayat_obat WHERE no_riwayat = '$no_riwayat'");
      }
      else{
        $stok_obat_baru = $stok_obat + $qty_obat_ri;
        mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_ri'");
        $query = mysqli_query($koneksi,"DELETE FROM riwayat_obat WHERE no_riwayat = '$no_riwayat'");
   
      }

		



	
		echo "<script>alert('Riwayat Obat Berhasil di Hapus'); window.location='../view/VObat?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	