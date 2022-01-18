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

$f_name =  $_POST['name'];
// $l_name =  $_POST['l_name'];

$email =  $_POST['email'];
$password =  $_POST['password'];
$sector =  $_POST['place'];
$state = $_POST['state'];
$city = $_POST['scity'];
$mobile = $_POST['mobile'];
$description = $_POST['description'];

// print_r($f_name);echo '<br>';
// print_r($email);echo '<br>';
// print_r($password);echo '<br>';
// print_r($subjects);echo '<br>';
// print_r($state_name);echo '<br>';
// print_r($city);echo '<br>';
// print_r($mobile);echo '<br>';
// print_r($description);echo '<br>';
// // $image = $_FILES["profile"]["name"]);
// print_r($_FILES["profile"]["name"]);
// exit();


$trn_date = date("Y-m-d H:i:s");
 
// check tutor registed or not
// $tutor = tutorCheck('councellor_info',$mobile, $email);

// $sector = explode(",", $subjects);

// $count = count($sector);

// $get_state_id = "SELECT id from states where name LIKE '%{$state_name}%'";
//    $state_query = mysqli_query($con, $get_state_id) or die("Query failed");
//    $row = mysqli_fetch_array($state_query);
//    $state = $row['id'];

$get_counc = "SELECT id from councellor_info where email = '$email' && mobile = '$mobile' ";
   $couns_q = mysqli_query($con, $get_counc) or die("Query failed1");
   $count_row = mysqli_num_rows($couns_q);
   

if($count_row > 0){

 // tutor email and contact already exist;
    echo json_encode(array('message'=>'Mobile no. or email already exists!','status'=>false));

}else{

   // *******************************************************************************************

   $uploadPath = "../../../../img/councellor/"; 

   if(!empty($_FILES["profile"]["name"])) { 
        // File info 
        $fileName = date("mjYHis")."_".basename($_FILES["profile"]["name"]); 
        $imageUploadPath = $uploadPath . $fileName; 
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            // Image temp source 
            $imageTemp = $_FILES["profile"]["tmp_name"]; 
             
            // Compress size and upload image 
            $compressedImage = compressImage($imageTemp, $imageUploadPath, 75); 
             
            if($compressedImage){ 
                $sql = "INSERT into councellor_info (name,email,password,mobile,state,city,sector,profile,description,created_on) values ('{$f_name}','{$email}','{$password}','{$mobile}','{$state}','{$city}','{$sector}','{$fileName}','{$description}','{$trn_date}')";

                   $query = mysqli_query($con, $sql) or die("Query Failed");

                   if($query){

                      echo json_encode(array('message'=>'success','status'=>201));

                  }else{

                      echo json_encode(array('message'=>'failed','status'=>false));

                  }
                
            } 
        }   
    }

}


?>