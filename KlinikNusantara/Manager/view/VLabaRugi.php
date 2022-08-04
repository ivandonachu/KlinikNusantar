<?php

use Mpdf\Tag\Tr;

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
if ($jabatan_valid == 'Manager') {
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

                                function formatuang($angka)
                                {
                                    $uang = "Rp " . number_format($angka, 2, ',', '.');
                                    return $uang;
                                }

if ($tanggal_awal == $tanggal_akhir) {


    //alat kesehatan
    //sql total seluruh pendapatan alkes
    $sql_alkes_seluruh = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_alkes_total FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                            INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                            INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                            WHERE a.tanggal = '$tanggal_awal' ");
    $data_alkes_seluruh = mysqli_fetch_assoc($sql_alkes_seluruh);
    $pendapatan_alkes_total = $data_alkes_seluruh['pendapatan_alkes_total'];

    //obat
    //sql total seluruh pendapatan obat
    $sql_obat_seluruh = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_obat_total FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                            INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                            INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                            WHERE a.tanggal = '$tanggal_awal' ");
    $data_obat_seluruh = mysqli_fetch_assoc($sql_obat_seluruh);
    $pendapatan_obat_total = $data_obat_seluruh['pendapatan_obat_total'];
    
    //tindakan 
    //sql total pendapatan tindakan 
    $sql_tindakan_seluruh = mysqli_query($koneksi, "SELECT  SUM(jumlah) AS pendapatan_tindakan_seluruh  FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                WHERE a.tanggal = '$tanggal_awal' ");
    $data_tindakan_seluruh = mysqli_fetch_assoc($sql_tindakan_seluruh);
    $pendapatan_tindakan_seluruh = $data_tindakan_seluruh['pendapatan_tindakan_seluruh'];

    //pembelian pokok
    //pembelian alat kesehatan
    $sql_pembelian_alkes = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pembelian_alkes FROM riwayat_alkes WHERE tanggal = '$tanggal_awal' ");

    $data_pembelian_alkes = mysqli_fetch_assoc($sql_pembelian_alkes);
    $pembelian_alkes = $data_pembelian_alkes['pembelian_alkes'];

    //pembelian obat
    $sql_pembelian_obat = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pembelian_obat FROM riwayat_obat WHERE tanggal = '$tanggal_awal' ");

    $data_pembelian_obat = mysqli_fetch_assoc($sql_pembelian_obat);
    $pembelian_obat = $data_pembelian_obat['pembelian_obat'];

    //pengeluaran
    //pengeluaran gaji karyawan
    $sql_pengeluaran_gaji = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pengeluaran_gaji FROM pengeluaran WHERE tanggal = '$tanggal_awal' AND akun = 'Gaji Karyawan' ");

    $data_pengeluaran_gaji = mysqli_fetch_assoc($sql_pengeluaran_gaji);
    $pengeluaran_gaji = $data_pengeluaran_gaji['pengeluaran_gaji'];

    //pengeluaran Biaya Kantor
    $sql_pengeluaran_biaya_kantor = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pengeluaran_biaya_kantor FROM pengeluaran WHERE tanggal = '$tanggal_awal' AND akun = 'Biaya Kantor' ");

    $data_pengeluaran_biaya_kantor = mysqli_fetch_assoc($sql_pengeluaran_biaya_kantor);
    $pengeluaran_biaya_kantor = $data_pengeluaran_biaya_kantor['pengeluaran_biaya_kantor'];

    //pengeluaran Listrik & Telepon
    $sql_pengeluaran_listrik = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pengeluaran_listrik FROM pengeluaran WHERE tanggal = '$tanggal_awal' AND akun = 'Listrik & Telepon' ");

    $data_pengeluaran_listrik = mysqli_fetch_assoc($sql_pengeluaran_listrik);
    $pengeluaran_listrik = $data_pengeluaran_listrik['pengeluaran_listrik'];

    //pengeluaran Alat Tulis Kantor
    $sql_pengeluaran_atk = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pengeluaran_atk FROM pengeluaran WHERE tanggal = '$tanggal_awal' AND akun = 'Alat Tulis Kantor' ");

    $data_pengeluaran_atk = mysqli_fetch_assoc($sql_pengeluaran_atk);
    $pengeluaran_atk = $data_pengeluaran_atk['pengeluaran_atk'];


    $total_pendapatan = $pendapatan_alkes_total + $pendapatan_obat_total + $pendapatan_tindakan_seluruh;
    $total_harga_pokok = $pembelian_alkes + $pembelian_obat;
    $laba_kotor = $total_pendapatan - $total_harga_pokok;
    $total_pengeluaran = $pengeluaran_gaji + $pengeluaran_biaya_kantor + $pengeluaran_listrik + $pengeluaran_atk;
    $laba_bersih_sebelum_pajak = $laba_kotor - $total_pengeluaran;
   


} else {

    //alat kesehatan
    //sql total seluruh pendapatan alkes
    $sql_alkes_seluruh = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_alkes_total FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                                                INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_alkes_seluruh = mysqli_fetch_assoc($sql_alkes_seluruh);
    $pendapatan_alkes_total = $data_alkes_seluruh['pendapatan_alkes_total'];

    //obat
    //sql total seluruh pendapatan obat
    $sql_obat_seluruh = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_obat_total FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                            INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                            INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                            WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_obat_seluruh = mysqli_fetch_assoc($sql_obat_seluruh);
    $pendapatan_obat_total = $data_obat_seluruh['pendapatan_obat_total'];

    //tindakan 
    //sql tindakan total
    $sql_tindakan_seluruh = mysqli_query($koneksi, "SELECT  SUM(jumlah) AS pendapatan_tindakan_seluruh  FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                        INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                        INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                        INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                        WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_tindakan_seluruh = mysqli_fetch_assoc($sql_tindakan_seluruh);
    $pendapatan_tindakan_seluruh = $data_tindakan_seluruh['pendapatan_tindakan_seluruh'];

    //pembelian pokok
    //pembelian alat kesehatan
    $sql_pembelian_alkes = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pembelian_alkes FROM riwayat_alkes WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $data_pembelian_alkes = mysqli_fetch_assoc($sql_pembelian_alkes);
    $pembelian_alkes = $data_pembelian_alkes['pembelian_alkes'];

    //pembelian obat
    $sql_pembelian_obat = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pembelian_obat FROM riwayat_obat WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $data_pembelian_obat = mysqli_fetch_assoc($sql_pembelian_obat);
    $pembelian_obat = $data_pembelian_obat['pembelian_obat'];

    //pengeluaran
    //pengeluaran gaji karyawan
    $sql_pengeluaran_gaji = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pengeluaran_gaji FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun = 'Gaji Karyawan' ");

    $data_pengeluaran_gaji = mysqli_fetch_assoc($sql_pengeluaran_gaji);
    $pengeluaran_gaji = $data_pengeluaran_gaji['pengeluaran_gaji'];

    //pengeluaran Biaya Kantor
    $sql_pengeluaran_biaya_kantor = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pengeluaran_biaya_kantor FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun = 'Biaya Kantor' ");

    $data_pengeluaran_biaya_kantor = mysqli_fetch_assoc($sql_pengeluaran_biaya_kantor);
    $pengeluaran_biaya_kantor = $data_pengeluaran_biaya_kantor['pengeluaran_biaya_kantor'];

    //pengeluaran Listrik & Telepon
    $sql_pengeluaran_listrik = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pengeluaran_listrik FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun = 'Listrik & Telepon' ");

    $data_pengeluaran_listrik = mysqli_fetch_assoc($sql_pengeluaran_listrik);
    $pengeluaran_listrik = $data_pengeluaran_listrik['pengeluaran_listrik'];

    //pengeluaran Alat Tulis Kantor
    $sql_pengeluaran_atk = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pengeluaran_atk FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akun = 'Alat Tulis Kantor' ");

    $data_pengeluaran_atk = mysqli_fetch_assoc($sql_pengeluaran_atk);
    $pengeluaran_atk = $data_pengeluaran_atk['pengeluaran_atk'];

    $total_pendapatan = $pendapatan_alkes_total + $pendapatan_obat_total + $pendapatan_tindakan_seluruh;
    $total_harga_pokok = $pembelian_alkes + $pembelian_obat;
    $laba_kotor = $total_pendapatan - $total_harga_pokok;
    $total_pengeluaran = $pengeluaran_gaji + $pengeluaran_biaya_kantor + $pengeluaran_listrik + $pengeluaran_atk;
    $laba_bersih_sebelum_pajak = $laba_kotor - $total_pengeluaran;
   
}
$no_urut1 = 0;
$no_urut2 = 0;
$no_urut3 = 0;






?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Laba Rugi</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsManager">
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
    <a class="nav-link" href="DsManager">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: clamp(5px, 3vw, 15px);"></i>
        <span style="font-size: clamp(5px, 3vw, 15px);">Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading" style="font-size: clamp(5px, 1vw, 22px); color:white;">
    Menu Manager
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa-solid fa-cash-register" style="font-size: clamp(5px, 3vw, 15px); color:white;"></i>
        <span style="font-size: clamp(5px, 3vw, 15px); color:white;">Manager</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="VLabaRugi">Laba Rugi</a>
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

                    <?php echo "<a href='VLabaRugi'><h5 class='text-center sm' style='color:white; margin-top: 8px; font-size: clamp(2px, 3vw, 22px);'>Laporan Laba Rugi</h5></a>"; ?>




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
                <div class="container" style="color : black;">
     <?php  echo "<form  method='POST' action='VLabaRugi' style='margin-bottom: 15px;'>" ?>
    <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
      </div>
    </div>
  </form>

 <br>
 <br>
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
     <br>
     <br>
     <br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" align="Center"><strong>Laporan Laba Rugi</strong></h3>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed"  style="color : black;">
                            <thead>
                                <tr>
                                    <td><strong>Akun</strong></td>
                                    <td class="text-left"><strong>Nama Akun</strong></td>
                                    <td class="text-left"><strong>Debit</strong></td>
                                    <td class="text-left"><strong>Kredit</strong></td>
                                    <td class="text-right"><strong>Aksi</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                <tr>
                                    <td><strong>4-000</strong></td>
                                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-100</td>
                                    <td class="text-left">Layanan Tindakan</td>
                                    <td class="text-left"><?= formatuang($pendapatan_tindakan_seluruh); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRLayananTindakan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-110</td>
                                    <td class="text-left">Penjualan Alat Kesehatan</td>
                                    <td class="text-left"><?= formatuang($pendapatan_alkes_total); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRPenjualanAlkes?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-120</td>
                                    <td class="text-left">Penjualan Obat</td>
                                    <td class="text-left"><?= formatuang($pendapatan_obat_total); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRPenjualanObat?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                              
                                <tr style="background-color:     #F0F8FF; ">
                                    <td><strong>Total Pendapatan</strong></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"><?= formatuang($total_pendapatan); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td><strong>5-000</strong></td>
                                    <td class="text-left"><strong>HARGA POKOK PENJUALAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-100</td>
                                    <td class="text-left">Pembelian Alat Kesehatan</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($pembelian_alkes); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRPembelianAlkes?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-110</td>
                                    <td class="text-left">Pembelian Obat</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($pembelian_obat); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRPembelianObat?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr style="background-color:    #F0F8FF;  ">
                                    <td><strong>Total Harga Pokok Penjualan</strong></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_harga_pokok); ?></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr style="background-color: navy;  color:white;">
                                    <td><strong>LABA KOTOR</strong></td>
                                    <td class="thick-line"></td>
                                    <?php
                                   
                                    if ($laba_kotor > 0) { ?>
                                    
                                    <td class="no-line text-left"><?= formatuang($laba_kotor); ?> </td>
                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                    <?php }
                                    else if ($laba_kotor < 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang($laba_kotor); ?></td>
                                    <?php }
                                    else if ($laba_kotor == 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <?php }
                                    ?>


                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td><strong>5-500</strong></td>
                                    <td class="text-left"><strong>BIAYA USAHA</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-510</td>
                                    <td class="text-left">Gaji Karyawan</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($pengeluaran_gaji); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRGajiKaryawan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-520</td>
                                    <td class="text-left">Biaya Kantor</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($pengeluaran_biaya_kantor); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRBiayaKantor?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-530</td>
                                    <td class="text-left">Alat Tulis Kantor</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($pengeluaran_atk); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRATK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-540</td>
                                    <td class="text-left">Listrik & Telepon</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($pengeluaran_listrik); ?></td>
                                    <?php echo "<td class='text-right'><a href='RincianLR/VRListrik?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr style="background-color:    #F0F8FF; ">
                                    <td><strong>Total Biaya Usaha</strong></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pengeluaran); ?></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr style="background-color: navy;  color:white;">
                                    <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                                    <td class="thick-line"></td>
                                    <?php
                                   
                                    if ($laba_bersih_sebelum_pajak > 0) { ?>
                                    
                                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?> </td>
                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                    <?php }
                                    else if ($laba_bersih_sebelum_pajak < 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?></td>

                                    <?php }
                                    else if ($laba_bersih_sebelum_pajak == 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <?php }
                                    ?>
                                    <td class="thick-line"></td>
                                    
                                </tr>
                                
                            </tbody>
                        </table>
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
                buttons: ['excel']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                lengthChange: false,

            });

            table.buttons().container()
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
</body>

</html>