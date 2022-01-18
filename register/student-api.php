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

// print_r($_POST);
// exit();

require '../connect.php';
require '../function.php';


$name = $data['name'];
// $class = $data['class'];
$email = $data['email'];
// $password = $data['password'];
$mobile = $data['phone'];
// $stu_subjects = $data['stu_subjects'];
// $tran_date = date("Y-m-d H:i:s");
// $state = $data['state'];
// $city = $data['city'];
$trn_date = date("Y-m-d H:i:s");
// print_r($stu_name);
// print_r($email);
// print_r($password);
// print_r($stu_mobile);
// exit();

$sql_count = "SELECT id FROM student WHERE mobile = '{$mobile}' OR email = '{$email}'";
    $query_count = mysqli_query($con, $sql_count) or die("Query failed");
    $count = mysqli_num_rows($query_count);
    $userId = mysqli_fetch_assoc($query_count)['id'];
   
if($count > 0){
       echo json_encode(array('message'=>'User already exists','status'=>201, 'userId' => $userId));

}else{
    // new user insert
    $sql = "INSERT INTO `student`(`name`, `email`, `mobile`, `trn_date`) VALUES ('$name','$email','$mobile','$trn_date')";
    $query = mysqli_query($con, $sql);

    if($query){

        $get_user = "SELECT id FROM student WHERE mobile = '{$mobile}' && email = '{$email}'";
        $get_query = mysqli_query($con, $get_user) or die("Query failed");
        $userId = mysqli_fetch_assoc($get_query)['id'];


       echo json_encode(array('message'=>'success','status'=>201, 'userId' => $userId));

   }else{

       echo json_encode(array('message'=>'failed','status'=>false));

   }

}
   
?>