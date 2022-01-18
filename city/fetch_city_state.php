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

$state_id = $data['sta_id'];
// print_r($state_id);
// exit();

$get_cities = "SELECT * FROM cities WHERE state_id = '$state_id'";
$run_query = mysqli_query($con, $get_cities);
while($rowD = mysqli_fetch_assoc($run_query)){
$cities[] = $rowD;
}

$res = array('getcities' => $cities);

if($res != ''){

	echo json_encode(array('message'=>'success','status'=>200,'data'=>$res));

}else{

	echo json_encode(array('message'=>'failed','status'=>400,));

}


?>
