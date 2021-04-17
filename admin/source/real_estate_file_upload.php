<?php
include("functions/functions.php");
include("functions/config.php");
//uploadMultipulimage();

 		

				// Make sure file is not cached (as it happens for example on iOS devices)
				/* header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
				header("Cache-Control: no-store, no-cache, must-revalidate");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");

			

				// 5 minutes execution time
				@set_time_limit(5 * 60);

				$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
				//$targetDir = 'uploads';
				$cleanupTargetDir = true; // Remove old files
				$maxFileAge = 5 * 3600; // Temp file age in seconds
					if (!file_exists($targetDir)) {
					@mkdir($targetDir);
				}
				  */
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
					$newfilename = str_replace(' ', '_', $filename);
				
                $re_id = $_REQUEST['re_id'];
			    $createdOn = date('Y-m-d H:i:s');
				
			
				 mkdir('../img/real_estate_file/'.$re_id,0777,true); 
					 $path1 = '../img/real_estate_file/'.$re_id.'/'.$newfilename;
					  move_uploaded_file($_FILES["file"]["tmp_name"], $path1);
				
				if($filename !=""){
				   $insertImage = mysql_query("INSERT INTO `real_estate_docs_file` (`real_estate_agent_id`, `image`, `createdOn`) VALUES ('".$re_id."', '".$newfilename."', '".$createdOn."')");  	  
				} 


?>
