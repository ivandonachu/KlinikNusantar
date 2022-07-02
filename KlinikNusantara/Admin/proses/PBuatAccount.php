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
$username = htmlspecialchars($_POST['username']);
$password1 = htmlspecialchars($_POST['password1']);
$password2 = htmlspecialchars($_POST['password2']);


    
    $sql_username = mysqli_query($koneksi, "SELECT * FROM karyawan a INNER JOIN account b on b.id_karyawan=a.id_karyawan WHERE b.username = '$username'");
    $sql_pengguna = mysqli_query($koneksi, "SELECT * FROM karyawan a INNER JOIN account b on b.id_karyawan=a.id_karyawan WHERE a.nama_karyawan = '$nama_karyawan'");
    $jml_char_pw = strlen($password1);
    $jml_char_username = strlen($username);
    if (count(explode(' ', $username)) > 1){
        echo "<script>alert('username tidak boleh ada spasi'); window.location='../view/VAccount';</script>";exit;
    }
    else if ($jml_char_username<8){
        echo "<script>alert('username harus lebih dari 8 huruf'); window.location='../view/VAccount';</script>";exit;
    }
    else if(mysqli_num_rows($sql_username) === 1 ){

        echo "<script>
            alert('username sudah di terdaftar !'); window.location='../view/Vaccount'; </script>";
                return false;
    }
    else if(mysqli_num_rows($sql_pengguna) === 1 ){

        echo "<script>
            alert('pengguna sudah ada akun !'); window.location='../view/Vaccount'; </script>";
                return false;
    }
    else if (count(explode(' ', $password1)) > 1){
        echo "<script>alert('password tidak boleh ada spasi'); window.location='../view/VAccount';</script>";exit;
    }
    else if($jml_char_pw < 8){
        echo "<script>alert('Password harus lebih dari 8 huruf'); window.location='../view/VAccount';</script>";exit;
    }
    else if ($jml_char_pw >15){
        echo "<script>alert('Password harus kurang dari 15 huruf'); window.location='../view/VAccount';</script>";exit;
    }
    else if ($password1 !== $password2){
        echo "<script>alert('Password baru tidak cocok'); window.location='../view/VAccount';</script>";exit;
    }
      $sql_karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nama_karyawan = '$nama_karyawan'");
      $data_karyawan = mysqli_fetch_assoc($sql_karyawan);
      $id_karyawan = $data_karyawan['id_karyawan'];
      $jabatan = $data_karyawan['jabatan'];
      $password = password_hash($password1, PASSWORD_DEFAULT);
      $query = mysqli_query ($koneksi,"INSERT INTO account VALUES('$username','$password','$id_karyawan')");
      
      if ($query!= "") {
      echo "<script>
              alert('ANDA TELAH MEMBUAT AKUN KARYAWAN  BARU !'); window.location='../view/VAccount';</script>";
      }

  ?>