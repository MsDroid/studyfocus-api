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

$_POST = json_decode(file_get_contents("php://input"), true);

/*
"php://input" :- this can read all type of row data which is received(xml,json).
file_get_content :- takes row data(json format) which is received.
*/


require '../connect.php';
require '../function.php';

// print_r($_POST);
// exit();

$tutor_id = $_POST['tutor_id'];
$rating =  $_POST['rating'];
$review =  $_POST['review'];
$user_id = $_POST['user_id'];
$trn_date = date("Y-m-d");

// print_r($tutor_id);
// print_r($rating);
// print_r($user_id);
// print_r($trn_date);
// exit();

$sql_count = "SELECT * FROM rating WHERE user_id = '{$user_id}' AND tutor_id = '{$tutor_id}'";
    $query_count = mysqli_query($con, $sql_count) or die("Query failed");
    $row_rating = mysqli_fetch_array($query_count);
    $rating_id = $row_rating['id'];
    $count = mysqli_num_rows($query_count);
   
if($count > 0){

       $sql = "UPDATE `rating` SET `rating`='$rating', `review`='$review' WHERE id = $rating_id";

                   $query = mysqli_query($con, $sql) or die("Query Failed");

                   if($query){

                      echo json_encode(array('msg'=>'Thank you for giving us rating & review.','status'=>201));

                  }else{

                      echo json_encode(array('msg'=>'failed','status'=>false));

                  }

}else{
    // new user insert
    $sql = "INSERT INTO `rating`(`user_id`, `tutor_id`, `rating`, `review`, `trn_date`) VALUES ('$user_id','$tutor_id','$rating', '$review','$trn_date')";

    $query = mysqli_query($con, $sql);

    if($query){

       echo json_encode(array('msg'=>'Thank you for giving us rating & review.','status'=>201));

   }else{

       echo json_encode(array('msg'=>'failed','status'=>false));

   }

}



 

?>