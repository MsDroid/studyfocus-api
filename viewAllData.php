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


$institutes = [];
$subjects = [];
$tutors = [];
$result = [];

// $search = $data['search'];

// institute
// $institute_sql = "select * from agency_info";
// $ins_query = mysqli_query($con, $institute_sql);
// $ins_data = mysqli_fetch_all($ins_query, MYSQLI_ASSOC);
// array_push($institutes, $ins_data);
// array_push($result, array('institute' => $institutes ));

// subjects
// $subjects_sql = "select * from subjects LIMIT 9";
// $sub_query = mysqli_query($con, $subjects_sql);
// $sub_data = mysqli_fetch_all($sub_query, MYSQLI_ASSOC);
// array_push($subjects, $sub_data);
// array_push($result, array('subjects' => $subjects ));

// tutors
$tutors_sql = "select * from tutor_info";
$tutors_query = mysqli_query($con, $tutors_sql);
$tutors_data = mysqli_fetch_all($tutors_query, MYSQLI_ASSOC);
// array_push($tutors, $tutors_data);
// array_push($result, array('tutor' => $tutors ));

$tutors_sql = "select * from agency_info";
$tutors_query = mysqli_query($con, $tutors_sql);
$agency_data = mysqli_fetch_all($tutors_query, MYSQLI_ASSOC);
// array_push($institutes, $tutors_data);
// array_push($result, array('ins' => $institutes ));

$res = array('tutors' => $tutors_data, 'agency' => $agency_data);


if($res != ''){

	echo json_encode(array('message'=>'success','status'=>201,'data'=>$res));

}else{

	echo json_encode(array('message'=>'failed','status'=>400,));

}


?>
