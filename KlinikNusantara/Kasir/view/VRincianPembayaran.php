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



$tanggal_awal = htmlspecialchars($_GET['tanggal1']);
$tanggal_akhir = htmlspecialchars($_GET['tanggal2']);
$no_antrian = htmlspecialchars($_GET['no_antrian']);


$sql_pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran e INNER JOIN perawatan f ON f.no_perawatan=e.no_perawatan INNER JOIN antrian a ON a.no_antrian=f.no_antrian INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
WHERE a.no_antrian = '$no_antrian'");


$data_pembayaran = mysqli_fetch_assoc($sql_pembayaran);

$no_perawatan = $data_pembayaran['no_perawatan'];
$tanggal = $data_pembayaran['tanggal'];
$nama_pasien = $data_pembayaran['nama_pasien'];
$alamat = $data_pembayaran['alamat'];
$no_hp = $data_pembayaran['no_hp'];
$nik = $data_pembayaran['nik'];
$jenis_pembayaran = $data_pembayaran['jenis_pembayaran'];
$jumlah_tagihan = $data_pembayaran['jumlah_tagihan'];
$jumlah_bayar = $data_pembayaran['jumlah_bayar'];
$kembalian = $jumlah_bayar - $jumlah_tagihan ;

$tindakan_1 = $data_pembayaran['tindakan_1'];
$tindakan_2 = $data_pembayaran['tindakan_2'];
$tindakan_3 = $data_pembayaran['tindakan_3'];
$tindakan_4 = $data_pembayaran['tindakan_4'];

$alkes_1 = $data_pembayaran['alkes_1'];
$qty_alkes_1 = $data_pembayaran['qty_alkes_1'];
$alkes_2 = $data_pembayaran['alkes_2'];
$qty_alkes_2 = $data_pembayaran['qty_alkes_2'];
$alkes_3 = $data_pembayaran['alkes_3'];
$qty_alkes_3 = $data_pembayaran['qty_alkes_3'];
$alkes_4 = $data_pembayaran['alkes_4'];
$qty_alkes_4 = $data_pembayaran['qty_alkes_4'];

$obat_1 = $data_pembayaran['obat_1'];
$qty_obat_1 = $data_pembayaran['qty_obat_1'];
$obat_2 = $data_pembayaran['obat_2'];
$qty_obat_2 = $data_pembayaran['qty_obat_2'];
$obat_3 = $data_pembayaran['obat_3'];
$qty_obat_3 = $data_pembayaran['qty_obat_3'];
$obat_4 = $data_pembayaran['obat_4'];
$qty_obat_4 = $data_pembayaran['qty_obat_4'];

