<?
if(isset($_POST['step'])){ $step=$_POST['step']; }else{ $step=0; }
$_SESSION['post'] = $_POST;

//print_r($_POST); die;

if ($step==1){
	if($_SESSION['query[error]'] != 1){
		// before validation changes 
		for ($i=0;$i<count($fields_name);$i++){
				if ($fields_type[$i]=="fdate"){
					$num=$i;								// 1 or  2 
					$f_name=$fields_name[$i];				// start_date or end_date
					$_POST[$f_name]=$_POST['yy_'.$num]."-".$_POST['mm_'.$num]."-".$_POST['dd_'.$num];
				}	
		}
		$step=check_form($fields_name,$fields_validation,$fields_heading);
		
		// after validation special checking of system
		for ($i=0;$i<count($fields_name);$i++){
				if ($fields_name[$i]=="username"){
					if ($_POST['username']!=""){
						$chk1 = "select * from $table where username ='".$_POST['username']."'";
						$data1= mysql_query($chk1);
						if (mysql_num_rows($data1)>0){
							$_SESSION['query[error]'] = 1;
							$_SESSION['query[txt]'] = "Username Already Exist<br>";
							$step=1;
						}else{
							$_SESSION['query[error]']=0;
							$_SESSION['query[txt]'] = "";
						}
					}
				}
		}
		
		// checking if the filename is either jpg / gif or png 
		$file_i=0;
		for ($i=0;$i<count($fields_name);$i++){
			if ($fields_type[$i]=="file"){
				$f_name=$fields_name[$i];
				$file_i++;
				$extcheck=false;
					if (is_uploaded_file($_FILES['file'.$file_i]['name'])) {
						$ext = strtolower(strrchr($_FILES['file'.$file_i]['name'],"."));
						if(($ext==".gif") || ($ext==".jpg") || ($ext==".jpeg") || ($ext==".png")){
							$extcheck=true;
						}
					
						if(!$extcheck){
							$_SESSION['query[error]'] = 1;
							$_SESSION['query[txt]'] = "Image can only be .gif, .jpg, .png formats <br>";
						}
					}
			}
			
			if ($fields_type[$i]=="doc"){
				$f_name=$fields_name[$i];
				$file_i++;
				$extcheck=false;
					if (is_uploaded_file($_FILES['file'.$file_i]['name'])) {
						$ext = strtolower(strrchr($_FILES['file'.$file_i]['name'],"."));
						if(($ext==".doc") || ($ext==".docs") || ($ext==".pdf") || ($ext==".csv")){
							$extcheck=true;
						}
					
						if(!$extcheck){
							$_SESSION['query[error]'] = 1;
							$_SESSION['query[txt]'] = "Dccument can only be .doc, .pdf, .docx formats <br>";
						}
					}
			}
			
			if($fields_type[$i]=="flv_videos"){
				$f_name=$fields_name[$i];
				$file_i++;
				$extcheck=false;
					if (is_uploaded_file($_FILES['file'.$file_i]['name'])) {
						$ext = strtolower(strrchr($_FILES['file'.$file_i]['name'],"."));
						if(($ext==".flv")){
							$extcheck=true;
						}
					
						if(!$extcheck){
							$_SESSION['query[error]'] = 1;
							$_SESSION['query[txt]'] = "FLV Video can only be .flv format <br>";
						}
					}
			}
		}// end of image check 
		
		
	}
}

