<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account a INNER JOIN karyawan b on b.id_karyawan=a.id_karyawan WHERE b.id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Dokter') {

}

else{  header("Location: logout.php");
exit;
}

$no_perawatan = htmlspecialchars($_POST['no_perawatan']);
$id_pasien = htmlspecialchars($_POST['id_pasien']);


        $sql_perawatan = mysqli_query($koneksi, "SELECT * FROM perawatan WHERE no_perawatan ='$no_perawatan' ");
        $data_perawatan = mysqli_fetch_assoc($sql_perawatan);
      
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

      
//update Data alkes
if($alkes_1 != ""){

        $sql_ri_alkes = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN alat_kesehatan c ON c.kode_alkes=a.kode_alkes WHERE a.no_perawatan = '$no_perawatan' AND c.nama_alkes = '$alkes_1'");
        $data_ri_alkes = mysqli_fetch_assoc($sql_ri_alkes);
        $no_riwayat = $data_ri_alkes['no_riwayat'];

        $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_1'");
        $data_alkes = mysqli_fetch_assoc($sql_alkes);

        $kode_alkes = $data_alkes['kode_alkes'];
        $stok_alkes = $data_alkes['stok_alkes'];


        $stok_alkes_baru = $stok_alkes + $qty_alkes_1;
        
        mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
        mysqli_query($koneksi,"DELETE FROM riwayat_alkes_perawatan WHERE no_riwayat = '$no_riwayat'");
    
}
if($alkes_2 != ""){

        $sql_ri_alkes = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN alat_kesehatan c ON c.kode_alkes=a.kode_alkes WHERE a.no_perawatan = '$no_perawatan' AND c.nama_alkes = '$alkes_2'");
        $data_ri_alkes = mysqli_fetch_assoc($sql_ri_alkes);
        $no_riwayat = $data_ri_alkes['no_riwayat'];

        $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_2'");
        $data_alkes = mysqli_fetch_assoc($sql_alkes);

        $kode_alkes = $data_alkes['kode_alkes'];
        $stok_alkes = $data_alkes['stok_alkes'];


        $stok_alkes_baru = $stok_alkes + $qty_alkes_2;
        
        mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
        mysqli_query($koneksi,"DELETE FROM riwayat_alkes_perawatan WHERE no_riwayat = '$no_riwayat'");

}
if($alkes_3 != ""){

    $sql_ri_alkes = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN alat_kesehatan c ON c.kode_alkes=a.kode_alkes WHERE a.no_perawatan = '$no_perawatan' AND c.nama_alkes = '$alkes_3'");
    $data_ri_alkes = mysqli_fetch_assoc($sql_ri_alkes);
    $no_riwayat = $data_ri_alkes['no_riwayat'];

    $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_3'");
    $data_alkes = mysqli_fetch_assoc($sql_alkes);

    $kode_alkes = $data_alkes['kode_alkes'];
    $stok_alkes = $data_alkes['stok_alkes'];


    $stok_alkes_baru = $stok_alkes + $qty_alkes_3;
    
    mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
    mysqli_query($koneksi,"DELETE FROM riwayat_alkes_perawatan WHERE no_riwayat = '$no_riwayat'");

}
if($alkes_4 != ""){

    $sql_ri_alkes = mysqli_query($koneksi, "SELECT * FROM riwayat_alkes_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN alat_kesehatan c ON c.kode_alkes=a.kode_alkes WHERE a.no_perawatan = '$no_perawatan' AND c.nama_alkes = '$alkes_4'");
    $data_ri_alkes = mysqli_fetch_assoc($sql_ri_alkes);
    $no_riwayat = $data_ri_alkes['no_riwayat'];

    $sql_alkes = mysqli_query($koneksi, "SELECT * FROM alat_kesehatan WHERE nama_alkes = '$alkes_4'");
    $data_alkes = mysqli_fetch_assoc($sql_alkes);

    $kode_alkes = $data_alkes['kode_alkes'];
    $stok_alkes = $data_alkes['stok_alkes'];


    $stok_alkes_baru = $stok_alkes + $qty_alkes_4;
    
    mysqli_query($koneksi,"UPDATE alat_kesehatan SET stok_alkes = '$stok_alkes_baru' WHERE kode_alkes =  '$kode_alkes'");
    mysqli_query($koneksi,"DELETE FROM riwayat_alkes_perawatan WHERE no_riwayat = '$no_riwayat'");

}

