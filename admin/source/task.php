<?
if(isset($_POST['step'])){ 

	
	if(($_POST['task']=="quote") && ($_POST['step']==1)){
		$table="quote";
		$_SESSION['query[txt]']="";
		$fields_name=array("site_id","date","name","email","phone","bed","bath","property_type","blinds_type","carpet","c_bedroom",
		"c_lounge","c_stairs","booking_date","login_id","furnished","cleaning_amount","cleaning_hours","amount","carpet_amount",
		"pest_amount","gardening_amount","uphostry_amount","comments","per_hour","inspection_date","address","job_ref","suburb");
		$fields_heading=array("Site Id","Date","Name","Email","Phone","Bed","Bath","Property Type","Blinds Type","Carpet Yes/No","Carpet Bedrooms","Carpet Lounge",
		"Carpet Stairs","Booking Date","login Id","furnished","cleaning_amount","cleaning_hours","amount","carpet_amount",
		"pest_amount","gardening_amount","uphostry_amount","Comments","Per Hour","inspection_date","address","job_ref","Suburb");
		
		$fields_validation=array(0,0,1,0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1);
		$fields_dtype=array(0,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
		$fields_add=array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
		
		$step = $_POST['step'];
		
		if ($step==1){
				$step=check_form($fields_name,$fields_validation,$fields_heading);
				/*if ($step==2){
					
					if(strtoupper($_POST['code']) != $_SESSION['captcha_phrase']){
						$_SESSION['query[txt]']= "Incorrect Verification Code.<br>";
						$_SESSION['query[error]'] = 1;
						$step=1;
					}				
				}*/
		}
		//echo "This is step a:".$step;
		 if ($step==2){ 
			//letscheckproxy();
			
			$_POST['status']=0;
			// 0 = not active , 1 = active , 2 = pending
			//$_POST['site_id']=$_SESSION['site_id'];
			$_POST['date']=$mysql_tdate;
			$_POST['login_id']=mysql_real_escape_string($_SESSION['admin']);
	
			$insert1=insert_form($fields_name,$fields_dtype,$table,$fields_add);
			if($insert1==1){ 
				$quote_id = mysql_insert_id();
				
				//echo error("Quote Have Been Successfully Created");
				//include("source/view_quote.php");
				$_SESSION['query[txt]']= "Quote has been created Successfully";
				header("Location: /admin/index.php?task=edit_quote&quote_id=".$quote_id);
				//header("Location: /admin/index.php?task=view_quote");
				die();
				// create Quote Template, 
				// Show template and Ask to Send Email to Client 
				
				
			}else{
				disp_mysql_error();
			}
		}
	}


	if(($_POST['task']=="edit_quote") && ($_POST['step']==1)){
			$table="quote";
		$_SESSION['query[txt]']="";
		$fields_name=array("site_id","name","email","phone","bed","bath","property_type","blinds_type","carpet","c_bedroom",
		"c_lounge","c_stairs","booking_date","login_id","furnished","cleaning_amount","cleaning_hours","amount","carpet_amount",
		"pest_amount","gardening_amount","uphostry_amount","comments","per_hour","inspection_date","address","bbq_amount","oven_amount","job_ref","suburb");
		$fields_heading=array("Site Id","Name","Email","Phone","Bed","Bath","Property Type","Blinds Type","Carpet Yes/No","Carpet Bedrooms","Carpet Lounge",
		"Carpet Stairs","Booking Date","login Id","furnished","cleaning_amount","cleaning_hours","amount","carpet_amount",
		"pest_amount","gardening_amount","uphostry_amount","Comments","Per Hour","inspection_date","address","bbq_amount","oven_amount","job_ref","Suburb");
		
		//$fields_validation=array(0,1,0,1,1,1,1,1,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0);
		$fields_validation=array(0,0,1,0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1);
		$fields_dtype=array(0,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
		$fields_add=array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
		
		$step = $_POST['step'];
		
		if ($step==1){
				$step=check_form($fields_name,$fields_validation,$fields_heading);
				/*if ($step==2){
					
					if(strtoupper($_POST['code']) != $_SESSION['captcha_phrase']){
						$_SESSION['query[txt]']= "Incorrect Verification Code.<br>";
						$_SESSION['query[error]'] = 1;
						$step=1;
					}				
				}*/
		}
		//echo "This is step a:".$step;
		 if ($step==2){ 
			//letscheckproxy();
			
			$_POST['status']=0;
			// 0 = not active , 1 = active , 2 = pending
			//$_POST['site_id']=$_SESSION['site_id'];
			//$_POST['date']=$mysql_tdate;
			$_POST['login_id']=mysql_real_escape_string($_SESSION['admin']);
	
			//$insert1=update_form($fields_name,$fields_dtype,$table,$fields_add);
			$insert1 = modify_form($fields_name,$fields_add,$fields_dtype,$table,$_REQUEST['quote_id']);

			$job_id = get_rs_value("quote","booking_id",$_REQUEST['quote_id']);
			if($job_id!=""){
				$job_site_id = get_rs_value("jobs","site_id",$job_id);
				if($_POST['site_id']!=$job_site_id){
					$bool = mysql_query("update jobs set site_id='".$_POST['site_id']."' where id=".$job_id."");	
					$bool = mysql_query("update job_details set site_id='".$_POST['site_id']."' where job_id=".$job_id."");	
				}
			}
			$_SESSION['query[txt]']= "Quote has been Edited";
			
			//echo $_SESSION['query[txt]'];
			//header("Location: /admin/index.php?task=view_quote");
			//die();				
			
		}	
	}
	
	



}


?>
