<?php
require_once 'connect.php';
// $nim = $_GET['nim'];
$query ="SELECT * FROM `rekap_mentoring_general` where nim ='1202184200'";
$sql = mysqli_query($conn,$query);
$row = mysqli_fetch_array($sql);


$presensi=$row['waktu_hadir'];
$bataspresensi=$row['tanggal_akhir'];

echo "Waktu Presensi : $presensi <br>";
echo "Batas Absensi  : $bataspresensi <br>";

$ray['msg']='Sukses dari server';
$nilai = '0';
if ($presensi > $bataspresensi){
    $nilai='85';
}else if ($presensi<$bataspresensi) {
    $nilai='100';
}

$ray = [];
$ray['data']=[];
$ray = ['general'];
$query2 ="SELECT * FROM `rekap_mentoring_general` where nim ='1202184200'";
$sql2 = mysqli_query($conn,$query2);
$row2 = mysqli_fetch_array($sql2);
while($row2 = mysqli_fetch_array($sql2)){
    $ray['general'][]=
    [
    "nama" => $row2['nama'],
    "nim" => $row2['nim'],
    "jk" => $row2['jk'],
    "kode" => $row2['kode'],
    "judul" => $row2['judul'],
    "waktu_hadir" => $row2['waktu_hadir'],
    "tanggal_akhir" => $row2['tanggal_akhir'],
    "nilai" => $nilai
    ];

}

    echo json_encode($ray);
?>