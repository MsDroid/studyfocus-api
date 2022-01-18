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

// print_r($_POST);
// exit();

require '../connect.php';
require '../function.php';

// print_r($_POST);
// exit();

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$msg = $_POST['msg'];

$trn_date = date("Y-m-d");

    $sql = "INSERT INTO `enquiry`(`name`, `email`, `subject`, `msg`, `trn_date`) VALUES ('$name','$email','$subject','$msg','$trn_date')";

    $query = mysqli_query($con, $sql);

    if($query){

       echo json_encode(array('message'=>'success','status'=>201));

   }else{

       echo json_encode(array('message'=>'failed','status'=>false));

   }


   
?>