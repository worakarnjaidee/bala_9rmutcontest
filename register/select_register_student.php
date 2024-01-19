<?php
  session_start();
  include("../db_connect.php");
  
  $data = array();
  if(isset($_POST['register_id'])){
    
    $register_id = $_POST['register_id'];
    $sql = "SELECT * FROM register_student WHERE register_id = :register_id";
    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":register_id", $register_id);
    $stmt -> execute();
    if($stmt -> rowCount() > 0){
        $registerStuent = $stmt->fetch();
        $data['result'] = $registerStuent;
        $data['status'] = 'ok';
    }else{
    	$data['result'] = '';
      $data['status'] = 'error';
    }
    
  }

  echo json_encode($data);



?>