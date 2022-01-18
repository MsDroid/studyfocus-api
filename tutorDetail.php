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
$related_subjects = [];

$slug = $data['tutor_slug'];
// tutors
$tutors_sql = "select * from tutor_info WHERE slug = '${slug}' ";
$tutors_query = mysqli_query($con, $tutors_sql);
$tutors_data = mysqli_fetch_all($tutors_query, MYSQLI_ASSOC);
$tutor_id = $tutors_data[0]['id'];
$city_id = $tutors_data[0]['city'];
$state_id = $tutors_data[0]['state'];


$get_qualification = "select * from tutor_qualification WHERE tutor_id = '${tutor_id}' ";
$get_qual_query = mysqli_query($con, $get_qualification);
$qualification = mysqli_fetch_all($get_qual_query, MYSQLI_ASSOC);

$get_sub_sql = "select subjects from tutor_info WHERE slug = '${slug}' ";
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



$rel_tutor = "select t.f_name as tutor_name,t.slug as slug,t.profile as profile,t.count as count, s.name as state_name, c.name as city_name from tutor_info as t INNER JOIN states AS s ON t.state = s.id INNER JOIN cities AS c ON t.city = c.id ORDER BY RAND() LIMIT 3";
$sub_query = mysqli_query($con, $rel_tutor);
$rel_tutor_data = mysqli_fetch_all($sub_query, MYSQLI_ASSOC);

$rating_sql = "select * from rating WHERE tutor_id = '$tutor_id' ORDER BY RAND() LIMIT 3";
$rate_query = mysqli_query($con, $rating_sql);
$rate_data = mysqli_fetch_all($rate_query, MYSQLI_ASSOC);

$avg_rating_sql = "select AVG(rating) from rating WHERE tutor_id = '$tutor_id'";
$rate_avg_query = mysqli_query($con, $avg_rating_sql);
$avg_rating = mysqli_fetch_assoc($rate_avg_query)['AVG(rating)'];
$avg = number_format((float)$avg_rating, 1, '.', '');

$city_sql = "select name from cities WHERE id = '$city_id'";
$city_query = mysqli_query($con, $city_sql);
$city = mysqli_fetch_assoc($city_query)['name'];

$state_sql = "select name from states WHERE id = '$state_id'";
$state_query = mysqli_query($con, $state_sql);
$state = mysqli_fetch_assoc($state_query)['name'];


// $rel_subjects = array('related_subjects' => $sub_data );

$res = array('tutors' => $tutors_data, 'related_subjects' => $sub_data, 'rel_tutor' => $rel_tutor_data, 'qualification' => $qualification, 'rating' => $rate_data, 'avg_rating' => $avg , 'city' => $city, 'state' => $state);

if($res != ''){

	echo json_encode(array('message'=>'success','status'=>201,'data'=>$res));

}else{

	echo json_encode(array('message'=>'failed','status'=>400));

}


?>
