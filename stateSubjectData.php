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

// $data = json_decode(file_get_contents("php://input"), true);
/*
"php://input" :- this can read all type of row data which is received(xml,json).
file_get_content :- takes row data(json format) which is received.
*/
require 'connect.php';
require 'function.php';



// function getSubImg($subject) {
// 	global $con;

// 	$subj = strtok($subject, ",");

// 	$sub_img = "select img from subjects WHERE subject_name LIKE '%{$subj}%'";
// 	$sub_img_query = mysqli_query($con, $sub_img);
// 	$img_data = mysqli_fetch_array($sub_img_query);
// 	$img = $img_data['img'];
// 	return $img;
// }

// subjects
$subjects_sql = "select * from subjects";
$sub_query = mysqli_query($con, $subjects_sql);
$sub_data = mysqli_fetch_all($sub_query, MYSQLI_ASSOC);

// placement
// $placement_sql = "select * from placement_area";
// $placement_query = mysqli_query($con, $placement_sql);
// $placement_data = mysqli_fetch_all($placement_query, MYSQLI_ASSOC);

// states
$states_sql = "select * from states";
$state_query = mysqli_query($con, $states_sql);
$state_data = mysqli_fetch_all($state_query, MYSQLI_ASSOC);

// medium
// $medium_sql = "select * from medium";
// $sub_query_medium = mysqli_query($con, $medium_sql);
// $medium = mysqli_fetch_all($sub_query_medium, MYSQLI_ASSOC);

// //boards
// $board_sql = "select * from board";
// $sub_query_board = mysqli_query($con, $board_sql);
// $board = mysqli_fetch_all($sub_query_board, MYSQLI_ASSOC);

// //classes
// $class_sql = "select * from class";
// $sub_query_class = mysqli_query($con, $class_sql);
// $cls = mysqli_fetch_all($sub_query_class, MYSQLI_ASSOC);

// //platform
// $platform_sql = "select * from teach_platform";
// $sub_query_platform = mysqli_query($con, $platform_sql);
// $platform = mysqli_fetch_all($sub_query_platform, MYSQLI_ASSOC);


$res = array('subjects' => $sub_data, 'states' => $state_data);


if($res != ''){

	echo json_encode(array('message'=>'success','status'=>201,'data'=>$res));

}else{

	echo json_encode(array('message'=>'failed','status'=>400,));

}


?>
