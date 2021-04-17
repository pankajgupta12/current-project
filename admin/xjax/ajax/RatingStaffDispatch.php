<?php 
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");
	$rating = mysql_real_escape_string($_POST['rating']);
	$staffID = mysql_real_escape_string($_POST['staffID']);
     $sql = mysql_query("UPDATE `staff` SET `staff_member_rating` = '".$rating."' WHERE `staff`.`id` = ".$staffID);
    if($sql){
	   
		if($_SESSION['dispatch']['from_date']==""){ $_SESSION['dispatch']['from_date'] = date("Y-m-d"); }

		$start_date_ts = strtotime($_SESSION['dispatch']['from_date']);
		$end_date_ts = $start_date_ts+(86400*7);
		$start_date_ts_h = $start_date_ts;
	   
		$staff_arg = "select * from staff where status=1";
		if(isset($_SESSION['dispatch']['site_id'])){ if($_SESSION['dispatch']['site_id']!="0"){ $staff_arg.=" and site_id=".$_SESSION['dispatch']['site_id']." "; } }
		if(isset($_SESSION['dispatch']['job_type'])){ if($_SESSION['dispatch']['job_type']!="0"){ $staff_arg.=" and job_types like '%".$_SESSION['dispatch']['job_type']."%'"; } }
		if(isset($_SESSION['dispatch']['staff_id'])){ if($_SESSION['dispatch']['staff_id']!="0"){ $staff_arg.=" and id =".$_SESSION['dispatch']['staff_id'].""; } }
		$staff_arg.= ' order by staff_member_rating desc';
	    $staff_table = mysql_query($staff_arg);
	  //echo "<pre>";   print_r($_SESSION);
    }
