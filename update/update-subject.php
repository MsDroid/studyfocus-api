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

$id = $_POST['tut_id'];
$subject =  $_POST['subject'];
$medium =  $_POST['medium'];
$state_name =  $_POST['state'];
$scity = $_POST['scity'];
$cls = $_POST['cls'];
$board = $_POST['board'];

$get_state_id = "SELECT id from states where name LIKE '%{$state_name}%'";
   $state_query = mysqli_query($con, $get_state_id) or die("Query failed");
   $row = mysqli_fetch_array($state_query);
   $state = $row['id'];


$sql = "UPDATE `tutor_info` SET `class`='$cls',`subjects`='$subject',`board`='$board',`medium`='$medium',`state`='$state',`city`='$scity' WHERE id = $id";

                   $query = mysqli_query($con, $sql) or die("Query Failed");

                   if($query){

                      echo json_encode(array('message'=>'success','status'=>201));

                  }else{

                      echo json_encode(array('message'=>'failed','status'=>false));

                  }
 

?>