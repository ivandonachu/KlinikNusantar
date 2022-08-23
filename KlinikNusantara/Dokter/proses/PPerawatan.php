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
$tanggal_antrian = htmlspecialchars($_POST['tanggal_antrian']);
$id_pasien = htmlspecialchars($_POST['id_pasien']);
$no_rm = htmlspecialchars($_POST['no_rm']);
$diagnosis = htmlspecialchars($_POST['diagnosis']);

$resep = htmlspecialchars($_POST['resep']);
$tanggal_cek_selanjutnya = htmlspecialchars($_POST['tanggal_cek_selanjutnya']);
$pesan = htmlspecialchars($_POST['pesan']);
$status = 'PGN';

//cek tindakan
if (isset($_POST['tindakan_1'])) {
  $tindakan_1 =  htmlspecialchars($_POST['tindakan_1']);
  $qty_tindakan_1 = htmlspecialchars($_POST['qty_tindakan_1']);

  if($qty_tindakan_1 == "" ){
    echo "<script>alert('Qty Tindakan kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

} else{
  $tindakan_1 = "";
  $qty_tindakan_1 = "";
}
if (isset($_POST['tindakan_2'])) {
  $tindakan_2 =  htmlspecialchars($_POST['tindakan_2']);
  $qty_tindakan_2 = htmlspecialchars($_POST['qty_tindakan_2']);

  if($qty_tindakan_2 == "" ){
    echo "<script>alert('Qty Tindakan kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

} else{
  $tindakan_2 = "";
  $qty_tindakan_2 = "";
}
if (isset($_POST['tindakan_3'])) {
  $tindakan_3 =  htmlspecialchars($_POST['tindakan_3']);
  $qty_tindakan_3 = htmlspecialchars($_POST['qty_tindakan_3']);

  if($qty_tindakan_3 == "" ){
    echo "<script>alert('Qty Tindakan kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

} else{
  $tindakan_3 = "";
  $qty_tindakan_3 = "";
}
if (isset($_POST['tindakan_4'])) {
  $tindakan_4 =  htmlspecialchars($_POST['tindakan_4']);
  $qty_tindakan_4 = htmlspecialchars($_POST['qty_tindakan_4']);

  if($qty_tindakan_4 == "" ){
    echo "<script>alert('Qty Tindakan kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

} else{
  $tindakan_4 = "";
  $qty_tindakan_4 = "";
}

    
//Input Data alkes
if(isset($_POST['alkes_1'])){
  $alkes_1 = htmlspecialchars($_POST['alkes_1']);
  $qty_alkes_1 = htmlspecialchars($_POST['qty_alkes_1']);

  if($qty_alkes_1 == "" ){
    echo "<script>alert('Qty alat kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }
  
} else{
  $alkes_1 = "";
  $qty_alkes_1 = "";
}

if (isset($_POST['alkes_2'])) {
  $alkes_2 = htmlspecialchars($_POST['alkes_2']); 
  $qty_alkes_2 = htmlspecialchars($_POST['qty_alkes_2']);

  if($qty_alkes_2 == "" ){
    echo "<script>alert('Qty alat kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }
  
} else{
  $alkes_2 = "";
  $qty_alkes_2 = "";
}


if (isset($_POST['alkes_3'])) {
$alkes_3 =  htmlspecialchars($_POST['alkes_3']); 
$qty_alkes_3 = htmlspecialchars($_POST['qty_alkes_3']);

  if($qty_alkes_3 == "" ){
    echo "<script>alert('Qty alat kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

} else{
  $alkes_3 = "";
  $qty_alkes_3 = "";
}


if (isset($_POST['alkes_4'])) {
  $alkes_4 =  htmlspecialchars($_POST['alkes_4']);
  $qty_alkes_4 = htmlspecialchars($_POST['qty_alkes_4']);

  if($qty_alkes_4 == "" ){
    echo "<script>alert('Qty alat kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }
  
} else{
  $alkes_4 = "";
  $qty_alkes_4 = "";
}



//Input Data obat
if(isset($_POST['obat_1'])){
  $obat_1 = htmlspecialchars($_POST['obat_1']); 
  $qty_obat_1 = htmlspecialchars($_POST['qty_obat_1']); 

  if($qty_obat_1 == "" ){
    echo "<script>alert('Qty obat yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

} else{
  $obat_1 = ""; 
  $qty_obat_1 = ""; 
}

if (isset($_POST['obat_2'])) {
  $obat_2 = htmlspecialchars($_POST['obat_2']); 
  $qty_obat_2 =  htmlspecialchars($_POST['qty_obat_2']); 

  if($qty_obat_2 == "" ){
    echo "<script>alert('Qty obat yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }
}  else{
  $obat_2 = ""; 
  $qty_obat_2 = ""; 
}

if (isset($_POST['obat_3'])) {
  $obat_3 =  htmlspecialchars($_POST['obat_3']);
  $qty_obat_3 =  htmlspecialchars($_POST['qty_obat_3']);

  if($qty_obat_3 == "" ){
    echo "<script>alert('Qty obat yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

}  else{
  $obat_3 = ""; 
  $qty_obat_3 = ""; 
}

if (isset($_POST['obat_4'])) {
  $obat_4 =  htmlspecialchars($_POST['obat_4']); 
  $qty_obat_4 = htmlspecialchars($_POST['qty_obat_4']); 

  if($qty_obat_4 == "" ){
    echo "<script>alert('Qty obat yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }
} else{
  $obat_4 = ""; 
  $qty_obat_4 = ""; 
}


if($tindakan_1 != ""){
  if($tindakan_2 != ""){
    if( $tindakan_1 == $tindakan_2){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($tindakan_3 != ""){
    if( $tindakan_1 == $tindakan_3){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($tindakan_4 != ""){
    if( $tindakan_1 == $tindakan_4){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}
else if($tindakan_2 != ""){
  if($tindakan_3 != ""){
    if( $tindakan_2 == $tindakan_3){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($tindakan_4 != ""){
    if( $tindakan_2 == $tindakan_4){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}
else if($tindakan_3 != ""){
  if($tindakan_4 != ""){
    if( $tindakan_3 == $tindakan_4){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}


if($alkes_1 != ""){
  if($alkes_2 != ""){
    if( $alkes_1 == $alkes_2){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($alkes_3 != ""){
    if( $alkes_1 == $alkes_3){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($alkes_4 != ""){
    if( $alkes_1 == $alkes_4){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}
else if($alkes_2 != ""){
  if($alkes_3 != ""){
    if( $alkes_2 == $alkes_3){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($alkes_4 != ""){
    if( $alkes_2 == $alkes_4){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}
else if($alkes_3 != ""){
  if($alkes_4 != ""){
    if( $alkes_3 == $alkes_4){
      echo "<script>alert('Ada data alat kesehatan yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}


if($obat_1 != ""){
  if($obat_2 != ""){
    if( $obat_1 == $obat_2){
      echo "<script>alert('Ada data obat yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($obat_3 != ""){
    if( $obat_1 == $obat_3){
      echo "<script>alert('Ada data obat yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($obat_4 != ""){
    if( $obat_1 == $obat_4){
      echo "<script>alert('Ada data obat yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}
else if($obat_2 != ""){
  if($obat_3 != ""){
    if( $obat_2 == $obat_3){
      echo "<script>alert('Ada data obat yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
  else if($obat_4 != ""){
    if( $obat_2 == $obat_4){
      echo "<script>alert('Ada data obat yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}
else if($obat_3 != ""){
  if($obat_4 != ""){
    if( $obat_3 == $obat_4){
      echo "<script>alert('Ada data obat yang dobel input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
   }
  }
}



$tgl_antri = date("Y-m-d");

    $result = mysqli_query($koneksi, "SELECT * FROM antrian a INNER JOIN perawatan b on b.no_antrian=a.no_antrian WHERE id_pasien ='$id_pasien' AND tanggal = '$tgl_antri' AND b.no_antrian = '$no_antrian' ");
    if(mysqli_num_rows($result) == 1 ){
    

      echo "<script>alert('Data Perawatan Pasien hari ini sudah di inputkan'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
        }

        mysqli_query($koneksi,"INSERT INTO perawatan VALUES('','$no_rm','$no_antrian','$id1','$diagnosis','$tanggal_cek_selanjutnya','$resep','$pesan','$tindakan_1','$qty_tindakan_1','$tindakan_2','$qty_tindakan_2','$tindakan_3','$qty_tindakan_3','$tindakan_4','$qty_tindakan_4'
                                                            ,'$alkes_1','$qty_alkes_1','$alkes_2','$qty_alkes_2','$alkes_3','$qty_alkes_3','$alkes_4','$qty_alkes_4'
                                                            ,'$obat_1','$qty_obat_1','$obat_2','$qty_obat_2','$obat_3','$qty_obat_3','$obat_4','$qty_obat_4')");

      $sql_perawatan = mysqli_query($koneksi, "SELECT * FROM perawatan a INNER JOIN antrian b on b.no_antrian=a.no_antrian WHERE id_pasien ='$id_pasien' AND tanggal = '$tgl_antri' AND b.no_antrian = '$no_antrian' ");
      $data_perawatan = mysqli_fetch_assoc($sql_perawatan);
      $no_perawatan = $data_perawatan['no_perawatan'];
       
//tindakan 
//tindakan 1
if (isset($_POST['tindakan_1'])) {
  $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_1'");
  $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

  $kode_tindakan = $data_tindakan['kode_tindakan'];
  $harga_tindakan = $data_tindakan['harga_tindakan'];
  $jumlah = $qty_tindakan_1 * $harga_tindakan;

  mysqli_query($koneksi,"INSERT INTO riwayat_tindakan VALUES('','$no_perawatan','$id1','$kode_tindakan','$qty_tindakan_1','$jumlah')");

} 
//tindakan 1
if (isset($_POST['tindakan_2'])) {
  $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_2'");
  $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

  $kode_tindakan = $data_tindakan['kode_tindakan'];
  $harga_tindakan = $data_tindakan['harga_tindakan'];
  $jumlah = $qty_tindakan_2 * $harga_tindakan;
  

  mysqli_query($koneksi,"INSERT INTO riwayat_tindakan VALUES('','$no_perawatan','$id1','$kode_tindakan','$qty_tindakan_2','$jumlah')");

} 
//tindakan 1
if (isset($_POST['tindakan_3'])) {
  $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_3'");
  $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

  $kode_tindakan = $data_tindakan['kode_tindakan'];
  $harga_tindakan = $data_tindakan['harga_tindakan'];

  $jumlah = $qty_tindakan_3 * $harga_tindakan;
  

  mysqli_query($koneksi,"INSERT INTO riwayat_tindakan VALUES('','$no_perawatan','$id1','$kode_tindakan','$qty_tindakan_3','$jumlah')");

} 
//tindakan 4
if (isset($_POST['tindakan_4'])) {
  $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_4'");
  $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

  $kode_tindakan = $data_tindakan['kode_tindakan'];
  $harga_tindakan = $data_tindakan['harga_tindakan'];

  $jumlah = $qty_tindakan_4 * $harga_tindakan;
  

  mysqli_query($koneksi,"INSERT INTO riwayat_tindakan VALUES('','$no_perawatan','$id1','$kode_tindakan','$qty_tindakan_4','$jumlah')");

} 

//Input Data alkes
if(isset($_POST['alkes_1'])){


      $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_1'");
      $data_alkes = mysqli_fetch_assoc($sql_alkes);

      $kode_alkes = $data_alkes['kode_alkes'];
      $stok_alkes = $data_alkes['stok_alkes'];
      $harga = $data_alkes['harga_jual'];

      $stok_alkes_baru = $stok_alkes - $qty_alkes_1;
      $jumlah = $qty_alkes_1 * $harga;

      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
      mysqli_query($koneksi,"INSERT INTO riwayat_alkes_perawatan VALUES('','$no_perawatan','$id1','$kode_alkes','$status','$qty_alkes_1','$jumlah')");
} else{
  $alkes_1 = "";
  $qty_alkes_1 = "";
}

if (isset($_POST['alkes_2'])) {


$sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_2'");
      $data_alkes = mysqli_fetch_assoc($sql_alkes);

      $kode_alkes = $data_alkes['kode_alkes'];
      $stok_alkes = $data_alkes['stok_alkes'];
      $harga = $data_alkes['harga_jual'];

      $stok_alkes_baru = $stok_alkes - $qty_alkes_2;
      $jumlah = $qty_alkes_2 * $harga;

      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
      mysqli_query($koneksi,"INSERT INTO riwayat_alkes_perawatan VALUES('','$no_perawatan','$id1','$kode_alkes','$status','$qty_alkes_2','$jumlah')");
} else{
  $alkes_2 = "";
  $qty_alkes_2 = "";
}


if (isset($_POST['alkes_3'])) {


$sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_3'");
      $data_alkes = mysqli_fetch_assoc($sql_alkes);

      $kode_alkes = $data_alkes['kode_alkes'];
      $stok_alkes = $data_alkes['stok_alkes'];
      $harga = $data_alkes['harga_jual'];

      $stok_alkes_baru = $stok_alkes - $qty_alkes_3;
      $jumlah = $qty_alkes_3 * $harga;

      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
      mysqli_query($koneksi,"INSERT INTO riwayat_alkes_perawatan VALUES('','$no_perawatan','$id1','$kode_alkes','$status','$qty_alkes_3','$jumlah')");
} else{
  $alkes_3 = "";
  $qty_alkes_3 = "";
}


if (isset($_POST['alkes_4'])) {


$sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_4'");
      $data_alkes = mysqli_fetch_assoc($sql_alkes);

      $kode_alkes = $data_alkes['kode_alkes'];
      $stok_alkes = $data_alkes['stok_alkes'];
      $harga = $data_alkes['harga_jual'];

      $stok_alkes_baru = $stok_alkes - $qty_alkes_4;
      $jumlah = $qty_alkes_4 * $harga;

      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
      mysqli_query($koneksi,"INSERT INTO riwayat_alkes_perawatan VALUES('','$no_perawatan','$id1','$kode_alkes','$status','$qty_alkes_4','$jumlah')");
} else{
  $alkes_4 = "";
  $qty_alkes_4 = "";
}



//Input Data obat
if(isset($_POST['obat_1'])){


  $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_1'");
      $data_obat = mysqli_fetch_assoc($sql_obat);

      $kode_obat = $data_obat['kode_obat'];
      $stok_obat = $data_obat['stok_obat'];
      $harga = $data_obat['harga_jual'];

      $stok_obat_baru = $stok_obat - $qty_obat_1;
      $jumlah = $qty_obat_1 * $harga;
      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
      mysqli_query($koneksi,"INSERT INTO riwayat_obat_perawatan VALUES('','$no_perawatan','$id1','$kode_obat','$status','$qty_obat_1','$jumlah')");
} else{
  $obat_1 = ""; 
  $qty_obat_1 = ""; 
}

if (isset($_POST['obat_2'])) {


$sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_2'");
      $data_obat = mysqli_fetch_assoc($sql_obat);

      $kode_obat = $data_obat['kode_obat'];
      $stok_obat = $data_obat['stok_obat'];
      $harga = $data_obat['harga_jual'];

      $stok_obat_baru = $stok_obat - $qty_obat_2;
      $jumlah = $qty_obat_2 * $harga;
      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
      mysqli_query($koneksi,"INSERT INTO riwayat_obat_perawatan VALUES('','$no_perawatan','$id1','$kode_obat','$status','$qty_obat_2','$jumlah')");
}  else{
  $obat_2 = ""; 
  $qty_obat_2 = ""; 
}

if (isset($_POST['obat_3'])) {


$sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_3'");
      $data_obat = mysqli_fetch_assoc($sql_obat);

      $kode_obat = $data_obat['kode_obat'];
      $stok_obat = $data_obat['stok_obat'];
      $harga = $data_obat['harga_jual'];

      $stok_obat_baru = $stok_obat - $qty_obat_3;
      $jumlah = $qty_obat_3 * $harga;
      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
      mysqli_query($koneksi,"INSERT INTO riwayat_obat_perawatan VALUES('','$no_perawatan','$id1','$kode_obat','$status','$qty_obat_3','$jumlah')");

  
}  else{
  $obat_3 = ""; 
  $qty_obat_3 = ""; 
}

if (isset($_POST['obat_4'])) {
 

$sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_4'");
      $data_obat = mysqli_fetch_assoc($sql_obat);

      $kode_obat = $data_obat['kode_obat'];
      $stok_obat = $data_obat['stok_obat'];
      $harga = $data_obat['harga_jual'];

      $stok_obat_baru = $stok_obat - $qty_obat_4;
      $jumlah = $qty_obat_4 * $harga;
      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
      mysqli_query($koneksi,"INSERT INTO riwayat_obat_perawatan VALUES('','$no_perawatan','$id1','$kode_obat','$status','$qty_obat_4','$jumlah')");

  
} else{
  $obat_4 = ""; 
  $qty_obat_4 = ""; 
}




 

echo "<script>alert('Data Perawatan Berhasil di input'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;

        

       


  ?>