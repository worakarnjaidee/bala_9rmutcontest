<?php
  session_start();
  include("../db_connect.php");
  $data = array();

  if(isset($_POST['register_id'])){
    $register_id = $_POST['register_id'];
    $sql = "DELETE FROM register_student WHERE register_id = :register_id";
    $stmt = $con -> prepare($sql);
    $stmt -> bindParam("register_id", $register_id);
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