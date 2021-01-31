

<?php
include 'connect.php';


$nim = $_POST['username'];
$password = $_POST['password'];

// $nim='1202184200';
// $password='mentee123';

// $nim=$_POST['nim'];
// $password=$_POST['password'];
$responseArr=new \stdClass();
$responseCred=new \stdClass();

 // this password inputed by user;

$check_nim = mysqli_query($conn,"select * from `mentee` where nim='$nim'");
$cek = mysqli_num_rows($check_nim);

if($cek < 0){
      $responseArr-> nim =NULL;
      $responseArr-> nama =NULL;
      $responseArr-> status_login ='username_failure';
}else{
  $queryPassword = mysqli_query($conn,"select a.password,a.id,a.nim,a.nama,a.fakultas,a.program_studi,c.kode,b.nama as 'nama_mentor',b.line_id,b.no_telp ,a.line_id,a.no_telp
from mentee a left join kelompok c on a.kelompok_id=c.id
left join kelompok on a.kelompok_id=kelompok.id
left join mentor b on kelompok.mentor_id=b.id
where a.nim=$nim;");
  $getCredential = mysqli_fetch_row($queryPassword);
  $hash = $getCredential[0];
  $id = $getCredential[1];
  $nim = $getCredential[2];
  $nama = $getCredential[3];
  $fakultas = $getCredential[4]; 
  $jurusan = $getCredential[5];
  $kelompok = $getCredential[6];
  $nama_mentor = $getCredential[7];
  $line_mentor = $getCredential[8];
  $telp_mentor = $getCredential[9];

  $line_mentee = $getCredential[10];
  $telp_mentee = $getCredential[11];

  if (password_verify($password, $hash)) {
    $responseArr-> status_login ='success';
    $responseArr-> nama =$nama;
    $responseArr-> nim =$nim;
    $responseArr-> password =$hash;
    $responseArr-> id =$id;
    $responseArr-> fakultas =$fakultas;
    $responseArr-> jurusan =$jurusan;
    $responseArr-> kode_kelompok =$kelompok;
    $responseArr-> mentor =$nama_mentor;
    $responseArr-> line_mentor =$line_mentor;
    $responseArr-> telp_mentor =$telp_mentor;
    $responseArr-> line_mentee =$line_mentee;
    $responseArr-> telp_mentee =$telp_mentee;
  } else {
    $responseArr-> nim =NULL;
    $responseArr-> nama =NULL;
    $responseArr-> status_login ='password_failure';
  }
}
// $responseCred-> name ='SIBIMA API';
// $responseCred-> ver ='1.0';
// $responseCred-> developer ='Henry Augusta';

echo json_encode($responseArr);
// echo ",";
// echo json_encode($responseCred);

 ?>
