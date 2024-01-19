<?php

  session_start();
  include("../db_connect.php");
  $data = array();

  if(isset($_POST['user_id'])){

    $userId = $_POST['user_id'];
    $activityOptionId = $_POST['activityOptionId'];

    $queryCheck = "SELECT * FROM activity_option_answer WHERE user_id = :user_id AND activityOptionId = :activityOptionId"; 

    $stmt = $con -> prepare($queryCheck);
    $stmt -> bindParam(":user_id", $userId);
    $stmt -> bindParam(":activityOptionId", $activityOptionId);

    $stmt -> execute();

    if($stmt -> rowCount() != 0){

      $answer = $_POST['answer'];

      $sql = "UPDATE activity_option_answer SET answer = :answer WHERE user_id = :user_id AND  activityOptionId = :activityOptionId";
      $stmt = $con -> prepare($sql);
      $stmt -> bindParam(":answer", $answer);
      $stmt -> bindParam(":user_id", $userId);
      $stmt -> bindParam(":activityOptionId", $activityOptionId);

      $stmt -> execute();
      if($stmt){
        $data["status"] = "ok";
      }else{
        $data["status"] = "error";
      }
      

    }else{
      $answer = $_POST['answer'];

      $sql = "INSERT INTO activity_option_answer (answer, activityOptionId, user_id) VALUES (:answer, :activityOptionId, :user_id)";

      $stmt = $con -> prepare($sql);
      $stmt -> bindParam(":answer", $answer);
      $stmt -> bindParam(":user_id", $userId);
      $stmt -> bindParam(":activityOptionId", $activityOptionId);
      $stmt -> execute();

      if($stmt){
        $data["status"] = "ok";
      }else{
        $data["status"] = "error";
      }
    }


  }else{
    $data["status"] = "error";
  }



  echo json_encode($data);

?>