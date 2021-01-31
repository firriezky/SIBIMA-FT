<?php
require_once 'connect.php';
$query ="SELECT * FROM `mentee`";
$sql = mysqli_query($conn,$query);
$ray = [];
while($row = mysqli_fetch_array($sql)){
    $ray[]=
    [
    "id" => $row['id'],
    "nama" => $row['nama'],
    "nim" => $row['nim'],
    "fakultas" => $row['fakultas']
    ];
}
    echo json_encode($ray);
