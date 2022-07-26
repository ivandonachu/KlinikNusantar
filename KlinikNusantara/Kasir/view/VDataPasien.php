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
if ($jabatan_valid == 'Kasir') {
} else {
    header("Location: logout.php");
    exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];
$foto_profile = $data['foto_profile'];

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

//sql data konten

$table = mysqli_query($koneksi, "SELECT * FROM pasien");


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Pasien</title>

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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

       <!-- Sidebar -->
       <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #300030" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasir">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px; max-height: 55px; width: 100%;" src="../gambar/Logo Klinik.jpeg"></div>
</a>
<br>

<br>
<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="DsKasir">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: clamp(5px, 3vw, 15px);"></i>
        <span style="font-size: clamp(5px, 3vw, 15px);">Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading" style="font-size: clamp(5px, 1vw, 22px); color:white;">
    Menu Kasir
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa-solid fa-cash-register" style="font-size: clamp(5px, 3vw, 15px); color:white;"></i>
        <span style="font-size: clamp(5px, 3vw, 15px); color:white;">Kasir</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="VPembayaran">Pembayaran</a>
            <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="VDataPasien">Data Pasien</a>
            <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="VAntrian">Antrian</a>
            <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" target="_blank" href="VLiveAntrian">Live Antrian</a>
        </div>
    </div>
</li>      



            <!-- Divider -->
            <hr class="sidebar-divider">




            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light  topbar mb-4 static-top shadow" style="background-color:#601848;">
                 <!-- Sidebar Toggle (Topbar) -->
                 <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
   
                    <?php echo "<a href='VDataPasien'><h5 class='text-center sm' style='color:white; margin-top: 8px; font-size: clamp(2px, 3vw, 22px);'>Data Pasien</h5></a>"; ?>

                   
                   

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                    
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>




                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline  small" style="color:white;"><?php echo "$nama"; ?></span>
                                <img class="img-profile rounded-circle" src="/assets/img_profile/<?= $foto_profile; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="VProfile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

<div class="row">
 <div class="col-md-10">

 </div>
 <div class="col-md-2">
   <!-- Button Input Data Bayar -->
   <div align="right">
     <button  style= "font-size: clamp(7px, 3vw, 15px); " type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i>Input Pasien</button> <br> <br>
   </div>
   <!-- Form Modal  -->
   <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role ="document">
      <div class="modal-content"> 
       <div class="modal-header">
         <h5 class="modal-title"> Form Input Pasien</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div> 

       <!-- Form Input Data -->
       <div class="modal-body" align="left">
         <?php  echo "<form action='../proses/PTambahPasien' enctype='multipart/form-data' method='POST'>";  ?>

         <br>

         <div class="row">
           <div class="col-md-4">
             <label>Nama Pasien</label>
             <input class="form-control form-control-sm" type="text"  name="nama_pasien" required="">
           </div>    
           <div class="col-md-4">
             <label>Tempat Lahir</label>
             <input class="form-control form-control-sm" type="text"  name="tempat_lahir" required="">
           </div>  
           <div class="col-md-4">
             <label>Tanggal Lahir</label>
             <input class="form-control form-control-sm" type="date"  name="tanggal_lahir" required="">
           </div>  
         </div>
          <br>
          <div class="row">
          <div class="col-md-4">
             <label>Jenis Kelamin</label>
             <select name="jenis_kelamin" class="form-control form-control-sm">
              <option>Pria</option>
              <option>Wanita</option>
            </select>
           </div>  
           <div class="col-md-4">
             <label>NIK</label>
             <input class="form-control form-control-sm" type="text"  name="nik">
           </div>    
           <div class="col-md-4">
             <label>Golongan Darah</label>
            <select name="golongan_darah" class="form-control form-control-sm">
              <option></option>
              <option>A</option>
              <option>B</option>
              <option>O</option>
              <option>AB</option>
            </select>
           </div>
         </div>
          <br>
         <div class="row">
          <div class="col-md-6">
              <label>No WA</label>
              <input class="form-control form-control-sm" type="text" name="no_hp" >
            </div>
            <div class="col-md-6">
              <label>Alamat</label>
              <textarea  class="form-control form-control-sm"  name="alamat" ></textarea>
            </div>
            </div>
        <br>

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
</div>

<!-- Tabel -->    
<div style="overflow-x: auto" >
<table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align="center">
<thead>
 <tr>
   <th style="font-size: clamp(12px, 1vw, 15px);">ID Pasien</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">Nama Pasien</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">Jenis Kelamin</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">Tempat, Tanggal Lahir</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">Usia</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">Golongan Darah</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">NIK</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">Alamat</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">No HP/WA</th>
   <th style="font-size: clamp(12px, 1vw, 15px);">Tgl Daftar</th>
   <th></th>
 </tr>
