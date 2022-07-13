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
if ($jabatan_valid == 'Dokter') {

}

else{  header("Location: logout.php");
exit;
}


                $no_antrian = htmlspecialchars($_POST['no_antrian']);

                $status_antrian = 'Pembayaran' ;

                mysqli_query($koneksi,"UPDATE antrian SET status_antrian = '$status_antrian' WHERE no_antrian =  '$no_antrian'");

                            
       
       
                echo "<script>alert('Antrian Berhasil di Selesaikan'); window.location='../view/DsDokter';</script>";exit;
        
                
                 
          
                  

     
        

       


  ?>