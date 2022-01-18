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

$tutors = [];

$slug = $data['agency_slug'];
// tutors
$tutors_sql = "select * from agency_info WHERE slug = '${slug}' ";
$tutors_query = mysqli_query($con, $tutors_sql);
$tutors_data = mysqli_fetch_all($tutors_query, MYSQLI_ASSOC);

$get_sub_sql = "select subjects from agency_info WHERE slug = '${slug}' ";
$get_sub_query = mysqli_query($con, $get_sub_sql);
$sub = mysqli_fetch_all($get_sub_query, MYSQLI_ASSOC);

$subject = $sub[0]['subjects'];
$subj = strtok($subject, ",");

$sub_img = "select img from subjects WHERE subject_name LIKE '%{$subj}%'";
$sub_img_query = mysqli_query($con, $sub_img);
$img_data = mysqli_fetch_array($sub_img_query);
$img = $img_data['img'];

// array_push($tutors_data, $img_data);
$tutors_data[0]['img'] = $img;

$subjects_sql = "select * from subjects ORDER BY RAND() LIMIT 3";
$sub_query = mysqli_query($con, $subjects_sql);
$sub_data = mysqli_fetch_all($sub_query, MYSQLI_ASSOC);

$rel_tutor = "select * from tutor_info ORDER BY RAND() LIMIT 3";
$sub_query = mysqli_query($con, $rel_tutor);
$rel_tutor_data = mysqli_fetch_all($sub_query, MYSQLI_ASSOC);


$res = array('agency' => $tutors_data, 'related_subjects' => $sub_data, 'rel_tutor' => $rel_tutor_data);

if($res != ''){

	echo json_encode(array('message'=>'success','status'=>201,'data'=>$res));

}else{

	echo json_encode(array('message'=>'failed','status'=>400,));

}


?>
