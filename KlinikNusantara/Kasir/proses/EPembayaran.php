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

$tanggal_awal = htmlspecialchars($_POST['tanggal1']);
$tanggal_akhir = htmlspecialchars($_POST['tanggal2']);
$no_pembayaran = htmlspecialchars($_POST['no_pembayaran']);
$jenis_pembayaran = htmlspecialchars($_POST['jenis_pembayaran']);
$total_bayar = htmlspecialchars($_POST['total_bayar']);



                mysqli_query($koneksi,"UPDATE pembayaran SET jenis_pembayaran = '$jenis_pembayaran' , jumlah_bayar = '$total_bayar'  WHERE no_pembayaran =  '$no_pembayaran'");
       
       
                echo "<script>alert('Data Pembayaran Berhasil di Edit'); window.location='../view/VPembayaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        
                
                 
          
                  

     
        

       


  ?>