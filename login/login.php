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

//  nothing comment

/*
"php://input" :- this can read all type of row data which is received(xml,json).
file_get_content :- takes row data(json format) which is received.
*/
require '../connect.php';
require '../function.php';


$data = json_decode(file_get_contents("php://input"), true);


$type = $data['type'];
$email = $data['email'];
$password = $data['password'];


switch ($type) {
    // In case of tutor type
    case 'tutor':
        $table = "tutor_info";
        $data = userLogin('*',$table,$email,$password);
        
       if($data != ''){
         echo json_encode(array('message'=>'success','status'=>201, 'data'=>$data));   
         break;
       }else{
        echo json_encode(array('message'=>'Invalid Credential!','status'=>400));
        break;
       }
        
        
// in case of student type
    case 'councellor':
        $table = "councellor_info";
        $data = userLogin('*',$table,$email,$password);
        
       if($data != ''){
         echo json_encode(array('message'=>'success','status'=>201, 'data'=>$data));   
         break;
       }else{
        echo json_encode(array('message'=>'Invalid Credential!','status'=>400));
        break;
       }
    
    
// In case of institute
    case 'institute':
        $table = "agency_info";
        $data = userLogin('*',$table,$email,$password);
        
       if($data != ''){
         echo json_encode(array('message'=>'success','status'=>201, 'data'=>$data));   
         break;
       }else{
        echo json_encode(array('message'=>'Invalid Credential!','status'=>400));
        break;
       }
    
    default:
        echo json_encode(array('message'=>'You are not allowed!','status'=>400));
        break;


}





?>