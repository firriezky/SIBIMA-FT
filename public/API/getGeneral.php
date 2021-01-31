<?php
require_once 'connect.php';
$nim =$_POST["nim"];
$fakultas =$_POST["fakultas"];

//Query for getting jadwal based on Faculty
$query ="SELECT * FROM `rekap_general` where nim ='$nim'";
$sql = mysqli_query($conn,$query);

$ray = [];
$ray['msg']='THIS API CODE PROVIDED BY HENRY AUGUSTA - SI18 - 1202184264';
$ray['mentee']=[];
$ray['data']=[];

$sqlMentee = mysqli_query($conn,$query);
$rowMentee = mysqli_fetch_array($sqlMentee);


while($row = mysqli_fetch_array($sql)){
    $ray['data'][]=
    [
    "nim" => $row['nim'],
    "nama" => $row['nama'],
    "id_agenda" => $row['id_agenda'],
    "judul" => $row['judul'],
    "waktu_hadir" => $row['waktu_hadir'],
    "tanggal_akhir" => $row['tanggal_akhir'],
    "nilai" =>  $row['nilai']
    ];
}

    echo json_encode($ray);
?>