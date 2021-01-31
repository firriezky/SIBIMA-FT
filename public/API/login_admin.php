

<?php
require_once 'connect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$responseArr['data_admin']=[];
$check_admin = mysqli_query($conn,"SELECT * from `admin` where username='$username'");
$cek = mysqli_num_rows($check_admin);

  if($cek < 0){
  $responseArr['data_admin'][]=[
    'status_login' =>'username_failure',
    'username' => NULL,
    'password' => NULL
  ];
  }else{

  $sqlPassword = mysqli_query($conn,"SELECT * FROM `admin` where username='$username'");
  $rowPassword = mysqli_fetch_array($sqlPassword);
  $hash = $rowPassword['password'];
  $password_db=$hash;


 
  if (password_verify($password,$hash)) {
    $responseArr['data_admin'][]=[
      'status_login' =>'success'
    ];
 
  } else {
    $responseArr['data_admin'][]=[
      'status_login' =>'password_failure'
    ];
  }
}


echo json_encode($responseArr);


 ?>
