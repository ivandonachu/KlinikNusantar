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

//sql data konten

if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
} else {
    $tanggal_awal = date('Y-m-d');
    $tanggal_akhir = date('Y-m-d');
}



if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM perawatan a INNER JOIN rekam_medis b ON a.no_rm=b.no_rm
    INNER JOIN pasien c ON c.no_rm=a.no_rm
    INNER JOIN antrian d ON d.no_antrian=a.no_antrian  
    INNER JOIN karyawan e ON e.id_karyawan=a.id_dokter
    WHERE tanggal = '$tanggal_awal' AND e.nama_karyawan = '$nama' ORDER BY a.no_perawatan  ASC ");

    $query = mysqli_query( $koneksi, "SELECT COUNT(no_perawatan) AS jumlah_perawatan  FROM perawatan a INNER JOIN antrian b ON b.no_antrian=a.no_antrian WHERE b.tanggal = '$tanggal_awal' AND a.id_dokter = '$id1' " );
    $hasil = mysqli_fetch_array($query);

    $jumlah_perawatan = $hasil['jumlah_perawatan'];


    
} else {
    $table = mysqli_query($koneksi, "SELECT * FROM  perawatan a INNER JOIN rekam_medis b ON a.no_rm=b.no_rm
    INNER JOIN pasien c ON c.no_rm=a.no_rm
    INNER JOIN antrian d ON d.no_antrian=a.no_antrian  
    INNER JOIN karyawan e ON e.id_karyawan=a.id_dokter
    WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND e.nama_karyawan = '$nama' ORDER BY a.no_perawatan  ASC ");

$query = mysqli_query( $koneksi, "SELECT COUNT(no_perawatan) AS jumlah_perawatan  FROM perawatan a INNER JOIN antrian b ON b.no_antrian=a.no_antrian WHERE b.tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.id_dokter = '$id1' " );
$hasil = mysqli_fetch_array($query);

$jumlah_perawatan = $hasil['jumlah_perawatan'];

}






?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Riwayat Perawatan</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsDokter">
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
    <a class="nav-link" href="DsDokter">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: clamp(5px, 3vw, 15px);"></i>
        <span style="font-size: clamp(5px, 3vw, 15px);">Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading" style="font-size: clamp(5px, 1vw, 22px); color:white;">
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa-solid fa-cash-register" style="font-size: clamp(5px, 3vw, 15px); color:white;"></i>
        <span style="font-size: clamp(5px, 3vw, 15px); color:white;">Perwatan & Pasien</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="VRiwayatPerawatan">Riwayat Perawatan</a>
            <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="VRMPasien">Rekam Medis Pasien</a>
            <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="VAntrian">Antrian</a>
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

                    <?php echo "<a href='VRiwayatPerawatan'><h5 class='text-center sm' style='color:white; margin-top: 8px; font-size: clamp(2px, 3vw, 22px);'>Riwayat Perawatan</h5></a>"; ?>




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
                    <?php echo "<form  method='POST' action='VRiwayatPerawatan' style='margin-bottom: 15px;'>" ?>
                    <div>
                        <div align="left" style="margin-left: 20px;">
                            <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                            <span>-</span>
                            <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                            <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                        </div>
                    </div>
                    </form>

                    <div class="row">
                        <!-- Tampilan tanggal -->
                        <div class="col-md-6">
                            <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                        </div>
                        <div class="col-md-6" align='right'>


                        </div>
                    </div>


                            <!-- Tabel -->
                            <div style="overflow-x: auto">
                                <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align='center'>
                                    <thead>
                                        <tr>
                                        <th style="font-size: clamp(12px, 1vw, 15px);">No</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tanggal</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Nama Pasien</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Diagnosis</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tindakan 1</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tindakan 2</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tindakan 3</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tindakan 4</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);"></th>
                               

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $urut = 0;
                                 
                              
                                        $kode_antrian = 'A';
                                        function formatuang($angka)
                                        {
                                            $uang = "Rp " . number_format($angka, 2, ',', '.');
                                            return $uang;
                                        }

                                        ?>
                                        <?php while ($data = mysqli_fetch_array($table)) {
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
                                         

                                            echo "<tr>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$urut</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal_perawatan</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_pasien</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$diagnosis</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tindakan_1</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tindakan_2</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tindakan_3</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tindakan_4</td>
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
                                                      <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                    <div>
                                                    <label>Alat Kesehatan 1</label>
                                                    </div>
                                                    <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $alkes_1; ?>" disabled>
                                                    </div>   
                                                      <div class="col-md-6">
                                                        <div>
                                                        <label>QTY Alat Kesehatan 1</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_alkes_1" value="<?= $qty_alkes_1; ?>" disabled>
                                                      </div>
                                                      </div>
                                                      <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                    <div>
                                                    <label>Alat Kesehatan 2</label>
                                                    </div>
                                                    <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $alkes_2; ?>" disabled> 
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Alat Kesehatan 2</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_alkes_2" value="<?= $qty_alkes_2; ?>" disabled>
                                                      </div>
                                                      </div>
                                                      <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                  <div>
                                                    <label>Alat Kesehatan 3</label>
                                                    </div>
                                                    <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $alkes_3; ?>" disabled>
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Alat Kesehatan 3</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_alkes_3" value="<?= $qty_alkes_3; ?>" disabled>
                                                      </div>
                                                      </div>
                                                      <br>
                                                  <div class="row">
                                                  <div class="col-md-6">
                                                  <div>
                                                    <label>Alat Kesehatan 4</label>
                                                    </div>
                                                    <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $alkes_4; ?>" disabled>
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Alat Kesehatan 4</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_alkes_4" value="<?= $qty_alkes_4; ?>" disabled>
                                                      </div>
                                                      </div>

                                                      <br>
                                                      <div class="row">
                                                  <div class="col-md-6">
                                                    <div>
                                                    <label>Obat 1</label>
                                                    </div>
                                                    <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $obat_1; ?>" disabled>  
                                                    </div>   
                                                      <div class="col-md-6">
                                                        <div>
                                                        <label>QTY Obat 1</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_obat_1" value="<?= $qty_obat_1; ?>" disabled>
                                                      </div>
                                                      </div>
                                                      <br>
                                                      <div class="row">
                                                  <div class="col-md-6">
                                                  <div>
                                                    <label>Obat 2</label>
                                                    </div>
                                                    <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $obat_2; ?>" disabled>   
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Obat 2</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_obat_2" value="<?= $qty_obat_2; ?>" disabled>
                                                      </div>
                                                      </div>
                                                      <br>
                                                      <div class="row">
                                                  <div class="col-md-6">
                                                  <div>
                                                    <label>Obat 3</label>
                                                    </div>
                                                    <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $obat_3; ?>" disabled>  
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Obat 3</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_obat_3" value="<?= $qty_obat_3; ?>" disabled>
                                                      </div>
                                                      </div>
                                                      <br>
                                                      <div class="row">
                                                  <div class="col-md-6">
                                                      <div>
                                                        <label>Obat 4</label>
                                                        </div>
                                                        <input class="form-control form-control-sm" type="text"  name="tanggal_cek_selanjutnya"  value="<?= $obat_4; ?>" disabled>   
                                                    </div>   
                                                      <div class="col-md-6">
                                                      <div>
                                                        <label>QTY Obat 4</label>
                                                        </div>
                                                          <input class="form-control form-control-sm" type="number"  name="qty_obat_4" value="<?= $qty_obat_4; ?>" disabled>
                                                      </div>
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
<br>

<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Perawatan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_perawatan  ?></div>
          </div>
          <div class="col-auto">
            <i class="fa-solid fa-hospital-user fa-2x text-gray-300"></i>
           
          </div>
        </div>
      </div>
    </div>
  </div>
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
            var table = $('#example').DataTable({
                lengthChange: false,
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        $(document).ready(function() {
            var table2 = $('#example1').DataTable({
                lengthChange: false,
            });

            table2.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        function createOptions(number) {
            var options = [],
                _options;

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

        $('#special').on('click', function() {
            mySelect.find('option:selected').prop('disabled', true);
            mySelect.selectpicker('refresh');
        });

        $('#special2').on('click', function() {
            mySelect.find('option:disabled').prop('disabled', false);
            mySelect.selectpicker('refresh');
        });

        $('#basic2').selectpicker({
            liveSearch: true,
            maxOptions: 1
        });
    </script>
    <script>
        function bunyi() {
        var bel = new Audio('/assets/sound/doorbell.mp3');
     
        bel.play();  onclick="bunyi();" 
}
    </script>
</body>

</html>