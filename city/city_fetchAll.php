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
require '../connect.php';
require '../function.php';

$state_id = $_GET['state'];
// echo json_decode($state_id);
// exit();

$fields = '*';
$table = 'cities';

$blogs = stateCity($fields, $table, $state_id);

if($blogs != ''){

	echo json_encode(array('message'=>'success','status'=>200,'data'=>$blogs));

}else{

	echo json_encode(array('message'=>'failed','status'=>400,));

}


?>
