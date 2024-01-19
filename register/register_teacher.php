<?php
  session_start();
  include("../db_connect.php");

  $data = array();


  if(isset($_POST['teacherName'])){

    $teacherName = $_POST['teacherName'];
    $teacherPosition = $_POST['teacherPosition'];
    $teacherTel = $_POST['teacherTel'];
    $teacherEmail = $_POST['teacherEmail'];
    $teacherFood = $_POST['teacherFood'];
    $userId = $_POST['userId'];
    $activityId = $_POST['activityId'];

    $sql = "INSERT INTO register_teacher VALUES ('', 
      :teacherName, 
      :teacherPosition, 
      :teacherTel, 
      :teacherEmail,
      :teacherFood,
      :activityId, 
      :userId)";

    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":teacherName", $teacherName);
    $stmt -> bindParam(":teacherPosition", $teacherPosition);
    $stmt -> bindParam(":teacherTel", $teacherTel);
    $stmt -> bindParam(":teacherEmail", $teacherEmail);
    $stmt -> bindParam(":teacherFood", $teacherFood);
    $stmt -> bindParam(":userId", $userId);
    $stmt -> bindParam(":activityId", $activityId);

    $stmt -> execute();

    if($stmt){
      $data['status'] = 'ok';
    }else{
      $data['status'] = 'error';
    }
    

  }else{
    $data['status'] = 'empty';
  }


  echo json_encode($data);

?>