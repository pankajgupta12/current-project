<?php 

include("source/functions/functions.php");
include("source/functions/config.php");



 $sql = mysql_query("SELECT id ,  job_id , job_type_id ,  staff_id  FROM `staff_jobs_status`    WHERE 1 = 1  and staff_id in (SELECT id from staff WHERE better_franchisee = 2)  ORDER by id desc LIMIT 0 , 10");
 
 //echo mysql_num_rows($sql);
 
  if(mysql_num_rows($sql) > 0) {
      
        while($data = mysql_fetch_array($sql)) {
         
		     $sql1 = mysql_query("SELECT id, job_id ,  amount_total ,  amount_staff, amount_profit FROM `job_details`  where job_id = '".$data['job_id']."' AND job_type_id = '".$data['job_type_id']."'");
			 
			 $getdata = mysql_fetch_assoc($sql1);
			 
			 echo $getdata['amount_total'] .'=='.$getdata['job_id'] .'=='.$getdata['job_type_id'] .'=='.$getdata['staff_id'].'<br/>';
			 
            
        }
      
  }


?>