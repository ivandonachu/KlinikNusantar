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

$tanggal = htmlspecialchars($_POST['tanggal']);
$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$no_riwayat = htmlspecialchars($_POST['no_riwayat']);
$nama_obat = htmlspecialchars($_POST['nama_obat']);
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
      //akses data riwayat obat
      $sql_ri_obat = mysqli_query($koneksi, "SELECT * FROM riwayat_obat a INNER JOIN obat b ON b.kode_obat=a.kode_obat INNER JOIN karyawan c ON c.id_karyawan=a.id_karyawan WHERE no_riwayat = '$no_riwayat'");
      $data_ri_obat = mysqli_fetch_assoc($sql_ri_obat);
      $qty_obat_ri = $data_ri_obat['qty'];
      $nama_obat_ri = $data_ri_obat['nama_obat'];
      $kode_obat_ri = $data_ri_obat['kode_obat'];
      $stok_obat_ri = $data_ri_obat['stok_obat'];

      //akses data obat yang di input
      $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$nama_obat'");
      $data_obat = mysqli_fetch_assoc($sql_obat);

      $kode_obat = $data_obat['kode_obat'];
      $harga_obat = $data_obat['harga_obat'];
      $stok_obat = $data_obat['stok_obat'];
      
      if($nama_obat_ri == $nama_obat){
        if($status == 'Penambahan Stok'){
          $stok_obat_baru = ($stok_obat - $qty_obat_ri) + $qty;
          $jumlah = $qty * $harga;
          
          if ($file == '') {
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
            mysqli_query($koneksi,"UPDATE riwayat_obat SET kode_obat = '$kode_obat' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

          }
          else{
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
            mysqli_query($koneksi,"UPDATE riwayat_obat SET kode_obat = '$kode_obat' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah', file_bukti = '$file' WHERE no_riwayat =  '$no_riwayat'");
          }

        }
        else{
          $stok_obat_baru = ($stok_obat + $qty_obat_ri) - $qty;
          $jumlah = $qty * $harga;
          
          if ($file == '') {
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
            mysqli_query($koneksi,"UPDATE riwayat_obat SET kode_obat = '$kode_obat' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
          }
          else{
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
            mysqli_query($koneksi,"UPDATE riwayat_obat SET kode_obat = '$kode_obat' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah', file_bukti = '$file' WHERE no_riwayat =  '$no_riwayat'");
          }
        }
      }
      else{
        if($status == 'Penambahan Stok'){
          $stok_obat_baru_ri = $stok_obat_ri - $qty_obat_ri;
          $stok_obat_baru = $stok_obat + $qty;
          $jumlah = $qty * $harga;
          
          if ($file == '') {
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru_ri' WHERE kode_obat =  '$kode_obat_ri'");
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
            mysqli_query($koneksi,"UPDATE riwayat_obat SET kode_obat = '$kode_obat' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
          }
          else{
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru_ri' WHERE kode_obat =  '$kode_obat_ri'");
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
            mysqli_query($koneksi,"UPDATE riwayat_obat SET kode_obat = '$kode_obat' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah', file_bukti = '$file' WHERE no_riwayat =  '$no_riwayat'");
          }

        }
        else{
          $stok_obat_baru_ri = $stok_obat_ri + $qty_obat_ri;
          $stok_obat_baru = $stok_obat - $qty;
          $jumlah = $qty * $harga;
          
          if ($file == '') {
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru_ri' WHERE kode_obat =  '$kode_obat_ri'");
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
            mysqli_query($koneksi,"UPDATE riwayat_obat SET kode_obat = '$kode_obat' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
          }
          else{
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru_ri' WHERE kode_obat =  '$kode_obat_ri'");
            mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
            mysqli_query($koneksi,"UPDATE riwayat_obat SET kode_obat = '$kode_obat' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah', file_bukti = '$file' WHERE no_riwayat =  '$no_riwayat'");
          }
        }
      }

          
     
       
             echo "<script>alert('Riwayat Obat Berhasil di Edit'); window.location='../view/VObat?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        

  ?>
