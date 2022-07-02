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

$nama_karyawan = htmlspecialchars($_POST['nama_karyawan']);
$jabatan = htmlspecialchars($_POST['jabatan']);
$no_hp = htmlspecialchars($_POST['no_hp']);
$alamat = htmlspecialchars($_POST['alamat']);

    $no_kode = 0;
    
    if($jabatan == 'Perawat'){
        $kode = 'pwt';

        $sql_data = mysqli_query($koneksi, "SELECT * FROM karyawan  ");
        while($data_karyawan = mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;

            $id_new = $kode.$no_kode;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id_new' ");
            if(mysqli_num_rows($sql_cek) === 0 ){

                $query = mysqli_query($koneksi,"INSERT INTO karyawan VALUES('$id_new','$nama_karyawan','$jabatan','$no_hp','$alamat','')");
           
                    echo "<script>alert('Data Karyawan Berhasil di input'); window.location='../view/VKaryawan';</script>";exit;
        
            }
           

        }
    }
    else if($jabatan == 'Dokter'){
        $kode = 'dkr';
        
        $sql_data = mysqli_query($koneksi, "SELECT * FROM karyawan");
        while($data_karyawan = mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;

            $id_new = $kode.$no_kode;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE  id_karyawan = '$id_new' ");
            if(mysqli_num_rows($sql_cek) === 0 ){

                $query = mysqli_query($koneksi,"INSERT INTO karyawan VALUES('$id_new','$nama_karyawan','$jabatan','$no_hp','$alamat','')");
           
                    echo "<script>alert('Data Karyawan Berhasil di input'); window.location='../view/VKaryawan';</script>";exit;
        
            }
           

        }
    }
    else if($jabatan == 'Kasir'){
        $kode = 'ksr';
        
        $sql_data = mysqli_query($koneksi, "SELECT * FROM karyawan ");
        while($data_karyawan = mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;

            $id_new = $kode.$no_kode;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id_new' ");
            if(mysqli_num_rows($sql_cek) === 0 ){

                $query = mysqli_query($koneksi,"INSERT INTO karyawan VALUES('$id_new','$nama_karyawan','$jabatan','$no_hp','$alamat','')");
           
                    echo "<script>alert('Data Karyawan Berhasil di input'); window.location='../view/VKaryawan';</script>";exit;
        
            }
           

        }
    }
    else if($jabatan == 'Manager'){
        $kode = 'mng';
        
        $sql_data = mysqli_query($koneksi, "SELECT * FROM karyawan ");
        while($data_karyawan = mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;

            $id_new = $kode.$no_kode;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id_new' ");
            if(mysqli_num_rows($sql_cek) === 0 ){

                $query = mysqli_query($koneksi,"INSERT INTO karyawan VALUES('$id_new','$nama_karyawan','$jabatan','$no_hp','$alamat','')");
           
                    echo "<script>alert('Data Karyawan Berhasil di input'); window.location='../view/VKaryawan';</script>";exit;
        
            }
           

        }
    }
    else if($jabatan == 'Admin'){
        $kode = 'adm';
        
        $sql_data = mysqli_query($koneksi, "SELECT * FROM karyawan ");
        while($data_karyawan = mysqli_fetch_array($sql_data)){
            $no_kode = $no_kode + 1;

            $id_new = $kode.$no_kode;
            $sql_cek = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id_new' ");
            if(mysqli_num_rows($sql_cek) === 0 ){

                $query = mysqli_query($koneksi,"INSERT INTO karyawan VALUES('$id_new','$nama_karyawan','$jabatan','$no_hp','$alamat','')");
           
                    echo "<script>alert('Data Karyawan Berhasil di input'); window.location='../view/VKaryawan';</script>";exit;
        
            }
           

        }
        

    }




  ?>