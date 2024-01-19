<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<?php
header('Content-Type: text/html; charset=utf-8');
$activityId = $_GET['activityId'];
$universityId = $_GET['universityId']; 

include 'PDFMerger.php';

use PDFMerger\PDFMerger;
$pdf = new PDFMerger;

$pdf->addPDF('register/fileupload/'.$activityId.'_liberalarts9rmutcontest.pdf', 'all');

include("db_connect.php");
	
	$activityName = "";
	$sql = "SELECT * FROM register_student INNER JOIN activity ON activity.activity_id = register_student.activity_id INNER JOIN user ON user.user_id = register_student.user_id INNER JOIN university ON university.university_id = user.university_id WHERE activity.activity_id = :activity_id AND university.university_id = :university_id";

	$stmt = $con -> prepare($sql);
	$stmt -> bindParam(":activity_id", $activityId);
	$stmt -> bindParam(":university_id", $universityId);

	$stmt -> execute();

	while ($row = $stmt->fetch()) {
		$pdf->addPDF('register/fileupload/'.$row["student_evidence"].'','all');
		$activityName = $row['activityName'];
	}

ob_end_clean();

$name = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $activityName);
$pdf->merge('browser', 'Activity-'.$name.'.pdf');
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.
?>