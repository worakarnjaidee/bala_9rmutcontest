<?php
  session_start();
  include("../db_connect.php");
  
  $data = array();

  if(isset($_POST['teacher_id'])){

    $teacher_id = $_POST['teacher_id'];
    $sql = "DELETE FROM register_teacher WHERE teacher_id = :teacher_id";
    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":teacher_id", $teacher_id);
    $stmt -> execute();

    if($stmt){
    	$data['status'] = 'ok';
    }else{
    	$data['status'] = 'error';
    }
  }else{
  	$data['status'] = 'error';
  }

  echo json_encode($data);



?>