<?php
require_once 'vendor/autoload.php';

$antrian = $_GET['antrian'];
$nama_ruangan = $_GET['nama_ruangan'];
$nama_karyawan = $_GET['nama_karyawan'];
$nama_pasien = $_GET['nama_pasien'];
$tanggal = $_GET['tanggal'];


$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [80, 98]  ]);
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


<table rules="rows"  align="center">
<tr>
    <th  style="font-size: 20px;">BIG DENTAL CLINIC</th>
</tr>
<tr>
    <td  style="font-size: 12px;">Jl. Mayor Salim Batubara, Kota Palembang</td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; ">'. $nama_pasien .'</td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; ">'. $tanggal .'</td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; ">'. $nama_ruangan .'</td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; ">'. $nama_karyawan .'</td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 80px; ">'. $antrian .'</td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>
<tr>
    <td align="center" style="font-size: 12px; "></td>
</tr>

<tr>
    <td align="center" style="font-size: 20px; ">Terima Kasih</td>
</tr>

</table>



            





</body>

</html>'
;
$mpdf->setAutoTopMargin = 'stretch';
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->WriteHTML($html);
$mpdf->Output();
?>