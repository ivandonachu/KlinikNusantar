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



if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM pembayaran e INNER JOIN perawatan f ON f.no_perawatan=e.no_perawatan INNER JOIN antrian a ON a.no_antrian=f.no_antrian INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
    WHERE tanggal = '$tanggal_awal'");

    $table2 = mysqli_query($koneksi, "SELECT harga_jual, nama_alkes, SUM(jumlah) AS pendapatan_alkes , SUM(qty) AS total_terjual_alkes FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                            INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                            INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                                                            WHERE a.tanggal = '$tanggal_awal' GROUP BY d.nama_alkes ");

    $table3 = mysqli_query($koneksi, "SELECT harga_jual, nama_obat, SUM(jumlah) AS pendapatan_obat , SUM(qty) AS total_terjual_obat FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                            INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                            INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                                                            WHERE a.tanggal = '$tanggal_awal' GROUP BY d.nama_obat ");
                                                                                                                            
    $table4 = mysqli_query($koneksi, "SELECT harga_tindakan, nama_tindakan, SUM(jumlah) AS pendapatan_tindakan , COUNT(nama_tindakan) AS total_tindakan FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                            INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                            INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                             WHERE a.tanggal = '$tanggal_awal' GROUP BY d.nama_tindakan ");
    //alat kesehatan
    //sql total seluruh pendapatan alkes
    $sql_alkes_seluruh = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_alkes_total FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                            INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                            INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                            WHERE a.tanggal = '$tanggal_awal' ");
    $data_alkes_seluruh = mysqli_fetch_assoc($sql_alkes_seluruh);
    $pendapatan_alkes_total = $data_alkes_seluruh['pendapatan_alkes_total'];

    //sql total seluruh pendapatan alkes cash
    $sql_alkes_cash = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_alkes_cash FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                            INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                            INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                            WHERE a.tanggal = '$tanggal_awal' AND e.jenis_pembayaran = 'Cash' ");
    $data_alkes_cash = mysqli_fetch_assoc($sql_alkes_cash);
    $pendapatan_alkes_cash = $data_alkes_cash['pendapatan_alkes_cash'];

    //sql total seluruh pendapatan alkes debit
    $sql_alkes_debit = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_alkes_debit FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                            INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                            INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                            WHERE a.tanggal = '$tanggal_awal' AND e.jenis_pembayaran = 'Debit' ");
    $data_alkes_debit = mysqli_fetch_assoc($sql_alkes_debit);
    $pendapatan_alkes_debit = $data_alkes_debit['pendapatan_alkes_debit'];

    //obat
    //sql total seluruh pendapatan obat
    $sql_obat_seluruh = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_obat_total FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                            INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                            INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                            WHERE a.tanggal = '$tanggal_awal' ");
    $data_obat_seluruh = mysqli_fetch_assoc($sql_obat_seluruh);
    $pendapatan_obat_total = $data_obat_seluruh['pendapatan_obat_total'];

    //sql total seluruh pendapatan alkes cash
    $sql_obat_cash = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_obat_cash FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                            INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                            INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                            WHERE a.tanggal = '$tanggal_awal' AND e.jenis_pembayaran = 'Cash' ");
    $data_obat_cash = mysqli_fetch_assoc($sql_obat_cash);
    $pendapatan_obat_cash = $data_obat_cash['pendapatan_obat_cash'];

    //sql total seluruh pendapatan alkes debit
    $sql_obat_debit = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_obat_debit FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                            INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                            INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                            WHERE a.tanggal = '$tanggal_awal' AND e.jenis_pembayaran = 'Debit' ");
    $data_obat_debit = mysqli_fetch_assoc($sql_obat_debit);
    $pendapatan_obat_debit = $data_obat_debit['pendapatan_obat_debit'];
    
    //tindakan 
    //sql tindakan total
    $sql_tindakan_seluruh = mysqli_query($koneksi, "SELECT  SUM(jumlah) AS pendapatan_tindakan_seluruh  FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                WHERE a.tanggal = '$tanggal_awal' ");
    $data_tindakan_seluruh = mysqli_fetch_assoc($sql_tindakan_seluruh);
    $pendapatan_tindakan_seluruh = $data_tindakan_seluruh['pendapatan_tindakan_seluruh'];

    //sql tindakan cash
    $sql_tindakan_cash = mysqli_query($koneksi, "SELECT  SUM(jumlah) AS pendapatan_tindakan_cash  FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                WHERE a.tanggal = '$tanggal_awal' AND e.jenis_pembayaran = 'Cash' ");
    $data_tindakan_cash = mysqli_fetch_assoc($sql_tindakan_cash);
    $pendapatan_tindakan_cash = $data_tindakan_cash['pendapatan_tindakan_cash'];

    //sql tindakan debit
    $sql_tindakan_debit = mysqli_query($koneksi, "SELECT  SUM(jumlah) AS pendapatan_tindakan_debit  FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                WHERE a.tanggal = '$tanggal_awal' AND e.jenis_pembayaran = 'Debit' ");
    $data_tindakan_debit = mysqli_fetch_assoc($sql_tindakan_debit);
    $pendapatan_tindakan_debit = $data_tindakan_debit['pendapatan_tindakan_debit'];

    $total_pendapatan_cash = $pendapatan_alkes_cash + $pendapatan_obat_cash + $pendapatan_tindakan_cash;
    $total_pendapatan_debit = $pendapatan_alkes_debit + $pendapatan_obat_debit + $pendapatan_tindakan_debit;
    $total_pendapatan = $total_pendapatan_cash + $total_pendapatan_debit;

} else {
    $table = mysqli_query($koneksi, "SELECT * FROM pembayaran e INNER JOIN perawatan f ON f.no_perawatan=e.no_perawatan INNER JOIN antrian a ON a.no_antrian=f.no_antrian INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
    WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $table2 = mysqli_query($koneksi, "SELECT harga_jual, nama_alkes, SUM(jumlah) AS pendapatan_alkes , SUM(qty) AS total_terjual_alkes FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                                                        INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                                                        INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                                                                                        WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY d.nama_alkes ");

    $table3 = mysqli_query($koneksi, "SELECT harga_jual, nama_obat, SUM(jumlah) AS pendapatan_obat , SUM(qty) AS total_terjual_obat FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                                                    INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                                                    INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                                                                                    WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY d.nama_obat ");

    $table4 = mysqli_query($koneksi, "SELECT harga_tindakan, nama_tindakan, SUM(jumlah) AS pendapatan_tindakan , COUNT(nama_tindakan) AS total_tindakan FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                                                                        INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                                                                        INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                                                                        WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY d.nama_tindakan ");

    //alat kesehatan
    //sql total seluruh pendapatan alkes
    $sql_alkes_seluruh = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_alkes_total FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                                                INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_alkes_seluruh = mysqli_fetch_assoc($sql_alkes_seluruh);
    $pendapatan_alkes_total = $data_alkes_seluruh['pendapatan_alkes_total'];

    //sql total seluruh pendapatan alkes cash
    $sql_alkes_cash = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_alkes_cash FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                            INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                            INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                            WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND e.jenis_pembayaran = 'Cash' ");
    $data_alkes_cash = mysqli_fetch_assoc($sql_alkes_cash);
    $pendapatan_alkes_cash = $data_alkes_cash['pendapatan_alkes_cash'];

    //sql total seluruh pendapatan alkes debit
    $sql_alkes_debit = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_alkes_debit FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                            INNER JOIN riwayat_alkes_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                            INNER JOIN alat_kesehatan d ON d.kode_alkes=c.kode_alkes
                                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                            WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND e.jenis_pembayaran = 'Debit' ");
    $data_alkes_debit = mysqli_fetch_assoc($sql_alkes_debit);
    $pendapatan_alkes_debit = $data_alkes_debit['pendapatan_alkes_debit'];

    //obat
    //sql total seluruh pendapatan obat
    $sql_obat_seluruh = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_obat_total FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                            INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                            INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                            WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_obat_seluruh = mysqli_fetch_assoc($sql_obat_seluruh);
    $pendapatan_obat_total = $data_obat_seluruh['pendapatan_obat_total'];

    //sql total seluruh pendapatan alkes cash
    $sql_obat_cash = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_obat_cash FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                        INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                        INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                                        INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                        WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND e.jenis_pembayaran = 'Cash' ");
    $data_obat_cash = mysqli_fetch_assoc($sql_obat_cash);
    $pendapatan_obat_cash = $data_obat_cash['pendapatan_obat_cash'];

    //sql total seluruh pendapatan alkes debit
    $sql_obat_debit = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pendapatan_obat_debit FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                            INNER JOIN riwayat_obat_perawatan c ON c.no_perawatan=b.no_perawatan 
                                                                                                            INNER JOIN obat d ON d.kode_obat=c.kode_obat
                                                                                                            INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                            WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND e.jenis_pembayaran = 'Debit' ");
    $data_obat_debit = mysqli_fetch_assoc($sql_obat_debit);
    $pendapatan_obat_debit = $data_obat_debit['pendapatan_obat_debit'];

    //tindakan 
    //sql tindakan total
    $sql_tindakan_seluruh = mysqli_query($koneksi, "SELECT  SUM(jumlah) AS pendapatan_tindakan_seluruh  FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                        INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                        INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                        INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                        WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_tindakan_seluruh = mysqli_fetch_assoc($sql_tindakan_seluruh);
    $pendapatan_tindakan_seluruh = $data_tindakan_seluruh['pendapatan_tindakan_seluruh'];

    //sql tindakan cash
    $sql_tindakan_cash = mysqli_query($koneksi, "SELECT  SUM(jumlah) AS pendapatan_tindakan_cash  FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                    INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                    INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                    INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                    WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND e.jenis_pembayaran = 'Cash' ");
    $data_tindakan_cash = mysqli_fetch_assoc($sql_tindakan_cash);
    $pendapatan_tindakan_cash = $data_tindakan_cash['pendapatan_tindakan_cash'];

    //sql tindakan debit
    $sql_tindakan_debit = mysqli_query($koneksi, "SELECT  SUM(jumlah) AS pendapatan_tindakan_debit  FROM antrian a INNER JOIN perawatan b ON a.no_antrian=b.no_antrian 
                                                                                                                    INNER JOIN riwayat_tindakan c ON c.no_perawatan=b.no_perawatan 
                                                                                                                    INNER JOIN tindakan d ON d.kode_tindakan=c.kode_tindakan
                                                                                                                    INNER JOIN pembayaran e ON e.no_perawatan=b.no_perawatan
                                                                                                                    WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND e.jenis_pembayaran = 'Debit' ");
    $data_tindakan_debit = mysqli_fetch_assoc($sql_tindakan_debit);
    $pendapatan_tindakan_debit = $data_tindakan_debit['pendapatan_tindakan_debit'];

    $total_pendapatan_cash = $pendapatan_alkes_cash + $pendapatan_obat_cash + $pendapatan_tindakan_cash;
    $total_pendapatan_debit = $pendapatan_alkes_debit + $pendapatan_obat_debit + $pendapatan_tindakan_debit;
    $total_pendapatan = $total_pendapatan_cash + $total_pendapatan_debit;
   
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

    <title>Riwayat Pembayaran</title>

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

                    <?php echo "<a href='VPembayaran'><h5 class='text-center sm' style='color:white; margin-top: 8px; font-size: clamp(2px, 3vw, 22px);'>Riwayat Pembayaran</h5></a>"; ?>




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
                    <?php echo "<form  method='POST' action='VPembayaran' style='margin-bottom: 15px;'>" ?>
                    <div>
                        <div align="left" style="margin-left: 20px;">
                            <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                            <span>-</span>
                            <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                            <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                        </div>
                    </div>
                    </form>

                    <br>
                    <div class="row">
                        <!-- Tampilan tanggal -->
                        <div class="col-md-6">
                            <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                        </div>
                    </div>
                    <br>

                    <!-- Tabel -->
                    <!-- Tabel -->
                    <div style="overflow-x: auto">
                        <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align='center'>
                            <thead>
                                <tr>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">No</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Tanggal</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Nama Pasien</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Nama Dokter</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Metode Pembayaran</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Total Tagihan</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Total Pembayaran</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Kembalian</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);"></th>
                                    <th></th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $urut = 0;
                                function formatuang($angka)
                                {
                                    $uang = "Rp " . number_format($angka, 2, ',', '.');
                                    return $uang;
                                }

                                ?>
                                <?php while ($data = mysqli_fetch_array($table)) {
                                    $no_pembayaran = $data['no_pembayaran'];
                                    $no_antrian = $data['no_antrian'];
                                    $tanggal = $data['tanggal'];
                                    $nama_pasien = $data['nama_pasien'];
                                    $nama_karyawan = $data['nama_karyawan'];
                                    $jenis_pembayaran = $data['jenis_pembayaran'];
                                    $jumlah_tagihan = $data['jumlah_tagihan'];
                                    $jumlah_bayar = $data['jumlah_bayar'];
                                    $kembalian = $jumlah_bayar - $jumlah_tagihan;
                                
                                    $urut = $urut + 1;


                                    echo "<tr>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$urut</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_pasien</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_karyawan</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$jenis_pembayaran</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >"; ?> <?= formatuang($jumlah_tagihan); ?> <?php echo"</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >"; ?> <?= formatuang($jumlah_bayar); ?> <?php echo"</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >"; ?> <?= formatuang($kembalian); ?> <?php echo"</td>
                                    <td";?> <a> <?php echo "<a href='VRincianPembayaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_antrian=$no_antrian'>Rincian</a></a></td>
                                    "; ?>
                                        <?php echo "<td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>


                                        <?php echo "<a href='VPrintStruk?no_antrian=$no_antrian&tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' target='_blank'><button style=' font-size: clamp(7px, 1vw, 10px);color:black;
                                             '  type='submit' class=' btn btn-secondary' >  <i class='fa-solid fa-print'></i> Print Struk</button></a>";
                                                
                                             ?>
                               
                                    
                                   <!-- Button Hapus -->
                                   <button style=" font-size: clamp(7px, 1vw, 10px); color:black; " href="#" type="submit" class=" btn bg-warning" data-toggle="modal" data-target="#formedit<?php echo $data['no_pembayaran']; ?>" data-toggle='tooltip' title='Edit Data Alkes'>
                                            <i class="fas fa-edit"></i> Edit</button>


                                        <!-- Form EDIT DATA -->

                                        <div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data['no_pembayaran']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Form Edit Riwayat Alat Kesehatan </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                            <span aria-hidden="true"> &times; </span>
                                                        </button>
                                                    </div>

                                                    <!-- Form Edit Data -->
                                                    <div class="modal-body" align="left">
                                                        <form action="../proses/EPembayaran" enctype="multipart/form-data" method="POST">

                                                            <input type="hidden" name="no_pembayaran" value="<?php echo $no_pembayaran; ?>">
                                                            <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                            <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">

                                                            <div class="row">
                                                                    <div class="col-md-6">
                                                                    <label>Metode Pembayaran</label>
                                                                    <?php $dataSelect = $data['jenis_pembayaran']; ?>
                                                                    <select id="jenis_pembayaran" name="jenis_pembayaran" class="form-control">
                                                                        <option <?php echo ($dataSelect == 'Cash') ? "selected" : "" ?>>Cash</option>
                                                                        <option <?php echo ($dataSelect == 'Debit') ? "selected" : "" ?>>Debit</option>
                                                                    </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Total Bayar</label>
                                                                        <input class="form-control form-control-sm" name="total_bayar" value="<?php echo $jumlah_bayar; ?>" type="text"   required="" >
                                                                    </div>
                                                            </div>

                                                            <br>


                                                    </div>


                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary"> Ubah </button>
                                                        <button type="reset" class="btn btn-danger"> RESET</button>
                                                    </div>
                                                    </form>
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
                    <hr>
                    <br>
                                
                    <div class="row">
                        <div class="col-md-4">
                                <h6 align="Center">Rincian Alat Kesehatan Terjual</h6>
                                <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                <thead align = 'center'>
                                    <tr>
                                    <th  style='font-size: 12px'>No</th>
                                    <th  style='font-size: 12px'>Nama Alat Kesehatan</th>
                                    <th  style='font-size: 12px'>Total Terjual</th>
                                    <th  style='font-size: 12px'>Harga</th>
                                    <th  style='font-size: 12px'>Total Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($data = mysqli_fetch_array($table2)){
                                    $harga_jual = $data['harga_jual'];
                                    $nama_alkes =$data['nama_alkes'];
                    
                                    $total_terjual_alkes = $data['total_terjual_alkes'];
                                    $pendapatan_alkes = $data['pendapatan_alkes'];
                                    $no_urut1 += 1 ;

                                    echo "<tr>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$no_urut1</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$nama_alkes</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$total_terjual_alkes</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>"; ?> <?= formatuang($harga_jual); ?> <?php echo"</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>"; ?> <?= formatuang($pendapatan_alkes); ?> <?php echo"</td>
                                    
                                </tr>";
                                }
                                ?>
                                
                                <tr > 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total Cash</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_alkes_cash); ?></th>
                                </tr>
                                <tr > 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total Debit</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_alkes_debit); ?></th>
                                </tr>
                                <tr > 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_alkes_total); ?></th>
                                </tr>

                                </tbody>
                                </table>
                        </div>
                        <div class="col-md-4">
                
                                <h6 align="Center">Rincian Obat Terjual</h6>
                                <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                <thead align = 'center'>
                                    <tr>
                                    <th  style='font-size: 12px'>No</th>
                                    <th  style='font-size: 12px'>Nama Obat</th>
                                    <th  style='font-size: 12px'>Total Terjual</th>
                                    <th  style='font-size: 12px'>Harga</th>
                                    <th  style='font-size: 12px'>Total Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($data = mysqli_fetch_array($table3)){
                                    $harga_jual = $data['harga_jual'];
                                    $nama_obat =$data['nama_obat'];
                    
                                    $total_terjual_obat = $data['total_terjual_obat'];
                                    $pendapatan_obat = $data['pendapatan_obat'];
                                    $no_urut2 += 1 ;

                                    echo "<tr>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$no_urut2</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$nama_obat</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$total_terjual_obat</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center' >"; ?> <?= formatuang($harga_jual); ?> <?php echo"</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center' >"; ?> <?= formatuang($pendapatan_obat); ?> <?php echo"</td>
                                                           
                                </tr>";
                                }
                                ?>
                                
                                <tr > 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total Cash</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_obat_cash); ?></th>
                                </tr>
                                <tr > 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total Debit</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_obat_debit); ?></th>
                                </tr>
                                <tr> 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_obat_total); ?></th>
                                </tr>

                                </tbody>
                                </table>

                        </div>
                        <div class="col-md-4">
                
                                <h6 align="Center">Rincian Tindakan</h6>
                                <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                <thead align = 'center'>
                                    <tr>
                                    <th  style='font-size: 12px'>No</th>
                                    <th  style='font-size: 12px'>Nama Tindakan</th>
                                    <th  style='font-size: 12px'>Jumlah Tindakan</th>
                                    <th  style='font-size: 12px'>Harga</th>
                                    <th  style='font-size: 12px'>Total Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($data = mysqli_fetch_array($table4)){
                                    $harga_tindakan = $data['harga_tindakan'];
                                    $nama_tindakan =$data['nama_tindakan'];
                    
                                    $total_tindakan = $data['total_tindakan'];
                                    $pendapatan_tindakan = $data['pendapatan_tindakan'];
                                    $no_urut3 += 1 ;

                                    echo "<tr>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$no_urut3</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$nama_tindakan</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center'>$total_tindakan</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center' >"; ?> <?= formatuang($harga_tindakan); ?> <?php echo"</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' align = 'center' >"; ?> <?= formatuang($pendapatan_tindakan); ?> <?php echo"</td>
                                                           
                                </tr>";
                                }
                                
                                ?>
                                
                                <tr> 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total Cash</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_tindakan_cash); ?></th>
                                </tr>
                                <tr > 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total Debit</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_tindakan_debit); ?></th>
                                </tr>
                                <tr > 
                                    <th colspan="4" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pendapatan_tindakan_seluruh); ?></th>
                                </tr>
                                
                                

                                </tbody>
                                </table>

                        </div>
                    </div>
                   
                    
                    <br>
                    <hr>
                    <br>
                    
                    
                    <div class="row" style="margin-right: 20px; margin-left: 20px;">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan Cash</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  formatuang($total_pendapatan_cash) ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan Debit</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_pendapatan_debit) ?></div>
                            </div>
                            <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pendapatan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=formatuang($total_pendapatan)?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <br><br>

               
                    

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