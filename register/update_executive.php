<?php
  session_start();
  include("../db_connect.php");

  $data = array();

  if(isset($_POST['executiveId'])){

    $executivePosition = $_POST['executivePosition'];
    $executiveTitleName = $_POST['executiveTitleName'];
    $executiveName = $_POST['executiveName'];
    $executiveTel = $_POST['executiveTel'];
    $executiveFood = $_POST['executiveFood'];
    $executiveId = $_POST['executiveId'];

    $sql = "UPDATE executive SET executivePosition = :executivePosition,
    executiveTitleName = :executiveTitleName,
    executiveName = :executiveName,
    executiveTel = :executiveTel,
    executiveFood = :executiveFood WHERE executiveId = :executiveId";

    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":executivePosition", $executivePosition);
    $stmt -> bindParam(":executiveTitleName", $executiveTitleName);
    $stmt -> bindParam(":executiveName", $executiveName);
    $stmt -> bindParam(":executiveTel", $executiveTel);
    $stmt -> bindParam(":executiveFood", $executiveFood);
    $stmt -> bindParam(":executiveId", $executiveId);

    $stmt -> execute();

    if($stmt){
      $data["status"] = "ok";
    }else{
      $data["status"] = "error";
    }
    
    
  }else{
    $data["status"] = "empty";
  }



  echo json_encode($data);

?>