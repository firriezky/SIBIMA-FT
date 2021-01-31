<?php
require_once 'connect.php';
$nim =$_POST['nim'];
$judul =$_POST['judul'];
$link =$_POST['link'];
$deskripsi =$_POST['deskripsi'];
$array=[];
$array ['connection_status']=[];
$array ['insert_status']=[];


$array['connection_status'][]=[
    "connection" => 'connected'
];
$kelompok_id='0';
$queryGetKelompok ="SELECT * FROM `mentee` where nim ='$nim'";
$sqlGetKelompok = mysqli_query($conn,$queryGetKelompok);

if($rowK = mysqli_fetch_array($sqlGetKelompok)){
    $kelompok_id=$rowK['kelompok_id'];
}


$queryUpload = "INSERT INTO tugas_besar (kelompok_id,judul,video_link,deskripsi,fakultas) VALUES (
    '$kelompok_id','$judul','$link','$deskripsi','$fakultas')";
$sql_upload = mysqli_query($conn,$queryUpload);

if($sql_upload){
    $array["insert_status"][]=[
        "status_insert" => 'berhasil'
    ];
}else{
    $array["insert_status"][]=[
        "status_insert" => 'gagal'
    ];
}

echo json_encode($array);
?>