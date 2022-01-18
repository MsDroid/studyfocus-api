<?php 
include 'connect.php';
include 'function.php';

// ----------------------------------------------------------------------
// agency login
// -----------------------------------------------------------------------
// email : er.sumeetsaurabh@gmail.com
// pass : S2563

// ----------------------------------------------------------------------
// student login
// -----------------------------------------------------------------------
// email : manoranjansngh77@gmail.com
// pass : 987898789

// ----------------------------------------------------------------------
// tutor login
// -----------------------------------------------------------------------
// email : nik123@gmail.com
// pass : 123




// ----------------------------------------------------------------------------------
// login api check
// ----------------------------------------------------------------------------------
// {
//     "type" : "tutor",
//     "email" : "nik123@gmail.com",
//     "password" : "987"
// }

// {
//     "type" : "student",
//     "email" : "mruunaline.vaddepally@gmail.com",
//     "password" : "venkatesh143"
// }

// {
//     "type" : "institute",
//     "email" : "test123@gmail.com",
//     "password" : "123"
// }


// -----------------------------------------------------------------------------------


// tutot login function
// $tutor = userLogin('*','tutor_info','nik123@gmail.com','987');


// student login function
// $tutor = userLogin('*','student_info','mruunaline.vaddepally@gmail.com','venkatesh143');


// agency login function
// $tutor = userLogin('*','agency_info','test123@gmail.com','123');

// ----------------------------------------------------------------------------------------------
// search tutors
// ----------------------------------------------------------------------------------------------

// values for fields
// $fields= '*';
// $digi=1;    //get value from digi
// $state=34;
// $city=259;
// $subject = 'english';


// json data
// {
//     "state" : 34,
//     "city" : 259,
//     "digi" : 1,
//     "subjects" : "english"
// }


// $tutor = searchTutors($fields, 'tutor_info', $state, $city, $digi, $subject);


// ----------------------------------------------------------------------------------------------
// search agency
// ----------------------------------------------------------------------------------------------

// values for fields
// $fields= '*';
// $digi=0;    //get value from digi
// $state=1;
// $city=1;
// $subject = 'english';


// json data
// {
//     "state" : 1,
//     "city" : 1,
//     "digi" : 0,
//     "subjects" : "english"
// }


// $tutor = searchAgency($fields, 'agency_info', $state, $city, $digi, $subject);



// ----------------------------------------------------------------------------------------------
// fetch all blogs
// ----------------------------------------------------------------------------------------------

// $fields = '*';
// $table = 'blog_content';
// $blog_id = 41;

// $blogs = singleBlogs($fields, $table, $blog_id);


// ----------------------------------------------------------------------------------------------

// $table = 'student_info';
// $stu_mobile = 9003772185;
// $email = 'mariammal19772@gmail.com';


// $user = studentCheck('student_info',$stu_mobile, $email);


// ----------------------------------------------------------------------------------------------

// $fields = '*';
// $table = 'slider';
// $slider = allBlogs($fields , $table);

// ----------------------------------------------------------------------------------------------
// student register
// ----------------------------------------------------------------------------------------------

// json data
// {
//     "stu_name" : "ramu",
//     "stu_class" : 10,
//     "email" : "ramu@gmail.com",
//     "password" : "9876534",
//     "stu_mobile" : 877364987,
//     "stu_subjects" : ["maths","hindi","english"],
//     "state" : 12,
//     "city" : 11
// }

// $stu_name = "ramu";
// $stu_class = 10;
// $email = "ramu@gmail.com";
// $password = "sdw9876534";
// $stu_mobile = 877364987;
// $stu_subjects = ["maths","hindi","english"];
// $tran_date = date("Y-m-d H:i:s");
// $state = 12;
// $city = 11;
// $trn_date = date("Y-m-d H:i:s");

// $user = studentCheck('student_info',$stu_mobile, $email);

// -----------------------------------------------------------------------------------------------

$fields = '*';
$state = 34;
$city = 259;
$digi =1;
$subjects = 'hindi';


// $tutor = searchTutors($fields, 'tutor_info', $state, $city, $digi, $subjects);
$tutor = searchAgency($fields, 'tutor_info', $state, $city, $digi, $subjects);



// -----------------------------------------------------------------------------------------
// search
// ----------------------------------------------------------------------------------------
// $keyword = "man";

// // $sql_tutor = "SELECT * FROM `tutor_info` WHERE f_name LIKE '%$keyword%' ";

// $search_data = search($keyword);

echo "<pre>";
print_r($tutor);











?>