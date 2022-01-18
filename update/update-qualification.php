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

// $_POST = json_decode(file_get_contents("php://input"), true);

/*
"php://input" :- this can read all type of row data which is received(xml,json).
file_get_content :- takes row data(json format) which is received.
*/


require '../connect.php';
require '../function.php';

// print_r($_POST);
// exit();

$id = $_POST['id'];

$qualification =  $_POST['qualification'];
$university = $_POST['university'];
$year_from = $_POST['year_from'];
$place = $_POST['place'];

$sql = "UPDATE `tutor_qualification` SET `university`='$university',`qualification`='$qualification',`year_from`='$year',`place`='$place' WHERE id = '$id' ";

                   $query = mysqli_query($con, $sql) or die("Query Failed");

                   if($query){

                      echo json_encode(array('message'=>'success','status'=>201));

                  }else{

                      echo json_encode(array('message'=>'failed','status'=>false));

                  }
 

?>