<?php
require_once 'connect.php';
$kontak =$_POST['kontak'];
$nama =$_POST['nama'];
$id =$_POST['id'];
$param =$_POST['param'];
$array=[];
$array ['update_status']=[];


if($param=='Delete'){
    $query="DELETE from helpdesk where id='$id'";
}else{
    $query = "UPDATE helpdesk set kontak='$kontak', nama='$nama' where id='$id'";
}




$sql_update = mysqli_query($conn,$query);
if($sql_update){
    $array["update_status"][]=[
        "status_update" => 'berhasil',
    ];
}else{
    $array["update_status"][]=[
        "status_update" => 'gagal'
    ];
}

echo json_encode($array);
?>