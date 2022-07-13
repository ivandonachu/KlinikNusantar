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

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$nama_obat = htmlspecialchars($_POST['nama_obat']);
$harga_beli = htmlspecialchars($_POST['harga_beli']);
$harga_jual = htmlspecialchars($_POST['harga_jual']);
$stok_awal = htmlspecialchars($_POST['stok_awal']);
$satuan = htmlspecialchars($_POST['satuan']);
$deskripsi = htmlspecialchars($_POST['deskripsi']);


    $no_kode = 1;
    

        $kode = 'OBT';

        $sql_data = mysqli_query($koneksi, "SELECT * FROM obat  ");
        
        if(mysqli_num_rows($sql_data) == 0 ){
            $kode_new = $kode.$no_kode;
            mysqli_query($koneksi,"INSERT INTO obat VALUES('$kode_new','$nama_obat','$harga_beli','$harga_jual','$stok_awal','$satuan','$deskripsi')");
               
            echo "<script>alert('Riwayat Obat Berhasil di Input'); window.location='../view/VObat?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        }

        while(mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;
            $kode_new = $kode.$no_kode;

            $sql_obat = mysqli_query($koneksi, "SELECT kode_obat FROM obat WHERE kode_obat = '$kode_new' ");
            $data_obat = mysqli_fetch_assoc($sql_obat);
            if(!isset($data_obat['kode_obat'])){
             mysqli_query($koneksi,"INSERT INTO obat VALUES('$kode_new','$nama_obat','$harga_beli','$harga_jual','$stok_awal','$satuan','$deskripsi')");
               
                echo "<script>alert('Riwayat Obat Berhasil di Input'); window.location='../view/VObat?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
            
            }

            

        }


     
        

       


  ?>