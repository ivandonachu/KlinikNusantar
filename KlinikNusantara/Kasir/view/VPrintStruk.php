<?php
require_once 'vendor/autoload.php';
include 'koneksi.php';
$no_antrian = $_GET['no_antrian'];

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
$total_pembayaran= 0;   
$no_urut=1;
$panjang_kertas = 165;

if($tindakan_1 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($tindakan_2 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($tindakan_3 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($tindakan_4 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($alkes_1 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($alkes_2 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($alkes_3 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($alkes_4 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($obat_1 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($obat_2 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($obat_3 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}
if($obat_4 == "" ){
    $panjang_kertas = $panjang_kertas - 4;
}

?>
  <style>
   tr{
    border-bottom: 2pt solid;
   }
  </style>

<?php

function formatuang($angka)
{
    $uang = number_format($angka, 0, ',', '.');
    return $uang;
}
function formatuangx($angka)
{
    $uang = "Rp " . number_format($angka, 0, ',', '.');
    return $uang;
}
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [80, $panjang_kertas]  ]);
$mpdf->AddPageByArray([
    'margin-left' => 5,
    'margin-right' => 5,
    'margin-top' => 5,
    'margin-bottom' => 5,
]);
$html = '
<html>

<head>
</head>

<body>
<br>
<br>

<table rules="rows"  align="center">
<tr>
    <td ><img style=" max-height: 35px; width: 100%;" src="../gambar/Logo Struk.jpg"></td>
    <td align="center" style="font-size: 9px;">BIG DENTAL CLINIC <br>Jl. Mayor Salim Batubara</td>
</tr>

</table>

<hr>
<table   align="center" style="width:100%">
<tr >
    <td colspan="3" style="font-size: 9px;">Nota Kasir</td>
</tr>
<tr>
    <td align="left" style="font-size: 9px; width:20%; ">Tanggal</td>
    <td align="center" style="font-size: 9px; width:1%;"> : </td>
    <td align="left" style="font-size: 9px; width:79%;">'. $tanggal .'</td>
</tr>
<tr>
    <td align="left" style="font-size: 9px; width:20%; ">Nama</td>
    <td align="center" style="font-size: 9px; width:1%;"> : </td>
    <td align="left" style="font-size: 9px; width:79%;">'. $nama_pasien .'</td>
</tr>
<tr>
    <td align="left" style="font-size: 9px; width:20%; ">Alamat</td>
    <td align="center" style="font-size: 9px; width:1%;"> : </td>
    <td align="left" style="font-size: 9px; width:79%;">'. $alamat .'</td>
</tr>
<tr>
    <td align="left" style="font-size: 9px; width:20%; ">Telepon</td>
    <td align="center" style="font-size: 9px; width:1%;"> : </td>
    <td align="left" style="font-size: 9px; width:79%;">'. $no_hp .'</td>
</tr>
<tr>
    <td align="left" style="font-size: 9px; width:20%; ">NIK</td>
    <td align="center" style="font-size: 9px; width:1%;"> : </td>
    <td align="left" style="font-size: 9px; width:79%;">'. $nik .'</td>
</tr>
<tr>
    <td align="left" style="font-size: 9px; width:20%; ">Pembayaran</td>
    <td align="center" style="font-size: 9px; width:1%;"> : </td>
    <td align="left" style="font-size: 9px; width:79%;">'. $jenis_pembayaran .'</td>
</tr>

</table>
<hr>
';

    //list tindakan
    //tindakan 1
    if($tindakan_1 != ""){
        $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_1'");
        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

        $harga_tindakan = $data_tindakan['harga_tindakan'];
        $html .= '<table align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $tindakan_1 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">  1 x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_tindakan) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($harga_tindakan) .'</td>
        </tr>
        
        </table> ';
        $no_urut = $no_urut + 1;
    }
    //tindakan 2
    if($tindakan_2 != ""){
        $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_2'");
        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

        $harga_tindakan = $data_tindakan['harga_tindakan'];
        $html .= '<table  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $tindakan_2 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">  1 x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_tindakan) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($harga_tindakan) .'</td>
        </tr>
        
        </table> ';
        $no_urut = $no_urut + 1;
    }
    //tindakan 1
    if($tindakan_3 != ""){
        $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_3'");
        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

        $harga_tindakan = $data_tindakan['harga_tindakan'];
        $html .= '<table  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $tindakan_3 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">  1 x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_tindakan) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($harga_tindakan) .'</td>
        </tr>
        
        </table> ';
        $no_urut = $no_urut + 1;
    }
    //tindakan 1
    if($tindakan_4 != ""){
        $sql_tindakan = mysqli_query($koneksi, "SELECT * FROM tindakan WHERE nama_tindakan = '$tindakan_4'");
        $data_tindakan = mysqli_fetch_assoc($sql_tindakan);

        $harga_tindakan = $data_tindakan['harga_tindakan'];
        $html .= '<table align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $tindakan_4 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">  1 x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_tindakan) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($harga_tindakan) .'</td>
        </tr>
        
        </table> ';
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
        $harga_alkes = $jumlah / $qty_alkes_1;
        $html .= '<table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $alkes_1 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">'. $qty_alkes_1 .' x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_alkes) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($jumlah) .'</td>
        </tr>
        
        </table> ';
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
        $harga_alkes = $jumlah / $qty_alkes_2;
        $html .= '<table rules="rows"  align="center" style="width:100%">

        <tr >
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $alkes_2 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">'. $qty_alkes_2 .' x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_alkes) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($jumlah) .'</td>
        </tr>
        
        </table> ';
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
        $harga_alkes = $jumlah / $qty_alkes_3;
        $html .= '<table   align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $alkes_3 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">'. $qty_alkes_3 .' x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_alkes) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($jumlah) .'</td>
        </tr>
        
        </table> ';
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
        $harga_alkes = $jumlah / $qty_alkes_4;
        $html .= '<table   align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $alkes_4 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">'. $qty_alkes_4 .' x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_alkes) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($jumlah) .'</td>
        </tr>
        
        </table> ';
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
        $harga_obat = $jumlah / $qty_obat_1;
        $html .= '<table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $obat_1 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">'. $qty_obat_1 .' x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_obat) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($jumlah) .'</td>
        </tr>
        
        </table> ';
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
        $harga_obat = $jumlah / $qty_obat_2;
        $html .= '<table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $obat_2 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">'. $qty_obat_2 .' x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_obat) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($jumlah) .'</td>
        </tr>
        
        </table> ';
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
        $harga_obat = $jumlah / $qty_obat_3;
        $html .= '<table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $obat_3 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">'. $qty_obat_3 .' x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_obat) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($jumlah) .'</td>
        </tr>
        
        </table> ';
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
        $harga_obat = $jumlah / $qty_obat_4;
        $html .= '<table rules="rows"  align="center" style="width:100%">

        <tr>
            <td align="left" style="font-size: 9px; width:5%; ">'. $no_urut .'.</td>
            <td align="left" style="font-size: 9px; width:36%;">'. $obat_4 .'</td>
            <td align="left" style="font-size: 9px; width:10%;">'. $qty_obat_4 .' x </td>
            <td align="left" style="font-size: 9px; width:22%;">'.  formatuang($harga_obat) .'</td>
            <td align="left" style="font-size: 9px; width:5%;"> = </td>
            <td align="left" style="font-size: 9px; width:22%;">'. formatuang($jumlah) .'</td>
        </tr>
        
        </table> ';
        $no_urut = $no_urut + 1;
    }

    $html .= '<hr>
    <table rules="rows"  align="center" style="width:100%">

    <tr>
        <td align="center" style="font-size: 9px; width:45%; ">Total Tagihan</td>
        <td align="center" style="font-size: 9px; width:10%;"> = </td>
        <td align="center" style="font-size: 9px; width:45%;">'.  formatuangx($jumlah_tagihan) .'</td>
    </tr>
    <tr>
        <td align="center" style="font-size: 9px; width:45%; ">Total Bayar</td>
        <td align="center" style="font-size: 9px; width:10%;"> = </td>
        <td align="center" style="font-size: 9px; width:45%;">'.  formatuangx($jumlah_bayar) .'</td>
    </tr>
    <tr>
        <td align="center" style="font-size: 9px; width:45%; ">Kembalian</td>
        <td align="center" style="font-size: 9px; width:10%;"> = </td>
        <td align="center" style="font-size: 9px; width:45%;">'.  formatuangx($kembalian) .'</td>
    </tr>
    
    </table> 
    <hr>
    <table rules="rows"  align="center" style="width:100%">

    <tr>
    <td align="center" style="font-size: 13px; ">Terima Kasih</td>
    </tr>
    
    </table>';

    





 $html .= '</body>

</html>';

$mpdf->setAutoTopMargin = 'stretch';
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->WriteHTML($html);
$mpdf->Output();
?>