<?php
  session_start();
  include("../db_connect.php");
  $data = array();

  if(isset($_POST["teacher_id"])){

    $teacher_id = $_POST['teacher_id'];
    $teacher_name = $_POST['teacher_name'];
    $teacher_position = $_POST['teacher_position'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $teacher_food = $_POST['teacher_food'];

    $sql = "UPDATE register_teacher SET teacher_name = :teacher_name,
    teacher_position = :teacher_position,
    tel = :tel,
    email = :email,
    teacher_food = :teacher_food WHERE teacher_id = :teacher_id";

    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":teacher_name", $teacher_name);
    $stmt -> bindParam(":teacher_position", $teacher_position);
    $stmt -> bindParam(":tel", $tel);
    $stmt -> bindParam(":email", $email);
    $stmt -> bindParam(":teacher_food", $teacher_food);
    $stmt -> bindParam(":teacher_id", $teacher_id);

    $stmt -> execute();
    if($stmt){
      $data["status"] = "ok";
    }else{
      $data["status"] = "error";
    }
    
    
  }else{
    $data["status"] = "error";
  }

  echo json_encode($data);

?>