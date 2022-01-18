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

$city_name = $data['city_name'];
$sub_name = $data['sub_name'];

$get_city_id = "select * from cities WHERE name = '$city_name' ";
$get_city_query = mysqli_query($con, $get_city_id);
$row_city_query = mysqli_fetch_assoc($get_city_query);
$city_id = $row_city_query['id'];

if($city_name == "India"){
	$city_id = '0';
}



// print_r($city_id);
// exit();

// tutors
// $tutors_sql = "select * from tutor_info";
// $tutors_query = mysqli_query($con, $tutors_sql);
// $tutors_data = mysqli_fetch_all($tutors_query, MYSQLI_ASSOC);

function getSubImg($subject) {
	global $con;

	$subj = strtok($subject, ",");

	$sub_img = "select img from subjects WHERE subject_name LIKE '%{$subj}%'";
	$sub_img_query = mysqli_query($con, $sub_img);
	$img_data = mysqli_fetch_array($sub_img_query);
	$img = $img_data['img'];
	return $img;
}

if($city_id === '0' && $sub_name === undefined){
	$tutors_sql = "select * from tutor_info ORDER BY rand() LIMIT 50";
}else if($city_id !== '0' && $sub_name !== undefined){
	$tutors_sql = "select * from tutor_info WHERE city = {$city_id} && subjects LIKE '%$sub_name%' ORDER BY rand() LIMIT 5";
}
else{
	$tutors_sql = "select * from tutor_info WHERE city = {$city_id} ORDER BY rand() LIMIT 50";
}
// exit();

// $tutors_sql = "select * from tutor_info WHERE city = '{$city_id}' ORDER BY rand() LIMIT 50";

$tutors_query = mysqli_query($con, $tutors_sql);
while($rowD = mysqli_fetch_assoc($tutors_query)){
	$sub = $rowD['subjects'];
	$sub_img = getSubImg($sub);
	// print_r($sub_img);
	$rowD['img'] = $sub_img;
	$subarr = explode(',', $sub);
	$sublen = sizeof($subarr);
	$rowD['sublength'] = $sublen;
	$tutors_data[] = $rowD;
}

$res = array('tutors' => $tutors_data);

if($res != ''){

	echo json_encode(array('message'=>'success','status'=>201,'data'=>$res));

}else{

	echo json_encode(array('message'=>'failed','status'=>400,));

}


?>
