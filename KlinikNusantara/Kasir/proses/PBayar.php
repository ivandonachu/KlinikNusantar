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
$no_antrian = htmlspecialchars($_POST['no_antrian']);
$jenis_pembayaran = htmlspecialchars($_POST['jenis_pembayaran']);
$status_antrian = 'Selesai' ;

$sql_perawatan = mysqli_query($koneksi, "SELECT * FROM perawatan a INNER JOIN rekam_medis b ON a.no_rm=b.no_rm
                                                                    INNER JOIN pasien c ON c.no_rm=a.no_rm
                                                                    INNER JOIN antrian d ON d.no_antrian=a.no_antrian  
                                                                    INNER JOIN karyawan e ON e.id_karyawan=a.id_dokter  
                                                                    WHERE d.no_antrian = '$no_antrian' ");

$data_perawatan = mysqli_fetch_assoc($sql_perawatan);

$no_perawatan = $data_perawatan['no_perawatan'];
$tindakan_1 = $data_perawatan['tindakan_1'];
$tindakan_2 = $data_perawatan['tindakan_2'];
$tindakan_3 = $data_perawatan['tindakan_3'];
$tindakan_4 = $data_perawatan['tindakan_4'];


$alkes_1 = $data_perawatan['alkes_1'];
$qty_alkes_1 = $data_perawatan['qty_alkes_1'];
$alkes_2 = $data_perawatan['alkes_2'];
$qty_alkes_2 = $data_perawatan['qty_alkes_2'];
$alkes_3 = $data_perawatan['alkes_3'];
$qty_alkes_3 = $data_perawatan['qty_alkes_3'];
$alkes_4 = $data_perawatan['alkes_4'];
$qty_alkes_4 = $data_perawatan['qty_alkes_4'];

$obat_1 = $data_perawatan['obat_1'];
$qty_obat_1 = $data_perawatan['qty_obat_1'];
$obat_2 = $data_perawatan['obat_2'];
$qty_obat_2 = $data_perawatan['qty_obat_2'];
$obat_3 = $data_perawatan['obat_3'];
$qty_obat_3 = $data_perawatan['qty_obat_3'];
$obat_4 = $data_perawatan['obat_4'];
$qty_obat_4 = $data_perawatan['qty_obat_4'];
$total_pembayaran= 0;   

//tindkan
if($tindakan_1 != ""){
    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_1'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

    $harga = $data_tindakan['harga_tindakan'];

    $jumlah = 1 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}

if($tindakan_2 != ""){
    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_2'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

    $harga = $data_tindakan['harga_tindakan'];

    $jumlah = 1 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}

if($tindakan_3 != ""){
    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_3'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

    $harga = $data_tindakan['harga_tindakan'];

    $jumlah = 1 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}

if($tindakan_4 != ""){
    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_4'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

    $harga = $data_tindakan['harga_tindakan'];

    $jumlah = 1 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}



//Alkes
if($alkes_1 != ""){
    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_1'");
    $data_alkes = mysqli_fetch_assoc($sql_alkes);

    $harga = $data_alkes['harga_jual'];

    $jumlah = $qty_alkes_1 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}
if($alkes_2 != ""){
    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_2'");
    $data_alkes = mysqli_fetch_assoc($sql_alkes);

    $harga = $data_alkes['harga_jual'];

    $jumlah = $qty_alkes_2 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}
if($alkes_3!= ""){
    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_3'");
    $data_alkes = mysqli_fetch_assoc($sql_alkes);

    $harga = $data_alkes['harga_jual'];

    $jumlah = $qty_alkes_3 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}
if($alkes_4 != ""){
    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_4'");
    $data_alkes = mysqli_fetch_assoc($sql_alkes);

    $harga = $data_alkes['harga_jual'];

    $jumlah = $qty_alkes_4 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}

//Obat
if($obat_1 != ""){
    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_1'");
    $data_obat = mysqli_fetch_assoc($sql_obat);

    $harga = $data_obat['harga_jual'];

    $jumlah = $qty_obat_1 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}
if($obat_2 != ""){
    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_2'");
    $data_obat = mysqli_fetch_assoc($sql_obat);

    $harga = $data_obat['harga_jual'];

    $jumlah = $qty_obat_2 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}
if($obat_3 != ""){
    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_3'");
    $data_obat = mysqli_fetch_assoc($sql_obat);

    $harga = $data_obat['harga_jual'];

    $jumlah = $qty_obat_3 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}
if($obat_4 != ""){
    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_4'");
    $data_obat = mysqli_fetch_assoc($sql_obat);

    $harga = $data_obat['harga_jual'];

    $jumlah = $qty_obat_4 * $harga;
    $total_pembayaran = $total_pembayaran + $jumlah;
}



       mysqli_query($koneksi,"INSERT INTO pembayaran VALUES('','$no_perawatan','$jenis_pembayaran','$total_pembayaran')");
       mysqli_query($koneksi,"UPDATE antrian SET status_antrian = '$status_antrian' WHERE no_antrian =  '$no_antrian'");
                   	
	  echo "<script>alert('Pembayaran Berhasil'); window.location='../view/VAntrian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
     


                    
     
        

       


  ?>