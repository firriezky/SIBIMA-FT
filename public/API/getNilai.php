<?php
require_once 'connect.php';
$nim =$_POST["nim"];
$kelompok =$_POST["kelompok"];
$query ="SELECT * FROM `rekap_small_class` where nim ='$nim' order by judul";
$sql = mysqli_query($conn,$query);
$ray = [];
$ray['additional info']; // for small class score
$info = 
"1 at data as nilai kultum ,2 at data as nilai kehadiran ,1 at general as nilai, 2 at general as waktu hadir ";
$ray['additional_info'][]=
[
    "info" => $info

];
$ray['shining_team']=[]; // for small class score
$ray['data']=[];

$queryTubes ="SELECT * FROM `rekap_nilai_tubes` where kode ='$kelompok'";
$sqlTubes = mysqli_query($conn,$queryTubes);
if($rowT = mysqli_fetch_array($sqlTubes)){
    $ray['shining_team'][]=
    [
    "tipe" => 'tubes',
    "judul" => $rowT['judul'],
    "score_2" =>  $rowT['nilai'], // as nilai tubes
    "score_1" =>  ''
    ];
}



$queryGeneral ="SELECT * FROM `rekap_general` where nim ='$nim'";
$sqlGeneral = mysqli_query($conn,$queryGeneral);

while($rowG = mysqli_fetch_array($sqlGeneral)){
    $ray['data'][]=
    [
    "tipe" => 'general',
    "judul" => $rowG['judul'],
    "score_2" =>  $rowG['nilai'],
    "score_1" =>  ''
    ];
}


while($row = mysqli_fetch_array($sql)){
    $ray['data'][]=
    [
    "tipe" => 'small_class',
    "judul" => $row['judul'],
    "score_1" => $row['kultum'], //1 as nilai kultum
    "score_2" => $row['kehadiran'] //2 as nilai kehadiran
    ];
}


    echo json_encode($ray);
?>