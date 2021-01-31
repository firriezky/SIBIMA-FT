<?php
$nim=$_POST['nim'];
require_once 'connect.php';
$array =[];
$array['kelompok']=[];


$queryAgenda="SELECT * from rekap_kelompok where nim ='$nim'";
$sqlAgenda = mysqli_query($conn,$queryAgenda);

while($rowAgenda=mysqli_fetch_array($sqlAgenda)){
    $array['kelompok'][]=[
        'id_kelompok'=>$rowAgenda['id_grup'],
        'kode_kelompok'=>$rowAgenda['kode'],
        'line_id'=>$rowAgenda['line_id'],
        'no_telp'=>$rowAgenda['no_telp'],
        'nama_mentor'=>$rowAgenda['nama']
    ];
}

echo json_encode($array);



?>