<?php
require_once 'connect.php';
$nim =$_POST['nim'];
$password =$_POST['password'];
$kontak =$_POST['kontak'];
$array=[];
$array ['connection_status']=[];
$array ['update_password_status']=[];
$array ['before']=[];
$array ['after']=[];

$updated_pass=password_hash($password, PASSWORD_BCRYPT);
$query = "UPDATE mentor set password='$updated_pass' where nim='$nim'";


$array['connection_status'][]=[
    "connection" => 'connected'
];

$sql_update = mysqli_query($conn,$query);
if($sql_update){
    $array["update_status"][]=[
        "status_update" => 'berhasil',
        "new password" => $updated_pass
    ];
}else{
    $array["update_status"][]=[
        "status_update" => 'gagal'
    ];
}

echo json_encode($array);
?>