<?php

// tell browsers what type of data return
header('Content-Type:application/json');

// '*' define all website access this api, or define custom website name inplace of '*'.  
header('Access-Control-Allow-Origin: *');

// method post
header('Access-Control-Allow-Methods: POST');

// allow access all headers(use it for security reasons).
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

/*
Authorization :- authorized to origin header.
X-Requested-With :- only ajax send request.
*/

$data = json_decode(file_get_contents("php://input"), true);
/*
"php://input" :- this can read all type of row data which is received(xml,json).
file_get_content :- takes row data(json format) which is received.
*/
require 'connect.php';
require 'function.php';


$agency_data = [];
$subjects = [];
$tutors_data = [];
$councellors = [];
$notification_data = [];
$councellor_data = [];
$result = [];

$get_city_id = $data['localCityId'];
// print_r($get_city_id);
// exit();


function getSubImg($subject) {
	global $con;

	$subj = strtok($subject, ",");

	$sub_img = "select img from subjects WHERE subject_name LIKE '%{$subj}%'";
	$sub_img_query = mysqli_query($con, $sub_img);
	$img_data = mysqli_fetch_array($sub_img_query);
	$img = $img_data['img'];
	return $img;
}

// // subjects
// $subjects_sql = "select * from subjects LIMIT 12";
// $sub_query = mysqli_query($con, $subjects_sql);
// $sub_data = mysqli_fetch_all($sub_query, MYSQLI_ASSOC);

// subjects
$subjects_sql = "select * from subjects LIMIT 12";
$sub_query = mysqli_query($con, $subjects_sql);
while($rowSub = mysqli_fetch_assoc($sub_query)){
	$sub_name = $rowSub['subject_name'];
	$sql_tutor_count = "SELECT COUNT(*) as tutor_count FROM tutor_info WHERE subjects LIKE '%$sub_name%' ";
	$tutor_count_query = mysqli_query($con, $sql_tutor_count);
	$rowSub['tutor_count'] = mysqli_fetch_assoc($tutor_count_query)['tutor_count'];
	
	$sub_data[] = $rowSub;
}

// $sub_data = mysqli_fetch_all($sub_query, MYSQLI_ASSOC);


$tutors_sql = "select * from tutor_info WHERE city = '{$get_city_id}' ORDER BY rand() LIMIT 20";
$tutors_query = mysqli_query($con, $tutors_sql);
while($rowD = mysqli_fetch_assoc($tutors_query)){
	$sub = $rowD['subjects'];
	$sub_img = getSubImg($sub);
	// print_r($sub_img);
	$rowD['img'] = $sub_img;
	$subarr = explode(',', $sub);
	$sublen = sizeof($subarr);
	$rowD['sublength'] = $sublen;
	$rowD['test'] = $get_city_id;
	
	$tutors_data[] = $rowD;
}


$agency_sql = "select * from agencynew_info WHERE city = '{$get_city_id}' ORDER BY rand()";
$agency_query = mysqli_query($con, $agency_sql);
// $agency_data = mysqli_fetch_assoc($agency_query);
while($rowD = mysqli_fetch_assoc($agency_query)){
	$sub = $rowD['subjects'];
	$sub_img = getSubImg($sub);
	// print_r($sub_img);
	$rowD['img'] = $sub_img;
	$subarr = explode(',', $sub);
	$sublen = sizeof($subarr);
	$rowD['sublength'] = $sublen;

	$city_sql = "select * from cities WHERE id = ".$rowD['city'];
	$city_query = mysqli_query($con, $city_sql);
	$rowD['cityname'] = mysqli_fetch_assoc($city_query)['name'];
	$rowD['test'] = $get_city_id;

	$agency_data[] = $rowD;
}

$notification_sql = "select * from notifications ORDER BY rand()";
$notification_query = mysqli_query($con, $notification_sql);
// $agency_data = mysqli_fetch_assoc($notification_query);
while($rowD = mysqli_fetch_assoc($notification_query)){
	$rowD['test'] = $get_city_id;
	$notification_data[] = $rowD;
}


$councellor_sql = "select * from councellor_info WEHRE city = '{$get_city_id}' ORDER BY rand()";
$councellor_query = mysqli_query($con, $councellor_sql);
// $agency_data = mysqli_fetch_assoc($councellor_query);
while($rowD = mysqli_fetch_assoc($councellor_query)){
	$rowD['test'] = $get_city_id;
	$councellor_data[] = $rowD;
}

$res = array('subjects' => $sub_data , 'tutors' => $tutors_data, 'agency' => $agency_data, 'councellors' => $councellor_data, 'notification' => $notification_data);


if($result != ''){

	echo json_encode(array('message'=>'success','status'=>201,'data'=>$res));

}else{

	echo json_encode(array('message'=>'failed','status'=>400,));

}


?>
