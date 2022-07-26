<?php 
include 'koneksi.php';

$no_perawatan = $_GET['no_perawatan'];
$tanggal_cekUP_selanjutnya = $_GET['tanggal_cekUP_selanjutnya'];
$nama_karyawan = $_GET['nama_karyawan'];
$nama_pasien = $_GET['nama_pasien'];
$no_hpx = $_GET['no_hpx'];

mysqli_query($koneksi,"INSERT INTO riwayat_wa VALUES('','$no_perawatan')");



$api_key   = '131497cc55cd7a73209492cceeeedcf3bfba87a1'; // API KEY Anda
$id_device = '6194'; // ID DEVICE yang di SCAN (Sebagai pengirim)
$url   = 'https://api.watsap.id/send-message'; // URL API
$no_hp = $no_hpx; // No.HP yang dikirim (No.HP Penerima)
$pesan = 'Selamat Pagi Kak '. $nama_pasien  .' 😊

Dari klinik Nusantara 

Kami menginformasikan bahwa besok '. $tanggal_cekUP_selanjutnya .' , Ada jadwal kontrol dengan '. $nama_karyawan .' 

Terimakasih 🙏

Apapun Keluhanya, Perawatanya hanya di Klinik Nusantara! 💗'; // Pesan yang dikirim

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);

$data_post = [
   'id_device' => $id_device,
   'api-key' => $api_key,
   'no_hp'   => $no_hp,
   'pesan'   => $pesan
];
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($curl);
curl_close($curl);
echo $response;

echo "<script> window.close();</script>";exit; 