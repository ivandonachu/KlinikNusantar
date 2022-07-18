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
$antrian = htmlspecialchars($_POST['antrian']);
$no_antrian = htmlspecialchars($_POST['no_antrian']);
$tanggal = htmlspecialchars($_POST['tanggal']);
$nama_ruangan = htmlspecialchars($_POST['nama_ruangan']);
$status_antrian = 'Dalam Perawatan' ;
$tgl_antri = date("Y-m-d");

        
            



            $result = mysqli_query($koneksi, "SELECT * FROM antrian WHERE  kode_ruangan = 'RUA1' AND status_antrian = 'Dalam Perawatan' ");

            if(mysqli_num_rows($result) != 0 ){
                $data_antrian = mysqli_fetch_assoc($result);
                $no_antrianx = $data_antrian['no_antrian'];
                 //akses data ruangan
                $sql_ruangan = mysqli_query($koneksi, "SELECT kode_ruangan FROM ruangan WHERE nama_ruangan = '$nama_ruangan' ");
                $data_ruangan = mysqli_fetch_assoc($sql_ruangan);
                $kode_ruangan = $data_ruangan['kode_ruangan'];
                mysqli_query($koneksi,"UPDATE antrian SET status_antrian = 'Menunggu' WHERE no_antrian =  '$no_antrianx'");

                mysqli_query($koneksi,"INSERT INTO live_antrian VALUES('','$tanggal','$antrian','$kode_ruangan')");

                mysqli_query($koneksi,"UPDATE antrian SET status_antrian = '$status_antrian' WHERE no_antrian =  '$no_antrian'");
               
                    echo "<script>alert('Panggilan Berhasil'); window.location='../view/VAntrian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&antrian=$antrian';</script>";exit;




                }


        //akses data ruangan
        $sql_ruangan = mysqli_query($koneksi, "SELECT kode_ruangan FROM ruangan WHERE nama_ruangan = '$nama_ruangan' ");
        $data_ruangan = mysqli_fetch_assoc($sql_ruangan);
        $kode_ruangan = $data_ruangan['kode_ruangan'];


              mysqli_query($koneksi,"INSERT INTO live_antrian VALUES('','$tanggal','$antrian','$kode_ruangan')");

              mysqli_query($koneksi,"UPDATE antrian SET status_antrian = '$status_antrian' WHERE no_antrian =  '$no_antrian'");
               
                    echo "<script>alert('Panggilan Berhasil'); window.location='../view/VAntrian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&antrian=$antrian';</script>";exit;
     


     
        

       


  ?>