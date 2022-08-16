<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
    exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account a INNER JOIN karyawan b on b.id_karyawan=a.id_karyawan WHERE b.id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Dokter') {
} else {
    header("Location: logout.php");
    exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];
$foto_profile = $data['foto_profile'];
$tanggal = date("Y-m-d");


$id_pasien = $_GET['id_pasien'];
    // DATA PASIEN
    $tabley = mysqli_query($koneksi, "SELECT * FROM pasien WHERE id_pasien = '$id_pasien' ");
    $data_pasien = mysqli_fetch_assoc($tabley);
    $nama_pasien = $data_pasien['nama_pasien'];
    $jenis_kelamin = $data_pasien['jenis_kelamin'];
    $tanggal_lahir = $data_pasien['tanggal_lahir'];
    $tempat_lahir = $data_pasien['tempat_lahir'];
    $golongan_darah = $data_pasien['golongan_darah'];
    $nik = $data_pasien['nik'];
    $alamat = $data_pasien['alamat'];
    $no_hp = $data_pasien['no_hp'];

    // DATA PASIEN + ANTRIAN
    $table = mysqli_query($koneksi, "SELECT * FROM antrian a INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan
                    INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan  
                    INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
                    INNER JOIN rekam_medis e ON e.no_rm=d.no_rm
                    LEFT JOIN perawatan f ON f.no_rm=e.no_rm 
                    WHERE d.id_pasien = '$id_pasien' ");

    $data_pasien_antrian = mysqli_fetch_assoc($table);
    if( isset( $data_pasien_antrian['id_pasien'])){

      $id_pasien = $data_pasien_antrian['id_pasien'];
      $nama_karyawan = $data_pasien_antrian['nama_karyawan'];
      $keluhan_awal = $data_pasien_antrian['keluhan_awal'];
      $status_antrian = $data_pasien_antrian['status_antrian'];
  }
  else{
    $id_pasien = "";
    $nama_karyawan = "";
    $keluhan_awal = "";
    $status_antrian = "";
  }

  
    //data rekam medis
    $sql_rm = mysqli_query($koneksi, "SELECT * FROM rekam_medis a INNER JOIN pasien b ON b.no_rm=a.no_rm WHERE b.id_pasien = '$id_pasien'");
    $data_rm = mysqli_fetch_assoc($sql_rm);

    if( isset( $data_rm['no_rm'])){

      $no_rm = $data_rm['no_rm'];
  }
  else{
    $no_rm = "";
  }

    //ANTRIAN
    $sql_antrian = mysqli_query($koneksi, "SELECT * FROM antrian a INNER JOIN pasien b ON b.id_pasien=a.id_pasien WHERE a.id_pasien = '$id_pasien' AND tanggal = '$tanggal' ");
    $data_antrian = mysqli_fetch_assoc($sql_antrian);


    if( isset( $data_antrian['tanggal'])){

      $tanggal_antrian = $data_antrian['tanggal'];
      $no_antrian = $data_antrian['no_antrian'];
  }
  else{
    $tanggal_antrian = "";
    $no_antrian = "";
  }
    
    //DATA PERAWATAN TERAKHIR
    $sql_perawatan = mysqli_query($koneksi, "SELECT * FROM perawatan a INNER JOIN rekam_medis b ON a.no_rm=b.no_rm
                                                                    INNER JOIN pasien c ON c.no_rm=a.no_rm
                                                                    INNER JOIN antrian d ON d.no_antrian=a.no_antrian  
                                                                    INNER JOIN karyawan e ON e.id_karyawan=a.id_dokter  
                                                                 WHERE c.id_pasien = '$id_pasien' ORDER BY a.no_perawatan  DESC LIMIT 1");

    $data_perawatan = mysqli_fetch_assoc($sql_perawatan);

    if( isset( $data_perawatan['tanggal'])){

        $tanggal_terakhir_cekUP = $data_perawatan['tanggal'];
        $tanggal_cekUP_selanjutnya = $data_perawatan['tgl_cek_selanjutnya'] ;
        $diagnosis = $data_perawatan['diagnosis'];
        $resep = $data_perawatan['resep'];
        $pesan = $data_perawatan['pesan'];
        $dokter = $data_perawatan['nama_karyawan'];
    }
    else{
      $tanggal_terakhir_cekUP = 'Pertama Kali Cek UP';
      $tanggal_cekUP_selanjutnya =  "Pertama Kali Cek UP" ;
      $diagnosis = "-";
      $tindakan = "-";
      $resep = "-";
      $pesan = "-";
      $dokter = "-";
    }

    //TABEL PERAWATAAN
    $tabel_perawatan = mysqli_query($koneksi, "SELECT * FROM perawatan a INNER JOIN rekam_medis b ON a.no_rm=b.no_rm
                                                                          INNER JOIN pasien c ON c.no_rm=a.no_rm
                                                                          INNER JOIN antrian d ON d.no_antrian=a.no_antrian  
                                                                          INNER JOIN karyawan e ON e.id_karyawan=a.id_dokter
                                                                           WHERE c.id_pasien = '$id_pasien' ORDER BY a.no_perawatan  ASC ");

// tanggal lahir
$tanggalx = new DateTime($tanggal_lahir);
// tanggal hari ini
$today = new DateTime('today');

// tahun
$y = $today->diff($tanggalx)->y;

// bulan
$m = $today->diff($tanggalx)->m;

// hari
$d = $today->diff($tanggalx)->d;

//script format tanggal
function formattanggal($date){
        

    $newDate = date(" d F Y", strtotime($date));
    switch(date("l"))
  {
    case 'Monday':$nmh="Senin";break; 
    case 'Tuesday':$nmh="Selasa";break; 
    case 'Wednesday':$nmh="Rabu";break; 
    case 'Thursday':$nmh="Kamis";break; 
    case 'Friday':$nmh="Jum'at";break; 
    case 'Saturday':$nmh="Sabtu";break; 
    case 'Sunday':$nmh="minggu";break; 
  }
  echo " $newDate";
   }
  

?>
<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rekam Medis Pasien <?= $nama_pasien ?></title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

     <!-- Link Tabel -->
     
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bootstrap-select/dist/css/bootstrap-select.css">
  <style>
    hr{
        border: 3;
        height: 3px;
        background-image: linear-gradient(to right, rgba(0,0,0,0),rgba(0,0,0,0.75), rgba(0,0,0,0));

    }


  </style>
  </head>
  <body>
  <div class="container" >

  <table style="width:100%"  >
  <tr align="center">
    <th colspan="2" rowspan="3" style="width:43%" ><img src="../gambar/Logo Klinik.png" style="height: 70px; width: 230px;"></th>
    <th colspan="4"> <h9 style='font-size: 12px' >Alamat : Dsn. 01 RT/RW 03/01 Desa Suka Maju</h9></th>
  </tr>
  <tr align="center">
    <td colspan="4"><h9 style='font-size: 12px' > Kec. Buay Madang Timur Kab. OKU Timur 32361 Sum-Sel </h9></td>
  </tr>
  <tr align="center">
    <td colspan="4"><h9 style='font-size: 12px' > Email : ptcahayabumimusi@gmail.com | Telp/Hp. 0812 2160 0689</h9></td>
  </tr>
</table>

<hr>
<table style="width:100%"  border="1" >
  <tr align="center" style="background-color: #9099a2;" >
    <th colspan="6"> <h9 style='font-size: 18px' >Rekam Medis</h9></th>

  </tr>
  
</table>

<br>
<table style="width:100%"  rules="rows"  >
  <tr>
    <th colspan="6" > <h9 style='font-size: 18px' >Data Pasien</h9></th>
  </tr>
  <tr>
    <th colspan="6" > <h9 style='font-size: 14px' ></h9></th>
  </tr>
</table>
<br>
<div class="container" >

<table style="width:100%" >



  <tr>
    <th style="width:13%;"> <p style='font-size: 14px'>Nama Pasien</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?=$nama_pasien?></p></th>
    <th style="width:15%;"> <p style='font-size: 14px' >Tempat, Tanggal Lahir</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $tempat_lahir?>, <?php formattanggal($tanggal_lahir);  ?> </p></th>
  </tr>
 
  <tr>
    <th style="width:13%;"> <p style='font-size: 14px'>Umur</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?php echo "".$y . "T " . $m . "B " . $d . "H";?> </p></th>
    <th style="width:13%;"> <p style='font-size: 14px' >Jenis Kelamin</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $jenis_kelamin?> </p></th>
  </tr>

  <tr>
    <th style="width:13%;"> <p style='font-size: 14px'>Golongan Darah</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $golongan_darah?> </p></th>
    <th style="width:13%;"> <p style='font-size: 14px' >NIK</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $nik?> </p></th>
  </tr>

  <tr>
    <th style="width:13%;"> <p style='font-size: 14px'>Alamat</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $alamat?> </p></th>
    <th style="width:13%;"> <p style='font-size: 14px' >No Hp</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $no_hp?> </p></th>
  </tr>


 
</table>
</div>



<br>
<table style="width:100%"  rules="rows"  >
  <tr>
    <th colspan="6" > <h9 style='font-size: 18px' >Data Perawatan Terakhir Kali</h9></th>
  </tr>
  <tr>
    <th colspan="6" > <h9 style='font-size: 14px' ></h9></th>
  </tr>
</table>
<br>
<div class="container" >

<table style="width:100%" >

  <tr>
   <th style="width:13%;"> <p style='font-size: 14px'>Dokter</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?=$dokter?></p></th>
    <th style="width:13%;"> <p style='font-size: 14px'>Diagnosis</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?=$diagnosis?></p></th>
  </tr>
 
  <tr>
    <th style="width:13%;"> <p style='font-size: 14px'>Resep</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $resep?></p></th>
    <th style="width:13%;"> <p style='font-size: 14px' >Pesan</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $pesan?> </p></th>
  </tr>

  <tr>
    <th style="width:13%;"> <p style='font-size: 14px'>Terakhir Cek Up</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $tanggal_terakhir_cekUP?> </p></th>
    <th style="width:13%;"> <p style='font-size: 14px' >Cek Up Selanjutnya</p></th>
    <th style="width:1%;"> <p style='font-size: 14px'> : </p></th>
    <th style="width:36%"> <p style='font-size: 14px' ><?= $tanggal_cekUP_selanjutnya?> </p></th>
  </tr>
 
</table>
</div>

<br>
<table style="width:100%"  rules="rows"  >
  <tr>
    <th colspan="6" > <h9 style='font-size: 18px' >List Perawatan Pasien</h9></th>
  </tr>
  <tr>
    <th colspan="6" > <h9 style='font-size: 14px' ></h9></th>
  </tr>
</table>
<br>
<div class="container" >
       <!-- Button Input Data Bayar -->
   <div align="right">
     <button  style= "font-size: clamp(7px, 3vw, 15px); " type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i>Catat Perawatan</button> <br> <br>
   </div>
   

   <!-- Form Modal  -->
   <div class="modal fade bd-example-modal-lg" id= "input" tabindex="-1" role="dialog"  aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg"  role ="document">
      <div class="modal-content"> 
       <div class="modal-header">
         <h5 class="modal-title"> Form Catat Perawatan</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div> 

       <!-- Form Input Data -->
       <div class="modal-body" align="left">
         <?php  echo "<form action='../proses/PPerawatan' enctype='multipart/form-data' method='POST'>";  ?>

         <br>
         <input type="hidden" name="no_antrian" value="<?= $no_antrian; ?>">
         <input type="hidden" name="tanggal_antrian" value="<?= $tanggal_antrian; ?>">
         <input type="hidden" name="id_pasien" value="<?= $id_pasien; ?>">
         <input type="hidden" name="no_rm" value="<?= $no_rm; ?>">
         <div class="row">  
           <div class="col-md-6">
             <label>Diagnosis</label>
             <textarea  class="form-control form-control-sm"  name="diagnosis" ></textarea>
             <small>Jika text panjang tolong enter saat sudah di ujung field</small>
           </div> 
           <div class="col-md-6">
              <label>Pesan</label>
              <textarea  class="form-control form-control-sm"  name="pesan" ></textarea>
              <small>Jika text panjang tolong enter saat sudah di ujung field</small>
            </div> 
         </div>

          <br>
          
          <div class="row">
          <div class="col-md-6">
          <label>Tindakan 1</label>
             <select id="tokens" class="selectpicker form-control" name="tindakan_1" multiple data-live-search="true">
            <?php
            include 'koneksi.php';
         
            $result = mysqli_query($koneksi, "SELECT nama_tindakan FROM tindakan ");   
            while ($data = mysqli_fetch_array($result)){
              $nama_tindakan = $data['nama_tindakan'];
  
                echo "<option> $nama_tindakan </option> ";
              }

            ?>
          </select>   
           </div> 
           <div class="col-md-6">
          <label>Tindakan 2</label>
             <select id="tokens" class="selectpicker form-control" name="tindakan_2" multiple data-live-search="true">
            <?php
            include 'koneksi.php';
         
            $result = mysqli_query($koneksi, "SELECT nama_tindakan FROM tindakan ");   
            while ($data = mysqli_fetch_array($result)){
              $nama_tindakan = $data['nama_tindakan'];
  
                echo "<option> $nama_tindakan </option> ";
              }

            ?>
          </select>   
           </div> 
             
         </div>
         <br>
          
          <div class="row">
          <div class="col-md-6">
          <label>Tindakan 3</label>
             <select id="tokens" class="selectpicker form-control" name="tindakan_3" multiple data-live-search="true">
            <?php
            include 'koneksi.php';
         
            $result = mysqli_query($koneksi, "SELECT nama_tindakan FROM tindakan ");   
            while ($data = mysqli_fetch_array($result)){
              $nama_tindakan = $data['nama_tindakan'];
  
                echo "<option> $nama_tindakan </option> ";
              }

            ?>
          </select>   
           </div> 
           <div class="col-md-6">
          <label>Tindakan 4</label>
             <select id="tokens" class="selectpicker form-control" name="tindakan_4" multiple data-live-search="true">
            <?php
            include 'koneksi.php';
         
            $result = mysqli_query($koneksi, "SELECT nama_tindakan FROM tindakan ");   
            while ($data = mysqli_fetch_array($result)){
              $nama_tindakan = $data['nama_tindakan'];
  
                echo "<option> $nama_tindakan </option> ";
              }

            ?>
          </select>   
           </div> 
             
         </div>
          <br>
         <div class="row">
         <div class="col-md-6">
             <label>Tanggal Cek Up Selanjutnya</label>
             <input class="form-control form-control-sm" type="date"  name="tanggal_cek_selanjutnya" >
           </div>  
           <div class="col-md-6">
             <label>Resep</label>
             <textarea  class="form-control form-control-sm"  name="resep" ></textarea>
             <small>Tampilan text sesuai dengan pengetikan (enter, spasi, titik, koma)</small>
           </div> 
            
            </div>
            
        <?php  /*    <br>
         <div class="row">
         <div class="col-md-6">
            <label>Alat Kesehatan 1</label>
                <select id="tokens" class="selectpicker form-control" name="alkes_1" multiple data-live-search="true">
                <?php
                include 'koneksi.php';
            
                $result2 = mysqli_query($koneksi, "SELECT nama_alkes FROM alat_kesehatan ");   
                while ($data2 = mysqli_fetch_array($result2)){
                $nama_alkes = $data2['nama_alkes'];
    
                    echo "<option> $nama_alkes </option> ";
                }

                ?>
          </select>  
           </div>   
            <div class="col-md-6">
                <label>QTY Alat Kesehatan 1</label>
                <input class="form-control form-control-sm" type="number"  name="qty_alkes_1">
            </div>
            </div>
            <br>
         <div class="row">
         <div class="col-md-6">
            <label>Alat Kesehatan 2</label>
                <select id="tokens" class="selectpicker form-control" name="alkes_2" multiple data-live-search="true">
                <?php
                include 'koneksi.php';
            
                $result2 = mysqli_query($koneksi, "SELECT nama_alkes FROM alat_kesehatan ");   
                while ($data2 = mysqli_fetch_array($result2)){
                $nama_alkes = $data2['nama_alkes'];
    
                    echo "<option> $nama_alkes </option> ";
                }

                ?>
          </select>  
           </div>   
            <div class="col-md-6">
                <label>QTY Alat Kesehatan 2</label>
                <input class="form-control form-control-sm" type="number"  name="qty_alkes_2" >
            </div>
            </div>
            <br>
         <div class="row">
         <div class="col-md-6">
            <label>Alat Kesehatan 3</label>
                <select id="tokens" class="selectpicker form-control" name="alkes_3" multiple data-live-search="true">
                <?php
                include 'koneksi.php';
            
                $result2 = mysqli_query($koneksi, "SELECT nama_alkes FROM alat_kesehatan ");   
                while ($data2 = mysqli_fetch_array($result2)){
                $nama_alkes = $data2['nama_alkes'];
    
                    echo "<option> $nama_alkes </option> ";
                }

                ?>
          </select>  
           </div>   
            <div class="col-md-6">
                <label>QTY Alat Kesehatan 3</label>
                <input class="form-control form-control-sm" type="number"  name="qty_alkes_3">
            </div>
            </div>
            <br>
         <div class="row">
         <div class="col-md-6">
            <label>Alat Kesehatan 4</label>
                <select id="tokens" class="selectpicker form-control" name="alkes_4" multiple data-live-search="true">
                <?php
                include 'koneksi.php';
            
                $result2 = mysqli_query($koneksi, "SELECT nama_alkes FROM alat_kesehatan ");   
                while ($data2 = mysqli_fetch_array($result2)){
                $nama_alkes = $data2['nama_alkes'];
    
                    echo "<option> $nama_alkes </option> ";
                }

                ?>
          </select>  
           </div>   
            <div class="col-md-6">
                <label>QTY Alat Kesehatan 4</label>
                <input class="form-control form-control-sm" type="number"  name="qty_alkes_4">
            </div>
            </div>

            <br>
            <div class="row">
         <div class="col-md-6">
            <label>Obat 1</label>
                <select id="tokens" class="selectpicker form-control" name="obat_1" multiple data-live-search="true">
                <?php
                include 'koneksi.php';
            
                $result2 = mysqli_query($koneksi, "SELECT nama_obat FROM obat ");   
                while ($data2 = mysqli_fetch_array($result2)){
                $nama_obat = $data2['nama_obat'];
    
                    echo "<option> $nama_obat </option> ";
                }

                ?>
          </select>  
           </div>   
            <div class="col-md-6">
            <label>QTY Obat 1</label>
                 <input class="form-control form-control-sm" type="number"  name="qty_obat_1">
            </div>
            </div>
            <br>
            <div class="row">
         <div class="col-md-6">
            <label>Obat 2</label>
                <select id="tokens" class="selectpicker form-control" name="obat_2" multiple data-live-search="true">
                <?php
                include 'koneksi.php';
            
                $result2 = mysqli_query($koneksi, "SELECT nama_obat FROM obat ");   
                while ($data2 = mysqli_fetch_array($result2)){
                $nama_obat = $data2['nama_obat'];
    
                    echo "<option> $nama_obat </option> ";
                }

                ?>
          </select>  
           </div>   
            <div class="col-md-6">
            <label>QTY Obat 2</label>
                 <input class="form-control form-control-sm" type="number"  name="qty_obat_2">
            </div>
            </div>
            <br>
            <div class="row">
         <div class="col-md-6">
            <label>Obat 3</label>
                <select id="tokens" class="selectpicker form-control" name="obat_3" multiple data-live-search="true">
                <?php
                include 'koneksi.php';
            
                $result2 = mysqli_query($koneksi, "SELECT nama_obat FROM obat ");   
                while ($data2 = mysqli_fetch_array($result2)){
                $nama_obat = $data2['nama_obat'];
    
                    echo "<option> $nama_obat </option> ";
                }

                ?>
          </select>  
           </div>   
            <div class="col-md-6">
            <label>QTY Obat 3</label>
                 <input class="form-control form-control-sm" type="number"  name="qty_obat_3">
            </div>
            </div>
            <br>
            <div class="row">
         <div class="col-md-6">
            <label>Obat 4</label>
                <select id="tokens" class="selectpicker form-control" name="obat_4" multiple data-live-search="true">
                <?php
                include 'koneksi.php';
            
                $result2 = mysqli_query($koneksi, "SELECT nama_obat FROM obat ");   
                while ($data2 = mysqli_fetch_array($result2)){
                $nama_obat = $data2['nama_obat'];
    
                    echo "<option> $nama_obat </option> ";
                }

                ?>
          </select>  
           </div>   
            <div class="col-md-6">
            <label>QTY Obat 4</label>
                 <input class="form-control form-control-sm" type="number"  name="qty_obat_4">
            </div>
            </div>
            */ ?>

         <div class="modal-footer">
           <button type="submit" class="btn btn-primary">INPUT</button>
           <button type="reset" class="btn btn-danger"> RESET</button>
         </div>
       </form>
 

   </div>
 </div>
</div>
    </div>
   </div>


<table style="width:100%" id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align='center'>
                                    <thead align='center'>
                                        <tr>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tanggal Perawatan</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Dokter</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Diagnosis</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Cek Up Selanjutnya</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody align='center'>
                                        <?php
                                        $urut = 0;
                                 
                              
                                        $kode_antrian = 'A';
                                        function formatuang($angka)
                                        {
                                            $uang = "Rp " . number_format($angka, 2, ',', '.');
                                            return $uang;
                                        }

                                        ?>
                                        <?php while ($data = mysqli_fetch_array($tabel_perawatan)) {
                                            $no_perawatan = $data['no_perawatan'];
                                            $tanggal_perawatan = $data['tanggal'];
                                            $dokter = $data['nama_karyawan'];
                                            $id_pasien = $data['id_pasien'];
                                            $tindakan_1 = $data['tindakan_1'];
                                            $tindakan_2 = $data['tindakan_2'];
                                            $tindakan_3 = $data['tindakan_3'];
                                            $tindakan_4 = $data['tindakan_4'];
                                            $keluhan_awal = $data['keluhan_awal'];
                                            $diagnosis = $data['diagnosis'];
                                            $resep = $data['resep'];
                                            $nama_pasien = $data['nama_pasien'];

                                            $alkes_1 = $data['alkes_1'];
                                            $alkes_2 = $data['alkes_2'];
                                            $alkes_3 = $data['alkes_3'];
                                            $alkes_4 = $data['alkes_4'];

                                            $qty_alkes_1 = $data['qty_alkes_1'];
                                            $qty_alkes_2 = $data['qty_alkes_2'];
                                            $qty_alkes_3 = $data['qty_alkes_3'];
                                            $qty_alkes_4 = $data['qty_alkes_4'];

                                            $obat_1 = $data['obat_1'];
                                            $obat_2 = $data['obat_2'];
                                            $obat_3 = $data['obat_3'];
                                            $obat_4 = $data['obat_4'];

                                            $qty_obat_1 = $data['qty_obat_1'];
                                            $qty_obat_2 = $data['qty_obat_2'];
                                            $qty_obat_3 = $data['qty_obat_3'];
                                            $qty_obat_4 = $data['qty_obat_4'];
              
                                            $tanggal_cekUP_selanjutnya = $data['tgl_cek_selanjutnya'] ;
                                
                                        
                                            

                                            $urut = $urut + 1;
                                            $antrian = $kode_antrian.$urut;

                                            // tanggal lahir
                                            $tanggalx = new DateTime($tanggal_lahir);
                                            // tanggal hari ini
                                            $today = new DateTime('today');

                                            // tahun
                                            $y = $today->diff($tanggalx)->y;

                                            // bulan
                                            $m = $today->diff($tanggalx)->m;

                                            // hari
                                            $d = $today->diff($tanggalx)->d;

                                            echo "<tr>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal_perawatan</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$dokter</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px); overflow: hidden; max-width: 40ch;text-overflow: ellipsis; white-space: nowrap;' >$diagnosis</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal_cekUP_selanjutnya</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>
                                      
        
                                            <!-- Button rincian perwatan -->

                                          <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-info " data-toggle="modal" data-target="#rincian<?php echo $data['no_perawatan']; ?>" data-toggle='tooltip' title='Edit Data Obat'>
                                            <i class="fa-solid fa-file-waveform"></i> Rincian</button>
                  
                                            
                                            <!-- Form Modal  -->
                                            <div class="modal fade bd-example-modal-lg" id= "rincian<?php echo $data['no_perawatan']; ?>" tabindex="-1" role="dialog"  aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                              <div class="modal-dialog  modal-lg"  role ="document">
                                                <div class="modal-content"> 
                                                <div class="modal-header">
                                                  <h5 class="modal-title"> Rincian Perawatan</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div> 

                                                <!-- Form Input Data -->
                                                <div class="modal-body" align="left">
                                                  <?php  echo "<form action='../proses/EPerawatan' enctype='multipart/form-data' method='POST'>";  ?>

                                                  <div class="row">  
                                                    <div class="col-md-6">
                                                      <label>Nama Pasien</label>
                                                      <textarea  class="form-control form-control-sm"  name="diagnosis"  disabled=""><?= $nama_pasien; ?></textarea>
                                                  
                                                    </div> 
                                                    <div class="col-md-6">
                                                        <label>Tanggal Perwatan</label>
                                                        <textarea  class="form-control form-control-sm"  name="pesan" disabled=""><?= $tanggal_perawatan; ?></textarea>
                                                      
                                                      </div> 
                                                  </div>
                                                  <br>
                                                  <div class="row">  
                                                    <div class="col-md-6">
                                                      <label>Keluhan Awal</label>
                                                      <textarea  class="form-control form-control-sm"  name="diagnosis"  disabled=""><?= $keluhan_awal; ?></textarea>
                                                  
                                                    </div> 
                                                    <div class="col-md-6">
                                                        <label>Dokter</label>
                                                        <textarea  class="form-control form-control-sm"  name="pesan" disabled=""><?= $dokter; ?></textarea>
                                                      
                                                      </div> 
                                                  </div>
                                                  <br>
                                                  <div class="row">  
                                                    <div class="col-md-6">
                                                      <label>Diagnosis</label>
                                                      <textarea  class="form-control form-control-sm"  name="diagnosis"  disabled=""><?= $diagnosis; ?></textarea>
                                                  
                                                    </div> 
                                                    <div class="col-md-6">
                                                        <label>Pesan</label>
                                                        <textarea  class="form-control form-control-sm"  name="pesan" disabled=""><?= $pesan; ?></textarea>
                                                      
                                                      </div> 
                                                  </div>

                                                    <br>
                                                    
                                                    <div class="row">
                                                    <div class="col-md-6">
                                                      <div>
                                                      <label>Tindakan 1</label>
                                                      </div>
                                                      <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $tindakan_1; ?>" disabled>
                                                    </div> 
                                                    <div class="col-md-6">
                                                    <div>
                                                      <label>Tindakan 2</label>
                                                      </div>
                                                      <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $tindakan_2; ?>" disabled>
                                                    </div> 
                                                      
                                                  </div>
                                                  <br>
                                                    
                                                    <div class="row">
                                                    <div class="col-md-6">
                                                    <div>
                                                      <label>Tindakan 3</label>
                                                      </div>
                                                      <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $tindakan_3; ?>" disabled>   
                                                    </div> 
                                                    <div class="col-md-6">
                                                    <div>
                                                      <label>Tindakan 4</label>
                                                      </div>
                                                      <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $tindakan_4; ?>" disabled>
                                                    </div> 
                                                      
                                                  </div>
                                                    <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                      <label>Tanggal Cek Up Selanjutnya</label>
                                                      <input class="form-control form-control-sm" type="date"  name="tanggal_cek_selanjutnya"  value="<?= $tanggal_cekUP_selanjutnya; ?>" disabled>
                                                    </div>  
                                                    <div class="col-md-6">
                                                      <label>Resep</label>
                                                      <textarea  class="form-control form-control-sm"  name="resep" disabled><?= $resep; ?></textarea>
                                                      
                                                    </div> 
                                                      
                                                      </div>
                                             
                                            

                                            
                                                </form>
                                          

                                            </div>
                                          </div>
                                          </div>
                                              </div>
                                            
                                            <?php if($tanggal == $tanggal_perawatan){?>
                                              <!-- Button Edit Perawatan -->
                                          <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-warning " data-toggle="modal" data-target="#formedit<?php echo $data['no_perawatan']; ?>" data-toggle='tooltip' title='Edit Data Obat'>
                                            <i class="fas fa-edit"></i> Edit</button>
                                            <?php } ?>
                                            
                                            <!-- Form Modal  -->
                                            <div class="modal fade bd-example-modal-lg" id= "formedit<?php echo $data['no_perawatan']; ?>" tabindex="-1" role="dialog"  aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                              <div class="modal-dialog  modal-lg"  role ="document">
                                                <div class="modal-content"> 
                                                <div class="modal-header">
                                                  <h5 class="modal-title"> Form Edit Perawatan</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div> 

                                                <!-- Form Input Data -->
                                                <div class="modal-body" align="left">
                                                  <?php  echo "<form action='../proses/EPerawatan' enctype='multipart/form-data' method='POST'>";  ?>

                                                  <br>
                                                  <input type="hidden" name="no_antrian" value="<?= $no_antrian; ?>">
                                                  <input type="hidden" name="tanggal_antrian" value="<?= $tanggal_antrian; ?>">
                                                  <input type="hidden" name="id_pasien" value="<?= $id_pasien; ?>">
                                                  <input type="hidden" name="no_rm" value="<?= $no_rm; ?>">
                                                  <input type="hidden" name="no_perawatan" value="<?= $no_perawatan; ?>">
                                                  <div class="row">  
                                                    <div class="col-md-6">
                                                      <label>Diagnosis</label>
                                                      <textarea  class="form-control form-control-sm"  name="diagnosis" ><?= $diagnosis; ?></textarea>
                                                      <small>Jika text panjang tolong enter saat sudah di ujung field</small>
                                                    </div> 
                                                    <div class="col-md-6">
                                                        <label>Pesan</label>
                                                        <textarea  class="form-control form-control-sm"  name="pesan" ><?= $pesan; ?></textarea>
                                                        <small>Jika text panjang tolong enter saat sudah di ujung field</small>
                                                      </div> 
                                                  </div>

                                                    <br>
                                                    
                                                    <div class="row">
                                                    <div class="col-md-6">
                                                      <div>
                                                      <label>Tindakan 1</label>
                                                      </div>
                                                      <select id="tokens" class="selectpicker form-control" name="tindakan_1" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['tindakan_1'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_tindakan FROM tindakan ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_tindakan = $datax['nama_tindakan'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_tindakan) ? "selected" : "" ?>> <?php echo $nama_tindakan; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>
                                                    </div> 
                                                    <div class="col-md-6">
                                                    <div>
                                                      <label>Tindakan 2</label>
                                                      </div>
                                                      <select id="tokens" class="selectpicker form-control" name="tindakan_2" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['tindakan_2'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_tindakan FROM tindakan ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_tindakan = $datax['nama_tindakan'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_tindakan) ? "selected" : "" ?>> <?php echo $nama_tindakan; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>   
                                                    </div> 
                                                      
                                                  </div>
                                                  <br>
                                                    
                                                    <div class="row">
                                                    <div class="col-md-6">
                                                    <div>
                                                      <label>Tindakan 3</label>
                                                      </div>
                                                      <select id="tokens" class="selectpicker form-control" name="tindakan_3" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['tindakan_3'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_tindakan FROM tindakan ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_tindakan = $datax['nama_tindakan'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_tindakan) ? "selected" : "" ?>> <?php echo $nama_tindakan; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>     
                                                    </div> 
                                                    <div class="col-md-6">
                                                    <div>
                                                      <label>Tindakan 4</label>
                                                      </div>
                                                      <select id="tokens" class="selectpicker form-control" name="tindakan_4" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['tindakan_4'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_tindakan FROM tindakan ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_tindakan = $datax['nama_tindakan'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_tindakan) ? "selected" : "" ?>> <?php echo $nama_tindakan; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>    
                                                    </div> 
                                                      
                                                  </div>
                                                    <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                      <label>Tanggal Cek Up Selanjutnya</label>
                                                      <input class="form-control form-control-sm" type="date"  name="tanggal_cek_selanjutnya"  value="<?= $tanggal_cekUP_selanjutnya; ?>">
                                                    </div>  
                                                    <div class="col-md-6">
                                                      <label>Resep</label>
                                                      <textarea  class="form-control form-control-sm"  name="resep" ><?= $resep; ?></textarea>
                                                      <small>Tampilan text sesuai dengan pengetikan (enter, spasi, titik, koma)</small>
                                                    </div> 
                                                      
                                                      </div>

                                                      <?php /*
                                                      <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                    <div>
                                                    <label>Alat Kesehatan 1</label>
                                                    </div>
                                                      
                                                    <select id="tokens" class="selectpicker form-control" name="alkes_1" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['alkes_1'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_alkes FROM alat_kesehatan ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_alkes = $datax['nama_alkes'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_alkes) ? "selected" : "" ?>> <?php echo $nama_alkes; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>   
                                                    </div>   
                                                      <div class="col-md-6">
                                                        <div>
                                                        <label>QTY Alat Kesehatan 1</label>
                                                        </div>
                                                          
                                                          <input class="form-control form-control-sm" type="number"  name="qty_alkes_1" value="<?= $qty_alkes_1; ?>">
                                                      </div>
                                                      </div>
                                                      <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                    <div>
                                                    <label>Alat Kesehatan 2</label>
                                                    </div>
                                                    <select id="tokens" class="selectpicker form-control" name="alkes_2" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['alkes_2'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_alkes FROM alat_kesehatan ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_alkes = $datax['nama_alkes'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_alkes) ? "selected" : "" ?>> <?php echo $nama_alkes; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>   
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Alat Kesehatan 2</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_alkes_2" value="<?= $qty_alkes_2; ?>">
                                                      </div>
                                                      </div>
                                                      <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                  <div>
                                                    <label>Alat Kesehatan 3</label>
                                                    </div>
                                                    <select id="tokens" class="selectpicker form-control" name="alkes_3" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['alkes_3'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_alkes FROM alat_kesehatan ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_alkes = $datax['nama_alkes'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_alkes) ? "selected" : "" ?>> <?php echo $nama_alkes; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>  
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Alat Kesehatan 3</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_alkes_3" value="<?= $qty_alkes_3; ?>">
                                                      </div>
                                                      </div>
                                                      <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                  <div>
                                                    <label>Alat Kesehatan 4</label>
                                                    </div>
                                                    <select id="tokens" class="selectpicker form-control" name="alkes_4" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['alkes_4'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_alkes FROM alat_kesehatan ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_alkes = $datax['nama_alkes'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_alkes) ? "selected" : "" ?>> <?php echo $nama_alkes; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>  
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Alat Kesehatan 4</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_alkes_4" value="<?= $qty_alkes_4; ?>">
                                                      </div>
                                                      </div>

                                                      <br>
                                                      <div class="row">
                                                  <div class="col-md-6">
                                                    <div>
                                                    <label>Obat 1</label>
                                                    </div>
                                                      
                                                    <select id="tokens" class="selectpicker form-control" name="obat_1" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['obat_1'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_obat FROM obat ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_obat = $datax['nama_obat'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_obat) ? "selected" : "" ?>> <?php echo $nama_obat; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>   
                                                    </div>   
                                                      <div class="col-md-6">
                                                        <div>
                                                        <label>QTY Obat 1</label>
                                                        </div>
                                                      
                                                          <input class="form-control form-control-sm" type="number"  name="qty_obat_1" value="<?= $qty_obat_1; ?>">
                                                      </div>
                                                      </div>
                                                      <br>
                                                      <div class="row">
                                                  <div class="col-md-6">
                                                  <div>
                                                    <label>Obat 2</label>
                                                    </div>
                                                    <select id="tokens" class="selectpicker form-control" name="obat_2" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['obat_2'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_obat FROM obat ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_obat = $datax['nama_obat'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_obat) ? "selected" : "" ?>> <?php echo $nama_obat; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>    
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Obat 2</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_obat_2" value="<?= $qty_obat_2; ?>">
                                                      </div>
                                                      </div>
                                                      <br>
                                                      <div class="row">
                                                  <div class="col-md-6">
                                                  <div>
                                                    <label>Obat 3</label>
                                                    </div>
                                                    <select id="tokens" class="selectpicker form-control" name="obat_3" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['obat_3'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_obat FROM obat ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_obat = $datax['nama_obat'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_obat) ? "selected" : "" ?>> <?php echo $nama_obat; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>    
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Obat 3</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_obat_3" value="<?= $qty_obat_3; ?>">
                                                      </div>
                                                      </div>
                                                      <br>
                                                      <div class="row">
                                                  <div class="col-md-6">
                                                      <div>
                                                        <label>Obat 4</label>
                                                        </div>
                                                        <select id="tokens" class="selectpicker form-control" name="obat_4" multiple data-live-search="true">
                                                                        <?php
                                                                        include 'koneksi.php';
                                                                        $dataSelect = $data['obat_4'];
                                                                        $resultx = mysqli_query($koneksi, "SELECT nama_obat FROM obat ");   

                                                                        while ($datax= mysqli_fetch_array($resultx)){
                                                                            $nama_obat = $datax['nama_obat'];


                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_obat) ? "selected" : "" ?>> <?php echo $nama_obat; ?> <?php echo "</option>";
                                                                        
                                                                        }
                                                                        ?>
                                                      </select>    
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Obat 4</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_obat_4" value="<?= $qty_obat_4; ?>">
                                                      </div>
                                                      </div>
                                                      
                                                                        */ ?>
                                                  <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">EDIT</button>
                                                    <button type="reset" class="btn btn-danger"> RESET</button>
                                                  </div>
                                                </form>
                                          

                                            </div>
                                          </div>
                                          </div>
                                              </div>
                                        
                                            
                                            <?php if($tanggal == $tanggal_perawatan){?>
                                              <!-- Button Edit Perawatan -->
                                              <button style= " font-size: clamp(7px, 1vw, 10px);color:black;" href="#" type="submit" class=" btn btn-danger" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_perawatan']; ?>" data-toggle='tooltip' title='Hapus Data Pengeluran'>
                                              <i class="fa-solid fa-trash"></i> Hapus</button>
                                            <?php } ?>
                                          
                                            <div class="modal fade bd-example-modal-lg" id="PopUpHapus<?php echo $data['no_perawatan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role ="document">
                                              <div class="modal-content"> 
                                             
                                                <div class="modal-header">
                                                <h5 class="modal-title"> Hapus Perawatan</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true"> &times; </span>
                                                  </button>
                                                </div>


                                                <div class="modal-body">
                                                  <form action="../proses/HPerawatan" method="POST">
                                                    <input type="hidden" name="no_perawatan" value="<?php echo $no_perawatan; ?>">
                                                    <input type="hidden" name="id_pasien" value="<?= $id_pasien; ?>">


                                                    <div class="form-group">
                                                      <h6> Yakin Ingin Hapus Data Perawatan? </h6>             
                                                    </div>

                                                    <div class="modal-footer">
                                                      <button type="submit" class="btn btn-primary"> Hapus </button>
                                                    </div>
                                                  </form>
                                                </div>

                                              </div>
                                            </div>
                                          </div>
                                  
                                             
                                          

                                        <?php echo  " </td> </tr>";
                                        }
                                        ?>

                                    </tbody>
                                </table>
                        </div>

                        <br>





</div>

<!-- Bootstrap core JavaScript-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>
<script src="/bootstrap-select/dist/js/bootstrap-select.js"></script>
<!-- Tabel -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
<script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                lengthChange: false,
              
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>

  </body>
</html>