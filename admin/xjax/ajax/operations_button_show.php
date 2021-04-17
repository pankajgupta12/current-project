
<?php  

session_start();
include_once("../../source/functions/functions.php");
include_once("../../source/functions/config.php");
  
		$pageid = $_POST['page'];
		$id = $_POST['id'];
		
		
		if($pageid == 'fdata') {
	         $fname = $_POST['fname'];
			 
   
	    	   if($fname == 'ans_date'){
				   $task_result = 'Operation Answered';
				  // $ans_date = date('Y-m-d H:i:s');
				    $stage  = 1;
					$response_type = 1;
			   }else if($fname == 'left_sms_date'){
				 $task_result = 'Operation Left Message';   
				// $left_sms_date = date('Y-m-d H:i:s');
				 $stage  = 2;
				 $heaidng1 = 'Left Message in New Tab';
				 $response_type = 2;
			   }else if($fname == 'check_question'){
				 $task_result = 'CheckBox In New Tab  ';   
				// $check_question = date('Y-m-d H:i:s');
				 //$check_question = '0000-00-00 00:00:00';
				 $stage  = 2;
				 $response_type = 19;
				 
			   }else if($fname == 'bfr_img_ans_date'){
				   $task_result = 'Before Images Operation Answered';
				  // $ans_date = date('Y-m-d H:i:s');
				 //  $left_sms_date = '0000-00-00 00:00:00';
				    $stage  = 2;
					$response_type = 51;
					$heaidng1 = 'Answered in Before Images  Tab';
			   }else if($fname == 'bfr_img_not_ans_date'){
				 $task_result = 'Before Images  Operation Left Message';   
				// $left_sms_date = date('Y-m-d H:i:s');
				// $ans_date = '0000-00-00 00:00:00';
				 $stage  = 2;
				 $heaidng1 = 'Left Message in Before Images  Tab';
				 $response_type = 2;
			   }else if($fname == 'bfr_img_checked_date'){
				 $task_result = 'CheckBox In Before Images  ';   
				// $check_question = date('Y-m-d H:i:s');
				 //$check_question = '0000-00-00 00:00:00';
				 $stage  = 2;
				
				 $response_type = 53;
				 
			   }
			   
			   $getsales_follow = mysql_fetch_assoc(mysql_query("Select id ,quote_id , job_id ,  fallow_date ,fallow_time, task_manager_id from sales_task_track where id=".$id.""));
			   
			   $job_id = $getsales_follow['job_id'];
			   $quote_id = $getsales_follow['quote_id'];
			   $task_manager_id = $getsales_follow['task_manager_id'];
			   $fallow_date = $getsales_follow['fallow_date'];
			   $fallow_time = $getsales_follow['fallow_time'];
			   
			    $bool = mysql_query("update sales_task_track set $fname ='".date('Y-m-d H:i:s')."' , stages = ".$stage."   where id=".$id."");
			   add_task_manager($id , $quote_id  , 2 , $fallow_date , $fallow_time ,$response_type ,$task_manager_id ,  $job_id);
			 //  add_sales_follow($id , $quote_id , '' , '' , $task_result ,$ans_date , $left_sms_date, 2); 
			    $heading = $task_result;
				
				//if($response_type == 19) {
				   $heading1 = $task_result;
				   add_job_notes($job_id,$heading1,$heading1);
				//}
			  //  add_job_notes($quote_id,$heading,$heading);
		}else if($pageid == 'emailsms') {
			
			echo 'Ok';
			
		}elseif($pageid == 'schedule') {
			
			$scheduletype = $_POST['scheduletype'];
			$getsalesdetails = mysql_fetch_assoc(mysql_query("Select quote_id , id ,site_id ,  stages from sales_task_track where id=".$id));
			$site_id = $getsalesdetails['site_id'];		
			$quote_id = $getsalesdetails['quote_id'];
			$stages = $getsalesdetails['stages'];	
			 
			 $getsales_follow = mysql_fetch_assoc(mysql_query("Select * from sales_follow where sales_id=".$id." Order by id desc limit 0 , 1"));
			 $task_result = $getsales_follow['task_result'];
			 
			 
			if($scheduletype == 2) { 
			  
  			    $time = date('H'); 	
				
			    $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
			      $sql = mysql_query("SELECT id , schedule_time FROM `site_time_slot` WHERE site_id = ".$site_id." and slot_from > ".$time." limit 0 , 1");
				if(mysql_num_rows($sql) > 0) {
					    $date = date('Y-m-d');
				
						$getdata = mysql_fetch_assoc($sql);
						//$gettime = $getdata['id'];
						$schedule_time1 = $getdata['schedule_time'];

						$heading = "Call Auto Re-Schedule by $staff_name time ".$date." (".$schedule_time1.")";
						
				}else {
					
					$sql = mysql_query("SELECT id , schedule_time FROM `site_time_slot` WHERE site_id = ".$site_id." limit 0 , 1");
					$todaydate = date('Y-m-d');
			        $date = date('Y-m-d',strtotime($todaydate . "+1 days"));
					
				    	$getdata = mysql_fetch_assoc($sql);
						
						$schedule_time1 = $getdata['schedule_time'];
						
						$heading = "Call Auto Re-Schedule by $staff_name time ".$date." (".$schedule_time1.")";
					
				} 
				
				    $next_action = 'Operation Follow up auto';
					
					$timedate = explode('-',$schedule_time1);
					$time = date('H:i:s' , strtotime("+15 minutes", strtotime($timedate[0])));
					$fallow_date  = $date .' '.$time;
				
				 $bool = mysql_query("update sales_task_track set fallow_date ='".$fallow_date."' , fallow_created_date ='".$date."' , fallow_time = '".$schedule_time1."'   where id=".$id.""); 
				 
					
				$response_type = 9;
				$schedule_time_date = $schedule_time1;
			}else {
			   
			   $next_action = 'Operation  Follow up Schedule';
			   $fallowdate = $_POST['fallowdate'];
			   $schedule_time = $_POST['schedule_time'];
				
			   
			   $timedate = explode('-',$schedule_time);
			   $time = date('H:i:s' , strtotime("+15 minutes", strtotime($timedate[0])));
			   $fallow_date  = $fallowdate .' '.$time;
			   
			   $bool = mysql_query("update sales_task_track set fallow_date ='".$fallow_date."' , fallow_created_date ='".$fallowdate."' , fallow_time = '".$schedule_time."'   where id=".$id.""); 
			  
			   //$quote_id = get_rs_value("sales_system","quote_id",$id);
			  $schedule_time_date = $schedule_time;
			  $response_type = 10;
			  $heading = ' Operation Call Schedule at'.$fallow_date;
			}
			// $lastid = CreateSalesTask($id);
			 //  $ans_date = '0000-00-00 00:00:00';  left_sms_date
			 
			   $getsales_follow = mysql_fetch_assoc(mysql_query("Select job_id , task_manager_id , fallow_date , fallow_time from sales_task_track where id=".$id.""));
			
			   $task_manager_id = $getsales_follow['task_manager_id'];
			   $fallow_date = $getsales_follow['fallow_date'];
			   $fallow_time = $getsales_follow['fallow_time'];
			   $job_id = $getsales_follow['job_id'];
			   
			   add_task_manager($id , $quote_id  , 2 ,$fallow_date , $fallow_time ,$response_type ,$task_manager_id ,  $job_id);
			   /* 
			  add_sales_follow($id , $quote_id , $fallow_date , $next_action , $task_result , '' ,'' );
			  add_quote_notes($quote_id,$heading,$heading); */
			
			
		}
		
		$argsql1 = mysql_query("select * from sales_task_track  where id = ".$_POST['id'].""); 
		$getdata = mysql_fetch_array($argsql1) ;
		
		//print_r($getdata);
			
		$getqdetails = mysql_fetch_assoc(mysql_query("select id , booking_id ,name , emailed_client  ,  sms_quote_date ,amount ,  step ,denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND id = ".$getdata['quote_id'].""));
		
		include_once('get_operations_sales_page.php'); 
?>