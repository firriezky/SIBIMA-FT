<?php
$fakultas=$_POST['fakultas'];
require_once 'connect.php';
$array =[];
$array['agenda']=[];
$nowDate=date("Y-m-d H:i:s");

$queryAgenda="SELECT * from agenda where fakultas='$fakultas' AND tipe<>3
AND tanggal_akhir>'$nowDate'";
$sqlAgenda = mysqli_query($conn,$queryAgenda);

while($rowAgenda=mysqli_fetch_array($sqlAgenda)){
    $array['agenda'][]=[
        'id_agenda'=>$rowAgenda['id'],
        'judul'=>$rowAgenda['judul']
    ];
}

echo json_encode($array);



?>