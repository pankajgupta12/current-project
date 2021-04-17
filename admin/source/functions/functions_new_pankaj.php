<?php 

function getSubStaff_data() {
			    $arg = "SELECT id, mobile,name FROM `sub_staff` where  status = 1";
			    $sql = mysql_query($arg);
	   
				   while($data = mysql_fetch_assoc($sql)) {
					  $substaffdetails[] = $data;
				   }
				   return $Substaffdetails;
		}
		
	function getJobDetailsInDishpatch($jobid){
		
		//$sql = mysql_query("SELECT Q.booking_id as jobid , Q.name as name, Q.suburb as suburb,  (SELECT name FROM `system_dd` WHERE `type` = 26 AND id = J.status  ) as statudata, J.status as statua FROM `quote_new` Q, jobs J WHERE Q.booking_id = J.id  AND J.id = ".$jobid."");
		$sql = mysql_query("SELECT Q.booking_id as jobid , Q.name as name, Q.suburb as suburb,  J.status as status  FROM `quote_new` Q, jobs J WHERE Q.booking_id = J.id  AND J.id = ".$jobid."");
		
		$data = mysql_fetch_assoc($sql);
		
		return $data;
	}	
	
	function getStaffOnDispatch($type = 0)
    {

		$arg = "select id , name, mobile, primary_post_code,better_franchisee from staff  where 1 = 1 AND status = 1";

		

		$sql = mysql_query($arg);

		while ($data = mysql_fetch_assoc($sql))
		{

			$staffdetails[$data['id']] = $data ;
			//$staffdetails[] = $data;

		}

		return $staffdetails;

    }

 function checkAmountPay($jobid){
	 
	   // $arg = "SELECT sum(amount_total) as jamt,  (SELECT sum(amount) as amt  FROM `job_payments` WHERE `job_id` = ".$jobid.") as Pamt    FROM `job_details` WHERE status  != 2 AND  job_id = ".$jobid."";
	    $arg = "SELECT GROUP_CONCAT(amount_total) as jamt, GROUP_CONCAT(job_type_id) as job_type_id, GROUP_CONCAT(reclean_job) as recleanjobs , (SELECT sum(amount) as amt  FROM `job_payments` WHERE `job_id` = ".$jobid.") as Pamt    FROM `job_details` WHERE status  != 2 AND  job_id = ".$jobid."";
	 $sql = mysql_query($arg);
	 $data = mysql_fetch_assoc($sql);
	 
	   $jamt = array_sum(explode(',',$data['jamt']));
		 if($data['Pamt']==""){ 
		    $payment_status = "(Not Paid)";
		}else if($data['Pamt']<$data['jamt']){
		    $payment_status = "(Semi)";
		}else if($data['Pamt']>=$data['jamt']){
		    $payment_status = "(Paid)";
		}
		$jobtypeid = explode(',',$data['job_type_id']);
		$recleanjobs = explode(',',$data['recleanjobs']);
		if(in_array(1, $jobtypeid)) {
			
			$recleanjobs = $recleanjobs[0];
		}
		
		$data = array('payment_status'=>$payment_status , 'recleanjobs'=>$recleanjobs);
		
		//print_r($data);
		
	 return $data;	 
 }	


?>