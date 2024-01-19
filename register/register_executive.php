<?php
  session_start();
  include("../db_connect.php");
  $data = array();


  if($_POST['executivePosition'] == "" || $_POST['executiveTitleName'] == "" || $_POST['executiveName'] == "" || $_POST['executiveTel'] == "" || $_POST['executiveFood'] == ""){

    $data['status'] = 'empty';
    

  }else{
    $executivePosition = $_POST['executivePosition'];
    $executiveTitleName = $_POST['executiveTitleName'];
    $executiveName = $_POST['executiveName'];
    $executiveTel = $_POST['executiveTel'];
    $executiveFood = $_POST['executiveFood'];
    $userId = $_POST['userId'];

    $sql = "INSERT INTO executive VALUES ('', 
      :executivePosition, 
      :executiveTitleName, 
      :executiveName, 
      :executiveTel,
      :executiveFood,
      :userId)";

    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":executivePosition", $executivePosition);
    $stmt -> bindParam(":executiveTitleName", $executiveTitleName);
    $stmt -> bindParam(":executiveName", $executiveName);
    $stmt -> bindParam(":executiveTel", $executiveTel);
    $stmt -> bindParam(":executiveFood", $executiveFood);
    $stmt -> bindParam(":userId", $userId);

    $stmt -> execute();

    if($stmt){
      $data['status'] = 'ok';
    }else{
      $data['status'] = 'error';
    }

    
  }


  echo json_encode($data);

?>