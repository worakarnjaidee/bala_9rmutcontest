<?php
  session_start();
  include("../db_connect.php");
  
  $data = array();

  if(isset($_POST['executiveId'])){

    $executiveId = $_POST['executiveId'];
    $sql = "DELETE FROM executive WHERE executiveId = :executiveId";
    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":executiveId", $executiveId);
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