?>
<table id="stafforderSet">
 <thead>
    <tr>
      <th>STAFF</th>
      <?php 
				for($i=1;$i<=7;$i++){ 
					echo '<th>'.date("l",$start_date_ts_h).'<br><span class="table_span">'.date("dS M Y",$start_date_ts_h).'</span></th>';
					$start_date_ts_h = ($start_date_ts_h+86400);
				}
			?>
    </tr>
  </thead>

  <tbody>
    <?php
	
	/* $find_arr = array("Cleaning","Carpet","Uphostry","Upholstry","Pest","Gardening","Oven");
	$rep_arr = array("C","Ca","U","U","P","G","O"); */
	 $getjobSql =   mysql_query("SELECT name,short_name FROM `job_type`");
		while ($getjobname = mysql_fetch_assoc($getjobSql))
		{ 
	       $find_arr[] = $getjobname['name'];
	       $rep_arr[] = $getjobname['short_name'];
		}
	
	
	$rating = 1;
	while ($staff = mysql_fetch_assoc($staff_table))
	{ 
		$staff_location = get_rs_value("sites","name",$staff['site_id']);
		$job_type = str_replace($find_arr,$rep_arr,$staff['job_types']);
	?>
    <tr>
        <td>
	        <div class="td_back"><strong><?php if($staff['nick_name'] &&  $staff['nick_name'] !='') { echo $staff['nick_name']; }else {echo $staff['name'];}?></strong><br>
               <span class="text11">(<?php echo $staff_location;?>)  (<?php echo $job_type;?>)</span>
			   
			   <div class="tooltip_div">
					<span class="name_text">Name: <?php echo $staff['name'];?></span>
					<span class="name_text">Email: <?php echo $staff['email'];?> </span>
					<span class="name_text">Phone: <?php echo $staff['mobile'];?> </span>
					<!--<span class="name_text">Date: 01-Jan-2016 </span>
					<span class="name_text">Time: 06:00pm </span>
					<span class="name_text">Hours: 06:00</span>-->
					<!--<div id="jRate<?php echo $staff['id'];?>" style="height:50px;width: 200px;margin-left: -46px;"></div>-->
					<span class="name_text">
						<select id="soflow-color" name="ratingPoint" onChange="RatingStaffDispatchborad(this.value,'<?php echo $staff['id'];?>');">
						   <option>Select Rating</option>
							 <?php for($rating = 0; $rating<=5; $rating++) {?>
							   <option value="<?php echo $rating; ?>" <?php if($staff['staff_member_rating'] == $rating) {echo  "selected";} ?>><?php echo $rating; ?></option>
							 <?php } ?>
						</select>
					</span>
					<ul class="tooltip_ul">
						<li><a onclick="javascript:scrollWindow('staff_details.php?task=edit_staff&id=<?php echo $staff['id'];?>','1200','850')" >Modify</a></li>
						<li><a onclick="javascript:scrollWindow('staff_details.php?task=staff_roster&id=<?php echo $staff['id'];?>','1200','850')" >Roster</a></li>
						<li><a Onclick="javascript:scrollWindow('staff_details.php?task=staff_docs&id=<?php echo $staff['id'];?>','1200','850')">Staff Doc</a></li>
					</ul>
				</div>
			</div>
		</td>
      <?php
	//echo $start_date_ts;  die;
        $sdate_staff = $start_date_ts;
        for($i=1;$i<=7;$i++)
		{
		
			$jd_arg = "select * from job_details where status!=2 ";
		/* 	if(isset($_SESSION['dispatch']['job_type'])){ if($_SESSION['dispatch']['job_type']!="0"){ $jd_arg.= " and job_type='".$_SESSION['dispatch']['job_type']."'"; } }
			$jd_arg.= " and staff_id=".$staff['id']." and job_date='".date("y-m-d", $sdate_staff)."' and job_id in (select id from jobs where status in(1,3,4))"; */
			
			if(isset($_SESSION['dispatch']['job_type'])){ if($_SESSION['dispatch']['job_type']!="0"){ $jd_arg.= " and job_type='".$_SESSION['dispatch']['job_type']."'"; } }
			$jd_arg.= " and staff_id=".$staff['id']." and job_date='".date("y-m-d", $sdate_staff)."' and job_id in (select id from jobs where status in(1,3,4,5)) OR job_id in (select job_id from job_reclean where status!=2 and staff_id=".$staff['id']." and reclean_date='".date("y-m-d", $sdate_staff)."') GROUP by job_id";
			
			$job_details_data = mysql_query($jd_arg);
			
			//echo $jd_arg."-".mysql_num_rows($job_details_data)."<br>";
			
			if(mysql_num_rows($job_details_data)>0){
			
			echo "<td>";
				while($job_details = mysql_fetch_assoc($job_details_data))
				{				
					
					$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".$job_details['job_id'].""));			
					$job = mysql_fetch_array(mysql_query("select * from jobs where id=".$job_details['job_id'].""));
					
					//echo "select * from job_details where staff_id=".$staff['id']." and job_date='".date("y-m-d", $sdate_staff)."' and job_id in (select id from jobs where status=1)";
					
					$job_payment_data = mysql_query("SELECT sum(amount) as total_amt FROM `job_payments` WHERE job_id=".mysql_real_escape_string($job_details['job_id'])." and deleted=0");
					$job_payment = mysql_fetch_array($job_payment_data);
					
					// total payment for the job
					$job_details_data1 = mysql_query("SELECT sum(amount_total) as total_amt FROM `job_details` WHERE job_type_id=1 and job_id=".mysql_real_escape_string($job_details['job_id'])." and status!=2");
					$job_details_amt = mysql_fetch_array($job_details_data1);
					
					//echo $job_payment['total_amt'];
					//echo "Payment Rec:".$job_payment['total_amt']." Total_Amt".$job_details_amt['total_amt']."<br>";
					if($job_payment['total_amt']==""){ 
						$payment_status = "(Not Paid)";
					}else if($job_payment['total_amt']<$job_details_amt['total_amt']){
						$payment_status = "(Semi Paid)";
					}else if($job_payment['total_amt']>=$job_details_amt['total_amt']){
						$payment_status = "(Paid)";
					}
					
					
					$reclen = mysql_query("SELECT * from job_reclean where staff_id=".$staff['id']." and reclean_date='".date("Y-m-d", $sdate_staff)."' and job_id = '".$job_details['job_id']."' AND status != 2"); 	

					$countReclean = mysql_num_rows($reclen);
					//echo $jd_arg;
					if($countReclean > 0) {	
					$recleanDate = mysql_fetch_array($reclen);		
					
				?>
				
				<a href="javascript:scrollWindow('popup.php?task=job_reclean&job_id=<?php echo $recleanDate['job_id'];?>','1200','850')">
					<div class="td_back td_back_darkred">
						(Re-Clean) #<?php echo $recleanDate['job_id'];?> <br/>
						<?php echo $quote['name'];?> <?php echo $quote['suburb'];?>
					</div>
					</a>
				<?php  }else { ?>	
     
						<a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $job_details['job_id'];?>','1200','850')">
						<div class="td_back td_back_<?php if($job['status']=="3"){ echo 'green'; }elseif($job['status']=="1"){ echo 'red'; }else if($job['status']=="4"){ echo 'orange'; } ?>">
							#<?php echo $job_details['job_id'];?> <?php echo $quote['name'];?><br>
							<?php echo $quote['suburb'];?> <?php echo $payment_status;?>
						  
						</div>
						</a>
      
               <?php
				}	
			}
		
		echo "</td>";
			}else{
                   $makedata = date("Y-m-d", $sdate_staff);
        $getStaffCheck = mysql_query("SELECT * FROM `staff_roster` where staff_id ='".$staff['id']."' and date = '".$makedata."'");
		$CheckAvil = mysql_fetch_array($getStaffCheck);
				?>
      <td <?php  if($CheckAvil['status'] == '0'){ ?> style = 'background-color: #ebccd1;' <?php } ?>><br></td>
      <?php
			}
			
            
            $sdate_staff = ($sdate_staff+86400);
        }
    ?>
    </tr>
    <?php	
   }	
	
	?>
   </tbody>
  </table>