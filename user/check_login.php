<?php
  session_start();

  include("../db_connect.php");
  $data = array();

  if(isset($_POST['username'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = "SELECT * FROM user WHERE username LIKE :username AND password LIKE :password";
    $stmt = $con -> prepare($result);
    $stmt -> bindParam(":username", $username);
    $stmt -> bindParam(":password", $password);
    $stmt -> execute();

    

    if($stmt -> rowCount() != 0){
        $objResult = $stmt -> fetch();
        if($objResult['user_active'] == 0){
          $data['status'] = 'notactive';
        }else{
          $_SESSION['user_id'] = $objResult['user_id'];
          $_SESSION['username'] = $objResult['username'];
          $_SESSION['university_id'] = $objResult['university_id'];
          $data['status'] = 'ok';
        }
    }else{
      $data['status'] = 'wrong';
    }

  }else{
    $data['status'] = 'error';
  }


  echo json_encode($data);
?>