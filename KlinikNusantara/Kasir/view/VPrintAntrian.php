<?php
require_once 'vendor/autoload.php';

$antrian = $_GET['antrian'];
$nama_ruangan = $_GET['nama_ruangan'];


$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [80, 80]  ]);
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
    <th  style="font-size: 30px;">'. $nama_ruangan .'</th>

</tr>
<tr>
 
    <td align="center" style="font-size: 150px; ">'. $antrian .'</td>


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