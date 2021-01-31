

<?php
require_once 'connect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$responseArr['data_mentor']=[];

$check_admin = mysqli_query($conn,"SELECT * from `mentor` where nim='$username'");
$cek = mysqli_num_rows($check_admin);

  if($cek = 0){
  $responseArr['data_mentor'][]=[
    'status_login' =>'username_failure',
    'username' => NULL,
    'password' => NULL
  ];
  }else{

  $sqlPassword = mysqli_query($conn,"SELECT * FROM `mentor` where nim='$username'");
  $rowPassword = mysqli_fetch_array($sqlPassword);
  $hash = $rowPassword['password'];
  $password_db=$hash;


 
  if (password_verify($password,$hash)) {
    $responseArr['data_mentor'][]=[
      'status_login' =>'success',
      'id_mentor' =>$rowPassword['id'],
      'nama_mentor' =>$rowPassword['nama'],
      'nim_mentor' =>$rowPassword['nim'],
      'no_telp' =>$rowPassword['no_telp'],
      'line_id' =>$rowPassword['line_id'],
      'fakultas' =>$rowPassword['fakultas']
    ];
 
  } else {
    $responseArr['data_mentor'][]=[
      'status_login' =>'password_failure',
      'user_row' =>$cek
    ];
  }
}


echo json_encode($responseArr);


 ?>
