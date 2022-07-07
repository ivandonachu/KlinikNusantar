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
$nama_alkes = htmlspecialchars($_POST['nama_alkes']);
$status = 'PNB';
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
      //akses data riwayat kode_alkes
      $sql_ri_alkes = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes a INNER JOIN alat_kesehatan b ON b.kode_alkes=a.kode_alkes INNER JOIN karyawan c ON c.id_karyawan=a.id_karyawan WHERE no_riwayat = '$no_riwayat'");
      $data_ri_alkes = mysqli_fetch_assoc($sql_ri_alkes);
      $qty_alkes_ri = $data_ri_alkes['qty'];
      $nama_alkes_ri = $data_ri_alkes['nama_alkes'];
      $kode_alkes_ri = $data_ri_alkes['kode_alkes'];
      $stok_alkes_ri = $data_ri_alkes['stok_alkes'];

      //akses data nama_alkes yang di input
      $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$nama_alkes'");
      $data_alkes = mysqli_fetch_assoc($sql_alkes);

      $kode_alkes = $data_alkes['kode_alkes'];
      $harga_alkes = $data_alkes['harga_alkes'];
      $stok_alkes = $data_alkes['stok_alkes'];
      
      if($nama_alkes_ri == $nama_alkes){
        if($status == 'PNB'){
          $stok_alkes_baru = ($stok_alkes - $qty_alkes_ri) + $qty;
          $jumlah = $qty * $harga;
          
          if ($file == '') {
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
            mysqli_query($koneksi,"UPDATE riwayat_alkes SET kode_alkes = '$kode_alkes' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

          }
          else{
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
            mysqli_query($koneksi,"UPDATE riwayat_alkes SET kode_alkes = '$kode_alkes' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah', file_bukti = '$file' WHERE no_riwayat =  '$no_riwayat'");
          }

        }
        else{
          $stok_alkes_baru = ($stok_alkes + $qty_alkes_ri) - $qty;
          $jumlah = $qty * $harga;
          
          if ($file == '') {
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
            mysqli_query($koneksi,"UPDATE riwayat_alkes SET kode_alkes = '$kode_alkes' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
          }
          else{
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
            mysqli_query($koneksi,"UPDATE riwayat_alkes SET kode_alkes = '$kode_alkes' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah', file_bukti = '$file' WHERE no_riwayat =  '$no_riwayat'");
          }
        }
      }
      else{
        if($status == 'PNB'){
          $stok_obat_baru_ri = $stok_alkes_ri - $qty_alkes_ri;
          $stok_alkes_baru = $stok_alkes + $qty;
          $jumlah = $qty * $harga;
          
          if ($file == '') {
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_obat_baru_ri' WHERE kode_alkes =  '$kode_alkes_ri'");
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
            mysqli_query($koneksi,"UPDATE riwayat_alkes SET kode_alkes = '$kode_alkes' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
          }
          else{
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_obat_baru_ri' WHERE kode_alkes =  '$kode_alkes_ri'");
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
            mysqli_query($koneksi,"UPDATE riwayat_alkes SET kode_alkes = '$kode_alkes' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah', file_bukti = '$file' WHERE no_riwayat =  '$no_riwayat'");
          }

        }
        else{
          $stok_obat_baru_ri = $stok_alkes_ri + $qty_alkes_ri;
          $stok_alkes_baru = $stok_alkes - $qty;
          $jumlah = $qty * $harga;
          
          if ($file == '') {
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_obat_baru_ri' WHERE kode_alkes =  '$kode_alkes_ri'");
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
            mysqli_query($koneksi,"UPDATE riwayat_alkes SET kode_alkes = '$kode_alkes' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
          }
          else{
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_obat_baru_ri' WHERE kode_alkes =  '$kode_alkes_ri'");
            mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
            mysqli_query($koneksi,"UPDATE riwayat_alkes SET kode_alkes = '$kode_alkes' , tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , qty = '$qty' , harga = '$harga' , jumlah = '$jumlah', file_bukti = '$file' WHERE no_riwayat =  '$no_riwayat'");
          }
        }
      }

          
     
       
           echo "<script>alert('Riwayat Alat Kesehatan Berhasil di Edit'); window.location='../view/VAlatKesehatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        

  ?>