//update data obat
if($obat_1 != ""){

    $sql_ri_obat = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN obat c ON c.kode_obat=a.kode_obat WHERE a.no_perawatan = '$no_perawatan' AND c.nama_obat = '$obat_1'");
    $data_ri_obat = mysqli_fetch_assoc($sql_ri_obat);
    $no_riwayat = $data_ri_obat['no_riwayat'];

    $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_1'");
    $data_obat = mysqli_fetch_assoc($sql_obat);

    $kode_obat = $data_obat['kode_obat'];
    $stok_obat = $data_obat['stok_obat'];


    $stok_obat_baru = $stok_obat + $qty_obat_1;
    
    mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
    mysqli_query($koneksi,"DELETE FROM riwayat_obat_perawatan WHERE no_riwayat = '$no_riwayat'");

}
if($obat_2 != ""){

    $sql_ri_obat = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN obat c ON c.kode_obat=a.kode_obat WHERE a.no_perawatan = '$no_perawatan' AND c.nama_obat = '$obat_2'");
    $data_ri_obat = mysqli_fetch_assoc($sql_ri_obat);
    $no_riwayat = $data_ri_obat['no_riwayat'];

    $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_2'");
    $data_obat = mysqli_fetch_assoc($sql_obat);

    $kode_obat = $data_obat['kode_obat'];
    $stok_obat = $data_obat['stok_obat'];


    $stok_obat_baru = $stok_obat + $qty_obat_2;
    
    mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
    mysqli_query($koneksi,"DELETE FROM riwayat_obat_perawatan WHERE no_riwayat = '$no_riwayat'");

}
if($obat_3 != ""){

    $sql_ri_obat = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN obat c ON c.kode_obat=a.kode_obat WHERE a.no_perawatan = '$no_perawatan' AND c.nama_obat = '$obat_3'");
    $data_ri_obat = mysqli_fetch_assoc($sql_ri_obat);
    $no_riwayat = $data_ri_obat['no_riwayat'];

    $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_3'");
    $data_obat = mysqli_fetch_assoc($sql_obat);

    $kode_obat = $data_obat['kode_obat'];
    $stok_obat = $data_obat['stok_obat'];


    $stok_obat_baru = $stok_obat + $qty_obat_3;
    
    mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
    mysqli_query($koneksi,"DELETE FROM riwayat_obat_perawatan WHERE no_riwayat = '$no_riwayat'");

}
if($obat_4 != ""){

    $sql_ri_obat = mysqli_query($koneksi, "SELECT * FROM riwayat_obat_perawatan a INNER JOIN perawatan b ON b.no_perawatan=a.no_perawatan INNER JOIN obat c ON c.kode_obat=a.kode_obat WHERE a.no_perawatan = '$no_perawatan' AND c.nama_obat = '$obat_4'");
    $data_ri_obat = mysqli_fetch_assoc($sql_ri_obat);
    $no_riwayat = $data_ri_obat['no_riwayat'];

    $sql_obat = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat = '$obat_4'");
    $data_obat = mysqli_fetch_assoc($sql_obat);

    $kode_obat = $data_obat['kode_obat'];
    $stok_obat = $data_obat['stok_obat'];


    $stok_obat_baru = $stok_obat + $qty_obat_4;
    
    mysqli_query($koneksi,"UPDATE obat SET stok_obat = '$stok_obat_baru' WHERE kode_obat =  '$kode_obat'");
    mysqli_query($koneksi,"DELETE FROM riwayat_obat_perawatan WHERE no_riwayat = '$no_riwayat'");

}


mysqli_query($koneksi,"DELETE FROM perawatan WHERE no_perawatan = '$no_perawatan'");
  
  echo "<script>alert('Data Perawatan Berhasil di Hapus'); window.location='../view/VRekamMedis?id_pasien=$id_pasien';</script>";exit;

        

       


  ?>