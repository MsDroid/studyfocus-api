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
require '../connect.php';
require '../function.php';

$cname = $data['sub_name'];
// print_r($cname);
// exit();

$get_state_id = "SELECT * FROM subjects WHERE subject_name = '$cname'";
$run_query = mysqli_query($con, $get_state_id);
$row = mysqli_fetch_assoc($run_query);


if($row != ''){

	echo json_encode(array('message'=>'success','status'=>200,'data'=>$row));

}else{

	echo json_encode(array('message'=>'failed','status'=>400,));

}


?>
