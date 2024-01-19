<?php 


function convert_dateTH($dateEN){

	$monthTH = array("01"=>"ม.ค.", "02"=>"ก.พ.", "03"=>"มี.ค.", "04"=>"เม.ย.", "05"=>"พ.ค.", "06"=>"มิ.ย.", "07"=>"ก.ค.", "08"=>"ส.ค.", "09"=>"ก.ย.", "10"=>"ต.ค.", "11"=>"พ.ย.", "12"=>"ธ.ค.");
	$date_en = $dateEN;
	$e = explode("-", $date_en);
	return $e[2]."/".$monthTH[$e[1]]."/".($e[0]+543);

}


?>