<?php
require_once 'connect.php';
$array =[];
$array['agenda']=[];
$nowDate=date("Y-m-d H:i:s");

$queryAgenda="SELECT * from agenda WHERE tipe=2 AND tanggal_akhir>'$nowDate'";
$sqlAgenda = mysqli_query($conn,$queryAgenda);

while($rowAgenda=mysqli_fetch_array($sqlAgenda)){
    $array['agenda'][]=[
        'id_agenda'=>$rowAgenda['id'],
        'judul'=>$rowAgenda['judul'],
        'fakultas'=>$rowAgenda['fakultas'],
        'waktu_akhir'=>$rowAgenda['tanggal_akhir']
    ];
}

echo json_encode($array);



?>