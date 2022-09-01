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

$nama_tindakan = htmlspecialchars($_POST['nama_tindakan']);
$harga_tindakan = htmlspecialchars($_POST['harga_tindakan']);


    $no_kode = 1;
    

        $kode = 'TDN';

        $sql_data = mysqli_query($koneksi, "SELECT * FROM tindakan  ");
        
        if(mysqli_num_rows($sql_data) == 0 ){
            $kode_new = $kode.$no_kode;
            $query = mysqli_query($koneksi,"INSERT INTO tindakan VALUES('$kode_new','$nama_tindakan','$harga_tindakan','Aktif')");
               
                       echo "<script>alert('Data Tindakan Berhasil di input'); window.location='../view/VTindakan';</script>";exit;
        }

        while(mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;
            $kode_new = $kode.$no_kode;

            $sql_cek = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE kode_tindakan = '$kode_new' ");
            if(mysqli_num_rows($sql_cek) === 0 ){

                $query = mysqli_query($koneksi,"INSERT INTO tindakan VALUES('$kode_new','$nama_tindakan','$harga_tindakan','Aktif')");
               
                        echo "<script>alert('Data Tindakan Berhasil di input'); window.location='../view/VTindakan';</script>";exit;
        
            }
            

        }


     
        

       


  ?>