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
$tanggal = date('Y-m-d');

$sql_antrian_r1 = mysqli_query($koneksi, "SELECT kode_antrian FROM live_antrian WHERE kode_ruangan = 'RUA1' AND tanggal = '$tanggal' ORDER BY no_live DESC LIMIT 1");
$data_antrian_r1 = mysqli_fetch_assoc($sql_antrian_r1);
if( !isset( $data_antrian_r1['kode_antrian'])){
    $kode_antrian_r1 = '00';
}
else{
    $kode_antrian_r1 = $data_antrian_r1['kode_antrian'];
}


$sql_antrian_r2 = mysqli_query($koneksi, "SELECT kode_antrian FROM live_antrian WHERE kode_ruangan = 'RUA2' AND tanggal = '$tanggal' ORDER BY no_live DESC LIMIT 1");
$data_antrian_r2 = mysqli_fetch_assoc($sql_antrian_r2);

if( !isset( $data_antrian_r2['kode_antrian'])){
    $kode_antrian_r2 = '00';
}
else{
    $kode_antrian_r2 = $data_antrian_r2['kode_antrian'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="refresh" content="3" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Kasir</title>

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
        float: right;
        width: 110px;
        height: 90px;
        background-color: #300030;
        margin-right: 40px
    }

    #minute {
        float: right;
        width: 110px;
        height: 90px;
        background-color: #300030;
        margin-right: 40px
    }

    #second {
        float: right;
        width: 110px;
        height: 90px;
        background-color: #300030;
        margin-right: 87px
    }

    #jam-digital p {
        color: #FFF;
        font-size: 55px;
        font-weight: bold;
        text-align: center
    }
</style>

</head>

<body id="page-top">


    <br>
    <div class="row">
        <div class="col-md-6">
            <img style="margin-top: px; max-height: 300px; width: 70%;" src="../gambar/Logo Klinik.jpeg">
        </div>
        <div class="col-md-6">
            <div align='right' ; style="margin-right: 50px;">
                <div class="row" style="margin-right: 30px;">
                    <div class="col-sm-12" style="color: black; font-weight: bold; font-size: 60px;">
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
                    <div class="col-sm-12">
                        <div id="jam-digital">


                            <div id="second">
                                <p id="detik"> </p>
                            </div>
                            <div id="minute">
                                <p id="menit"> </p>
                            </div>
                            <div id="hours">
                                <p id="jam"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row" style="margin-left: 240px; margin-top: 110px;">
        <div class="col-md-6">
        <table rules="rows" style="background-color: #300030;">
                <tr align="center">
                    <th colspan="3" style="font-size: 100px; color: #FFF;">Ruangan 1</th>

                </tr>
                <tr>
                    <td style="font-size: 50px;  color: #300030;">Aaa</td>
                    <?php 
                        if($kode_antrian_r1 == ""){?>
                            <td align="center" style="font-size: 400px; color: #FFF;"><?= $kode_antrian_r1; ?></td>
                        <?php }
                        else{?>
                            <td align="center" style="font-size: 400px; color: #FFF;"><?= $kode_antrian_r1; ?></td>
                        <?php }
                    
                    ?>
                    <td style="font-size: 50px;  color: #300030;">Aaaa</td>

                </tr>

            </table>

        </div>
        <div class="col-md-6">

            <table rules="rows" style="background-color: #300030;">
                <tr align="center">
                    <th colspan="3" style="font-size: 100px; color: #FFF;">Ruangan 2</th>

                </tr>
                <tr>
                    <td style="font-size: 50px;  color: #300030;">Aaa</td>
                    <?php 
                        if($kode_antrian_r2 == ""){?>
                            <td align="center" style="font-size: 400px; color: #FFF;"><?= $kode_antrian_r1; ?></td>
                        <?php }
                        else{?>
                            <td align="center" style="font-size: 400px; color: #FFF;"><?= $kode_antrian_r2 ?></td>
                        <?php }
                    
                    ?>
                    <td style="font-size: 50px;  color: #300030;">Aaaa</td>

                </tr>

            </table>


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