if ($step==2){
	//echo "<pre>"; print_r($f_filed_desc); die;
	$insert=insert_form($fields_name,$fields_dtype,$table,$fields_add,$f_filed_desc);
	
		if($insert == 1){
			 //echo "Inserted Properly";
			 $file_i=0;
			 $_POST['id']=mysql_insert_id();
			 include("source/task.php");
			 for ($i=0;$i<count($fields_name);$i++){
					if ($fields_type[$i]=="file"){
						$f_name=$fields_name[$i];
						if($t==83){
							//echo $_POST['type'];
							$dimensions = get_rs_value("banner_type","size",$_POST['type']);
						}else{
							$dimensions = $f_type_value[$i];
						}
						$file_i++;
						
							if (is_uploaded_file($_FILES['file'.$file_i]['tmp_name'])) {
								$uploaddir = DB_dir.$img_folder;
								$ext = strrchr($_FILES['file'.$file_i]['name'],".");
								$newfilename_sml=rw("id")."_".$file_i."".$ext;
								$newfilename1_data="/images/".$img_folder."/".$newfilename_sml;
								$dest1=$uploaddir."/".$newfilename_sml;
								
								$newfilename_smlx=rw("id")."_".$file_i."x".$ext;
								$dest1x=$uploaddir."/".$newfilename_smlx;
								
								$uploadfile=$_FILES['file'.$file_i]['tmp_name'];
							//echo "File is uploaded and is resized to 50x300";
							// image magic tools comand line argument
							///usr/local/bin/
							//echo $uploaddir;
							if(is_dir($uploaddir)==false){ mkdir ($uploaddir, 0777); }
							
							$resizecmd = $convert_prefix."convert -resize $dimensions $uploadfile $dest1";
							echo "<br>".$resizecmd."<br>";
							exec($resizecmd);
							//compress_image($newfilename1_data, $newfilename1_data, 65);
							/*if($t=="47"){
								 $dimex = explode("x",$dimensions);
								 $dimex_x= ($dimex[1]/2)-10;
								 $dimex_y= ($dimex[0]/2)-48;
								 
								$resizecmd = $convert_prefix."convert -gravity Center -font helvetica -fill white -pointsize 12 -draw 'text 0,0 \"SAMPLE IMAGE\"' $dest1 $dest1"; 
								
								 echo "<br>".$resizecmd."<br>";
								 exec($resizecmd);
							}
							*/

							
							
							$arg22="update $table set $f_name='$newfilename1_data' where id=".rw("id");
							//echo $arg22."<br>";
							$insert22 = mysql_query($arg22);
						}else{
							echo "No $f_name uploaded";
						}
				}
				
				if ($fields_type[$i]=="doc"){
					$f_name=$fields_name[$i];
					//$dimensions = $f_type_value[$i];
					$file_i++;
						
						if (is_uploaded_file($_FILES['doc'.$file_i]['tmp_name'])) {
								$uploaddir = DB_dir.$img_folder;
								$ext = strrchr($_FILES['doc'.$file_i]['name'],".");
								$newfilename_sml=rw("id")."_document_".$file_i."".$ext;
								$newfilename1_data="/images/".$img_folder."/".$newfilename_sml;
								$dest1=$uploaddir."/".$newfilename_sml;
								$uploadfile=$_FILES['doc'.$file_i]['tmp_name'];
							//echo "File is uploaded and is resized to 50x300";
							// image magic tools comand line argument
							///usr/local/bin/
							
							if(is_dir($uploaddir)==false){ mkdir ($uploaddir, 0777); }
							
							//$resizecmd = $convert_prefix."convert -resize $dimensions $uploadfile $dest1";
							//echo "<br>".$resizecmd."<br>";
							//exec($resizecmd);
							
							copy($uploadfile,$dest1);
							
							
							$arg22="update $table set $f_name='$newfilename1_data' where id=".rw("id");
							//echo $arg22."<br>";
							$insert22 = mysql_query($arg22);
						}else{
							echo "No $f_name uploaded";
						}
				}	
				
				if ($fields_type[$i]=="flv_videos"){
					$f_name=$fields_name[$i];
					$dimensions = $f_type_value[$i];
					$file_i++;
						
						if (is_uploaded_file($_FILES['file'.$file_i]['tmp_name'])) {
								$uploaddir = DB_dir.$img_folder;
								$ext = strrchr($_FILES['file'.$file_i]['name'],".");
								$newfilename_sml=rw("id")."_".$file_i."".$ext;
								$newfilename1_data="/images/".$img_folder."/".$newfilename_sml;
								$dest1=$uploaddir."/".$newfilename_sml;
								$uploadfile=$_FILES['file'.$file_i]['tmp_name'];
							//echo "File is uploaded and is resized to 50x300";
							// image magic tools comand line argument
							///usr/local/bin/
							
							if(is_dir($uploaddir)==false){ mkdir ($uploaddir, 0777); }
							
							//$resizecmd = $convert_prefix."convert -resize $dimensions $uploadfile $dest1";
							//echo "<br>".$resizecmd."<br>";
							//exec($resizecmd);
							copy($uploadfile,$dest1);
							
							
							$arg22="update $table set $f_name='$newfilename1_data' where id=".rw("id");
							//echo $arg22."<br>";
							$insert22 = mysql_query($arg22);
						}else{
							echo "No $f_name uploaded";
						}
				
				}
			}
		}else{ // if not inserted ....
			disp_mysql_error();
		}
include("source/confirmation.php");
}else{  // if step=1 then 
		if ($a=="modify"){
				$arg = "select * from contacts where id=$id";
				$details = mysql_fetch_array(mysql_db_query( DB_name, $arg ));
				$data = mysql_query( $arg);
		}

//form page

include("temp.php");
}
?>