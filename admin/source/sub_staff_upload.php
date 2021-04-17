<?php  
include("functions/functions.php");
include("functions/config.php");
		
		if($_GET['sub_staff_id'] != '' && $_GET['page'] == 'sub_staff_doc') {
		
		     // Make sure file is not cached (as it happens for example on iOS devices)
				/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
				header("Cache-Control: no-store, no-cache, must-revalidate");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");
				$newfilename = '';
		
		    @set_time_limit(5 * 60);*/

				// Uncomment this one to fake upload time
				// usleep(5000);

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
				  
			
		    if (!empty($_FILES["file"]["name"] != '')) {
			    	$filename = $_FILES["file"]["name"];
					//$filename=$_FILES["file"]["name"];
					//$extension=end(explode(".", $filename));
					$newfilename = (str_replace(' ', '_', $filename));

					$sub_staff_id = $_REQUEST['sub_staff_id'];
					//$page = $_REQUEST['page'];
					//$jobIDdata = explode('_',$jobstr);
					$createdOn = date('Y-m-d H:i:s');
					//$path =  getcwd();
					
					
					mkdir('../img/sub_staff_file/'.$sub_staff_id,0777,true); 
					 $path1 = '../img/sub_staff_file/'.$sub_staff_id.'/'.$newfilename;
					move_uploaded_file($_FILES["file"]["tmp_name"], $path1);
					  
			
		 
				 $insertImage = mysql_query("INSERT INTO `sub_staff_files` (`sub_staff_id`, `image`, `createdOn`) VALUES ('".$sub_staff_id."', '".$newfilename."', '".$createdOn."')");  
				 
				 if($insertImage) {
				     return true;
				 }
			}
		
		}
?>		