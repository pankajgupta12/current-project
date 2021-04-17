<?
if(isset($_POST['step'])){ $step=$_POST['step']; }else{ $step=0; }
$_SESSION['post'] = $_POST;

//echo $step;
if ($step==1){
	//echo " we are here ";
	if($_SESSION['query[error]'] != 1){
		for ($i=0;$i<count($fields_name);$i++){
				if ($fields_type[$i]=="fdate"){
					$num=$i;								// 1 or  2 
					$f_name=$fields_name[$i];				// start_date or end_date
					$_POST[$f_name]=$_POST['yy_'.$num]."-".$_POST['mm_'.$num]."-".$_POST['dd_'.$num];
					//echo "just created".$_POST[$f_name]."<br>";
				}	
			}
		//echo $_POST['task']; die;
		if($_POST['task'] == 42) {
		  $step = 2;
		}else{
			$step=check_form($fields_name,$fields_validation,$fields_heading);
		}
		for ($i=0;$i<count($fields_name);$i++){
				if ($fields_name[$i]=="username"){
					if ($_POST['username']!=""){
						$chk1 = "select * from $table where username ='".$_POST['username']."' and id!=".rw("id")."";
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
	}
}
//echo $step; 
if ($step==2){
// upload image 
//echo "<pre>"; print_r($f_filed_desc); die;
$insert1="";
 if($table == 'staff' && $_POST['task'] == 4) {
	 $stringfield = "`site_id`, `application_id`, `name`, `email`, `password`, `mobile`, `mobile_name`, `abn`, `company_name`, `bsb`, `account_number`, `status`, `description`, `job_types`, `insurance_doc`, `agreement_doc`, `site_id2`, `insurance_expiry`, `staff_member_rating`, `nick_name`, `avaibility`, `amt_share_type`, `login_date`, `better_franchisee`, `electronic_consent`, `latitute`, `longitude`, `current_login_address`, `staff_gst`, `is_doc_verify`, `is_insurance_expired`, `primary_post_code`, `secondary_post_code`, `team_of`, `no_work`, `user_role`, `document_check`, `is_terms_condition`, `is_order_now`, `created_date`, `is_chat_job_id`, `show_price`, `real_estate_staff`, `allow_sub_staff`, `address`, `payment_type`";
	 
	//echo "SELECT $stringfield FROM staff WHERE id = '".rw("id")."' "; 
	 
   $qry_before = mysql_query("SELECT $stringfield FROM staff WHERE id = '".rw("id")."' ");
   $qry_before_rs = mysql_fetch_assoc($qry_before);
   
   //print_r($qry_before_rs);
   
    if($qry_before_rs['status'] == 1) {
       $status = 'Activated';
   }else if($qry_before_rs['status'] == 0){
       $status = 'Deactivate';
   }
   $qry_before_rs['status']  = $status;
  // print_r($qry_before_rs);
    
   
 }
 
// echo $step; die;
$insert1=modify_form($fields_name,$fields_add,$fields_dtype,$table,rw("id"),$f_filed_desc);

//added to get staff result after updation
 if($table == 'staff' && $_POST['task'] == 4) {
	 //echo "SELECT $stringfield FROM staff WHERE id = '".rw("id")."' ";
	$query_after = mysql_query("SELECT $stringfield FROM staff WHERE id = '".rw("id")."' ");
    $query_after_rs = mysql_fetch_assoc($query_after);
	// print_r($query_after_rs);
	
		if($query_after_rs['status'] == 1) {
            $status1 = 'Activated';
        }else if($query_after_rs['status'] == 0){
          $status1 = 'Deactivate';
       }
   $query_after_rs['status']  = $status1;
	
    StaffDetailsUpdateByadmin($qry_before_rs, $query_after_rs);
 }

  

			 include("source/task.php");
			for ($i=0;$i<count($fields_name);$i++){
				if ($fields_type[$i]=="file"){
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
							//echo $uploaddir;
							if(is_dir($uploaddir)==false){ mkdir ($uploaddir, 0755); }
							
							$resizecmd = $convert_prefix."convert -resize $dimensions $uploadfile $dest1";
							//echo "<br>".$resizecmd."<br>";
							exec($resizecmd);
							
							
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
							echo $arg22."<br>";
							$insert22 = mysql_query($arg22);
						}else{
							echo "No $f_name uploaded";
						}
				}
				//	getStaffDetails(rw("id"),$table);
			}
$action = "list"; $a="list";
include("list.php");
}else{  // if step=1 then 
		if ($a=="modify"){
			$details="";
				$arg = "select * from $table where id=".rw("id");
				//echo $arg;
				$data = mysql_query($arg);
				$details = mysql_fetch_array($data);
				//print_r($details);
				$_SESSION['post'] = $details;
				
		}

//form page
include("temp.php");
}
?>