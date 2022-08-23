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
$no_perawatan = htmlspecialchars($_POST['no_perawatan']);

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

  if($qty_alkes_1 == "0" ){
    echo "<script>alert('Qty alat kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }
  
} else{
  $alkes_1 = "";
  $qty_alkes_1 = "";
}

if (isset($_POST['alkes_2'])) {
  $alkes_2 = htmlspecialchars($_POST['alkes_2']); 
  $qty_alkes_2 = htmlspecialchars($_POST['qty_alkes_2']);

  if($qty_alkes_2 == "0" ){
    echo "<script>alert('Qty alat kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }
  
} else{
  $alkes_2 = "";
  $qty_alkes_2 = "";
}


if (isset($_POST['alkes_3'])) {
$alkes_3 =  htmlspecialchars($_POST['alkes_3']); 
$qty_alkes_3 = htmlspecialchars($_POST['qty_alkes_3']);

  if($qty_alkes_3 == "0" ){
    echo "<script>alert('Qty alat kesehatan yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

} else{
  $alkes_3 = "";
  $qty_alkes_3 = "";
}


if (isset($_POST['alkes_4'])) {
  $alkes_4 =  htmlspecialchars($_POST['alkes_4']);
  $qty_alkes_4 = htmlspecialchars($_POST['qty_alkes_4']);

  if($qty_alkes_4 == "0" ){
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

  if($qty_obat_1 == "0" ){
    echo "<script>alert('Qty obat yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

} else{
  $obat_1 = ""; 
  $qty_obat_1 = ""; 
}

if (isset($_POST['obat_2'])) {
  $obat_2 = htmlspecialchars($_POST['obat_2']); 
  $qty_obat_2 =  htmlspecialchars($_POST['qty_obat_2']); 

  if($qty_obat_2 == "0" ){
    echo "<script>alert('Qty obat yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }
}  else{
  $obat_2 = ""; 
  $qty_obat_2 = ""; 
}

if (isset($_POST['obat_3'])) {
  $obat_3 =  htmlspecialchars($_POST['obat_3']);
  $qty_obat_3 =  htmlspecialchars($_POST['qty_obat_3']);

  if($qty_obat_3 == "0" ){
    echo "<script>alert('Qty obat yang di tambahkan tidak boleh kosong'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;
  }

}  else{
  $obat_3 = ""; 
  $qty_obat_3 = ""; 
}

if (isset($_POST['obat_4'])) {
  $obat_4 =  htmlspecialchars($_POST['obat_4']); 
  $qty_obat_4 = htmlspecialchars($_POST['qty_obat_4']); 

  if($qty_obat_4 == "0" ){
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


      $sql_perawatan = mysqli_query($koneksi, "SELECT * FROM perawatan a INNER JOIN antrian b on b.no_antrian=a.no_antrian WHERE id_pasien ='$id_pasien' AND tanggal = '$tgl_antri' AND b.no_antrian = '$no_antrian' ");
      $data_perawatan = mysqli_fetch_assoc($sql_perawatan);
      $no_perawatan = $data_perawatan['no_perawatan'];

      $alkes_1_perawatan = $data_perawatan['alkes_1'];
      $alkes_2_perawatan = $data_perawatan['alkes_2'];
      $alkes_3_perawatan = $data_perawatan['alkes_3'];
      $alkes_4_perawatan = $data_perawatan['alkes_4'];

      $obat_1_perawatan = $data_perawatan['obat_1'];
      $obat_2_perawatan = $data_perawatan['obat_2'];
      $obat_3_perawatan = $data_perawatan['obat_3'];
      $obat_4_perawatan = $data_perawatan['obat_4'];

      $tindakan_1_perawatan = $data_perawatan['tindakan_1'];
      $tindakan_2_perawatan = $data_perawatan['tindakan_2'];
      $tindakan_3_perawatan = $data_perawatan['tindakan_3'];
      $tindakan_4_perawatan = $data_perawatan['tindakan_4'];



//tindakan 
//tindakan 1
if ($tindakan_1_perawatan == "") {
    if($tindakan_1 == ""){
      
    }
    else{

      $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_1'");
      $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
    
      $kode_tindakan = $data_tindakan['kode_tindakan'];
      $harga_tindakan = $data_tindakan['harga_tindakan'];
      $jumlah = $qty_tindakan_1 * $harga_tindakan;
    
      mysqli_query($koneksi,"INSERT INTO riwayat_tindakan VALUES('','$no_perawatan','$id1','$kode_tindakan','$qty_tindakan_1','$jumlah')");

    }
} 
else{
  $sql_ri_tindakan_1 = mysqli_query($koneksi, "SELECT * FROM riwayat_tindakan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN tindakan c ON c.kode_tindakan=a.kode_tindakan WHERE a.no_perawatan = '$no_perawatan' AND c.nama_tindakan = '$tindakan_1_perawatan'");
  $data_ri_alkes_1 = mysqli_fetch_assoc($sql_ri_tindakan_1);
  $no_riwayat = $data_ri_alkes_1['no_riwayat'];

  if($tindakan_1 == "" ){
      mysqli_query($koneksi,"DELETE FROM riwayat_tindakan WHERE no_riwayat = '$no_riwayat'");
  }
  else{
      $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_1'");
      $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
    
      $kode_tindakan = $data_tindakan['kode_tindakan'];
      $harga_tindakan = $data_tindakan['harga_tindakan'];
      $jumlah = $qty_tindakan_1 * $harga_tindakan;

      mysqli_query($koneksi,"UPDATE riwayat_tindakan SET kode_tindakan = '$kode_tindakan' , qty_tindakan = '$qty_tindakan_1', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
  }
}
//tindakan 2
if ($tindakan_2_perawatan == "") {
  if($tindakan_2 == ""){

  }
  else{

    $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_2'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
  
    $kode_tindakan = $data_tindakan['kode_tindakan'];
    $harga_tindakan = $data_tindakan['harga_tindakan'];
    $jumlah = $qty_tindakan_2 * $harga_tindakan;
  
    mysqli_query($koneksi,"INSERT INTO riwayat_tindakan VALUES('','$no_perawatan','$id1','$kode_tindakan','$qty_tindakan_2','$jumlah')");

  }
} 
else{
$sql_ri_tindakan_2 = mysqli_query($koneksi, "SELECT * FROM riwayat_tindakan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN tindakan c ON c.kode_tindakan=a.kode_tindakan WHERE a.no_perawatan = '$no_perawatan' AND c.nama_tindakan = '$tindakan_2_perawatan'");
$data_ri_alkes_2 = mysqli_fetch_assoc($sql_ri_tindakan_2);
$no_riwayat = $data_ri_alkes_2['no_riwayat'];

if($tindakan_2 == "" ){
  mysqli_query($koneksi,"DELETE FROM riwayat_tindakan WHERE no_riwayat = '$no_riwayat'");
}
else{
    $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_2'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
  
    $kode_tindakan = $data_tindakan['kode_tindakan'];
    $harga_tindakan = $data_tindakan['harga_tindakan'];
    $jumlah = $qty_tindakan_2 * $harga_tindakan;

  mysqli_query($koneksi,"UPDATE riwayat_tindakan SET kode_tindakan = '$kode_tindakan'  , qty_tindakan = '$qty_tindakan_2', jumlah = '$jumlah'  WHERE no_riwayat =  '$no_riwayat'");
}
}

//tindakan 3
if ($tindakan_3_perawatan == "") {
  if($tindakan_3 == ""){

  }
  else{

    $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_3'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
  
    $kode_tindakan = $data_tindakan['kode_tindakan'];
    $harga_tindakan = $data_tindakan['harga_tindakan'];
    $jumlah = $qty_tindakan_3 * $harga_tindakan;
  
    mysqli_query($koneksi,"INSERT INTO riwayat_tindakan VALUES('','$no_perawatan','$id1','$kode_tindakan','$qty_tindakan_3','$jumlah')");

  }
} 
else{
$sql_ri_tindakan_3 = mysqli_query($koneksi, "SELECT * FROM riwayat_tindakan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN tindakan c ON c.kode_tindakan=a.kode_tindakan WHERE a.no_perawatan = '$no_perawatan' AND c.nama_tindakan = '$tindakan_3_perawatan'");
$data_ri_alkes_3 = mysqli_fetch_assoc($sql_ri_tindakan_3);
$no_riwayat = $data_ri_alkes_3['no_riwayat'];

if($tindakan_3 == "" ){
  mysqli_query($koneksi,"DELETE FROM riwayat_tindakan WHERE no_riwayat = '$no_riwayat'");
}
else{
    $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_3'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
  
    $kode_tindakan = $data_tindakan['kode_tindakan'];
    $harga_tindakan = $data_tindakan['harga_tindakan'];
    $jumlah = $qty_tindakan_3 * $harga_tindakan;

  mysqli_query($koneksi,"UPDATE riwayat_tindakan SET kode_tindakan = '$kode_tindakan'  , qty_tindakan = '$qty_tindakan_3', jumlah = '$jumlah'  WHERE no_riwayat =  '$no_riwayat'");
}
}

//tindakan 4
if ($tindakan_4_perawatan == "") {
  if($tindakan_4 == ""){

  }
  else{

    $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_4'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
  
    $kode_tindakan = $data_tindakan['kode_tindakan'];
    $harga_tindakan = $data_tindakan['harga_tindakan'];
    $jumlah = $qty_tindakan_4 * $harga_tindakan;
  
    mysqli_query($koneksi,"INSERT INTO riwayat_tindakan VALUES('','$no_perawatan','$id1','$kode_tindakan','$qty_tindakan_4','$jumlah')");

  }
} 
else{
$sql_ri_tindakan_4 = mysqli_query($koneksi, "SELECT * FROM riwayat_tindakan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN tindakan c ON c.kode_tindakan=a.kode_tindakan WHERE a.no_perawatan = '$no_perawatan' AND c.nama_tindakan = '$tindakan_4_perawatan'");
$data_ri_alkes_4 = mysqli_fetch_assoc($sql_ri_tindakan_4);
$no_riwayat = $data_ri_alkes_4['no_riwayat'];

if($tindakan_4 == "" ){
  mysqli_query($koneksi,"DELETE FROM riwayat_tindakan WHERE no_riwayat = '$no_riwayat'");
}
else{
    $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_4'");
    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
  
    $kode_tindakan = $data_tindakan['kode_tindakan'];
    $harga_tindakan = $data_tindakan['harga_tindakan'];
    $jumlah = $qty_tindakan_4 * $harga_tindakan;

  mysqli_query($koneksi,"UPDATE riwayat_tindakan SET kode_tindakan = '$kode_tindakan'  , qty_tindakan = '$qty_tindakan_4', jumlah = '$jumlah'  WHERE no_riwayat =  '$no_riwayat'");
}
}

    
      
//Input Data alkes
//alkes1
if($alkes_1_perawatan == "" ){
    if($alkes_1 == ""){

    }
    else{
      
            $sql_alkes_1 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_1'");
            $data_alkes_1 = mysqli_fetch_assoc($sql_alkes_1);
      
            $kode_alkes_1 = $data_alkes_1['kode_alkes'];
            $stok_alkes_1 = $data_alkes_1['stok_alkes'];
            $harga_1 = $data_alkes_1['harga_jual'];

            $stok_alkes_baru = $stok_alkes_1 - $qty_alkes_1;
            $jumlah = $qty_alkes_1 * $harga_1;
      
            $query = mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_1'");
            $query = mysqli_query($koneksi,"INSERT INTO riwayat_alkes_perawatan VALUES('','$no_perawatan','$id1','$kode_alkes_1','$status','$qty_alkes_1','$jumlah')");
    }

} else{
  
        //akses data riwayat kode_alkes perawatan
        $sql_ri_alkes_1 = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN alat_kesehatan c ON c.kode_alkes=a.kode_alkes WHERE a.no_perawatan = '$no_perawatan' AND c.nama_alkes = '$alkes_1_perawatan'");
        $data_ri_alkes_1 = mysqli_fetch_assoc($sql_ri_alkes_1);
        $qty_alkes_ri_1 = $data_ri_alkes_1['qty_alkes_1'];
        $nama_alkes_ri_1 = $data_ri_alkes_1['alkes_1'];
        $kode_alkes_ri_1 = $data_ri_alkes_1['kode_alkes'];
        $stok_alkes_ri_1 = $data_ri_alkes_1['stok_alkes'];
        $no_riwayat = $data_ri_alkes_1['no_riwayat'];

        if($alkes_1 != ""){

          //akses data nama_alkes yang di input
         $sql_alkes_1 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_1'");
         $data_alkes_1 = mysqli_fetch_assoc($sql_alkes_1);
   
         $kode_alkes_1 = $data_alkes_1['kode_alkes'];
         $stok_alkes_1 = $data_alkes_1['stok_alkes'];
         $harga_1 = $data_alkes_1['harga_jual'];
        }else{

          //akses data nama_alkes yang di input
         $sql_alkes_1 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$nama_alkes_ri_1'");
         $data_alkes_1 = mysqli_fetch_assoc($sql_alkes_1);
   
         $kode_alkes_1 = $data_alkes_1['kode_alkes'];
         $stok_alkes_1 = $data_alkes_1['stok_alkes'];
         $harga_1 = $data_alkes_1['harga_jual'];
        }
         
        
    if($alkes_1 == ""){

      
       $stok_alkes_baru = ($stok_alkes_1 + $qty_alkes_ri_1);
    

       mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_ri_1'");
       mysqli_query($koneksi,"DELETE FROM riwayat_alkes_perawatan WHERE no_riwayat = '$no_riwayat'");

    }
    
    else if($alkes_1 == $alkes_1_perawatan){

       $stok_alkes_baru = ($stok_alkes_1 + $qty_alkes_ri_1) - $qty_alkes_1;
       $jumlah = $qty_alkes_1 * $harga_1;

       mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_1'");
       mysqli_query($koneksi,"UPDATE riwayat_alkes_perawatan SET kode_alkes = '$kode_alkes_1' , qty = '$qty_alkes_1' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

    }
    
    else{

      $stok_alkes_baru_ri = $stok_alkes_ri_1 + $qty_alkes_ri_1;
      $stok_alkes_baru = $stok_alkes_1 - $qty_alkes_1;
      $jumlah = $qty_alkes_1 * $harga_1;
      
 
        mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru_ri' WHERE kode_alkes =  '$kode_alkes_ri_1'");
        mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_1'");
        mysqli_query($koneksi,"UPDATE riwayat_alkes_perawatan SET kode_alkes = '$kode_alkes_1' , qty = '$qty_alkes_1' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
    
    }

}



// alkes 2
if($alkes_2_perawatan == "" ){
  if($alkes_2 == ""){

  }
  else{
    
          $sql_alkes_2 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_2'");
          $data_alkes_2 = mysqli_fetch_assoc($sql_alkes_2);
    
          $kode_alkes_2 = $data_alkes_2['kode_alkes'];
          $stok_alkes_2 = $data_alkes_2['stok_alkes'];
          $harga_2 = $data_alkes_2['harga_jual'];

          $stok_alkes_baru = $stok_alkes_2 - $qty_alkes_2;
          $jumlah = $qty_alkes_2 * $harga_2;
    
          $query = mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_2'");
          $query = mysqli_query($koneksi,"INSERT INTO riwayat_alkes_perawatan VALUES('','$no_perawatan','$id1','$kode_alkes_2','$status','$qty_alkes_2','$jumlah')");
  }

} else{

      //akses data riwayat kode_alkes perawatan
      $sql_ri_alkes_2 = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN alat_kesehatan c ON c.kode_alkes=a.kode_alkes WHERE a.no_perawatan = '$no_perawatan' AND c.nama_alkes = '$alkes_2_perawatan'");
      $data_ri_alkes_2 = mysqli_fetch_assoc($sql_ri_alkes_2);
      $qty_alkes_ri_2 = $data_ri_alkes_2['qty_alkes_2'];
      $nama_alkes_ri_2 = $data_ri_alkes_2['alkes_2'];
      $kode_alkes_ri_2 = $data_ri_alkes_2['kode_alkes'];
      $stok_alkes_ri_2 = $data_ri_alkes_2['stok_alkes'];
      $no_riwayat = $data_ri_alkes_2['no_riwayat'];

      if($alkes_2 != ""){

        //akses data nama_alkes yang di input
       $sql_alkes_2 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_2'");
       $data_alkes_2 = mysqli_fetch_assoc($sql_alkes_2);
 
       $kode_alkes_2 = $data_alkes_2['kode_alkes'];
       $stok_alkes_2 = $data_alkes_2['stok_alkes'];
       $harga_2 = $data_alkes_2['harga_jual'];
      }else{

        //akses data nama_alkes yang di input
       $sql_alkes_2 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$nama_alkes_ri_2'");
       $data_alkes_2 = mysqli_fetch_assoc($sql_alkes_2);
 
       $kode_alkes_2 = $data_alkes_2['kode_alkes'];
       $stok_alkes_2 = $data_alkes_2['stok_alkes'];
       $harga_2 = $data_alkes_2['harga_jual'];
      }
       
      
  if($alkes_2 == ""){

    
     $stok_alkes_baru = ($stok_alkes_2 + $qty_alkes_ri_2);
  

     mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_ri_2'");
     mysqli_query($koneksi,"DELETE FROM riwayat_alkes_perawatan WHERE no_riwayat = '$no_riwayat'");

  }
  
  else if($alkes_2 == $alkes_2_perawatan){

     $stok_alkes_baru = ($stok_alkes_2 + $qty_alkes_ri_2) - $qty_alkes_2;
     $jumlah = $qty_alkes_2 * $harga_2;

     mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_2'");
     mysqli_query($koneksi,"UPDATE riwayat_alkes_perawatan SET kode_alkes = '$kode_alkes_2', qty = '$qty_alkes_2', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

  }
  
  else{

    $stok_alkes_baru_ri = $stok_alkes_ri_2 + $qty_alkes_ri_2;
    $stok_alkes_baru = $stok_alkes_2 - $qty_alkes_2;
    $jumlah = $qty_alkes_2 * $harga_2;
    

      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru_ri' WHERE kode_alkes =  '$kode_alkes_ri_2'");
      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_2'");
      mysqli_query($koneksi,"UPDATE riwayat_alkes_perawatan SET kode_alkes = '$kode_alkes_2' , qty = '$qty_alkes_2', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
  
  }

}

//alkes_3
if($alkes_3_perawatan == "" ){
  if($alkes_3 == ""){

  }
  else{
    
          $sql_alkes_3 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_3'");
          $data_alkes_3 = mysqli_fetch_assoc($sql_alkes_3);
    
          $kode_alkes_3 = $data_alkes_3['kode_alkes'];
          $stok_alkes_3 = $data_alkes_3['stok_alkes'];
          $harga_3 = $data_alkes_3['harga_jual'];

          $stok_alkes_baru = $stok_alkes_3 - $qty_alkes_3;
          $jumlah = $qty_alkes_3 * $harga_3;
    
          $query = mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_3'");
          $query = mysqli_query($koneksi,"INSERT INTO riwayat_alkes_perawatan VALUES('','$no_perawatan','$id1','$kode_alkes_3','$status','$qty_alkes_3','$jumlah')");
  }

} else{

      //akses data riwayat kode_alkes perawatan
      $sql_ri_alkes_3 = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN alat_kesehatan c ON c.kode_alkes=a.kode_alkes WHERE a.no_perawatan = '$no_perawatan' AND c.nama_alkes = '$alkes_3_perawatan'");
      $data_ri_alkes_3 = mysqli_fetch_assoc($sql_ri_alkes_3);
      $qty_alkes_ri_3 = $data_ri_alkes_3['qty_alkes_3'];
      $nama_alkes_ri_3 = $data_ri_alkes_3['alkes_3'];
      $kode_alkes_ri_3 = $data_ri_alkes_3['kode_alkes'];
      $stok_alkes_ri_3 = $data_ri_alkes_3['stok_alkes'];
      $no_riwayat = $data_ri_alkes_3['no_riwayat'];

      if($alkes_3 != ""){

        //akses data nama_alkes yang di input
       $sql_alkes_3 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_3'");
       $data_alkes_3 = mysqli_fetch_assoc($sql_alkes_3);
 
       $kode_alkes_3 = $data_alkes_3['kode_alkes'];
       $stok_alkes_3 = $data_alkes_3['stok_alkes'];
       $harga_3 = $data_alkes_3['harga_jual'];
      }else{

        //akses data nama_alkes yang di input
       $sql_alkes_3 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$nama_alkes_ri_3'");
       $data_alkes_3 = mysqli_fetch_assoc($sql_alkes_3);
 
       $kode_alkes_3 = $data_alkes_3['kode_alkes'];
       $stok_alkes_3 = $data_alkes_3['stok_alkes'];
       $harga_3 = $data_alkes_3['harga_jual'];
      }
       
      
  if($alkes_3 == ""){

    
     $stok_alkes_baru = ($stok_alkes_3 + $qty_alkes_ri_3);
  

     mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_ri_3'");
     mysqli_query($koneksi,"DELETE FROM riwayat_alkes_perawatan WHERE no_riwayat = '$no_riwayat'");

  }
  
  else if($alkes_3 == $alkes_3_perawatan){

     $stok_alkes_baru = ($stok_alkes_3 + $qty_alkes_ri_3) - $qty_alkes_3;
     $jumlah = $qty_alkes_3 * $harga_3;

     mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_3'");
     mysqli_query($koneksi,"UPDATE riwayat_alkes_perawatan SET kode_alkes = '$kode_alkes_3', qty = '$qty_alkes_3', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

  }
  
  else{

    $stok_alkes_baru_ri = $stok_alkes_ri_3 + $qty_alkes_ri_3;
    $stok_alkes_baru = $stok_alkes_3 - $qty_alkes_3;
    $jumlah = $qty_alkes_3 * $harga_3;
    

      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru_ri' WHERE kode_alkes =  '$kode_alkes_ri_3'");
      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_3'");
      mysqli_query($koneksi,"UPDATE riwayat_alkes_perawatan SET kode_alkes = '$kode_alkes_3' , qty = '$qty_alkes_3', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
  
  }

}

//alkes 4
if($alkes_4_perawatan == "" ){
  if($alkes_4 == ""){

  }
  else{
    
          $sql_alkes_4 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_4'");
          $data_alkes_4 = mysqli_fetch_assoc($sql_alkes_4);
    
          $kode_alkes_4 = $data_alkes_4['kode_alkes'];
          $stok_alkes_4 = $data_alkes_4['stok_alkes'];
          $harga_4 = $data_alkes_4['harga_jual'];

          $stok_alkes_baru = $stok_alkes_4 - $qty_alkes_4;
          $jumlah = $qty_alkes_4 * $harga_4;
    
          $query = mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_4'");
          $query = mysqli_query($koneksi,"INSERT INTO riwayat_alkes_perawatan VALUES('','$no_perawatan','$id1','$kode_alkes_4','$status','$qty_alkes_4','$jumlah')");
  }

} else{

      //akses data riwayat kode_alkes perawatan
      $sql_ri_alkes_4 = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN alat_kesehatan c ON c.kode_alkes=a.kode_alkes WHERE a.no_perawatan = '$no_perawatan' AND c.nama_alkes = '$alkes_4_perawatan'");
      $data_ri_alkes_4 = mysqli_fetch_assoc($sql_ri_alkes_4);
      $qty_alkes_ri_4 = $data_ri_alkes_4['qty_alkes_4'];
      $nama_alkes_ri_4 = $data_ri_alkes_4['alkes_4'];
      $kode_alkes_ri_4 = $data_ri_alkes_4['kode_alkes'];
      $stok_alkes_ri_4 = $data_ri_alkes_4['stok_alkes'];
      $no_riwayat = $data_ri_alkes_4['no_riwayat'];

      if($alkes_4 != ""){

        //akses data nama_alkes yang di input
       $sql_alkes_4 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_4'");
       $data_alkes_4 = mysqli_fetch_assoc($sql_alkes_4);
 
       $kode_alkes_4 = $data_alkes_4['kode_alkes'];
       $stok_alkes_4 = $data_alkes_4['stok_alkes'];
       $harga_4 = $data_alkes_4['harga_jual'];
      }else{

        //akses data nama_alkes yang di input
       $sql_alkes_4 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$nama_alkes_ri_4'");
       $data_alkes_4 = mysqli_fetch_assoc($sql_alkes_4);
 
       $kode_alkes_4 = $data_alkes_4['kode_alkes'];
       $stok_alkes_4 = $data_alkes_4['stok_alkes'];
       $harga_4 = $data_alkes_4['harga_jual'];
      }
       
      
  if($alkes_4 == ""){

    
     $stok_alkes_baru = ($stok_alkes_4 + $qty_alkes_ri_4);
  

     mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_ri_4'");
     mysqli_query($koneksi,"DELETE FROM riwayat_alkes_perawatan WHERE no_riwayat = '$no_riwayat'");

  }
  
  else if($alkes_4 == $alkes_4_perawatan){

     $stok_alkes_baru = ($stok_alkes_4 + $qty_alkes_ri_4) - $qty_alkes_4;
     $jumlah = $qty_alkes_4 * $harga_4;

     mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_4'");
     mysqli_query($koneksi,"UPDATE riwayat_alkes_perawatan SET kode_alkes = '$kode_alkes_4' , qty = '$qty_alkes_4', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

  }
  
  else{

    $stok_alkes_baru_ri = $stok_alkes_ri_4 + $qty_alkes_ri_4;
    $stok_alkes_baru = $stok_alkes_4 - $qty_alkes_4;
    $jumlah = $qty_alkes_4 * $harga_4;
    

      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru_ri' WHERE kode_alkes =  '$kode_alkes_ri_4'");
      mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes_4'");
      mysqli_query($koneksi,"UPDATE riwayat_alkes_perawatan SET kode_alkes = '$kode_alkes_4', qty = '$qty_alkes_4' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
  
  }

}



//Input Data obat

//obat 1
if($obat_1_perawatan == "" ){
  if($obat_1 == ""){

  }
  else{
    
          $sql_obat_1 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_1'");
          $data_obat_1 = mysqli_fetch_assoc($sql_obat_1);
    
          $kode_obat_1 = $data_obat_1['kode_obat'];
          $stok_obat_1 = $data_obat_1['stok_obat'];
          $harga_1 = $data_obat_1['harga_jual'];

          $stok_obat_baru = $stok_obat_1 - $qty_obat_1;
          $jumlah = $qty_obat_1 * $harga_1;
    
          $query = mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_1'");
          $query = mysqli_query($koneksi,"INSERT INTO riwayat_obat_perawatan VALUES('','$no_perawatan','$id1','$kode_obat_1','$status','$qty_obat_1','$jumlah')");
  }

} else{

      //akses data riwayat kode_alkes perawatan
      $sql_ri_obat_1 = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN obat c ON c.kode_obat=a.kode_obat WHERE a.no_perawatan = '$no_perawatan' AND c.nama_obat = '$obat_1_perawatan'");
      $data_ri_obat_1 = mysqli_fetch_assoc($sql_ri_obat_1);
      $qty_obat_ri_1 = $data_ri_obat_1['qty_obat_1'];
      $nama_obat_ri_1 = $data_ri_obat_1['obat_1'];
      $kode_obat_ri_1 = $data_ri_obat_1['kode_obat'];
      $stok_obat_ri_1 = $data_ri_obat_1['stok_obat'];
      $no_riwayat = $data_ri_obat_1['no_riwayat'];

      if($obat_1 != ""){

        //akses data nama_alkes yang di input
       $sql_obat_1 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_1'");
       $data_obat_1 = mysqli_fetch_assoc($sql_obat_1);
 
       $kode_obat_1 = $data_obat_1['kode_obat'];
       $stok_obat_1 = $data_obat_1['stok_obat'];
       $harga_1 = $data_obat_1['harga_jual'];
      }else{

        //akses data nama_alkes yang di input
       $sql_obat_1 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$nama_obat_ri_1 '");
       $data_obat_1 = mysqli_fetch_assoc($sql_obat_1);
 
       $kode_obat_1 = $data_obat_1['kode_obat'];
       $stok_obat_1 = $data_obat_1['stok_obat'];
       $harga_1 = $data_obat_1['harga_jual'];
      }
       
      
  if($obat_1 == ""){

    
     $stok_obat_baru = ($stok_obat_1 + $qty_obat_ri_1);
  

     mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_ri_1'");
     mysqli_query($koneksi,"DELETE FROM riwayat_obat_perawatan WHERE no_riwayat = '$no_riwayat'");

  }
  
  else if($obat_1 == $obat_1_perawatan){

     $stok_obat_baru = ($stok_obat_1 + $qty_obat_ri_1) - $qty_obat_1;
     $jumlah = $qty_obat_1 * $harga_1;

     mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_1'");
     mysqli_query($koneksi,"UPDATE riwayat_obat_perawatan SET kode_obat = '$kode_obat_1' , qty = '$qty_obat_1', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

  }
  
  else{

    $stok_obat_baru_ri = $stok_obat_ri_1 + $qty_obat_ri_1;
    $stok_obat_baru = $stok_obat_1 - $qty_obat_1;
    $jumlah = $qty_obat_1 * $harga_1;
    

      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru_ri' WHERE kode_obat =  '$kode_obat_ri_1'");
      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_1'");
      mysqli_query($koneksi,"UPDATE riwayat_obat_perawatan SET kode_obat = '$kode_obat_1' , qty = '$qty_obat_1', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
  
  }

}


// obat 2

if($obat_2_perawatan == "" ){
  if($obat_2 == ""){

  }
  else{
    
          $sql_obat_2 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_2'");
          $data_obat_2 = mysqli_fetch_assoc($sql_obat_2);
    
          $kode_obat_2 = $data_obat_2['kode_obat'];
          $stok_obat_2 = $data_obat_2['stok_obat'];
          $harga_2 = $data_obat_2['harga_jual'];

          $stok_obat_baru = $stok_obat_2 - $qty_obat_2;
          $jumlah = $qty_obat_2 * $harga_2;
    
          $query = mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_2'");
          $query = mysqli_query($koneksi,"INSERT INTO riwayat_obat_perawatan VALUES('','$no_perawatan','$id1','$kode_obat_2','$status','$qty_obat_2','$jumlah')");
  }

} else{

      //akses data riwayat kode_alkes perawatan
      $sql_ri_obat_2 = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN obat c ON c.kode_obat=a.kode_obat WHERE a.no_perawatan = '$no_perawatan' AND c.nama_obat = '$obat_2_perawatan'");
      $data_ri_obat_2 = mysqli_fetch_assoc($sql_ri_obat_2);
      $qty_obat_ri_2 = $data_ri_obat_2['qty_obat_2'];
      $nama_obat_ri_2 = $data_ri_obat_2['obat_2'];
      $kode_obat_ri_2 = $data_ri_obat_2['kode_obat'];
      $stok_obat_ri_2 = $data_ri_obat_2['stok_obat'];
      $no_riwayat = $data_ri_obat_2['no_riwayat'];

      if($obat_2 != ""){

        //akses data nama_alkes yang di input
       $sql_obat_2 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_2'");
       $data_obat_2 = mysqli_fetch_assoc($sql_obat_2);
 
       $kode_obat_2 = $data_obat_2['kode_obat'];
       $stok_obat_2 = $data_obat_2['stok_obat'];
       $harga_2 = $data_obat_2['harga_jual'];
      }else{

        //akses data nama_alkes yang di input
       $sql_obat_2 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$nama_obat_ri_2 '");
       $data_obat_2 = mysqli_fetch_assoc($sql_obat_2);
 
       $kode_obat_2 = $data_obat_2['kode_obat'];
       $stok_obat_2 = $data_obat_2['stok_obat'];
       $harga_2 = $data_obat_2['harga_jual'];
      }
       
      
  if($obat_2 == ""){

    
     $stok_obat_baru = ($stok_obat_2 + $qty_obat_ri_2);
  

     mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_ri_2'");
     mysqli_query($koneksi,"DELETE FROM riwayat_obat_perawatan WHERE no_riwayat = '$no_riwayat'");

  }
  
  else if($obat_2 == $obat_2_perawatan){

     $stok_obat_baru = ($stok_obat_2 + $qty_obat_ri_2) - $qty_obat_2;
     $jumlah = $qty_obat_2 * $harga_2;

     mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_2'");
     mysqli_query($koneksi,"UPDATE riwayat_obat_perawatan SET kode_obat = '$kode_obat_2' , qty = '$qty_obat_2', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

  }
  
  else{

    $stok_obat_baru_ri = $stok_obat_ri_2 + $qty_obat_ri_2;
    $stok_obat_baru = $stok_obat_2 - $qty_obat_2;
    $jumlah = $qty_obat_2 * $harga_2;
    

      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru_ri' WHERE kode_obat =  '$kode_obat_ri_2'");
      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_2'");
      mysqli_query($koneksi,"UPDATE riwayat_obat_perawatan SET kode_obat = '$kode_obat_2' , qty = '$qty_obat_2', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
  
  }

}

// obat 3
if($obat_3_perawatan == "" ){
  if($obat_3 == ""){

  }
  else{
    
          $sql_obat_3 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_3'");
          $data_obat_3 = mysqli_fetch_assoc($sql_obat_3);
    
          $kode_obat_3 = $data_obat_3['kode_obat'];
          $stok_obat_3 = $data_obat_3['stok_obat'];
          $harga_3 = $data_obat_3['harga_jual'];

          $stok_obat_baru = $stok_obat_3 - $qty_obat_3;
          $jumlah = $qty_obat_3 * $harga_3;
    
          $query = mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_3'");
          $query = mysqli_query($koneksi,"INSERT INTO riwayat_obat_perawatan VALUES('','$no_perawatan','$id1','$kode_obat_3','$status','$qty_obat_3','$jumlah')");
  }

} else{

      //akses data riwayat kode_alkes perawatan
      $sql_ri_obat_3 = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN obat c ON c.kode_obat=a.kode_obat WHERE a.no_perawatan = '$no_perawatan' AND c.nama_obat = '$obat_3_perawatan'");
      $data_ri_obat_3 = mysqli_fetch_assoc($sql_ri_obat_3);
      $qty_obat_ri_3 = $data_ri_obat_3['qty_obat_3'];
      $nama_obat_ri_3 = $data_ri_obat_3['obat_3'];
      $kode_obat_ri_3 = $data_ri_obat_3['kode_obat'];
      $stok_obat_ri_3 = $data_ri_obat_3['stok_obat'];
      $no_riwayat = $data_ri_obat_3['no_riwayat'];

      if($obat_3 != ""){

        //akses data nama_alkes yang di input
       $sql_obat_3 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_3'");
       $data_obat_3 = mysqli_fetch_assoc($sql_obat_3);
 
       $kode_obat_3 = $data_obat_3['kode_obat'];
       $stok_obat_3 = $data_obat_3['stok_obat'];
       $harga_3 = $data_obat_3['harga_jual'];
      }else{

        //akses data nama_alkes yang di input
       $sql_obat_3 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$nama_obat_ri_3 '");
       $data_obat_3 = mysqli_fetch_assoc($sql_obat_3);
 
       $kode_obat_3 = $data_obat_3['kode_obat'];
       $stok_obat_3 = $data_obat_3['stok_obat'];
       $harga_3 = $data_obat_3['harga_jual'];
      }
       
      
  if($obat_3 == ""){

    
     $stok_obat_baru = ($stok_obat_3 + $qty_obat_ri_3);
  

     mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_ri_3'");
     mysqli_query($koneksi,"DELETE FROM riwayat_obat_perawatan WHERE no_riwayat = '$no_riwayat'");

  }
  
  else if($obat_3 == $obat_3_perawatan){

     $stok_obat_baru = ($stok_obat_3 + $qty_obat_ri_3) - $qty_obat_3;
     $jumlah = $qty_obat_3 * $harga_3;

     mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_3'");
     mysqli_query($koneksi,"UPDATE riwayat_obat_perawatan SET kode_obat = '$kode_obat_3' , qty = '$qty_obat_3', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

  }
  
  else{

    $stok_obat_baru_ri = $stok_obat_ri_3 + $qty_obat_ri_3;
    $stok_obat_baru = $stok_obat_3 - $qty_obat_3;
    $jumlah = $qty_obat_3 * $harga_3;
    

      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru_ri' WHERE kode_obat =  '$kode_obat_ri_3'");
      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_3'");
      mysqli_query($koneksi,"UPDATE riwayat_obat_perawatan SET kode_obat = '$kode_obat_3' , qty = '$qty_obat_3', jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
  
  }

}


//obat 4
if($obat_4_perawatan == "" ){
  if($obat_4 == ""){

  }
  else{
    
          $sql_obat_4 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_4'");
          $data_obat_4 = mysqli_fetch_assoc($sql_obat_4);
    
          $kode_obat_4 = $data_obat_4['kode_obat'];
          $stok_obat_4 = $data_obat_4['stok_obat'];
          $harga_4 = $data_obat_4['harga_jual'];

          $stok_obat_baru = $stok_obat_4 - $qty_obat_4;
          $jumlah = $qty_obat_4 * $harga_4;
    
          $query = mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_4'");
          $query = mysqli_query($koneksi,"INSERT INTO riwayat_obat_perawatan VALUES('','$no_perawatan','$id1','$kode_obat_4','$status','$qty_obat_4','$jumlah')");
  }

} else{

      //akses data riwayat kode_alkes perawatan
      $sql_ri_obat_4 = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN obat c ON c.kode_obat=a.kode_obat WHERE a.no_perawatan = '$no_perawatan' AND c.nama_obat = '$obat_4_perawatan'");
      $data_ri_obat_4 = mysqli_fetch_assoc($sql_ri_obat_4);
      $qty_obat_ri_4 = $data_ri_obat_4['qty_obat_4'];
      $nama_obat_ri_4 = $data_ri_obat_4['obat_4'];
      $kode_obat_ri_4 = $data_ri_obat_4['kode_obat'];
      $stok_obat_ri_4 = $data_ri_obat_4['stok_obat'];
      $no_riwayat = $data_ri_obat_4['no_riwayat'];

      if($obat_4 != ""){

        //akses data nama_alkes yang di input
       $sql_obat_4 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_4'");
       $data_obat_4 = mysqli_fetch_assoc($sql_obat_4);
 
       $kode_obat_4 = $data_obat_4['kode_obat'];
       $stok_obat_4 = $data_obat_4['stok_obat'];
       $harga_4 = $data_obat_4['harga_jual'];
      }else{

        //akses data nama_alkes yang di input
       $sql_obat_4 = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$nama_obat_ri_4 '");
       $data_obat_4 = mysqli_fetch_assoc($sql_obat_4);
 
       $kode_obat_4 = $data_obat_4['kode_obat'];
       $stok_obat_4 = $data_obat_4['stok_obat'];
       $harga_4 = $data_obat_4['harga_jual'];
      }
       
      
  if($obat_4 == ""){

    
     $stok_obat_baru = ($stok_obat_4 + $qty_obat_ri_4);
  

     mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_ri_4'");
     mysqli_query($koneksi,"DELETE FROM riwayat_obat_perawatan WHERE no_riwayat = '$no_riwayat'");

  }
  
  else if($obat_4 == $obat_4_perawatan){

     $stok_obat_baru = ($stok_obat_4 + $qty_obat_ri_4) - $qty_obat_4;
     $jumlah = $qty_obat_4 * $harga_4;

     mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_4'");
     mysqli_query($koneksi,"UPDATE riwayat_obat_perawatan SET kode_obat = '$kode_obat_4' , qty = '$qty_obat_4' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");

  }
  
  else{

    $stok_obat_baru_ri = $stok_obat_ri_4 + $qty_obat_ri_4;
    $stok_obat_baru = $stok_obat_4 - $qty_obat_4;
    $jumlah = $qty_obat_4 * $harga_4;
    

      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru_ri' WHERE kode_obat =  '$kode_obat_ri_4'");
      mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat_4'");
      mysqli_query($koneksi,"UPDATE riwayat_obat_perawatan SET kode_obat = '$kode_obat_4' , qty = '$qty_obat_4' , jumlah = '$jumlah' WHERE no_riwayat =  '$no_riwayat'");
  
  }

}


mysqli_query($koneksi,"UPDATE perawatan SET diagnosis = '$diagnosis' , tgl_cek_selanjutnya = '$tanggal_cek_selanjutnya' , resep = '$resep' , pesan = '$pesan' 
, tindakan_1 = '$tindakan_1' , tindakan_2 = '$tindakan_2', tindakan_3 = '$tindakan_3', tindakan_4 = '$tindakan_4'
, qty_tindakan_1 = '$qty_tindakan_1', qty_tindakan_2 = '$qty_tindakan_2', qty_tindakan_3 = '$qty_tindakan_3', qty_tindakan_4 = '$qty_tindakan_4'
, alkes_1 = '$alkes_1' , qty_alkes_1 = '$qty_alkes_1', alkes_2 = '$alkes_2', qty_alkes_2 = '$qty_alkes_2' 
, alkes_3 = '$alkes_3' , qty_alkes_3 = '$qty_alkes_3', alkes_4 = '$alkes_4', qty_alkes_4 = '$qty_alkes_4'
, obat_1 = '$obat_1' , qty_obat_1 = '$qty_obat_1' , obat_2 = '$obat_2' , qty_obat_2 = '$qty_obat_2'
, obat_3 = '$obat_3' , qty_obat_3 = '$qty_obat_3' , obat_4 = '$obat_4' , qty_obat_4 = '$qty_obat_4.' WHERE no_perawatan =  '$no_perawatan'");
 

echo "<script>alert('Data Perawatan Berhasil di Edit'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;

        

       


  ?>