$no_urut = 1;
function formatuang($angka)
{
    $uang = "Rp " . number_format($angka, 2, ',', '.');
    return $uang;
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

    <title>Rincian Pembayaran</title>

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

                    <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px; font-size: clamp(2px, 3vw, 22px);'>Rincian Pembayaran</h5></a>"; ?>




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
                <div align="left">
                <?php echo "<a href='VPembayaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
                </div>
                    <br>

                    <!-- Tabel -->
         
                      
<table rules="rows"  align="center" style="width:30%">
<tr>
    <td ><img style=" max-height: 50px; width: 100%;" src="../gambar/Logo Struk.jpeg"></td>
    <td align="center" style="font-size: 14px;">Klinik Nusantara <br>Jl. Mayor Salim Batubara</td>
</tr>

</table>

<hr>
<table   align="center" style="width:100%">
<tr >
    <th colspan="3" style="font-size: 14px;">Rincian Pembayaran</th>
</tr>
<tr>
    <td align="left" style="font-size: 12px; width:20%; ">Tanggal</td>
    <td align="center" style="font-size: 12px; width:1%;"> : </td>
    <td align="left" style="font-size: 12px; width:79%;"><?= $tanggal ?></td>
</tr>
<tr>
    <td align="left" style="font-size: 12px; width:20%; ">Nama</td>
    <td align="center" style="font-size: 12px; width:1%;"> : </td>
    <td align="left" style="font-size: 12px; width:79%;"><?= $nama_pasien ?></td>
</tr>
<tr>
    <td align="left" style="font-size: 12px; width:20%; ">Alamat</td>
    <td align="center" style="font-size: 12px; width:1%;"> : </td>
    <td align="left" style="font-size: 12px; width:79%;"><?= $alamat ?></td>
</tr>
<tr>
    <td align="left" style="font-size: 12px; width:20%; ">Telepon</td>
    <td align="center" style="font-size: 12px; width:1%;"> : </td>
    <td align="left" style="font-size: 12px; width:79%;"><?= $no_hp ?></td>
</tr>
<tr>
    <td align="left" style="font-size: 12px; width:20%; ">NIK</td>
    <td align="center" style="font-size: 12px; width:1%;"> : </td>
    <td align="left" style="font-size: 12px; width:79%;"><?= $nik ?></td>
</tr>
<tr>
    <td align="left" style="font-size: 12px; width:20%; ">Pembayaran</td>
    <td align="center" style="font-size: 12px; width:1%;"> : </td>
    <td align="left" style="font-size: 12px; width:79%;"><?= $jenis_pembayaran ?></td>
</tr>

</table>
<hr>

<?php
    //list tindakan
    //tindakan 1
    if($tindakan_1 != ""){
        $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_1'");
        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

        $harga_tindakan = $data_tindakan['harga_tindakan']; ?>
        <table align="center" style="width:100%">
        <tr>
            <th align="left" style="font-size: 12px; width:5%; ">No</th>
            <th align="left" style="font-size: 12px; width:36%;">Nama</th>
            <th align="left" style="font-size: 12px; width:10%;">Qty</th>
            <th align="left" style="font-size: 12px; width:22%;">Harga</th>
            <th align="left" style="font-size: 12px; width:5%;"></th>
            <th align="left" style="font-size: 12px; width:22%;">Total</th>
        </tr>
        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?= $tindakan_1 ?></td>
            <td align="left" style="font-size: 12px; width:10%;">  1 x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($harga_tindakan) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?= formatuang($harga_tindakan) ?></td>
        </tr>
        
        </table> <?php 
        $no_urut = $no_urut + 1;
    }
    //tindakan 2
    if($tindakan_2 != ""){
        $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_2'");
        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

        $harga_tindakan = $data_tindakan['harga_tindakan']; ?>
        <table  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?= $tindakan_2 ?></td>
            <td align="left" style="font-size: 12px; width:10%;">  1 x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($harga_tindakan) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?= formatuang($harga_tindakan) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }
    //tindakan 3
    if($tindakan_3 != ""){
        $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_3'");
        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

        $harga_tindakan = $data_tindakan['harga_tindakan']; ?>
        <table  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?= $tindakan_3 ?></td>
            <td align="left" style="font-size: 12px; width:10%;">  1 x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($harga_tindakan) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?= formatuang($harga_tindakan) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }
    //tindakan 4
    if($tindakan_4 != ""){
        $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_4'");
        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

        $harga_tindakan = $data_tindakan['harga_tindakan']?>
        <table align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?= $tindakan_4 ?></td>
            <td align="left" style="font-size: 12px; width:10%;">  1 x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($harga_tindakan) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?= formatuang($harga_tindakan) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }


    //list alkes
    //alkes 1
    if($alkes_1 != ""){
        $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_1'");
        $data_alkes = mysqli_fetch_assoc($sql_alkes);
        $kode_alkes = $data_alkes['kode_alkes'];

        $sql_alkes_per = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan WHERE no_perawatan = '$no_perawatan' AND kode_alkes = '$kode_alkes' ");
        $data_alkes_per = mysqli_fetch_assoc($sql_alkes_per);
        $jumlah = $data_alkes_per['jumlah'];
        $harga_alkes = $jumlah / $qty_alkes_1; ?>
       <table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?= $alkes_1 ?></td>
            <td align="left" style="font-size: 12px; width:10%;"><?= $qty_alkes_1 ?> x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($harga_alkes) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?= formatuang($jumlah) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }

    //alkes 2
    if($alkes_2 != ""){
        $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_2'");
        $data_alkes = mysqli_fetch_assoc($sql_alkes);
        $kode_alkes = $data_alkes['kode_alkes'];

        $sql_alkes_per = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan WHERE no_perawatan = '$no_perawatan' AND kode_alkes = '$kode_alkes' ");
        $data_alkes_per = mysqli_fetch_assoc($sql_alkes_per);
        $jumlah = $data_alkes_per['jumlah'];
        $harga_alkes = $jumlah / $qty_alkes_2; ?>
        <table rules="rows"  align="center" style="width:100%">

        <tr >
        <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?= $alkes_2 ?></td>
            <td align="left" style="font-size: 12px; width:10%;"><?= $qty_alkes_2 ?> x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($harga_alkes) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?= formatuang($jumlah) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }

    //alkes 3
    if($alkes_3 != ""){
        $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_3'");
        $data_alkes = mysqli_fetch_assoc($sql_alkes);
        $kode_alkes = $data_alkes['kode_alkes'];

        $sql_alkes_per = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan WHERE no_perawatan = '$no_perawatan' AND kode_alkes = '$kode_alkes' ");
        $data_alkes_per = mysqli_fetch_assoc($sql_alkes_per);
        $jumlah = $data_alkes_per['jumlah'];
        $harga_alkes = $jumlah / $qty_alkes_3; ?>
        <table   align="center" style="width:100%">

        <tr>
        <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?= $alkes_3 ?></td>
            <td align="left" style="font-size: 12px; width:10%;"><?= $qty_alkes_3 ?> x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($harga_alkes) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?= formatuang($jumlah) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }

    //alkes 4
    if($alkes_4 != ""){
        $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_4'");
        $data_alkes = mysqli_fetch_assoc($sql_alkes);
        $kode_alkes = $data_alkes['kode_alkes'];

        $sql_alkes_per = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan WHERE no_perawatan = '$no_perawatan' AND kode_alkes = '$kode_alkes' ");
        $data_alkes_per = mysqli_fetch_assoc($sql_alkes_per);
        $jumlah = $data_alkes_per['jumlah'];
        $harga_alkes = $jumlah / $qty_alkes_4; ?>
        <table   align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?= $alkes_4 ?></td>
            <td align="left" style="font-size: 12px; width:10%;"><?= $qty_alkes_4 ?> x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($harga_alkes) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?= formatuang($jumlah) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }


    //list alkes
    //obat 1
    if($obat_1 != ""){
        $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_1'");
        $data_obat = mysqli_fetch_assoc($sql_obat);
        $kode_obat = $data_obat['kode_obat'];

        $sql_obat_per = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan WHERE no_perawatan = '$no_perawatan' AND kode_obat = '$kode_obat' ");
        $data_obat_per = mysqli_fetch_assoc($sql_obat_per);
        $jumlah = $data_obat_per['jumlah'];
        $harga_obat = $jumlah / $qty_obat_1; ?>
        <table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?=  $obat_1 ?></td>
            <td align="left" style="font-size: 12px; width:10%;"><?=  $qty_obat_1 ?> x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=   formatuang($harga_obat) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($jumlah) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }
    //obat 2
    if($obat_2 != ""){
        $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_2'");
        $data_obat = mysqli_fetch_assoc($sql_obat);
        $kode_obat = $data_obat['kode_obat'];

        $sql_obat_per = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan WHERE no_perawatan = '$no_perawatan' AND kode_obat = '$kode_obat' ");
        $data_obat_per = mysqli_fetch_assoc($sql_obat_per);
        $jumlah = $data_obat_per['jumlah'];
        $harga_obat = $jumlah / $qty_obat_2; ?>
        <table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?=  $obat_2 ?></td>
            <td align="left" style="font-size: 12px; width:10%;"><?=  $qty_obat_2?> x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=   formatuang($harga_obat) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($jumlah) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }

    //obat 3
    if($obat_3 != ""){
        $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_3'");
        $data_obat = mysqli_fetch_assoc($sql_obat);
        $kode_obat = $data_obat['kode_obat'];

        $sql_obat_per = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan WHERE no_perawatan = '$no_perawatan' AND kode_obat = '$kode_obat' ");
        $data_obat_per = mysqli_fetch_assoc($sql_obat_per);
        $jumlah = $data_obat_per['jumlah'];
        $harga_obat = $jumlah / $qty_obat_3; ?>
       <table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?=  $obat_3 ?></td>
            <td align="left" style="font-size: 12px; width:10%;"><?=  $qty_obat_3 ?> x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=   formatuang($harga_obat) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($jumlah) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    }

    //obat 4
    if($obat_4 != ""){
        $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_4'");
        $data_obat = mysqli_fetch_assoc($sql_obat);
        $kode_obat = $data_obat['kode_obat'];

        $sql_obat_per = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan WHERE no_perawatan = '$no_perawatan' AND kode_obat = '$kode_obat' ");
        $data_obat_per = mysqli_fetch_assoc($sql_obat_per);
        $jumlah = $data_obat_per['jumlah'];
        $harga_obat = $jumlah / $qty_obat_4; ?>
        <table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 12px; width:5%; "><?= $no_urut ?></td>
            <td align="left" style="font-size: 12px; width:36%;"><?=  $obat_4 ?></td>
            <td align="left" style="font-size: 12px; width:10%;"><?=  $qty_obat_4 ?> x </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=   formatuang($harga_obat) ?></td>
            <td align="left" style="font-size: 12px; width:5%;"> = </td>
            <td align="left" style="font-size: 12px; width:22%;"><?=  formatuang($jumlah) ?></td>
        </tr>
        
        </table> <?php
        $no_urut = $no_urut + 1;
    } ?>

    <hr>
    <table   align="center" style="width:100%">

    <tr>
        <td align="center" style="font-size: 12px; width:45%; ">Total Tagihan</td>
        <td align="center" style="font-size: 12px; width:10%;"> = </td>
        <td align="center" style="font-size: 12px; width:45%;"><?=  formatuang($jumlah_tagihan) ?></td>
    </tr>
    <tr>
        <td align="center" style="font-size: 12px; width:45%; ">Total Bayar</td>
        <td align="center" style="font-size: 12px; width:10%;"> = </td>
        <td align="center" style="font-size: 12px; width:45%;"><?=  formatuang($jumlah_bayar) ?></td>
    </tr>
    <tr>
        <td align="center" style="font-size: 12px; width:45%; ">Kembalian</td>
        <td align="center" style="font-size: 12px; width:10%;"> = </td>
        <td align="center" style="font-size: 12px; width:45%;"><?= formatuang($kembalian) ?></td>
    </tr>
    
    </table> 
    <hr>

                    </div>


                    <br>
               
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