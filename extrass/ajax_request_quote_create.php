<?php 
 //print_r($_POST); die;

session_start();
include("../../../admin/source/functions/functions.php");
include("../../../admin/source/functions/config.php");


//echo "<pre>"; print_r($_POST); die;
	if(isset($_POST['step']) == '1' &&  $_POST['quote_type'] == 'create_quote') {
        if(isset($_POST)){
			
	    	$secret = base64_decode($_POST['secret']);
	    //	echo  "select id , step   from quote_new where ssecret ='".mysql_real_escape_string($secret)."'"; die;
			$quotedetails = mysql_fetch_object(mysql_query("select id , step   from quote_new where ssecret ='".mysql_real_escape_string($secret)."'"));
			
			//print_r($quotedetails); die;
			
			$quote_id = $quotedetails->id;
			$quote_step = $quotedetails->step; 
			$task_manager_id = 0; 
	
			$suburb = mysql_real_escape_string($_POST['suburb']);	
			$booking_date = mysql_real_escape_string($_POST['booking_date']);	
			$bedroom = mysql_real_escape_string($_POST['bedroom']);	
			$bathroom = mysql_real_escape_string($_POST['bathroom']);	
			$furnished = mysql_real_escape_string($_POST['furnished']);	
			$living_area = mysql_real_escape_string($_POST['living_area']);	
			$house_type = mysql_real_escape_string($_POST['house_type']);	
			$blinds = mysql_real_escape_string($_POST['blinds']);	
			$address = mysql_real_escape_string($_POST['address']);	
			
			$errors = array();
		
			if(empty($suburb)){
					$errors['suburb'] = 'Please enter a suburb.';				
				}
			 if(empty($booking_date)){
				$errors['booking_date'] = 'Please enter a job date.';				
			}
			if(empty($bedroom)){
				$errors['bedroom'] = 'Please enter a bedroom.';				
			}
			 if(empty($bathroom)){
				$errors['bathroom'] = 'Please enter a bathroom.';				
			}
			 if(empty($living_area)){
				$errors['living_area'] = 'Please enter a living area.';				
			}
			if(empty($furnished)){
				$errors['furnished'] = 'Please enter a furnished.';				
			}
			if(empty($house_type)){
				$errors['house_type'] = 'Please enter a house type.';				
			}
			
			if(empty($blinds)){
				$errors['blinds'] = 'Please enter a blinds';				
			}
			if(empty($address)){
				$errors['address'] = 'Please enter a address.';				
			}		
				if(count($errors) > 0){
					if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
							echo json_encode($errors);
							exit;
						 }
				//This is when Javascript is turned off:
						   echo "<ul>";
						   foreach($errors as $key => $value){
						  echo "<li>" . $value . "</li>";
						   }
						   echo "</ul>";exit;
								   
			}else{
			 
			
			 $update1 = mysql_query("UPDATE quote_new SET suburb = '".$suburb."',booking_date = '".$booking_date."',step = '2',address = '".$address."'  WHERE id = '".$quote_id."'" );
				
				
			$quote_detailsData_Cleaning = mysql_query("UPDATE quote_details SET bed='".$bedroom."',bath='".$bathroom."',living='".$living_area."',furnished='".$furnished."',property_type='".$house_type."',blinds_type='".$blinds."'  WHERE quote_id= '".$quote_id."' AND job_type_id = '1'"); 
			
				if(!empty($_POST['job_type'])) {
						foreach($_POST['job_type'] as $jobkey=>$jobType) {	
								if($jobType == '2'){
									$getjobtype = 'Carpet';
								}else{
									$getjobtype = 'Pest';
								}
				         //mysql_query("UPDATE quote_details SET bed='".$bedroom."',bath='".$bathroom."',living='".$living_area."',furnished='".$furnished."',property_type='".$house_type."',blinds_type='".$blinds."'  WHERE quote_id= '".$quote_id."' AND job_type_id = '".$jobType."'"); 
					    
					  $getquotedetails = mysql_query("Select * from quote_details where quote_id= '".$quote_id."' and job_type_id='".$jobType."'");				
								
						if(mysql_num_rows($getquotedetails)>0) {
						  if($getjobtype == 'Carpet'){
							 mysql_query("UPDATE quote_details SET bed='".$bedroom."',bath='".$bathroom."',living='".$living_area."'  WHERE quote_id= '".$quote_id."' AND job_type_id = '".$jobType."'"); 
						  }else{
						      // mysql_query("UPDATE quote_details SET bed='".$bedroom."',bath='".$bathroom."',living='".$living_area."'  WHERE quote_id= '".$quote_id."' AND job_type_id = '".$jobType."'"); 
						  }
						 }else{
						     
							if($getjobtype == 'Carpet'){
							     mysql_query("INSERT INTO `quote_details` (`quote_id`, `job_type_id`, `job_type`, `bed`, `living`) VALUES ('".$quote_id."', '".$jobType."', '".$getjobtype."', '".$bedroom."', '".$living_area."')");
						        
							}else{
							      mysql_query("INSERT INTO `quote_details` (`quote_id`, `job_type_id`, `job_type`) VALUES ('".$quote_id."', '".$jobType."', '".$getjobtype."')");
							}
								
						}
					
					}
				} 
					
        		$quotequery = mysql_query("select * from quote_details where quote_id=".$quote_id."");
                	if(mysql_num_rows($quotequery)>0) {
                		while($getquotedata = mysql_fetch_array($quotequery)) {
                	       $desc = create_memberquote_desc_str($getquotedata);	
                	      mysql_query("update quote_details set description='".$desc."' where quote_id='".$quote_id."' AND  id='".$getquotedata['id']."'");
                		} 
        		}
		    
		    //$clientname have provided property info, Quote Waiting Admin Approval
		     $quote_name = get_rs_value("quote_new","name",$quote_id);
		     
		     $comment =  '<b>Info Given : </b> '.ucfirst($quote_name).' have provided property info, Quote Waiting Admin Approval';
			  
                $notificationArrayData = array(
                    'notifications_type' => 5,
                    'quote_id' =>$quote_id,
                    'job_id' => 0,
                    'staff_id' => 0,
                    'heading' => $comment,
                    'comment' => $comment,
                    'notifications_status' => 0,
                    'p_order' => 5,
                    'all_chat_type'=>'1',
                    'login_id' => $task_manager_id,
                    'staff_name' => $quote_name,
                    'date' => date("Y-m-d H:i:s")
                );
                add_site_notifications($notificationArrayData);
			    add_quote_notes($quote_id,$comment,$comment);
				
				if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

						$errors['done']='success';
						//$errors['MSG']='Work order has been added successfully.';
						echo json_encode($errors);
						//redirect('masterForm/raw_material_master');
						exit;
					}
			}
		}
	}
	

	
	
?>