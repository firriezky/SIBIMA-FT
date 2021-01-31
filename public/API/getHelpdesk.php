<?php
require_once 'connect.php';

$query ="SELECT * FROM `helpdesk`";
$sql = mysqli_query($conn,$query);
$ray = [];
$ray['kontak']=[];

$queryT ="SELECT * FROM `helpdesk`";
$sqlT = mysqli_query($conn,$queryT);


while($rowT = mysqli_fetch_array($sqlT)){
    $ray['kontak'][]=
    [
    "id" => $rowT['id'],
    "whatsapp" =>  $rowT['kontak'],
    "nama" =>  $rowT['nama']
    ];
}

    echo json_encode($ray);
?>