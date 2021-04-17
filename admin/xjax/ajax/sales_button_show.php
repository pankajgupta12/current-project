
<?php  

session_start();
include_once("../../source/functions/functions.php");
include_once("../../source/functions/config.php");
  
		$pageid = $_POST['page'];
		$id = $_POST['id'];
		
		
		if($pageid == 'fdata') {
	         $fname = $_POST['fname'];
			 
			 //$quote_id = get_rs_value("sales_task_track","quote_id",$id);
   
	    	   if($fname == 'ans_date'){
				   $task_result = 'Answered';
				   $ans_date = date('Y-m-d H:i:s');
				   $left_sms_date = '0000-00-00 00:00:00';
				    $stage  = 1;
					$response_type = 1;
			   }else if($fname == 'left_sms_date'){
				 $task_result = 'Left Message';   
				 $left_sms_date = date('Y-m-d H:i:s');
				 $ans_date = '0000-00-00 00:00:00';
				 $stage  = 2;
				 $response_type = 2;
			   }
			   
			   $getsales_follow = mysql_fetch_assoc(mysql_query("Select id ,quote_id , fallow_date ,fallow_time, task_manager_id from sales_task_track where id=".$id.""));
			   
			   $quote_id = $getsales_follow['quote_id'];
			   $task_manager_id = $getsales_follow['task_manager_id'];
			   $fallow_date = $getsales_follow['fallow_date'];
			   $fallow_time = $getsales_follow['fallow_time'];
			   
			    $bool = mysql_query("update sales_task_track set $fname ='".date('Y-m-d H:i:s')."' , stages = ".$stage."   where id=".$id."");
			   add_task_manager($id , $quote_id  , 1 , $fallow_date , $fallow_time ,$response_type ,$task_manager_id ,  0);
			   add_sales_follow($id , $quote_id , '' , '' , $task_result ,$ans_date , $left_sms_date); 
			    $heading = $task_result;
			    add_quote_notes($quote_id,$heading,$heading);
		}else if($pageid == 'emailsms') {
			
		  	//print_r($_POST); 
			
			$fname = $_POST['fname'];
			$type = $_POST['type'];
			$textid = $_POST['textid'];
			
			$quote_id = get_rs_value("sales_task_track","quote_id",$id);
			
			$getqdetails = mysql_fetch_assoc(mysql_query("Select *  from quote_new where id=".$quote_id));
			$sqltpl = mysql_fetch_assoc(mysql_query("Select *  from sales_template where id=".$textid));
			
			 //$salesmessage = get_sql("sales_template","message"," where id=".$textid);
			
			  $adminname = get_rs_value("admin","name",$_SESSION['admin']);
			  //$sitename = get_rs_value("site","name",$getqdetails['site_id']);
			  
			  
			   if($getqdetails['ssecret']==""){ 
					$secret = str_makerand ("15","25",true,false,true); 
					$bool = mysql_query("update quote_new set ssecret='".mres($secret)."' where id=".mres($quote_id)."");
				}else{ 
					$secret = $getqdetails['ssecret'];
				}
				
		//echo $secret; die;		
			$siteUrl = get_rs_value("siteprefs","site_url",1);	
			$url = $siteUrl."/members/quote/index.php?action=checkkey&secret=".$secret;	
			$getURL = createbitLink($url,'business2sell','R_3e3af56c36834837ba96e7fab0f4361a','json'); 
			  
			//echo $getURL; die;  
			  
			   $siteUrl = get_rs_value("siteprefs","site_url",1);		
			  $qid = base64_encode(base64_encode($getqdetails['id']));
			  $shorturl = $siteUrl.'/thank-you.php?action=thankyou&token='.$qid;
			  $spamlink = createbitLink($shorturl,'business2sell','R_3e3af56c36834837ba96e7fab0f4361a','json'); 
			  
			  $quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=".$getqdetails['quote_for'].""));
			 // $quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=".$getqdetails['site'].""));
			
			/* <a  style="padding: 6px;text-decoration: none;color: #000; margin-bottom:10px; display: inline-block; border-radius: 4px;" href="<?php echo $url; ?>" ><img  src="<?php echo $Protocol.$_SERVER['SERVER_NAME']; ?>/admin/images/book_online.png"/></a> */
             $Protocol = ($_SERVER['HTTPS'] == 'on') ? "https://" : "http://" ;
			 
			 /* $getlink =  '<a style="padding: 6px;text-decoration: none;color: #000; margin-bottom:10px; display: inline-block; border-radius: 4px;" href="'.$getURL.'" target="_blank"><img  src="'.$Protocol.$_SERVER['SERVER_NAME'].'/admin/images/book_online.png"/></a>'; */
			 
			 $getlink = '<span style="color:#e46c0a;font-size: 22px;"><strong><u><a href="'.$getURL.'"  target="_blank">CLICK HERE TO BOOK ONLINE NOW</a></u></strong></span>';
			 
			 //<span style="color:#a52a2a;"><strong><u>CLICK HERE TO BOOK ONLINE NOW</u></strong></span>
			 $booksmslink = $getURL;
			 $booksmslinkwitjlink = '<a href="'.$getURL.'">'.$getURL.'</a>';
			 $s_number = '<a href="tel:'.$quote_for_option['phone'].'">'.$quote_for_option['phone'].'</a>';
			 
			// echo $getqdetails['site_id'];
			  if($textid == 7) {
			    $location = get_rs_value("sites","br_domain_text",$getqdetails['site_id']);		
			  }else{
			   $location = get_rs_value("sites","domain_text",$getqdetails['site_id']);		
			   }
			  
			   
			$getname = array('$cname' ,'$booknow' ,'$name' ,'$s_number' ,'$spamlink' ,'$quotforname' ,'$adminname','$location','$booksmslink' ,'\r\n');
			$replacedlink = array($quote_for_option['name'] ,$getlink ,$getqdetails['name'] ,$s_number ,$spamlink ,$quote_for_option['name'] ,$adminname , $location ,$booksmslink  ,''); 
			 
			/* print_r($getname);
			print_r($replacedlink); */
			
			 $salesmessage =  str_replace($getname , $replacedlink , ($sqltpl['message']));
			 if($type == 2){
				 
					$getname = array('$cname' ,'$booknow' ,'$name' ,'$s_number' ,'$spamlink' ,'$quotforname' ,'$adminname','$location','$booksmslink' ,'\r\n');
					$replacedlink = array($quote_for_option['name'] ,$getlink ,$getqdetails['name'] ,$s_number ,$spamlink ,$quote_for_option['name'] ,$adminname , $location ,$booksmslinkwitjlink  ,''); 
				 
			   $salesmessage_text =  str_replace($getname , $replacedlink , ($sqltpl['message']));
			 }
			 $subject = 'Q#'.$getqdetails['id'] .'- '.$sqltpl['subject'];
			
				
			 
			// $cname = get_rs_value("sales_system","name",$id);
			 if($fname == 'threed_sms') {
				 $fnamedata = 'Third SMS';
			 }else{
			    $fnamedata = Ucfirst(str_replace('_', ' ' , $fname));
			 }
			// echo  $type; die;
			if($type == 1) {
				  $response_type = ($textid-1);
				  $task_result = $fnamedata . ' Send to '.$getqdetails['name']; 
				   $sendfrom = $quote_for_option['booking_email'];	
				   $heading = $fnamedata . ' Send to '.$getqdetails['name'];
				  // $subject = $quote_id.' Please cehck '.$fnamedata;
				 sendmail($getqdetails['name'],$getqdetails['email'],$subject,$salesmessage,$sendfrom,$getqdetails['site_id'] , $getqdetails['quote_for']);
				//sendmail($getqdetails['name'],'ankit.business2sell@gmail.com',$subject,$salesmessage,$sendfrom,$getqdetails['site_id'] , $getqdetails['quote_for']); 
				// sendmail($getqdetails['name'],'pankaj.business2sell@gmail.com',$subject,$salesmessage,$sendfrom,$getqdetails['site_id'] , $getqdetails['quote_for']); 
				$bool = mysql_query("update sales_task_track set $fname ='".date('Y-m-d H:i:s')."'   where id=".$id.""); 
				// $lastid = CreateSalesTask($id);
				   
			}else if($type == 2){
			 
				 
				$response_type = ($textid + 5);
				$mobile = $getqdetails['phone'];
				 
				 $sms_code = send_sms(str_replace(" ","",$mobile),mysql_real_escape_string($salesmessage));
				// $sms_code = send_sms(str_replace(" ","",'11111111111'),mysql_real_escape_string($salesmessage));
				
				if($sms_code == 1) {
					  $smsstatus   =" (Delivered)"; 
					  $bool = mysql_query("update sales_task_track set $fname ='".date('Y-m-d H:i:s')."'   where id=".$id.""); 
				}else {
					 $smsstatus ="<span style=\"color:red;\"> (Failed)</span>"; 
				} 
				//$smsstatus = '';
				$heading = $fnamedata.' send on '.$mobile.$smsstatus;
				$task_result = $fnamedata . ' Send to '.$mobile.$smsstatus; 
				//$bool = mysql_query("update sales_task_track set $fname ='".date('Y-m-d H:i:s')."'   where id=".$id.""); 
			}
			
			$getsales_follow = mysql_fetch_assoc(mysql_query("Select task_manager_id , fallow_date , fallow_time from sales_task_track where id=".$id.""));
			
			   $task_manager_id = $getsales_follow['task_manager_id'];
			   $fallow_date = $getsales_follow['fallow_date'];
			   $fallow_time = $getsales_follow['fallow_time'];
			
			   add_task_manager($id , $quote_id  , 1 ,$fallow_date , $fallow_time ,$response_type ,$task_manager_id ,  0);
			   add_quote_notes($quote_id,$heading,$salesmessage_text);
			   add_sales_follow($id , $quote_id , '' , '' , $task_result ,'' , ''); 
			
			 
		}elseif($pageid == 'schedule') {
			
			$scheduletype = $_POST['scheduletype'];
			$getsalesdetails = mysql_fetch_assoc(mysql_query("Select quote_id , id ,site_id ,  stages from sales_task_track where id=".$id));
			$site_id = $getsalesdetails['site_id'];		
			$quote_id = $getsalesdetails['quote_id'];
			$stages = $getsalesdetails['stages'];	
			$keyid = $_POST['keyid'];	
			 
			 $getsales_follow = mysql_fetch_assoc(mysql_query("Select * from sales_follow where sales_id=".$id." Order by id desc limit 0 , 1"));
			 $task_result = $getsales_follow['task_result'];
			 
			 
			if($scheduletype == 2) { 
			  
	           //$stages = 2;
	           
	            if($stages == 1) {
				   $stages = 3;
				}else if($stages == 3 || $stages == 2) {
					 $stages = 4;
				}else if($stages == 4) {
					 $stages = 5;
				}else if($stages == 5) {
					 $stages = 5;
				}
				
	            $follow_data =  dd_value(119);
			    
			   
			    
			    
				
				/* 2:10 pm
				Time in Perth WA, Australia

				5:10 pm
				Time in Melbourne VIC, Australia

				4:10 pm
				Time in Gold Coast QLD, Australia

				5:10 pm
				Time in Sydney NSW, Australia */
			   
			   
			  /*   $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
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
					
				}  */
				
					    $ct = date('H:i');
						if($ct < $follow_data[$keyid]) {
							$date = date('Y-m-d');
						}else{
							$date1 = date('Y-m-d');
							$date = date('Y-m-d',strtotime('+1 day',strtotime($date1)));
						}
				
				
				
				$gettime = $follow_data[$keyid];
				
				 $site_id = get_rs_value("quote_new","site_id",$quote_id);
				if($site_id == 10){
					$gettime = date('H:i',strtotime('- 3 hour',strtotime($gettime)));
					$schedule_time = $gettime .'-'.date('H:i',strtotime('+30 minutes',strtotime($gettime)));
				}elseif($site_id == 1 || $site_id == 5){
					$gettime = date('H:i',strtotime('- 1 hour',strtotime($gettime)));
					$schedule_time = $gettime .'-'.date('H:i',strtotime('+30 minutes',strtotime($gettime)));
				}else{
					$schedule_time = $gettime .'-'.date('H:i',strtotime('+30 minutes',strtotime($gettime)));
				}
				
				
				$heading = "Call Auto Re-Schedule by $staff_name time ".$date." (".$schedule_time.")";
				
				    $next_action = 'Follow up auto';
					
					$timedate = explode('-',$schedule_time);
					$time = date('H:i:s' , strtotime("+15 minutes", strtotime($timedate[0])));
					$fallow_date  = $date .'-'.$time;
				
								
				
				 $bool = mysql_query("update sales_task_track set fallow_date ='".$fallow_date."' ,stages ='".$stages."' , fallow_created_date ='".$date."' , fallow_time = '".$schedule_time."'   where id=".$id.""); 
				 
					
				$response_type = 9;
				$schedule_time_date = $schedule_time1;
			}else {
			   
			   $next_action = 'Follow up Schedule';
			   $fallowdate = $_POST['fallowdate'];
			   $schedule_time = $_POST['schedule_time'];
				
				if($stages == 1) {
				   $stages = 3;
				}else if($stages == 3 || $stages == 2) {
					 $stages = 4;
				}else if($stages == 4) {
					 $stages = 5;
				}else if($stages == 5) {
					 $stages = 5;
				}
			   
			   
			   $timedate = explode('-',$schedule_time);
			   $time = date('H:i:s' , strtotime("+15 minutes", strtotime($timedate[0])));
			   $fallow_date  = $fallowdate .' '.$time;
			   
			   $bool = mysql_query("update sales_task_track set fallow_date ='".$fallow_date."' ,stages ='".$stages."' , fallow_created_date ='".$fallowdate."' , fallow_time = '".$schedule_time."'   where id=".$id.""); 
			  
			   //$quote_id = get_rs_value("sales_system","quote_id",$id);
			  $schedule_time_date = $schedule_time;
			  $response_type = 10;
			  $heading = ' Call Schedule at'.$fallow_date;
			}
			// $lastid = CreateSalesTask($id);
			 //  $ans_date = '0000-00-00 00:00:00';  left_sms_date
			 
			   $getsales_follow = mysql_fetch_assoc(mysql_query("Select task_manager_id , fallow_date , fallow_time from sales_task_track where id=".$id.""));
			
			   $task_manager_id = $getsales_follow['task_manager_id'];
			   $fallow_date = $getsales_follow['fallow_date'];
			   $fallow_time = $getsales_follow['fallow_time'];
			
			   add_task_manager($id , $quote_id  , 1 ,$fallow_date , $fallow_time ,$response_type ,$task_manager_id ,  0);
			   
			  add_sales_follow($id , $quote_id , $fallow_date , $next_action , $task_result , '' ,'' );
			  add_quote_notes($quote_id,$heading,$heading);
			  
		}elseif($pageid == 'stepupdate') {
			 // print_r($_POST);  die;
			  
			//  var DataString = 'id='+id+'&qid='+qid+'&fname='+fname+'&page=stepupdate&value='+value;
			
			$strvalue[1] = $_POST['qid'];
			$strvalue[0] = $_POST['value'];
			
				$quotedetails = mysql_fetch_assoc(mysql_query("Select step , login_id from quote_new where id=".$strvalue[1]));
			
				$stepid = $quotedetails['step'];
				$getid = $strvalue[0];
				
				$name = getSystemvalueByID($getid,31);
				$stepname = getSystemvalueByID($stepid,31);
				$heading = "Quote Step change ".$stepname." to ".$name."";
				add_quote_notes($strvalue[1],$heading,$heading);
				
				 if($getid == 6 || $getid == 5 || $getid == 7)
				{
					$bool = mysql_query("update quote_new set step='".$strvalue[0]."'  , denied_id = 0 where id=".mres($strvalue[1])."");
				}
				else
				{
					$bool = mysql_query("update quote_new set step='".$strvalue[0]."' where id=".mres($strvalue[1])."");
				} 
				
				 $getsales_follow = mysql_fetch_assoc(mysql_query("Select task_manager_id , quote_id , fallow_date , fallow_time from sales_task_track where id=".$id.""));
			
				$quote_id = $getsales_follow['quote_id'];
				$task_manager_id = $getsales_follow['task_manager_id'];
				$fallow_date = $getsales_follow['fallow_date'];
				$fallow_time = $getsales_follow['fallow_time'];
				$response_type = 11;
				$next_action = 'Quote In C-Denied';
				$task_result = 'Quote In C-Denied';
			    add_task_manager($id , $quote_id  , 1 ,$fallow_date , $fallow_time ,$response_type ,$task_manager_id ,  0);
				add_sales_follow($id , $quote_id , $fallow_date , $next_action , $task_result , '' ,'' );
				
					/* if($quotedetails['login_id'] == 0) {
						
						$bool = mysql_query("update quote_new set login_id='".$_SESSION['admin']."' where id=".mres($strvalue[1])."");
					}  */
			//  $lastid = CreateSalesTask($id);
			  // add_sales_follow($strvalue[1] , $quote_id , $fallow_date , $next_action , $task_result , '' ,'' );
			  //$heading = 'Quote  Denied'
			 // add_quote_notes($strvalue[1],$heading,$heading);
		}
		
		//echo  "select * from sales_task_track  where id = ".$lastid."";
		
		$argsql1 = mysql_query("select * from sales_task_track  where id = ".$_POST['id'].""); 
		$getdata = mysql_fetch_array($argsql1) ;
		
		//print_r($getdata);
			
		$getqdetails = mysql_fetch_assoc(mysql_query("select id , booking_id ,name ,moving_from ,is_flour_from ,  emailed_client  ,  sms_quote_date ,amount ,  step ,denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND id = ".$getdata['quote_id'].""));
		
		include_once('get_sales_page.php'); 
?>