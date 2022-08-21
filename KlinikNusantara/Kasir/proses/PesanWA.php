<?php 
include 'koneksi.php';

$no_perawatan = $_GET['no_perawatan'];
$hari_tanggal = $_GET['hari_tanggal'];
$nama_karyawan = $_GET['nama_karyawan'];
$nama_pasien = $_GET['nama_pasien'];
$no_hpx = $_GET['no_hpx'];

mysqli_query($koneksi,"INSERT INTO riwayat_wa VALUES('','$no_perawatan')");


$token = "kbjso4DswcPFMRjNshP6AKpXcjEoEaC47jYqs7bxnneUofBL45";
$phone= $no_hpx; //untuk group pakai groupid contoh: 62812xxxxxx-xxxxx
$message = "Selamat Pagi Kak  $nama_pasien  😊

Dari BIG DENTAL CLINIC 

Kami menginformasikan bahwa besok *$hari_tanggal* Ada jadwal kontrol dengan *$nama_karyawan* 

Terimakasih 🙏

Apapun Keluhanya, Perawatanya hanya di *Klinik Nusantara!* 💗";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'token='.$token.'&number='.$phone.'&message='.$message,
));
$response = curl_exec($curl);
curl_close($curl);
echo "<script> window.close();</script>";exit; 