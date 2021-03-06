<?php 
include 'connect.php';

function compressImage($source, $destination, $quality) { 
    // Get image info 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        case 'image/webp': 
            $image = imagecreatefromwebp($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
     
    // Save image 
    imagejpeg($image, $destination, $quality); 
     
    // Return compressed image 
    return $destination; 
} 

// 
function slugify($length_of_string, $name)
{

    // String of all alphanumeric character
	$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    // Shufle the $str_result and returns substring
    // of specified length
	$rand_string = substr(str_shuffle($str_result), 
		0, $length_of_string);
	$uniq = strtolower($rand_string);
	$string = preg_replace('/\s+/', '', $name);
	$slug = $string.'_'.$uniq;
	return $slug;
}

// for login as student, tutor, and institute
function userLogin($fields, $table, $email, $password){
	global $con;
	$sql = "SELECT $fields from $table where email='$email' and password='$password' ";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}

// for search tutors in search section
function searchTutors($fields, $table, $state_id, $city, $subjects){

	$q_append = "";

	$q_append .= ($state_id === 0) ? "" : " AND state = {$state_id}";
	$q_append .= ($city === 0) ?  "" : " AND city = {$city}";
	$q_append .= ($subjects === 0) ?  "" : " AND subjects LIKE '%$subjects%' ";

	global $con;
	$sql = "SELECT $fields from $table where( ".$q_append." )";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}


// for search tutors in search section
function searchAgency($fields, $table, $state, $city, $subjects){
	global $con;

	$sql = "SELECT $fields from $table where state = $state AND city=$city AND subjects LIKE '%$subjects%' ";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}



// fetch all blogs
function allBlogs($fields, $table){
	global $con;

	$sql = "SELECT $fields from $table ORDER BY created_at desc";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}



// fetch single blogs
function singleBlogs($fields, $table, $blog_slug){
	global $con;

	$sql = "SELECT $fields from $table where blog_slug='{$blog_slug}'";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}

// fetch search blogs
function searchBlogs($fields, $table, $blog_search){
	global $con;

	$sql = "SELECT $fields from $table WHERE blog_title LIKE '%{$blog_search}%'";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}

// fetch single data
function relatedBlogs($fields, $table, $cat){
	global $con;

	$sql = "SELECT $fields from $table where category='{$cat}'";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}


// fetch single data
function singleData($fields, $table, $id){
	global $con;

	$sql = "SELECT $fields from $table where id='{$id}'";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}


// fetch state city
function stateCity($fields, $table, $state){
	global $con;

	// $get_state_id = "SELECT id from states where name LIKE '%{$state}%'";
	// $state_query = mysqli_query($con, $get_state_id) or die("Query failed");
	// $row = mysqli_fetch_array($state_query);
	// $id = $row['id'];


	$sql = "SELECT $fields from $table where state_id='{$state}'";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}


// edit tutor profile
function editProfile($table, $fields, $id){
	global $con;

	$sql = "SELECT $fields from $table where id='$id' ";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $data;
	}else{
		return false;
	}
}


// edit student profile
function updateStudentProfile($table, $name, $password, $id){
	global $con;

	$sql = "UPDATE $table set f_name = '$name', password='$password' where id='$id' ";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if ($query) {
		return true;
	}else{
		return false;
	}
}


// edit tutor profile
function updateTutorPro($table, $name, $password, $email, $mobile, $profile, $id){
	global $con;
	$sql = "UPDATE $table set f_name = '{$name}', password='{$password}', email='{$email}', mobile='{$mobile}', profile='{$profile}'  where id='{$id}' ";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if ($query) {
		return true;
	}else{
		return false;
	}
}


// edit agency profile
function updateAgencyProfile($table, $name, $password, $email, $profile, $id){
	global $con;
	$sql = "UPDATE $table set name = '{$name}', password='{$password}', email='{$email}', profile='{$profile}'  where id='{$id}' ";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if ($query) {
		return true;
	}else{
		return false;
	}
}



// edit student profile
function editStudentProfile($table, $name, $password, $id){
	global $con;
	$sql = "UPDATE $table set stu_name = '$name', password='$password' where id='$id' ";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if ($query) {
		return true;
	}else{
		return false;
	}
}




// check user at register time
function tutorCheck($table, $mobile, $email){
	global $con;

	$sql = "SELECT id FROM $table WHERE mobile = '{$mobile}' OR email = '{$email}'";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		return true;
	}else{
		return false;
	}
}


// check student at register time
function studentCheck($table, $mobile, $email){
	global $con;

	$sql = "SELECT id FROM $table WHERE stu_mobile = '{$mobile}' OR email = '{$email}'";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		return true;
	}else{
		return false;
	}
}




// check user at register time
function agencyCheck($table, $mobile, $email){
	global $con;

	$sql = "SELECT id FROM $table WHERE mobile = '{$mobile}' OR email = '{$email}'";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if (mysqli_num_rows($query) > 0 ) {
		return true;
	}else{
		return false;
	}
}


//array to string conversion
function arraytoString($Arr){

	$result="";  
	foreach($Arr as $sub)  
	{  
		$result .= $sub.",";  
	}  
	return $result;
}


// check user at register time
function insertAgencyTutor($table, $subject, $tutor, $inst_id){
	global $con;

	$sql = "INSERT INTO $table (inst_id, subject, tutor) values ('{$inst_id}','{$subject}','{$tutor}')";
	$query = mysqli_query($con, $sql) or die("Query failed");
	if ($query) {
		return true;
	}else{
		return false;
	}
}



//search
// function search($keyword){
// 	global $con;
// 	// tutor search query
// 	 $sql_tutor = "SELECT * FROM `tutor_info` WHERE f_name LIKE '%$keyword%' or subjects LIKE '%$keyword%' ";
// 	$tutor_query = mysqli_query($con, $sql_tutor);
// 	// institute search query
// 	 $sql_agency = "SELECT * FROM `agency_info` WHERE f_name LIKE '%$keyword%' or subjects LIKE '%$keyword%' ";
// 	$agency_query = mysqli_query($con, $sql_agency);


// 	if($tutor_query){
// 		return  "tutor query";
// 		// $data = mysqli_fetch_assoc($tutor_query);
// 		// echo "<pre>";
// 		// print_r($data);
// 	}elseif($agency_query){
// 		return  "agency query";
// 		// $data = mysqli_fetch_assoc($tutor_query);
// 		// echo "<pre>";
// 		// print_r($data);
// 	}else{
// 		return "sorry";
// 	}

// }





?>