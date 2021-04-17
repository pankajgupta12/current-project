<?php  
error_reporting(0);
session_start();
include("functions/functions.php");
include("functions/config.php");
	
	
    if($_REQUEST['applicant_id'] != '' && $_REQUEST['page'] != '') {

	 
	  //print_r($_REQUEST); die;
	  
	
	
		$applicant_id = mysql_real_escape_string($_REQUEST['applicant_id']);
		$page = mysql_real_escape_string($_REQUEST['page']);
		
			// Make sure file is not cached (as it happens for example on iOS devices)
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");


			// 5 minutes execution time
			@set_time_limit(5 * 60);


			// Settings
			$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
			//$targetDir = 'uploads';
			$cleanupTargetDir = true; // Remove old files
			$maxFileAge = 5 * 3600; // Temp file age in seconds
			//echo $targetDir; die;
			//require_once
			// Create target dir
			if (!file_exists($targetDir)) {
			@mkdir($targetDir);
			}


			// Get a file name
			if (isset($_REQUEST["name"])) {
			$filename = $_REQUEST["name"];
			} elseif (!empty($_FILES)) {
			$filename = $_FILES["file"]["name"];
			} else {
			$filename = uniqid("file_");
			}
	  
	   
			//$filename=$_FILES["file"]["name"];
			$extension=end(explode(".", $filename));
			$newfilename = round(microtime(true)) . str_replace(' ', '_', $filename);
			
			$created_at = date('Y-m-d H:i:s');
			$path =  getcwd();
			   if(is_dir('../../application/files/'.$applicant_id) == false){
					//mkdir($dir);
					echo "yes";
					 mkdir('../../application/files/'.$applicant_id,0777,true);
	             }else{
					 echo "no";
				 }
				 
			//mkdir('../img/staff_file/'.$job_id,0777,true); 
			$path1 = '../../application/files/'.$applicant_id.'/'.$newfilename;
			move_uploaded_file($_FILES["file"]["tmp_name"], $path1);
		
		if($filename !=""){
			$insertImage = mysql_query("INSERT INTO `applications_doc` (`applications_id`, `doc_file`, `created_at`) VALUES ('".$applicant_id."', '".$newfilename."', '".$created_at."')");  
		} 
    }
?>