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
                      echo json_encode(array('message'=>'success','status'=>201));
                  }else{
                      echo json_encode(array('message'=>'failed','status'=>false));
                  }
                
            } 
        } else {
                      echo json_encode(array('message'=>'failed-not fount image','status'=>false));

        }  
    




?>