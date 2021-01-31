<?php
require_once 'connect.php';
$nim =$_POST["nim"];

$ray = [];
$ray['before']=[]; //for general score


$queryGeneral ="SELECT * FROM `mentor` where nim ='$nim'";
$sqlGeneral = mysqli_query($conn,$queryGeneral);

while($rowG = mysqli_fetch_array($sqlGeneral)){
    $ray['before'][]=
    [
    "nama" => $rowG['nama'],
    "nim" =>  $rowG['nim'],
    "line" =>  $rowG['line_id'],
    "jurusan" =>  $rowG['program_studi'],
    "fakultas" =>  $rowG['fakultas'],
    "kontak" =>  $rowG['no_telp']
    ];
}


// if($rowG = mysqli_fetch_array($sql)){
//     $ray['after'][]=
//     [
//         "nama" => $rowG['nama'],
//         "line" =>  $rowG['line_id'],
//         "kontak" =>  $rowG['no_telp']
//     ];
// }
    echo json_encode($ray);
?>