</thead>
<tbody>

 <?php while($data = mysqli_fetch_array($table)){
  $id_pasien = $data['id_pasien'];
  $nama_pasien = $data['nama_pasien'];
  $jenis_kelamin = $data['jenis_kelamin'];
  $tempat_lahir =$data['tempat_lahir'];
  $tanggal_lahir =$data['tanggal_lahir'];
  $nik =$data['nik'];
  $golongan_darah =$data['golongan_darah'];
  $no_hp =$data['no_hp'];
  $alamat =$data['alamat'];
  $tgl_daftar =$data['tgl_daftar'];

// tanggal lahir
$tanggalx = new DateTime($tanggal_lahir);
// tanggal hari ini
$today = new DateTime();

// tahun
$y = $today->diff($tanggalx)->y;

// bulan
$m = $today->diff($tanggalx)->m;

// hari
$d = $today->diff($tanggalx)->d;

  echo "<tr>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$id_pasien</td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_pasien</td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$jenis_kelamin</td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$tempat_lahir,";?> <?=  formattanggal($tanggal_lahir); ?> <?php echo" </td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >";?> <?php echo "".$y . "T " . $m . "B " . $d . "H";?> <?php echo"</td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$golongan_darah</td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$nik</td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$alamat</td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$no_hp</td>
  <td style='font-size: clamp(12px, 1vw, 15px);' >$tgl_daftar</td>
  "; ?>
  <?php echo "<td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>
  <button style= " font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-warning" data-toggle="modal" data-target="#formedit<?php echo $data['id_pasien']; ?>" data-toggle='tooltip' title='Edit Data Pasien'> 
  <i class="fas fa-edit"></i> Edit</button>
  <!-- Form EDIT DATA -->

  <div class="modal fade" id="formedit<?php echo $data['id_pasien']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role ="document">
     <div class="modal-content"> 
       <div class="modal-header">
         <h5 class="modal-title"> Edit Data Pasien </h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="close">
           <span aria-hidden="true"> &times; </span>
         </button>
       </div>

       <!-- Form Edit Data -->
       <div class="modal-body">
         <form action="../proses/EDataPasien" enctype="multipart/form-data" method="POST">

         <div class="row">
           <div class="col-md-6">
             <label>ID Pasien</label>
             <input class="form-control form-control-sm" type="text"  name="id_pasien" value="<?= $id_pasien; ?>" required="" disabled>
             <input type="hidden" name="id_pasien" value="<?= $id_pasien; ?>">
           </div>    
           <div class="col-md-6">
             <label>Nama Pasien</label>
             <input class="form-control form-control-sm" type="text"  name="nama_pasien"  value="<?= $nama_pasien; ?>" required="">
           </div>   
         </div>
          <br>
          <div class="row">
          <div class="col-md-4">
             <label>Jenis Kelamin</label>
             <?php $dataSelect = $data['jenis_kelamin']; ?>
            <select name="jenis_kelamin" class="form-control form-control-sm">
              <option></option>
              <option <?php echo ($dataSelect == 'Pria') ? "selected": "" ?> >Pria</option>
              <option <?php echo ($dataSelect == 'Wanita') ? "selected": "" ?> >Wanita</option>
            </select>
           </div>
          <div class="col-md-4">
             <label>Tempat Lahir</label>
             <input class="form-control form-control-sm" type="text"  name="tempat_lahir" value="<?= $tempat_lahir; ?>"  required="">
           </div>  
           <div class="col-md-4">
             <label>Tanggal Lahir</label>
             <input class="form-control form-control-sm" type="date"  name="tanggal_lahir" value="<?= $tanggal_lahir; ?>" required="">
           </div>    
         </div>
          <br>
         <div class="row">
          <div class="col-md-6">
             <label>NIK</label>
             <input class="form-control form-control-sm" type="text"  name="nik" value="<?= $nik; ?>">
           </div>    
           <div class="col-md-6">
             <label>Golongan Darah</label>
             <?php $dataSelect = $data['golongan_darah']; ?>
            <select name="golongan_darah" class="form-control form-control-sm">
              <option></option>
              <option <?php echo ($dataSelect == 'A') ? "selected": "" ?> >A</option>
              <option <?php echo ($dataSelect == 'B') ? "selected": "" ?> >B</option>
              <option <?php echo ($dataSelect == 'O') ? "selected": "" ?> >O</option>
              <option <?php echo ($dataSelect == 'AB') ? "selected": "" ?> >AB</option>
            </select>
           </div>
         </div>
          <br>
         <div class="row">
          <div class="col-md-6">
              <label>No WA</label>
              <input class="form-control form-control-sm" type="text" name="no_hp"  value="<?= $no_hp; ?>">
            </div>
            <div class="col-md-6">
              <label>Alamat</label>
              <textarea  class="form-control form-control-sm"  name="alamat" ><?= $alamat; ?></textarea>
            </div>
            </div>
        <br>

           <div class="modal-footer">
             <button type="submit" class="btn btn-primary"> Ubah </button>
             <button type="reset" class="btn btn-danger"> RESET</button>
           </div>
         </form>
       </div>
     </div>
   </div>
 </div>

 <!-- Button Hapus -->
 <button style= " font-size: clamp(7px, 1vw, 10px);color:black;" href="#" type="submit" class=" btn btn-danger " data-toggle="modal" data-target="#PopUpHapus<?php echo $data['id_pasien']; ?>" data-toggle='tooltip' title='Hapus Data Pasien'>
 <i class="fa-solid fa-trash"></i> Hapus</button>
 <div class="modal fade" id="PopUpHapus<?php echo $data['id_pasien']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role ="document">
    <div class="modal-content"> 
     <div class="modal-header">
       <h4 class="modal-title"> <b> Hapus Data Pasien </b> </h4>
       <button type="button" class="close" data-dismiss="modal" aria-label="close">
         <span aria-hidden="true"> &times; </span>
       </button>
     </div>

     <div class="modal-body">
       <form action="../proses/HDataPasien" method="POST">
         <input type="hidden" name="id_pasien" value="<?php echo $id_pasien ;?>">
         <div class="form-group">
           <h6> Yakin Ingin Hapus Data Pasien <?php echo $data['nama_pasien']; ?> </h6>             
         </div>

         <div class="modal-footer">
           <button type="submit" class="btn btn-primary"> Hapus </button>
         </div>
       </form>
     </div>
   </div>
 </div>
</div>

<button style= " font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn btn-success " data-toggle="modal" data-target="#antrian<?php echo $data['id_pasien']; ?>" data-toggle='tooltip' title='Input Antrian Pasien'> 
<i class="fa-solid fa-people-line"></i> Antrian</button>
  <!-- Form EDIT DATA -->

  <div class="modal fade" id="antrian<?php echo $data['id_pasien']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role ="document">
     <div class="modal-content"> 
       <div class="modal-header">
         <h5 class="modal-title"> Input Antrian Pasien </h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="close">
           <span aria-hidden="true"> &times; </span>
         </button>
       </div>

       <!-- Form Edit Data -->
       <div class="modal-body">
         <form action="../proses/PTambahAntrian" enctype="multipart/form-data" method="POST">

         <div class="row">
           <div class="col-md-6">
             <label>Nama Pasien</label>
             <input class="form-control form-control-sm" type="text"  name="id_pasien" value="<?= $nama_pasien; ?>" required="" disabled>
             <input type="hidden" name="id_pasien" value="<?= $id_pasien; ?>">
           </div>
           <div class="col-md-6">
             <label>Ruangan</label>
            <select name="nama_ruangan" class="form-control form-control-sm">
              <option>Ruangan 1</option>
              <option>Ruangan 2</option>
            </select>
           </div>   

         </div>
          <br>
         <div class="row">
         <div class="col-md-6">
          <div>
          <label>Dokter</label>
          </div>
            
  
             <select id="tokens" class="selectpicker form-control" name="nama_dokter" multiple data-live-search="true">
            <?php
            include 'koneksi.php';
         
            $result = mysqli_query($koneksi, "SELECT nama_karyawan FROM karyawan WHERE jabatan = 'Dokter' ");   
            while ($data2 = mysqli_fetch_array($result)){
              $nama_karyawan = $data2['nama_karyawan'];
  
                echo "<option> $nama_karyawan </option> ";
              }
                
             
               
            ?>
          </select>
           </div> 
            <div class="col-md-6">
              <label>Keluhan Awal</label>
              <textarea  class="form-control form-control-sm"  name="keluhan_awal" ></textarea>
            </div>
          </div>
        <br>

           <div class="modal-footer">
             <button type="submit" class="btn btn-primary"> INPUT </button>
             <button type="reset" class="btn btn-danger"> RESET</button>
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
<br>
</div>
</div>





            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="footer" style="background-color:#601848; height: 55px; padding-top: 15px; ">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span style="color:white; font-size: 12px;"></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout">Logout</a>
                </div>
            </div>
        </div>
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
    var table = $('#example').DataTable( {
      lengthChange: false,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>
<script>
  function createOptions(number) {
    var options = [], _options;

    for (var i = 0; i < number; i++) {
      var option = '<option value="' + i + '">Option ' + i + '</option>';
      options.push(option);
    }

    _options = options.join('');

    $('#number')[0].innerHTML = _options;
    $('#number-multiple')[0].innerHTML = _options;

    $('#number2')[0].innerHTML = _options;
    $('#number2-multiple')[0].innerHTML = _options;
  }

  var mySelect = $('#first-disabled2');

  createOptions(4000);

  $('#special').on('click', function () {
    mySelect.find('option:selected').prop('disabled', true);
    mySelect.selectpicker('refresh');
  });

  $('#special2').on('click', function () {
    mySelect.find('option:disabled').prop('disabled', false);
    mySelect.selectpicker('refresh');
  });

  $('#basic2').selectpicker({
    liveSearch: true,
    maxOptions: 1
  });
  
</script>


</body>

</html>