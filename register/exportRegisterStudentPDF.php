<?php
	header('Content-Type: text/html; charset=utf-8');
	$activityId = $_GET['activityId'];
	$universityId = $_GET['universityId'];
	include("../db_connect.php");

	function ThDate(){
		//เดือนภาษาไทย
		$ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
		 
		//กำหนดคุณสมบัติ

		$months = date( "m" )-1; // ค่าเดือน (1-12)
		$day = date( "d" ); // ค่าวันที่(1-31)
		$years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.
		 
		return "<b>พิมพ์ข้อมูล ณ วันที่ $day  
				$ThMonth[$months] 
				พ.ศ. $years</b>";
	}
	
	require_once('../tcpdf/tcpdf.php');

	//กำหนดให้พิมพ์ข้อความ วันที่พิมพ์ข้อมูล
	class MYPDF extends TCPDF {
	    // Page footer
	    public function Footer() {

	        // Position at 15 mm from bottom
	        $this->SetY(-15);
	        // Set font
	        $this->SetFont('thsarabun', '', 12, '', true);
	        // Page number
	        $this->writeHTML('<p align="center">'.ThDate().'</p>');
	    }
	}
	
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('9 มทร.');
	$pdf->SetTitle('liberalarts9rmutcontest');

	//$pdf->setFontSubsetting(true);
	$pdf->SetFont('thsarabun', '', 14, '', true);
	$pdf->AddPage('P', 'A4');

	$mainContent = "";

	$activity = "SELECT * FROM activity WHERE activity_id = :activity_id";
	$stmt = $con -> prepare($activity);
	$stmt -> bindParam(":activity_id", $activityId);
	$stmt -> execute();
	$resultActivity = $stmt -> fetch();


	$university = "SELECT * FROM university WHERE university_id = :university_id";
	$stmt2 = $con -> prepare($university);
	$stmt2 -> bindParam(":university_id", $universityId);
	$stmt2 -> execute();
	$resultUniversityName = $stmt2 -> fetch();

	$content = '
		<div class="container">
			<div align="center">
				<img src="../assets/img/banner.png" width="300px">
			</div>
			<div align="center" style="font-size: 14pt;">
				<b>ใบสมัคร'.$resultActivity['activityName'].' </b><br> 
				<b>กิจกรรม '.$resultActivity['activityDetail'].'  </b><br>
				<b>โครงการ "การสัมมนาและการแข่งขันทักษะทางวิชาการด้านศิลปศาสตร์ของ 9 มทร. ครั้งที่ 8" </b><br>
				<b>ระหว่างวันที่ 28 กุมภาพันธ์ - 1 มีนาคม 2567 </b><br>
				<b>ณ คณะบริหารธุรกิจและศิลปศาสตร์ มหาวิทยาลัยเทคโนโลยีราชมงคลล้านนา เชียงใหม่ </b><br>
				<b>--------------------------------------------------------------------------------------------</b><br>
			</div>

			<div>
				<b>ชื่อหน่วยงาน : </b> '.$resultUniversityName['university_name'].' <br>
				<b>รายชื่อนักศึกษาเข้าร่วมการแข่งขัน</b> <br>
				<table width="100%" cellpadding="2" border="1">
					<tr>
						<th align="center" width="10%"><b>ลำดับที่</b></th>
						<th align="center" width="40%"><b>ชื่อ-สกุล</b></th>
						<th align="center" width="10%"><b>ชั้นปี</b></th>
						<th align="center" width="40%"><b>หลักสูตร/สาขา</b></th>
					</tr>
	';

	$result = "SELECT * FROM register_student INNER JOIN activity ON activity.activity_id = register_student.activity_id INNER JOIN user ON user.user_id = register_student.user_id INNER JOIN university ON university.university_id = user.university_id WHERE activity.activity_id = :activity_id AND university.university_id = :university_id";

	$stmt3 = $con -> prepare($result);
	$stmt3 -> bindParam(":activity_id", $activityId);
	$stmt3 -> bindParam(":university_id", $universityId);
	$stmt3 -> execute();

	$i = 1;
	while ($row = $stmt3->fetch()) {
		$content .= '<tr>
				<td align="center">'.$i.'</td>
				<td>'.$row['student_name'].'</td>
				<td align="center">'.$row['student_level'].'</td>
				<td>'.$row['student_course'].'</td>
			</tr>';
		$i++;
	}

	$content .= $mainContent;
	$content .= '
				</table>
			</div>

			<div>
				<b>อาจารย์ผู้ควบคุม/ประสานงาน</b> <br>
			
			<table width="100%" cellpadding="2" border="1">
				<tr>
					<th align="center" width="10%"><b>ลำดับที่</b></th>
					<th align="center" width="30%"><b>ชื่อ-สกุล</b></th>
					<th align="center" width="10%"><b>ตำแหน่ง</b></th>
					<th align="center" width="15%"><b>เบอร์โทร</b></th>
					<th align="center" width="35%"><b>อีเมล์</b></th>
				</tr>
			';


	$result = "SELECT * FROM register_teacher INNER JOIN activity ON activity.activity_id = register_teacher.activity_id INNER JOIN user ON user.user_id = register_teacher.user_id INNER JOIN university ON university.university_id = user.university_id WHERE activity.activity_id = :activity_id AND university.university_id = :university_id";
	$stmt4 = $con -> prepare($result);
	$stmt4 -> bindParam(":activity_id", $activityId);
	$stmt4 -> bindParam(":university_id", $universityId);
	$stmt4 -> execute();
	$i = 1;
	while ($row = $stmt4->fetch()) {
			$content .= '
			<tr>
				<td align="center">'.$i.'</td>
				<td>'.$row['teacher_name'].'</td>
				<td align="center"> '.$row['teacher_position'].'</td>
				<td align="center"> '.$row['tel'].'</td>
				<td>'.$row['email'].'</td>
			</tr>
			';
			$i++;
	}

	$content .=	'

			</table>
	</div>

			<div>
				<b><u>หมายเหตุ</u></b> <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;นักศึกษาที่สมัครเข้าร่วมแข่งขันฯ ขอความอนุเคราะห์แนบสำเนาบัตรนักศึกษาและสำเนาบัตรประจำตัวประชาชน<br>  
				&nbsp;&nbsp; (สำหรับการสมัครในบางกิจกรรม ให้แนบผลการลงทะเบียนในภาคการศึกษาปัจจุบันด้วย)<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$resultActivity['activityCoordinate'].'<br>
			</div>
				
						';

		$content .= $mainContent;

		$content .= '
				
		</div>';

	ob_end_clean();

	$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);

	$pdf->Output(__DIR__ . '/fileupload/'.$activityId.'_liberalarts9rmutcontest.pdf', 'F');


	header( "location: ../exportSummaryRegister.php?activityId=".$activityId."&universityId=".$universityId."" );

?>


