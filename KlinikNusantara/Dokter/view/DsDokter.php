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


    $table = mysqli_query($koneksi, "SELECT * FROM antrian a INNER JOIN karyawan b ON a.id_dokter=b.id_karyawan
                                                             INNER JOIN ruangan c ON c.kode_ruangan=a.kode_ruangan  
                                                             INNER JOIN pasien d ON d.id_pasien=a.id_pasien 
                                                             INNER JOIN rekam_medis e ON e.no_rm=d.no_rm
                                                             LEFT JOIN perawatan f ON f.no_rm=e.no_rm 
                                                             WHERE a.tanggal = '$tanggal' AND b.nama_karyawan = '$nama' AND a.status_antrian = 'Dalam Perawatan' ");



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Dokter</title>

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
    <script type="text/javascript">
        window.setTimeout("waktu()", 1000);

        function waktu() {
            var tanggal = new Date();
            setTimeout("waktu()", 1000);
            document.getElementById("jam").innerHTML = tanggal.getHours();
            document.getElementById("menit").innerHTML = tanggal.getMinutes();
            document.getElementById("detik").innerHTML = tanggal.getSeconds();
        }
    </script>

</head>

<style>
    #jam-digital {
        overflow: hidden
    }

    #hours {
        float: left;
        width: 50px;
        height: 30px;
        background-color: #300030;
        margin-right: 25px
    }

    #minute {
        float: left;
        width: 50px;
        height: 30px;
        background-color: #300030;
        margin-right: 25px
    }

    #second {
        float: left;
        width: 50px;
        height: 30px;
        background-color: #300030;
    }

    #jam-digital p {
        color: #FFF;
        font-size: 22px;
        text-align: center
    }
</style>

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
            <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="VRiwayatPerwatan">Riwayat Perawatan</a>
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
                <div class="row">
                    <div class="col-sm-9">
                    </div>
                    <div class="col-sm-3" style="color: black; font-size: 18px;">
                        <script type='text/javascript'>
                            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                            var date = new Date();
                            var day = date.getDate();
                            var month = date.getMonth();
                            var thisDay = date.getDay(),
                                thisDay = myDays[thisDay];
                            var yy = date.getYear();
                            var year = (yy < 1000) ? yy + 1900 : yy;
                            document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-9">
                    </div>
                    <div class="col-sm-3">
                        <div id="jam-digital">
                            <div id="hours">
                                <p id="jam"></p>
                            </div>
                            <div id="minute">
                                <p id="menit"> </p>
                            </div>
                            <div id="second">
                                <p id="detik"> </p>
                            </div>
                        </div>
                    </div>
                </div>


                <h2 align='center'>List Perawatan</h2>
                            <br>
                            <hr>
                            <br>
                            <!-- Tabel -->
                            <div style="overflow-x: auto" >
                                <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align='center'>
                                    <thead align='center'>
                                        <tr>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Nama Pasien</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Tanggal Lahir</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Umur</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Keluhan Awal</th>
                                            <th style="font-size: clamp(12px, 1vw, 15px);">Terahir Cek Up</th>
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
                                        <?php while ($data = mysqli_fetch_array($table)) {
                                            $nama_pasien = $data['nama_pasien'];
                                            $id_pasien = $data['id_pasien'];
                                            $tanggal_lahir = $data['tanggal_lahir'];
                                            $nama_karyawan = $data['nama_karyawan'];
                                            $keluhan_awal = $data['keluhan_awal'];
                                            $status_antrian = $data['status_antrian'];

                                            $sql_antrian = mysqli_query($koneksi, "SELECT tanggal FROM antrian a INNER JOIN pasien b ON b.id_pasien=a.id_pasien 
                                                                                                                INNER JOIN rekam_medis c ON c.no_rm=b.no_rm
                                                                                                                LEFT JOIN perawatan d ON d.no_rm=c.no_rm 
                                                                                                                WHERE a.id_pasien = '$id_pasien' AND status_antrian = 'Selesai' ORDER BY a.no_antrian DESC LIMIT 1");
                                            $data_antrian = mysqli_fetch_assoc($sql_antrian);

                                            if( !isset( $data_antrian['tanggal'])){
                                                $tanggal_terakhir_cekUP = 'Pertama Kali Cek UP';
                                                $tanggal_cekUP_selanjutnya =  "Pertama Kali Cek UP" ;
                                            }
                                            else{
                                                $tanggal_terakhir_cekUP = $data_antrian['tanggal'];
                                                $tanggal_cekUP_selanjutnya = $data_antrian['tgl_cek_selanjutnya'] ;
                                            }
                                        
                                            

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
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_pasien</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal_lahir</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >";?> <?php echo "".$y . " tahun " . $m . " bulan " . $d . " hari";?> <?php echo"</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$keluhan_awal</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal_terakhir_cekUP</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal_cekUP_selanjutnya</td>
                                            <td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>
                                      
        
                                            <!-- Button Print No antri -->
                                            
                                            <?php echo "<a href='VRekamMedis?id_pasien=$id_pasien' target='_blank'><button style=' font-size: clamp(12px, 2vw, 15px);color:black; '  type='submit' class=' btn btn-info' >
                                            <i class='fa-solid fa-file-waveform'></i> Rekam Medis</button></a>";?>
                                            
                                          
                                            <!-- Button Selesai -->
                                            <button style=" font-size: clamp(12px, 2vw, 15px);color:black;" href="#" type="submit" class=" btn btn-success" data-toggle="modal" data-target="#selesai_perawatan<?php echo $data['no_antrian']; ?>" data-toggle='tooltip' title='Selesai perawatan'>
                                            <i class="fa-solid fa-circle-check"></i> Selesai</button>
                                            <div class="modal fade" id="selesai_perawatan<?php echo $data['no_antrian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Konfirmasi perawatan </b> </h4>
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
                                                                    <h6> Yakin Ingin Menyelesaikan Perawatan <?= $nama_pasien; ?> </h6>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary"> Selesai </button>
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

</body>

</html>