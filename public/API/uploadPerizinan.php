<?php
$part="../../storage/tesupload/";
$filename = "img".rand(9,9999).".jpg";
$destinationfile=$part.$filename;

$res = array();
$kode = "";
$message = "";
if($_FILES['imageupload']){
    if(move_uploaded_file($_FILES['imageupload']['tmp_name'],
    $destinationfile)){
        $kode=1;
        $message="Berhasil Upload";
    }else{
        $kode=0;
        $message="Gagal Upload";
    }
}else{
    $kode=0;
    $message="Request Error";
}

$res['kode']=$kode;
$res['pesan']=$message;

echo json_encode($res);
?>
