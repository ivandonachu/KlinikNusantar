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


    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];


    if(isset($_GET['kode_alkes'])){
        $kode_alkes = $_GET['kode_alkes'];
        if ($tanggal_awal == $tanggal_akhir) {
            $table = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes a INNER JOIN alat_kesehatan b ON b.kode_alkes=a.kode_alkes 
                                                                            INNER JOIN karyawan c ON c.id_karyawan=a.id_karyawan 
                                                                            INNER JOIN status_penggunaan d ON d.kode_penggunaan=a.kode_penggunaan 
                                                                             WHERE tanggal = '$tanggal_awal' AND a.kode_alkes = '$kode_alkes' ");
    

            $table2 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan");

            //pembelian alat kesehatan
            $sql_pembelian_alkes = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pembelian_alkes FROM riwayat_alkes WHERE tanggal = '$tanggal_awal' AND kode_alkes = '$kode_alkes' ");

            $data_pembelian_alkes = mysqli_fetch_assoc($sql_pembelian_alkes);
            $pembelian_alkes = $data_pembelian_alkes['pembelian_alkes'];

        } else {
            $table = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes a INNER JOIN alat_kesehatan b ON b.kode_alkes=a.kode_alkes 
                                                                            INNER JOIN karyawan c ON c.id_karyawan=a.id_karyawan 
                                                                            INNER JOIN status_penggunaan d ON d.kode_penggunaan=a.kode_penggunaan 
                                                                            WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_alkes = '$kode_alkes' ORDER BY a.tanggal");
           

            $table2 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan");

            //pembelian alat kesehatan
            $sql_pembelian_alkes = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pembelian_alkes FROM riwayat_alkes WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_alkes = '$kode_alkes' ");

            $data_pembelian_alkes = mysqli_fetch_assoc($sql_pembelian_alkes);
            $pembelian_alkes = $data_pembelian_alkes['pembelian_alkes'];
        }
    }
    else{
        if ($tanggal_awal == $tanggal_akhir) {
            $table = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes a INNER JOIN alat_kesehatan b ON b.kode_alkes=a.kode_alkes 
                                                                            INNER JOIN karyawan c ON c.id_karyawan=a.id_karyawan 
                                                                            INNER JOIN status_penggunaan d ON d.kode_penggunaan=a.kode_penggunaan 
                                                                            WHERE tanggal = '$tanggal_awal' ");
    
    
            $table2 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan");
            
            

            //pembelian alat kesehatan
            $sql_pembelian_alkes = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pembelian_alkes FROM riwayat_alkes WHERE tanggal = '$tanggal_awal' ");

            $data_pembelian_alkes = mysqli_fetch_assoc($sql_pembelian_alkes);
            $pembelian_alkes = $data_pembelian_alkes['pembelian_alkes'];

        } else {
            $table = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes a INNER JOIN alat_kesehatan b ON b.kode_alkes=a.kode_alkes 
                                                                            INNER JOIN karyawan c ON c.id_karyawan=a.id_karyawan 
                                                                            INNER JOIN status_penggunaan d ON d.kode_penggunaan=a.kode_penggunaan 
                                                                            WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY a.tanggal");

            $table2 = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan");

            //pembelian alat kesehatan
            $sql_pembelian_alkes = mysqli_query($koneksi, "SELECT SUM(jumlah) AS pembelian_alkes FROM riwayat_alkes WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

            $data_pembelian_alkes = mysqli_fetch_assoc($sql_pembelian_alkes);
            $pembelian_alkes = $data_pembelian_alkes['pembelian_alkes'];
        }
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

    <title>Rincian Pembelian Alat Kesehatan</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../DsManager">
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
    <a class="nav-link" href="../DsManager">
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
        <a class="collapse-item" style="font-size: clamp(5px, 3vw, 15px);" href="../VLabaRugi">Laba Rugi</a>
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

                    <?php echo "<a href='VRPembelianAlkes?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px; font-size: clamp(2px, 3vw, 22px);'>Rincian Pembelian Alat Kesehatan</h5></a>"; ?>




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
                                <a class="dropdown-item" href="../VProfile">
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
                <?php echo "<a href='../VLabaRugi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
                </div>

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
                    <h6 align="Center">Riwayat Restok / Pembelian Alat Kesehatan</h6>
                    <div style="overflow-x: auto">
                        <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align='center'>
                            <thead>
                                <tr>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">No</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Tanggal</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Nama Karyawan</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Status</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Nama Alat Kesehatan</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">QTY</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Harga</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">Jumlah</th>
                                    <th style="font-size: clamp(12px, 1vw, 15px);">File</th>
                                
                                 
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
                                    $no_riwayat = $data['no_riwayat'];
                                    $tanggal = $data['tanggal'];
                                    $nama_karyawan = $data['nama_karyawan'];
                                    $status = $data['status'];
                                    $nama_alkes = $data['nama_alkes'];
                                    $qty = $data['qty'];
                                    $harga = $data['harga'];
                                    $jumlah = $data['jumlah'];
                                    $file_bukti = $data['file_bukti'];
                                   
                                    $urut = $urut + 1;


                                    echo "<tr>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$urut</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$tanggal</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_karyawan</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$status</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_alkes</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >$qty</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >" ?> <?= formatuang($harga); ?> <?php echo "</td>
                                    <td style='font-size: clamp(12px, 1vw, 15px);' >" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                                    "; ?>
                                    <?php echo "
                                    <td style='font-size: clamp(12px, 1vw, 15px);'>"; ?> <a download="../file_admin/<?= $file_bukti ?>" href="../file_admin/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                    </tr>";
                                }
                                    ?>
                                    <tr > 
                                    <th colspan="7" style="font-size: clamp(12px, 1vw, 15px);" align = "center">Total</th>
                                    <th colspan="2" style="font-size: clamp(12px, 1vw, 15px);" bgcolor="#F0F8FF"   align = "center"><?= formatuang($pembelian_alkes); ?></th>
                                   </tr>
                            </tbody>
                        </table>
                    </div>


                    <br>
                    <hr>
                    <br>
                    

                    <h6 align="Center">Stok Obat</h6>
                    <table id="example2" class="table-sm table-striped table-bordered  nowrap" style="width:auto" align="center">
                        <thead>
                            <tr>
                                <th style="font-size: clamp(12px, 1vw, 15px);">Kode Alat Kesehatan</th>
                                <th style="font-size: clamp(12px, 1vw, 15px);">Nama Alat Kesehatan</th>
                                <th style="font-size: clamp(12px, 1vw, 15px);">Harga Beli Alat Kesehatan</th>
                                <th style="font-size: clamp(12px, 1vw, 15px);">Harga Jual Alat Kesehatan</th>
                                <th style="font-size: clamp(12px, 1vw, 15px);">Stok Alat Kesehatan</th>
                                <th style="font-size: clamp(12px, 1vw, 15px);">Deskripsi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php while ($data = mysqli_fetch_array($table2)) {
                                $kode_alkes = $data['kode_alkes'];
                                $nama_alkes = $data['nama_alkes'];
                                $harga_beli = $data['harga_beli'];
                                $harga_jual = $data['harga_jual'];
                                $stok_alkes = $data['stok_alkes'];
                                $deskripsi = $data['deskripsi'];

                       
                                echo "<tr>
                                <td style='font-size: clamp(12px, 1vw, 15px);' >$kode_alkes</td>
                                <td style='font-size: clamp(12px, 1vw, 15px);' >$nama_alkes</td>
                                <td  style='font-size: clamp(12px, 1vw, 15px);'>" ?> <?= formatuang($harga_beli); ?> <?php echo "</td>
                                <td  style='font-size: clamp(12px, 1vw, 15px);'>" ?> <?= formatuang($harga_jual); ?> <?php echo "</td>
                                <td style='font-size: clamp(12px, 1vw, 15px);' >$stok_alkes</td>
                                <td style='font-size: clamp(12px, 1vw, 15px);' >$deskripsi</td>";?>

                        
                    
                                <?php echo "<td style='font-size: clamp(12px, 1vw, 15px);'>"; ?>
                                     <!-- Button search -->
                                    <?php echo " <a href='VRPembelianAlkes?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&kode_alkes=$kode_alkes'><i class='fa-solid fa-magnifying-glass'></i></a>"; ?>
                                     
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
        $(document).ready(function() {
            var table = $('#example2').DataTable({
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