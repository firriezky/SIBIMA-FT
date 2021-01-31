<?php
require_once 'connect.php';
$nim =$_POST['nim'];
$line =$_POST['line'];
$kontak =$_POST['kontak'];
$array=[];
$array ['connection_status']=[];
$array ['update_status']=[];
$array ['before']=[];
$array ['after']=[];


$query_check = "SELECT * from mentee where nim='$nim'";
$query = "UPDATE mentee set line_id='$line',no_telp='$kontak' where nim='$nim'";



$array['connection_status'][]=[
    "connection" => 'connected'
];

$sql_check= mysqli_query($conn,$query_check); 

if($row = mysqli_fetch_array($sql_check)){
$array['before'][]=
[
"nim" => $row['nim'],
"nama" => $row['nama'],
"line_id" => $row['line_id'],
"no_telp" => $row['no_telp']
];
}

$sql_update = mysqli_query($conn,$query);
if($sql_update){
    $array["update_status"][]=[
        "status_update" => 'berhasil'
    ];
}else{
    $array["update_status"][]=[
        "status_update" => 'gagal'
    ];
}
$sql_check2= mysqli_query($conn,$query_check); 
if($rowx = mysqli_fetch_array($sql_check2)){
    $array["after"][]=
    [
    "nim" => $rowx['nim'],
    "nama" => $rowx['nama'],
    "line_id" => $rowx['line_id'],
    "no_telp" => $rowx['no_telp']
    ];
    }

    if($nim==null){
        $array["update_status"][]=[
            "status_update" => 'gagal',
            "cause" => 'null nim'
        ];
    }

echo json_encode($array);
?>