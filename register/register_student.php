<?php
  session_start();
  include("../db_connect.php");
  $data = array();



  if(!file_exists($_FILES["studentEvidence"]["tmp_name"]) || $_POST['studentName'] == "" || $_POST['studentLevel'] == "" || $_POST['studentCourse'] == "" || !isset($_POST['studentFood'])){

    $data['status'] = 'empty';


  }else{
    $newname = "";

    //เอาชื่อไฟล์ที่มีอักขระแปลกๆออก
    $remove_these = array(' ','`','"','\'','\\','/','_');
    $newname = str_replace($remove_these, '', $_FILES["studentEvidence"]["name"]);
    $split = explode('.', $newname);

    $newname = time().".".$split[1];
    move_uploaded_file($_FILES['studentEvidence']['tmp_name'], 'fileupload/' . $newname);

    

    $studentName = $_POST['studentName'];
    $studentLevel = $_POST['studentLevel'];
    $studentCourse = $_POST['studentCourse'];
    $studentFood = $_POST['studentFood'];
    $activityId = $_POST['activityId'];
    $userId = $_POST['userId'];

    $result = "INSERT INTO register_student VALUES ('',
      :studentName, 
      :studentLevel, 
      :studentCourse, 
      :studentEvidence,
      :studentFood,
      :activityId, 
      :userId
    )";

    $stmt = $con -> prepare($result);
    $stmt -> bindParam(":studentName", $studentName);
    $stmt -> bindParam(":studentLevel", $studentLevel);
    $stmt -> bindParam(":studentCourse", $studentCourse);
    $stmt -> bindParam(":studentEvidence", $newname);
    $stmt -> bindParam(":studentFood", $studentFood);
    $stmt -> bindParam(":activityId", $activityId);
    $stmt -> bindParam(":userId", $userId);

    $stmt -> execute();
    $data['status'] = 'ok';
    
  }


  echo json_encode($data);

?>