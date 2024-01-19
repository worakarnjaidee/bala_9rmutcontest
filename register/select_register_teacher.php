<?php
  session_start();
  include("../db_connect.php");

  
  $data = array();

  if(isset($_POST['teacher_id'])){

    $teacher_id = $_POST['teacher_id'];
    $sql = "SELECT * FROM register_teacher WHERE teacher_id = :teacher_id";
    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":teacher_id", $teacher_id);

    $stmt -> execute();

    if($stmt -> rowCount() > 0){
        $registerTeacher = $stmt -> fetch();
        $data['result'] = $registerTeacher;
        $data['status'] = 'ok';
    }else{
    	$data['result'] = '';
      $data['status'] = 'error';
    }
    
  }

  echo json_encode($data);



?>