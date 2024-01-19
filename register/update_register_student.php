<?php
  session_start();
  include("../db_connect.php");

  $data = array();

  $newname = "";

  $studentName = $_POST['editRegisterName'];
  $studentLevel = $_POST['editRegisterLevel'];
  $studentCourse = $_POST['editRegisterCourse'];
  $studentFood = $_POST['editStudentFood'];
  $register_id = $_POST['register_id'];


  if($_FILES["editRegisterEvidence"]["name"] != ""){

    //เอาชื่อไฟล์ที่มีอักขระแปลกๆออก
    $remove_these = array(' ','`','"','\'','\\','/','_');
    $newname = str_replace($remove_these, '', $_FILES["editRegisterEvidence"]["name"]);
    $split = explode('.', $newname);

    $newname = time().".".$split[1];
    move_uploaded_file($_FILES['editRegisterEvidence']['tmp_name'], 'fileupload/'.$newname);
    
  }


  $insertFile = "";
  if($newname != ""){

    $sql = "UPDATE register_student SET student_name = :studentName,
    student_level = :studentLevel,
    student_course = :studentCourse,
    student_food = :studentFood,
    student_evidence = :studentEvidence 
    WHERE register_id = :register_id";

    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":studentName", $studentName);
    $stmt -> bindParam(":studentLevel", $studentLevel);
    $stmt -> bindParam(":studentCourse", $studentCourse);
    $stmt -> bindParam(":studentFood", $studentFood);
    $stmt -> bindParam(":studentEvidence", $newname);
    $stmt -> bindParam(":register_id", $register_id);

     $stmt -> execute();

  }else{
    $sql = "UPDATE register_student SET student_name = :studentName,
    student_level = :studentLevel,
    student_course = :studentCourse,
    student_food = :studentFood
    WHERE register_id = :register_id";
  
    $stmt = $con -> prepare($sql);
    $stmt -> bindParam(":studentName", $studentName);
    $stmt -> bindParam(":studentLevel", $studentLevel);
    $stmt -> bindParam(":studentCourse", $studentCourse);
    $stmt -> bindParam(":studentFood", $studentFood);
    $stmt -> bindParam(":register_id", $register_id);

    $stmt -> execute();
  }



  $data["status"] = "ok";

  echo json_encode($data);

?>