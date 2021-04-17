<? 			
			if(isset($_SESSION['dispatch']['status']) || isset($_SESSION['dispatch']['keyword'])){ 
			
				$job_arg = "select id, quote_id , site_id, status from jobs where id>0 ";			
				
				if($_SESSION['dispatch']['status']!=""){ if($_SESSION['dispatch']['status']!="0"){ $job_arg.= " and status=".$_SESSION['dispatch']['status'];	 }	 }
				
				if(isset($_SESSION['dispatch']['keyword'])){ if($_SESSION['dispatch']['keyword']!=""){ 
					$job_arg.=" and id in (select booking_id from quote_new where name like '%".$_SESSION['dispatch']['keyword']."%' or 
					address like '%".$_SESSION['dispatch']['keyword']."%' or 
					phone like '%".$_SESSION['dispatch']['keyword']."%' or 
					booking_id like '%".$_SESSION['dispatch']['keyword']."%')"; 
				} }else{
					$first_month = strtotime( 'first day of ' . date( 'F Y'));
					$job_arg.=" and id in (select distinct(job_id) from job_details where staff_id!=0 and status!=2 and job_date>='".date("Y-m-d",$first_month)."')";
				}
				//$job_arg.=" order by id desc";
			//echo $job_arg."<br>";
			}else{
				$first_month = strtotime( 'first day of ' . date( 'F Y'));
				$job_arg = "select id, quote_id, site_id, status from jobs where id in (select distinct(job_id) from job_details where staff_id!=0 and status!=2 and job_date>='".date("Y-m-d",$first_month)."')";	
			}
		
			$job_arg.= " order by id desc limit 0,50 ";
			 //	echo $job_arg;
			$jobs_data = mysql_query($job_arg);

		  
		  
		   while($jobs = mysql_fetch_assoc($jobs_data)){ 
			
			$quote = mysql_fetch_array(mysql_query("select id , address , name,phone,address,suburb,amount,booking_date from quote_new where id=".$jobs['quote_id'].""));
			
			//$job_details = mysql_query("select * from job_details where job_id=".$jobs['id']."");
			
			/*$job_str = $quote['bed'].' Bed '.$quote['bath'].' Bath ';
			if($quote['furnished']=="Yes"){ $job_str.=" Furnished "; } 
			if($quote['carpet']=="Yes"){ 
				$job_str.=", Carpet:".$quote['c_bedroom'].' Bed with '.$quote['c_lounge'].' Lounge';
				if($quote['c_stairs']!=""){ $job_str.= " & ".$quote['c_stairs']." Stairs"; }
				//$job_str.="";
			}*/
			
			$site_name = get_rs_value("sites","name",$jobs['site_id']);
			if($quote['address']==""){ $quote['address'] = '<em>No Address Added</em>'; } 
			if($jobs['status']=="3"){ $tdclass='green'; }elseif($jobs['status']=="1"){ $tdclass='red'; }else if($jobs['status']=="4"){ $tdclass='orange'; }else if($jobs['status']=="5"){ $tdclass='darkred'; }  
			
			
			echo "<a href=\"javascript:scrollWindow('popup.php?task=jobs&job_id=".$jobs['id']."','1200','850')\">";
			echo	'<li class="td_back_'.$tdclass.'">
						<span class="stev_john"><strong>'.$quote['name'].'</strong> <span class="date_right"><strong>#'.$jobs['id'].'</strong></span></span>
						<span class="stev_john">'.$quote['phone'].' <span class="date_right">'.changeDateFormate($quote['booking_date'],'datetime').'</span></span>
						<span class="stev_john">'.$quote['address'].'</span>
						<span class="stev_john">'.$site_name.' '.$quote['suburb'].'<span class="date_right"><strong>$'.$quote['amount'].'</strong></span></span>
					</li>';
			echo '</a>';
			
	  
	  }
      
      ?>
