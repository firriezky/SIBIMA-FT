<?php
require_once 'connect.php';
$nomor =$_POST['nomor'];
$nama =$_POST['nama'];

$array=[];
$array ['connection_status']=[];
$array ['insert_status']=[];


$array['connection_status'][]=[
    "connection" => 'connected'
];


$queryUpload = "INSERT INTO helpdesk (kontak,nama) values ('$nomor','$nama')";
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