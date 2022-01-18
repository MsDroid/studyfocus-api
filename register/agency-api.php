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
// $l_name = '';

$email =  $_POST['email'];
$password =  $_POST['password'];
$tutor_subjects =  $_POST['subject'];
$state = $_POST['state'];
$city = $_POST['scity'];
$mobile = $_POST['mobile'];
$experience = $_POST['experience'];
$feerange = $_POST['feerange'];


$class = $_POST['cls'];
$adhar = 'N/A';
$demo = 'N/A';
$home = 'N/A';
$digi = 'N/A';
$board = $_POST['board'];
$platform = $_POST['platform'];
$medium = $_POST['medium'];
$area = 'N/A';
$qualification = 'N/A';
$description = $_POST['description'];

$trn_date = date("Y-m-d H:i:s");
$slug = slugify(8, $f_name);
 
// check tutor registed or not
$tutor = tutorCheck('tutor_info',$mobile, $email);

// print_r($tutor_subjects);
// exit();
$subjects = $tutor_subjects; 
$count_subjects = explode(",", $subjects);
$count = count($count_subjects);
// $subjects = implode(",",$tutor_subjects);
// $medium = implode(",",$medium1);
// $board = implode(",",$board1);
// $class = implode(",",$class1);
// $platform = implode(",",$platform1);

// $get_state_id = "SELECT id from states where name LIKE '%{$state_name}%'";
//    $state_query = mysqli_query($con, $get_state_id) or die("Query failed");
//    $row = mysqli_fetch_array($state_query);
//    $state = $row['id'];

if($tutor){

 // tutor email and contact already exist;
    echo json_encode(array('message'=>'Mobile no. or email already exists!','status'=>false));

}else{

   // *******************************************************************************************

   $uploadPath = "../../../../img/newagency/"; 

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
                $sql = "INSERT into agencynew_info (name,email,password,class,mobile,adhar,demo,home,digi,subjects,board,platform,medium,state,city,area,qualification,description,experience,profile,slug,fee_range,trn_date) values ('{$f_name}','{$email}','{$password}','{$class}','{$mobile}','{$adhar}','{$demo}','{$home}','{$digi}','{$subjects}','{$board}','{$platform}','{$medium}','{$state}','{$city}','{$area}','{$qualification}','{$description}','{$experience}','{$fileName}','{$slug}','{$feerange}','{$trn_date}')";

                   $query = mysqli_query($con, $sql) or die("Query Failed");

                   if($query){

                      echo json_encode(array('message'=>'success','status'=>201));

                  }else{

                      echo json_encode(array('message'=>'failed','status'=>false));

                  }
                
            } 
        }   
    }



   // ***********************************************************************************************

// new user insert
   //  $sql = "INSERT into tutor_info (f_name,l_name,email,password,class,mobile,adhar,demo,home,digi,subjects,board,platform,medium,state,city,area,qualification,description,profile,slug,trn_date) values ('{$f_name}','{$l_name}','{$email}','{$password}','{$class}','{$mobile}','{$adhar}','{$demo}','{$home}','{$digi}','{$subjects}','{$board}','{$platform}','{$medium}','{$state}','{$city}','{$area}','{$qualification}','{$description}','{$profile}','{$slug}','{$trn_date}')";

   //  $query = mysqli_query($con, $sql) or die("Query Failed");

   //  if($query){

   //     echo json_encode(array('message'=>'success','status'=>201));

   // }else{

   //     echo json_encode(array('message'=>'failed','status'=>false));

   // }

}


?>