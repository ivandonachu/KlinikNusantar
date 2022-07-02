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

//change password
$username = htmlspecialchars($_POST['username']);
$password_baru1 = $username;
    
   
                    $password_baru1 = password_hash($password_baru1, PASSWORD_DEFAULT);
                    mysqli_query($koneksi,"UPDATE account SET password = '$password_baru1' WHERE username =  '$username'");
                    echo "<script>alert('Password Berhasil Di Reset'); window.location='../view/VAccount';</script>";exit;

           



	
