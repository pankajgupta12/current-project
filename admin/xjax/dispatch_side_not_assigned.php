<?php

$job_arg = "select id,quote_id,site_id,status  from jobs where status=1 and id in(select job_id from job_details where staff_id=0 and status!=2) order by id desc limit 0,50";
$jobs_data = mysql_query($job_arg);
			
//echo '<li><span class="stev_john"><strong>Jobs Not Assigned</strong></span></li>';
echo '<ul class="cret_right_ul">';		

while($jobs = mysql_fetch_assoc($jobs_data)){ 
			
			$quote = mysql_fetch_array(mysql_query("select id , address , name,phone,address,suburb,amount,booking_date from quote_new where id=".$jobs['quote_id'].""));
			$job_details = mysql_query("select id ,job_id , site_id,job_type,amount_total,staff_id from job_details where job_id=".$jobs['id']."");
			
			/*$job_str = $job_details['job_type'].": ";
			if($job_details['job_type_id']=="1"){ 
				$quote['bed'].' Bed '.$quote['bath'].' Bath ';
				if($quote['furnished']=="Yes"){ $job_str.=" Furnished "; } 
				if($quote['carpet']=="Yes"){ 
					$job_str.=", Carpet:".$quote['c_bedroom'].' Bed with '.$quote['c_lounge'].' Lounge';
					if($quote['c_stairs']!=""){ $job_str.= " & ".$quote['c_stairs']." Stairs"; }
					//$job_str.="";
				}			
			}*/
			
			$site_name = get_rs_value("sites","name",$jobs['site_id']);
			
			if($quote['address']==""){ $quote['address'] = '<em>No Address Added</em>'; } 
			//if($jobs['status']=="3"){ $tdclass='green'; }elseif($jobs['status']=="1"){ $tdclass='red'; }else if($jobs['status']=="4"){ $tdclass='orange'; } 
			
		echo "";
			echo	'<li class="td_back">
						<span class="stev_john"><strong>'.$quote['name'].'</strong> <span class="date_right">';
						echo "<a href=\"javascript:scrollWindow('popup.php?task=jobs&job_id=".$jobs['id']."','1200','850')\">";
						echo '<strong>#'.$jobs['id'].'</strong></a></span></span>
						<span class="stev_john">'.$quote['phone'].' <span class="date_right">'.changeDateFormate($quote['booking_date'],'datetime').'</span></span>
						<span class="stev_john">'.$quote['address'].'</span>
						<span class="stev_john">'.$site_name.' '.$quote['suburb'].'<span class="date_right"><strong>$'.$quote['amount'].'</strong></span></span>
						<span class="stev_john">';
							  
          echo '<table class="staff-table">
                <thead><tr>
                  <th>Type</td>
                  <th>Amount</td>
                  <th>Cleaner</td>
                </tr></thead><tbody>';
				
				
				while($jdetails = mysql_fetch_assoc($job_details)){ 
				
					$cond = " (site_id=".$jdetails['site_id']." or site_id2=".$jdetails['site_id']." OR find_in_set( ".$jdetails['site_id']." , all_site_id))  and job_types like '%".$jdetails['job_type']."%' and status=1";
					//$onchange = "onchange=\"javascript:send_data('staff_id_".$jdetails['id']."','','div_staff_id_".$jdetails['id']."');\"";					
					$onchng = "onchange=\"javascript:assing_jobs('".$jdetails['id']."','".$jdetails['job_id']."','staff_id_".$jdetails['id']."');\" style=\"font-size: 12px;\"";					
					if($jdetails['amount_total']>0){ 
						echo '<tr>
						  <td  class="text12">'.$jdetails['job_type'].'</td>
						  <td  class="text12">'.$jdetails['amount_total'].'</td>
						  <td  class="text12" id="div_staff_id_'.$jdetails['id'].'">'.create_dd_staff("staff_id_".$jdetails['id'],"staff","id","name",$cond,$onchng,$jdetails['staff_id']).'</td>
						</tr>';
					}
				}
				
          echo '</tbody></table></span>';
		  //echo '</a>';	
		    if(in_array($_SESSION['admin'] , array(1,3,12,15,17))) {
		        echo '<span class="stev_john"><a href="javascript:delete_job(\''.$jobs['id'].'\');">[Delete]</a></span>';
			}
          echo '</li>';
	  
	}
echo '</ul>';
?>
	  
