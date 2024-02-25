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

if (isset($_GET['antrian'])) {
    $antrian = $_GET['antrian'];

} else {
    $antrian = "";

}


if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM antrian a INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
    WHERE tanggal = '$tanggal_awal' AND c.nama_ruangan = 'Ruangan 1' ORDER BY a.no_antrian");
    $table2 = mysqli_query($koneksi, "SELECT * FROM antrian a INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
     WHERE tanggal = '$tanggal_awal' AND c.nama_ruangan = 'Ruangan 2' ORDER BY a.no_antrian");
} else {
    $table = mysqli_query($koneksi, "SELECT * FROM antrian a INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
    WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND c.nama_ruangan = 'Ruangan 1' ORDER BY a.no_antrian");
    $table2 = mysqli_query($koneksi, "SELECT * FROM antrian a INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
    WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND c.nama_ruangan = 'Ruangan 2' ORDER BY a.no_antrian");
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

    <title>Antrian Pasien</title>

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
    <?php 
      if($antrian == ""){

      }
      else{?>
        <audio src="/assets/sound/doorbell.mp3" id="my_audio" autoplay="autoplay"></audio>
      <?php };  ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #300030" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasir">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px; max-height: 55px; width: 100%;" src="../gambar/Logo Klinik.png"></div>
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

                    <?php echo "<a href='VAntrian'><h5 class='text-center sm' style='color:white; margin-top: 8px; font-size: clamp(2px, 3vw, 22px);'>Antrian Pasien</h5></a>"; ?>




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
                    <?php echo "<form  method='POST' action='VAntrian' style='margin-bottom: 15px;'>" ?>
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
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <!-- Button Input Data obat -->

                            <?php //echo "<a href='VAntrianR2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-info'>Ruang 2</button></a>"; 
                            ?>
                        </div>
                    </div>


                    <br>
                    <hr>
                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <h2 align='center'>Antrian Ruangan 1</h2>
                            <br>
                            <hr>
                            <br>
                            <!-- Tabel -->
                            <div style="overflow-x: auto">
                                <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align='center'>
                                    <thead>
                                        <tr>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">No</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tanggal</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Nama Pasien</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Keluhan Awal</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Dokter</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Ruangan</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Status</th>
                                            <th></th>

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
                                            $no_antrian = $data['no_antrian'];
                                            $tanggal = $data['tanggal'];
                                            $nama_pasien = $data['nama_pasien'];
                                            $nama_ruangan = $data['nama_ruangan'];
                                            $nama_karyawan = $data['nama_karyawan'];
                                            $keluhan_awal = $data['keluhan_awal'];
                                            $status_antrian = $data['status_antrian'];

                                            $urut = $urut + 1;
                                            $antrian = $kode_antrian.$urut;

                                            echo "<tr>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$antrian</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_pasien</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$keluhan_awal</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_karyawan</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_ruangan</td>
                                            ";
                                            if ($status_antrian == 'Menunggu') {
                                                echo " <td style='font-size: clamp(12px, 1vw, 15px); color: #DAA520; font-weight: bold;' >$status_antrian </td>";
                                            } else if ($status_antrian == 'Dalam Perawatan') {
                                                echo " <td style='font-size: clamp(12px, 1vw, 15px); color: #1E90FF; font-weight: bold;' >$status_antrian </td>";
                                            }else if ($status_antrian == 'Pembayaran') {
                                                echo " <td style='font-size: clamp(12px, 1vw, 15px); color: #008B8B; font-weight: bold;' >$status_antrian </td>";
                                            } else if ($status_antrian == 'Selesai') {
                                                echo " <td style='font-size: clamp(12px, 1vw, 15px); color: #008000; font-weight: bold;' >$status_antrian </td>";
                                            }

                                           ?>
                                            <?php echo "<td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>
                                      
                                      
                                            <?php   if ($status_antrian == 'Menunggu') {?>
                                                <!-- Button Panggil Antri -->
                                              <button style=" font-size: clamp(7px, 1vw, 10px);color:black;" href="#" type="submit" class=" btn btn-info" data-toggle="modal" data-target="#panggil_antrian1<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Panggil Antrian'>
                                              <i class='fa-solid fa-headset'></i></button>

                                               <!-- Button Print No antri -->
                                            
                                               <?php echo "  <a href='VPrintAntrian?antrian=$antrian&nama_ruangan=$nama_ruangan&nama_karyawan=$nama_karyawan&nama_pasien=$nama_pasien&tanggal=$tanggal' target='_blank'><button style=' font-size: clamp(7px, 1vw, 10px);color:black; '  type='submit' class=' btn btn-secondary' >
                                            <i class='fa-solid fa-print'></i></button></a>"; ?>

                                            <?php } ?>
                                            
                                             
                                            <div class="modal fade" id="panggil_antrian1<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Panggil Antrian </b> </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="../proses/PanggilAntrian" method="POST">
                                                                <input type="hidden" name="no_antrian" value="<?php echo $no_antrian; ?>">
                                                                <input type="hidden" name="antrian" value="<?php echo $antrian; ?>">
                                                                <input type="hidden" name="nama_ruangan" value="<?php echo $nama_ruangan; ?>">
                                                                <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                <div class="form-group">
                                                                    <h6> Panggil Antrian Antrian <?= $nama_pasien; ?> </h6>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"> Panggil </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php 
                                            if($status_antrian == 'Selesai' ){ ?>
                                            <!-- Button Print struk bayar -->
                                            
                                            <?php echo "<a href='VPrintStruk?no_antrian=$no_antrian' target='_blank'><button style=' font-size: clamp(7px, 1vw, 10px);color:black;
                                             '  type='submit' class=' btn btn-secondary' >  <i class='fa-solid fa-print'></i></button></a>";
                                                
                                            } ?>

                                            

                                            
                                            <?php 
                                            if($status_antrian == 'Pembayaran' ){ ?>
                                            <!-- Button Bayar -->
                                            <button style=" font-size: clamp(7px, 1vw, 10px); color:black; "href="#" type="submit" class=" btn bg-success " data-toggle="modal" data-target="#pembayaran<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Pembayaran'>
                                            <i class="fa-solid fa-dollar-sign"></i></button>
                    

                                            <div class="modal fade" id="pembayaran<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Konfirmasi Pembayaran </b> </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="../proses/PBayar" method="POST">
                                                                <input type="hidden" name="no_antrian" value="<?php echo $no_antrian; ?>">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                <?php 
                                                                                                                                        
                                                                    $sql_perawatan = mysqli_query($koneksi, "SELECT * FROM perawatan a INNER JOIN rekam_medis b ON a.no_rm=b.no_rm
                                                                    INNER JOIN pasien c ON c.no_rm=a.no_rm
                                                                    INNER JOIN antrian d ON d.no_antrian=a.no_antrian  
                                                                    INNER JOIN karyawan e ON e.id_karyawan=a.id_dokter  
                                                                    WHERE d.no_antrian = '$no_antrian' ");

                                                                    $data_perawatan = mysqli_fetch_assoc($sql_perawatan);

                                                                    $no_perawatan = $data_perawatan['no_perawatan'];
                                                                    $tindakan_1 = $data_perawatan['tindakan_1'];
                                                                    $qty_tindakan_1 = $data_perawatan['qty_tindakan_1'];
                                                                    $tindakan_2 = $data_perawatan['tindakan_2'];
                                                                    $qty_tindakan_2 = $data_perawatan['qty_tindakan_2'];
                                                                    $tindakan_3 = $data_perawatan['tindakan_3'];
                                                                    $qty_tindakan_3 = $data_perawatan['qty_tindakan_3'];
                                                                    $tindakan_4 = $data_perawatan['tindakan_4'];
                                                                    $qty_tindakan_4 = $data_perawatan['qty_tindakan_4'];
                                                                    $tindakan_5 = $data_perawatan['tindakan_5'];
                                                                    $qty_tindakan_5 = $data_perawatan['qty_tindakan_5'];
                                                                    $tindakan_6 = $data_perawatan['tindakan_6'];
                                                                    $qty_tindakan_6 = $data_perawatan['qty_tindakan_6'];


                                                                    $alkes_1 = $data_perawatan['alkes_1'];
                                                                    $qty_alkes_1 = $data_perawatan['qty_alkes_1'];
                                                                    $alkes_2 = $data_perawatan['alkes_2'];
                                                                    $qty_alkes_2 = $data_perawatan['qty_alkes_2'];
                                                                    $alkes_3 = $data_perawatan['alkes_3'];
                                                                    $qty_alkes_3 = $data_perawatan['qty_alkes_3'];
                                                                    $alkes_4 = $data_perawatan['alkes_4'];
                                                                    $qty_alkes_4 = $data_perawatan['qty_alkes_4'];

                                                                    $obat_1 = $data_perawatan['obat_1'];
                                                                    $qty_obat_1 = $data_perawatan['qty_obat_1'];
                                                                    $obat_2 = $data_perawatan['obat_2'];
                                                                    $qty_obat_2 = $data_perawatan['qty_obat_2'];
                                                                    $obat_3 = $data_perawatan['obat_3'];
                                                                    $qty_obat_3 = $data_perawatan['qty_obat_3'];
                                                                    $obat_4 = $data_perawatan['obat_4'];
                                                                    $qty_obat_4 = $data_perawatan['qty_obat_4'];
                                                                    $total_pembayaran= 0;   

                                                                    //tindkan
                                                                    if($tindakan_1 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_1'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = $qty_tindakan_1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    if($tindakan_2 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_2'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = $qty_tindakan_2 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    if($tindakan_3 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_3'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = $qty_tindakan_3 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    if($tindakan_4 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_4'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = $qty_tindakan_4 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    if($tindakan_5 != ""){
                                                                        $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_5'");
                                                                        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);
    
                                                                        $harga = $data_tindakan['harga_tindakan'];
    
                                                                        $jumlah = $qty_tindakan_5 * $harga;
                                                                        $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    if($tindakan_6 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_6'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = $qty_tindakan_6 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }



                                                                    //Alkes
                                                                    if($alkes_1 != ""){
                                                                    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_1'");
                                                                    $data_alkes = mysqli_fetch_assoc($sql_alkes);

                                                                    $harga = $data_alkes['harga_jual'];

                                                                    $jumlah = $qty_alkes_1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($alkes_2 != ""){
                                                                    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_2'");
                                                                    $data_alkes = mysqli_fetch_assoc($sql_alkes);

                                                                    $harga = $data_alkes['harga_jual'];

                                                                    $jumlah = $qty_alkes_2 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($alkes_3!= ""){
                                                                    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_3'");
                                                                    $data_alkes = mysqli_fetch_assoc($sql_alkes);

                                                                    $harga = $data_alkes['harga_jual'];

                                                                    $jumlah = $qty_alkes_3 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($alkes_4 != ""){
                                                                    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_4'");
                                                                    $data_alkes = mysqli_fetch_assoc($sql_alkes);

                                                                    $harga = $data_alkes['harga_jual'];

                                                                    $jumlah = $qty_alkes_4 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    //Obat
                                                                    if($obat_1 != ""){
                                                                    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_1'");
                                                                    $data_obat = mysqli_fetch_assoc($sql_obat);

                                                                    $harga = $data_obat['harga_jual'];

                                                                    $jumlah = $qty_obat_1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($obat_2 != ""){
                                                                    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_2'");
                                                                    $data_obat = mysqli_fetch_assoc($sql_obat);

                                                                    $harga = $data_obat['harga_jual'];

                                                                    $jumlah = $qty_obat_2 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($obat_3 != ""){
                                                                    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_3'");
                                                                    $data_obat = mysqli_fetch_assoc($sql_obat);

                                                                    $harga = $data_obat['harga_jual'];

                                                                    $jumlah = $qty_obat_3 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($obat_4 != ""){
                                                                    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_4'");
                                                                    $data_obat = mysqli_fetch_assoc($sql_obat);

                                                                    $harga = $data_obat['harga_jual'];

                                                                    $jumlah = $qty_obat_4 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>Metode Pembayaran</label>

                                                                        <select name="jenis_pembayaran" class="form-control form-control-sm">
                                                                            <option>Cash</option>
                                                                            <option>Debit</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Total Tagihan</label>
                                                                        <input class="form-control form-control-sm" type="text"  value="<?= formatuang($total_pembayaran); ?>" required="" disabled>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Total Bayar</label>
                                                                        <input class="form-control form-control-sm" name="total_bayar" type="text"   required="" >
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Potongan Harga</label>
                                                                        <input class="form-control form-control-sm" name="potongan_bayar" type="text"  value="0"  required="" > 
                                                                        <small>input dalam bentuk persen (0-100)%</small>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <h6> Konfirmasi Pembayaran <?= $nama_pasien; ?> </h6>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"> Bayar </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <?php
                                                
                                            } ?>
                                             




                                            
                                            <button style=" font-size: clamp(7px, 1vw, 10px); color:black; "href="#" type="submit" class=" btn bg-warning " data-toggle="modal" data-target="#edit_antrian1<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Edit Antrian'>
                                                <i class="fas fa-edit"></i></button>
                                            <!-- Form EDIT DATA -->

                                            <div class="modal fade bd-example-modal-lg" id="edit_antrian1<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"> Form Edit Antrian </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>

                                                        <!-- Form Edit Data -->
                                                        <div class="modal-body" align="left">
                                                            <form action="../proses/EAntrian" enctype="multipart/form-data" method="POST">

                                                                <input type="hidden" name="no_antrian" value="<?php echo $no_antrian; ?>">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Nama Pasien</label>
                                                                        <input class="form-control form-control-sm" type="text"  value="<?= $nama_pasien; ?>" required="" disabled>
                                                                        <input type="hidden" name="id_pasien" value="<?= $id_pasien; ?>">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Ruangan</label>

                                                                        <select name="nama_ruangan" class="form-control form-control-sm">
                                                                            <?php $dataSelect = $data['nama_ruangan']; ?>
                                                                            <option <?php echo ($dataSelect == 'Ruangan 1') ? "selected" : "" ?>>Ruangan 1</option>
                                                                            <option <?php echo ($dataSelect == 'Ruangan 2') ? "selected" : "" ?>>Ruangan 2</option>
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
                                                                            while ($data2 = mysqli_fetch_array($result)) {
                                                                                $nama_karyawan = $data2['nama_karyawan'];
                                                                                $dataSelect = $data['nama_karyawan'];

                                                                                    echo "<option" ?> <?php echo ($dataSelect == $nama_karyawan) ? "selected" : "" ?>> <?php echo $nama_karyawan; ?> <?php echo "</option>";
                                                                                 }
                                                                                                                                                                                                
                                                                                                                                                                                                        ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label>Keluhan Awal</label>
                                                                        <textarea class="form-control form-control-sm" name="keluhan_awal"><?= $keluhan_awal; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <br>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"> EDIT </button>
                                                                    <button type="reset" class="btn btn-danger"> RESET</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Button Hapus -->
                                            <button style=" font-size: clamp(7px, 1vw, 10px);color:black;" href="#" type="submit" class=" btn btn-danger" data-toggle="modal" data-target="#hapus_antrian1<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Hapus Antrian'>
                                                <i class="fa-solid fa-trash"></i></button>
                                            <div class="modal fade" id="hapus_antrian1<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Hapus Antrian </b> </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="../proses/HAntrian" method="POST">
                                                                <input type="hidden" name="no_antrian" value="<?php echo $no_antrian; ?>">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                <div class="form-group">
                                                                    <h6> Yakin Ingin Hapus Antrian <?= $nama_pasien; ?> </h6>
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
                        </div>
                        <div class="col-md-6">
                            <h2 align='center'>Antrian Ruangan 2</h2>
                            <br>
                            <hr>
                            <br>
                            <!-- Tabel -->
                            <div style="overflow-x: auto">
                                <table id="example1" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align='center'>
                                    <thead>
                                        <tr>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">No</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tanggal</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Nama Pasien</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Keluhan Awal</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Dokter</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Ruangan</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Status</th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $urut = 0;

                                        $kode_antrian = 'B';
                                        ?>
                                        <?php while ($data = mysqli_fetch_array($table2)) {
                                            $no_antrian = $data['no_antrian'];
                                            $tanggal = $data['tanggal'];
                                            $nama_pasien = $data['nama_pasien'];
                                            $nama_ruangan = $data['nama_ruangan'];
                                            $nama_karyawan = $data['nama_karyawan'];
                                            $keluhan_awal = $data['keluhan_awal'];
                                            $status_antrian = $data['status_antrian'];

                                            $urut = $urut + 1;

                                            $antrian = $kode_antrian.$urut;
                                            echo "<tr>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$antrian</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_pasien</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$keluhan_awal</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_karyawan</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_ruangan</td>
                                            ";
                                            if ($status_antrian == 'Menunggu') {
                                                echo " <td style='font-size: clamp(12px, 1vw, 15px); color: #DAA520; font-weight: bold;' >$status_antrian </td>";
                                            } else if ($status_antrian == 'Dalam Perawatan') {
                                                echo " <td style='font-size: clamp(12px, 1vw, 15px); color: #1E90FF; font-weight: bold;' >$status_antrian </td>";
                                            } else if ($status_antrian == 'Pembayaran') {
                                                echo " <td style='font-size: clamp(12px, 1vw, 15px); color: #008B8B; font-weight: bold;' >$status_antrian </td>";
                                            }else if ($status_antrian == 'Selesai') {
                                                echo " <td style='font-size: clamp(12px, 1vw, 15px); color: #008000; font-weight: bold;' >$status_antrian </td>";
                                            }

                                        ?>
                                            <?php echo "<td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>

                                            
                                      
                                            <?php   if ($status_antrian == 'Menunggu') {?>
                                                <!-- Button Panggil Antri -->
                                              <button style=" font-size: clamp(7px, 1vw, 10px);color:black;" href="#" type="submit" class=" btn btn-info" data-toggle="modal" data-target="#panggil_antrian1<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Panggil Antrian'>
                                              <i class='fa-solid fa-headset'></i></button>

                                               <!-- Button Print No antri -->
                                            
                                               <?php echo "  <a href='VPrintAntrian?antrian=$antrian&nama_ruangan=$nama_ruangan&nama_karyawan=$nama_karyawan&nama_pasien=$nama_pasien&tanggal=$tanggal' target='_blank'><button style=' font-size: clamp(7px, 1vw, 10px);color:black; '  type='submit' class=' btn btn-secondary' >
                                            <i class='fa-solid fa-print'></i></button></a>"; ?>

                                            <?php } ?>
                                            
                                             
                                            <div class="modal fade" id="panggil_antrian1<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Panggil Antrian </b> </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="../proses/PanggilAntrian" method="POST">
                                                                <input type="hidden" name="no_antrian" value="<?php echo $no_antrian; ?>">
                                                                <input type="hidden" name="antrian" value="<?php echo $antrian; ?>">
                                                                <input type="hidden" name="nama_ruangan" value="<?php echo $nama_ruangan; ?>">
                                                                <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                <div class="form-group">
                                                                    <h6> Panggil Antrian Antrian <?= $nama_pasien; ?> </h6>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"> Panggil </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php 
                                            if($status_antrian == 'Selesai' ){ ?>
                                            <!-- Button Print struk bayar -->
                                            
                                            <?php echo "<a href='VPrintStruk?no_antrian=$no_antrian' target='_blank'><button style=' font-size: clamp(7px, 1vw, 10px);color:black;
                                             '  type='submit' class=' btn btn-secondary' >  <i class='fa-solid fa-print'></i></button></a>";
                                                
                                            } ?>

                                            

                                            
                                            <?php 
                                            if($status_antrian == 'Pembayaran' ){ ?>
                                            <!-- Button Bayar -->
                                            <button style=" font-size: clamp(7px, 1vw, 10px); color:black; "href="#" type="submit" class=" btn bg-success " data-toggle="modal" data-target="#pembayaran<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Pembayaran'>
                                            <i class="fa-solid fa-dollar-sign"></i></button>
                    

                                            <div class="modal fade" id="pembayaran<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Konfirmasi Pembayaran </b> </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="../proses/PBayar" method="POST">
                                                                <input type="hidden" name="no_antrian" value="<?php echo $no_antrian; ?>">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                <?php 
                                                                                                                                        
                                                                    $sql_perawatan = mysqli_query($koneksi, "SELECT * FROM perawatan a INNER JOIN rekam_medis b ON a.no_rm=b.no_rm
                                                                    INNER JOIN pasien c ON c.no_rm=a.no_rm
                                                                    INNER JOIN antrian d ON d.no_antrian=a.no_antrian  
                                                                    INNER JOIN karyawan e ON e.id_karyawan=a.id_dokter  
                                                                    WHERE d.no_antrian = '$no_antrian' ");

                                                                    $data_perawatan = mysqli_fetch_assoc($sql_perawatan);

                                                                    $no_perawatan = $data_perawatan['no_perawatan'];
                                                                    $tindakan_1 = $data_perawatan['tindakan_1'];
                                                                    $tindakan_2 = $data_perawatan['tindakan_2'];
                                                                    $tindakan_3 = $data_perawatan['tindakan_3'];
                                                                    $tindakan_4 = $data_perawatan['tindakan_4'];


                                                                    $alkes_1 = $data_perawatan['alkes_1'];
                                                                    $qty_alkes_1 = $data_perawatan['qty_alkes_1'];
                                                                    $alkes_2 = $data_perawatan['alkes_2'];
                                                                    $qty_alkes_2 = $data_perawatan['qty_alkes_2'];
                                                                    $alkes_3 = $data_perawatan['alkes_3'];
                                                                    $qty_alkes_3 = $data_perawatan['qty_alkes_3'];
                                                                    $alkes_4 = $data_perawatan['alkes_4'];
                                                                    $qty_alkes_4 = $data_perawatan['qty_alkes_4'];

                                                                    $obat_1 = $data_perawatan['obat_1'];
                                                                    $qty_obat_1 = $data_perawatan['qty_obat_1'];
                                                                    $obat_2 = $data_perawatan['obat_2'];
                                                                    $qty_obat_2 = $data_perawatan['qty_obat_2'];
                                                                    $obat_3 = $data_perawatan['obat_3'];
                                                                    $qty_obat_3 = $data_perawatan['qty_obat_3'];
                                                                    $obat_4 = $data_perawatan['obat_4'];
                                                                    $qty_obat_4 = $data_perawatan['qty_obat_4'];
                                                                    $total_pembayaran= 0;   

                                                                    //tindkan
                                                                    if($tindakan_1 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_1'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = 1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    if($tindakan_2 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_2'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = 1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    if($tindakan_3 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_3'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = 1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    if($tindakan_4 != ""){
                                                                    $sql_tindakan = mysqli_query($koneksi, "SELECT harga_tindakan FROM tindakan WHERE nama_tindakan = '$tindakan_4'");
                                                                    $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

                                                                    $harga = $data_tindakan['harga_tindakan'];

                                                                    $jumlah = 1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }



                                                                    //Alkes
                                                                    if($alkes_1 != ""){
                                                                    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_1'");
                                                                    $data_alkes = mysqli_fetch_assoc($sql_alkes);

                                                                    $harga = $data_alkes['harga_jual'];

                                                                    $jumlah = $qty_alkes_1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($alkes_2 != ""){
                                                                    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_2'");
                                                                    $data_alkes = mysqli_fetch_assoc($sql_alkes);

                                                                    $harga = $data_alkes['harga_jual'];

                                                                    $jumlah = $qty_alkes_2 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($alkes_3!= ""){
                                                                    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_3'");
                                                                    $data_alkes = mysqli_fetch_assoc($sql_alkes);

                                                                    $harga = $data_alkes['harga_jual'];

                                                                    $jumlah = $qty_alkes_3 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($alkes_4 != ""){
                                                                    $sql_alkes = mysqli_query($koneksi, "SELECT harga_jual FROM alat_kesehatan WHERE nama_alkes = '$alkes_4'");
                                                                    $data_alkes = mysqli_fetch_assoc($sql_alkes);

                                                                    $harga = $data_alkes['harga_jual'];

                                                                    $jumlah = $qty_alkes_4 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                    //Obat
                                                                    if($obat_1 != ""){
                                                                    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_1'");
                                                                    $data_obat = mysqli_fetch_assoc($sql_obat);

                                                                    $harga = $data_obat['harga_jual'];

                                                                    $jumlah = $qty_obat_1 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($obat_2 != ""){
                                                                    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_2'");
                                                                    $data_obat = mysqli_fetch_assoc($sql_obat);

                                                                    $harga = $data_obat['harga_jual'];

                                                                    $jumlah = $qty_obat_2 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($obat_3 != ""){
                                                                    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_3'");
                                                                    $data_obat = mysqli_fetch_assoc($sql_obat);

                                                                    $harga = $data_obat['harga_jual'];

                                                                    $jumlah = $qty_obat_3 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }
                                                                    if($obat_4 != ""){
                                                                    $sql_obat = mysqli_query($koneksi, "SELECT harga_jual FROM obat WHERE nama_obat = '$obat_4'");
                                                                    $data_obat = mysqli_fetch_assoc($sql_obat);

                                                                    $harga = $data_obat['harga_jual'];

                                                                    $jumlah = $qty_obat_4 * $harga;
                                                                    $total_pembayaran = $total_pembayaran + $jumlah;
                                                                    }

                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>Metode Pembayaran</label>

                                                                        <select name="jenis_pembayaran" class="form-control form-control-sm">
                                                                            <option>Cash</option>
                                                                            <option>Debit</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Total Tagihan</label>
                                                                        <input class="form-control form-control-sm" type="text"  value="<?= formatuang($total_pembayaran); ?>" required="" disabled>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Total Bayar</label>
                                                                        <input class="form-control form-control-sm" name="total_bayar" type="text"   required="" >
                                                                    </div>
                                                                    
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <h6> Konfirmasi Pembayaran <?= $nama_pasien; ?> </h6>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"> Bayar </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <?php
                                                
                                            } ?>
                                             




                                            
                                            <button style=" font-size: clamp(7px, 1vw, 10px); color:black; "href="#" type="submit" class=" btn bg-warning " data-toggle="modal" data-target="#edit_antrian1<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Edit Antrian'>
                                                <i class="fas fa-edit"></i></button>
                                            <!-- Form EDIT DATA -->

                                            <div class="modal fade bd-example-modal-lg" id="edit_antrian1<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"> Form Edit Antrian </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>

                                                        <!-- Form Edit Data -->
                                                        <div class="modal-body" align="left">
                                                            <form action="../proses/EAntrian" enctype="multipart/form-data" method="POST">

                                                                <input type="hidden" name="no_antrian" value="<?php echo $no_antrian; ?>">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Nama Pasien</label>
                                                                        <input class="form-control form-control-sm" type="text"  value="<?= $nama_pasien; ?>" required="" disabled>
                                                                        <input type="hidden" name="id_pasien" value="<?= $id_pasien; ?>">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Ruangan</label>

                                                                        <select name="nama_ruangan" class="form-control form-control-sm">
                                                                            <?php $dataSelect = $data['nama_ruangan']; ?>
                                                                            <option <?php echo ($dataSelect == 'Ruangan 1') ? "selected" : "" ?>>Ruangan 1</option>
                                                                            <option <?php echo ($dataSelect == 'Ruangan 2') ? "selected" : "" ?>>Ruangan 2</option>
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
                                                                            while ($data2 = mysqli_fetch_array($result)) {
                                                                                $nama_karyawan = $data2['nama_karyawan'];
                                                                                $dataSelect = $data['nama_karyawan'];

                                                                                    echo "<option" ?> <?php echo ($dataSelect == $nama_karyawan) ? "selected" : "" ?>> <?php echo $nama_karyawan; ?> <?php echo "</option>";
                                                                                 }
                                                                                                                                                                                                
                                                                                                                                                                                                        ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label>Keluhan Awal</label>
                                                                        <textarea class="form-control form-control-sm" name="keluhan_awal"><?= $keluhan_awal; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <br>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"> EDIT </button>
                                                                    <button type="reset" class="btn btn-danger"> RESET</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Button Hapus -->
                                            <button style=" font-size: clamp(7px, 1vw, 10px);color:black;" href="#" type="submit" class=" btn btn-danger" data-toggle="modal" data-target="#hapus_antrian1<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Hapus Antrian'>
                                                <i class="fa-solid fa-trash"></i></button>
                                            <div class="modal fade" id="hapus_antrian1<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Hapus Antrian </b> </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="../proses/HAntrian" method="POST">
                                                                <input type="hidden" name="no_antrian" value="<?php echo $no_antrian; ?>">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                <div class="form-group">
                                                                    <h6> Yakin Ingin Hapus Antrian <?= $nama_pasien; ?> </h6>
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
                        </div>

                        </diav>
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