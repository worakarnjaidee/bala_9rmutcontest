<?php
  session_start();
  include("../db_connect.php");
  
  $data = array();
  if(isset($_POST['executiveId'])){
    
    $executiveId = $_POST['executiveId'];

    $sql = "SELECT * FROM executive WHERE executiveId = :executiveId";
    $stmt = $con -> prepare($sql);

    $stmt -> bindParam(":executiveId", $executiveId);
    $stmt -> execute();

    if($stmt -> rowCount() > 0){
        $executive = $stmt->fetch();
        $data['result'] = $executive;
        $data['status'] = 'ok';
    }else{
    	$data['result'] = '';
      $data['status'] = 'error';
    }
    
  }

  echo json_encode($data);



?>