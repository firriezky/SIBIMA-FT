<?php
require_once 'connect.php';
$mentee_id =$_POST['mentee_id'];
$agenda_id =$_POST['agenda_id'];

$array=[];
$array ['presensi_status']=[];
$waktu=date('Y-m-d H:i:s');
$late="default";


// if(desc.equals("duplicate_row"));
// if(desc.equals("wrong_fac"));
// if(desc.equals("mentee0"));
// if(desc.equals("insert_success"));
// if(desc.equals("insert_failed"));

$queryCheckMentee="SELECT nama from mentee where id=$mentee_id";
$sqlCMentee=mysqli_query($conn,$queryCheckMentee);
$rowCMentee=mysqli_fetch_array($sqlCMentee);

$nama = $rowCMentee['nama'];

$cekMentee = mysqli_num_rows($sqlCMentee);
if($cekMentee<1){
    $array["presensi_status"][]=[
        "status" => 'failed',
        "desc" => 'mentee0',
        "nama" => null,
        "waktu" => $waktu,
        "late" => $late
    ];
}else{

$queryCheckFakultas="SELECT fakultas from mentee where id=$mentee_id";
$queryCheckFakultasAgenda ="SELECT tanggal_akhir,fakultas from agenda where id=$agenda_id";


$sqlFMentee=mysqli_query($conn,$queryCheckFakultas);
$sqlFAgenda=mysqli_query($conn,$queryCheckFakultasAgenda);

$rowFMentee=mysqli_fetch_array($sqlFMentee);
$rowFAgenda=mysqli_fetch_array($sqlFAgenda);

$fMentee=$rowFMentee['fakultas'];
$fAgenda=$rowFAgenda['fakultas'];

$timeAgenda=$rowFAgenda['tanggal_akhir'];



if($fMentee!=$fAgenda){
    $array["presensi_status"][]=[
        "status" => 'failed',
        "desc" => 'wrong_fac',
        "nama" => null,
        "waktu" => $waktu,
        "late" => $late
        // "mentee_id" => $mentee_id,
        // "f_agenda" => $fAgenda,
        // "f_mentee" => $fMentee
    ];
}else{

$queryCheckDuplicate ="SELECT * FROM presensi where mentee_id ='$mentee_id' AND agenda_id='$agenda_id'";
$sqlCheckDuplicate= mysqli_query($conn,$queryCheckDuplicate);

$cek = mysqli_num_rows($sqlCheckDuplicate);
if($cek >0){
    
    $array["presensi_status"][]=[
        "status" => 'failed',
        "desc" => 'duplicate_row',
        "nama" => null,
        "waktu" => $waktu,
        "late" => $late,
        // "num_rows" => $cek
    ];
}else if($cek==0){
$queryInsert = "insert into presensi (created_at,updated_at,mentee_id,agenda_id,waktu_hadir) values (now(),now(),$mentee_id,$agenda_id,now())";
$sqlInsert = mysqli_query($conn,$queryInsert);

    if($waktu>$timeAgenda){
    $late="true";
    }else{
    $late="false";
    }

if($sqlInsert){
    $array["presensi_status"][]=[
        "status" => 'success',
        "desc" => 'insert_success',
        "nama" => $nama,
        "waktu" => $waktu,
        "late" => $late,
        // "num_rows" => $cek
    ];
}else{
    $array["presensi_status"][]=[
        "status" => 'failed',
        "desc" => 'insert_failed',
        "waktu" => $waktu,
        "late" => $late
        // "num_rows" => $cek
    ];
            }
        }
    }
}
echo json_encode($array);
?>