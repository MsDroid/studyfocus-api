<?php

// tell browsers what type of data return
header('Content-Type:application/json');

// '*' define all website access this api, or define custom website name inplace of '*'.  
header('Access-Control-Allow-Origin: *');

// method post
header('Access-Control-Allow-Methods: POST');

// allow access all headers(use it for security reasons).
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// print_r($_POST);
// exit();

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

// $fields = '*';
$state = $data['state'];
$city = $data['scity'];
// $digi = $data['digi'];
$sub = $data['subject'];

	$get_sub_name = "SELECT * from subjects where id = '{$sub}' ";
	$sub_query = mysqli_query($con, $get_sub_name) or die("Query failed");
	$row = mysqli_fetch_array($sub_query);
	$sub_name = $row['subject_name'];

$query = "SELECT * FROM tutor_info";
    $conditions = array();

    if(!empty($state)) {
      $conditions[] = "state='$state'";
    }
    if(!empty($city)) {
      $conditions[] = "city='$city'";
    }
    if(!empty($sub)) {
      $conditions[] = "subjects LIKE '%$sub_name%'";
    }
    

    $sql = $query;
    if (count($conditions) > 0) {
      $sql .= " WHERE " . implode(' AND ', $conditions);
    }

	function getSubImg($subject) {
	global $con;

	$subj = strtok($subject, ",");

	$sub_img = "select img from subjects WHERE subject_name LIKE '%{$subj}%'";
	$sub_img_query = mysqli_query($con, $sub_img);
	$img_data = mysqli_fetch_array($sub_img_query);
	$img = $img_data['img'];
	return $img;
	}

	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		while($rowD = mysqli_fetch_assoc($query)){
			$sub = $rowD['subjects'];
			$sub_img = getSubImg($sub);
			// print_r($sub_img);
			$rowD['img'] = $sub_img;
			$subarr = explode(',', $sub);
			$sublen = sizeof($subarr);
			$rowD['sublength'] = $sublen;
			$tutors_data[] = $rowD;
		}
	}

		
if($tutors_data != ''){

	echo json_encode(array('message'=>'success','status'=>201,'tutors'=>$tutors_data));

}else{

	echo json_encode(array('message'=>'success','status'=>201,'tutors'=>''));
	
}


?>
