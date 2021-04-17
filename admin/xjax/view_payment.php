<script language="javascript">

function edit_pay_status(objval,booking_id){
	var str = booking_id+"|"+document.getElementById(objval).value;
	//alert(str);
	send_data(str,5,'payment_view');
}

function change_booking(field,objx,bid){
	var objval = document.getElementById(objx).value;
	var str = field+"|"+objval+"|"+bid;
	//alert(str);
	send_data(str,6,'payment_view');
	
}

function review_email(objval,booking_id,job_type){
	if(objval==1){
		var str = booking_id+"|"+job_type;
		send_data(str,529,'');
	}
}
</script>
<style>
 .jobrefposRelNew{
	 position: absolute;
    width: 10px;
    height: 10px;
    background-color: #4CAF50;
    content: "";
    left: 50%;
    bottom: 6%;
    transform: translate(-50%, -50%);
    border-radius: 100px; 
 }
</style>
<?
               
			      //$staffid = getStaff();
                    
					$getReCleandata = getLasteekReClean();
                     $getsyvalue = system_dd_type(18);

if(!isset($_SESSION['payment_report']['from_date'])){ $_SESSION['payment_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['payment_report']['to_date'])){ $_SESSION['payment_report']['to_date'] = date("Y-m-t"); }

 if(!isset($_SESSION['payment_report']['job_id'])){ $_SESSION['payment_report']['job_id'] = ""; }
if(!isset($_SESSION['payment_report']['job_status'])){ $_SESSION['payment_report']['job_status'] = "0"; }
if(!isset($_SESSION['payment_report']['payment_completed'])){ $_SESSION['payment_report']['payment_completed'] = "3"; }
if(!isset($_SESSION['payment_report']['pay_staff'])){ $_SESSION['payment_report']['pay_staff'] = "0"; }
if(!isset($_SESSION['payment_report']['acc_payment_check'])){ $_SESSION['payment_report']['acc_payment_check'] = "0"; } 

if(!isset($_SESSION['payment_report']['job_type'])){ $_SESSION['payment_report']['job_type'] = "0"; }

if(!isset($_SESSION['payment_report']['quote_for'])){ $_SESSION['payment_report']['quote_for'] = "0"; }

$arg = "select id, status , (SELECT name  FROM `system_dd` WHERE `type` = 26 AND id =  jobs.status) as s_jstatus from jobs where id in (select distinct(job_id) from job_details where status !=2 
and job_date>='".$_SESSION['payment_report']['from_date']."' and job_date<='".$_SESSION['payment_report']['to_date']."'";

 if($_SESSION['payment_report']['payment_completed']==1){ $arg.= " and payment_completed=1"; 
}else if($_SESSION['payment_report']['payment_completed']=="2"){ $arg.= " and payment_completed=0"; } 

if($_SESSION['payment_report']['pay_staff']=="1"){ $arg.=" and pay_staff=1";  
}else if($_SESSION['payment_report']['pay_staff']=="2"){ $arg.=" and pay_staff=0"; } 

if($_SESSION['payment_report']['acc_payment_check']==1){ $arg.=" and acc_payment_check=1"; 
}else if($_SESSION['payment_report']['acc_payment_check']=="2"){ $arg.=" and acc_payment_check=0"; } 


if($_SESSION['payment_report']['job_type']==1){ $arg.=" and quote_id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )"; 
}else if($_SESSION['payment_report']['job_type']=="2"){ $arg.=" and quote_id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )"; }
				    


$arg.=") ";


if($_SESSION['payment_report']['quote_for'] == 2 ){
       $arg .="  AND id in (SELECT booking_id from quote_new where bbc_staff_id > 0) "; 
}else{
       $arg .="  AND id in (SELECT booking_id from quote_new where bbc_staff_id = 0) "; 
}

if(($_SESSION['payment_report']['job_id']!="") && ($_SESSION['payment_report']['job_id']!="0")){ $arg.= " and id=".$_SESSION['payment_report']['job_id']." "; }
if($_SESSION['payment_report']['job_status']!="0"){ 
	$arg.= " and status=".$_SESSION['payment_report']['job_status']." ";
}  


$arg.= " order by date desc ";

//print_r($_SESSION['payment_report']); 

//echo 'job_type: '.$_SESSION['payment_report']['job_type'];
//echo $arg; die;
$data = mysql_query($arg);

if (mysql_num_rows($data)>0){ 
?>
<!--<link href="../css/general.css" rel="stylesheet" type="text/css">-->
<table width="100%" border="0" align="center" cellpadding="6" cellspacing="3" class="tableScroll table_bg">  
  <tr class="header_td">
    <td width="2%">Job Id</td>
    <td width="2%">Site Id</td>
    <td width="5%">Name</td>
    <td width="2%">Job Date</td>
    <td width="20%">Amt Rec</td>
    <td width="65%">Jobs</td>    
  </tr>
  <?php 
  while($r=mysql_fetch_assoc($data)){ 
	
	
	 // $getImage = checkImageStatusPayment(21075,3);
     //print_r($getImage['job_type'][1]);
	 //die; 
	 
	$getImage  =  checkImageStatusPayment($r['id'],3);
	
	 if($r['status'] == '5'){
		 $checkimage = count($getImage['job_type'][2]);
	 }else{
		 $checkimage = count($getImage['job_type'][1]);
	 } 
	 
	 $class_icon = false;
	 if($checkimage > 0) {
		 $class_icon = true;
	 }
	 
	 $cheklistImagecehck = $getImage['checklist'];
	
	
	 
	
	//$r =  mysql_fetch_assoc(mysql_query("select * from jobs where id=".$job_details['job_id'].""));
	$quote = mysql_fetch_assoc(mysql_query("select id , job_ref , postcode , suburb , booking_date ,phone,address , name , start_job_in_postcode , (SELECT name FROM sites WHERE id= site_id) as sname from quote_new where booking_id=".$r['id'].""));	  	
	//$staff_name = get_sql("staff","name"," where id in (select staff_id from job_details where job_id=".$r['id']." and job_type='Cleaning' )");	  
	$tdclass="";
	if($r['status']=="3"){ $tdclass='#c5eaca'; }elseif($r['status']=="1"){ $tdclass='#eacec5'; }else if($r['status']=="4"){ $tdclass='#efda8d'; } 
	if($tr_color=="#ebebeb"){ $tr_color="#fff"; }else{ $tr_color = "#ebebeb"; } 
	
	 $getcartNum = mysql_fetch_assoc(mysql_query("SELECT cc_name  FROM `payment_gateway` WHERE `job_id` = ".$r['id']." LIMIT 0 ,1"));
	 $checkAccount = mysql_fetch_assoc(mysql_query("SELECT amount FROM `job_payments`  WHERE payment_method = 'Account'  AND `job_id` = ".$r['id']." LIMIT 0 ,1"));
	 
	 
 ?>
    <tr class="table_cells" style="background-color:<? echo $tr_color?>; height:55px!Important; <?php  if($checkAccount['amount'] > 0) {  ?> background: #dfc1c1 !important;<?php  } ?>">
    <td <?php   if($class_icon == false) {  ?> title="Work Image not uploaded" class="posRelNew" <?php  } else { ?> title="Work Image uploaded" class="posRelNewGreen" <?php  } ?>>
	
		
			<?php  
			if($quote['start_job_in_postcode'] != '') {
				 
              $suburbDetails = explode('_', $quote['start_job_in_postcode']);			 
				 if(strtoupper($suburbDetails[1]) == strtoupper($quote['suburb'])) {
					  echo $suburbDetails[1].' (Yes)';
				 }elseif($suburbDetails[1] != $quote['suburb']) {
					 echo $suburbDetails[1].' (No Match)';
				 }
		    } else{
				echo '(N/A)';
			}
			 ?>
		<br/>
		<a href="javascript:scrollWindow('popup.php?task=jobs&amp;job_id=<? echo $r['id'];?>','1200','850')"><? echo $r['id'];?></a>
		
	<?php  if($quote['job_ref'] == 'Crm') { ?>
	  <span class="jobrefposRelNew" title="CRM"></span>
	<?php  } ?>
	
	</td>
         <td <?php   if($cheklistImagecehck > 0) {  ?>  title="CheckList Image uploaded" class="posRelNewGreen" <?php  } else { ?> title="CheckList Images not uploaded"        class="posRelNew"  <?php  } ?>><? echo $quote['sname']; ?></td>
	 
			<td style="background-color:<?php echo $tdclass;?>"><a title="<?php echo  $r['s_jstatus']; ?>"  <?php if($r['status']=="5"){ ?> class="posRelNew"  <?php } ?> href="javascript:showdiv('namediv_<?php echo $r['id'];?>');"><? echo $quote['name'];?></a>
				<div id="namediv_<?php echo $r['id'];?>" style="display:none"><? echo $quote['phone'];?><br>
				<? echo $quote['address'];?><hr />
				<? echo $getcartNum['cc_name'];?><br />
				</div>
			</td>
			
	 
    <td style="width:13%;">
		<?php /* if(mysql_num_rows($qry_job_date) > 1) { 
		while($row_job_date = mysql_fetch_assoc($qry_job_date)) { ?>
			<strong><? echo changeDateFormate($row_job_date['job_date'],'datetime');?></strong><br/>
		<?php } }else { ?>
		<strong><? echo changeDateFormate($quote['booking_date'],'datetime');?></strong>
		<?php } */ ?>
		
		<strong><? echo changeDateFormate($quote['booking_date'],'datetime');?></strong>
	  <br/><br/>
		<?php
		// $quote_details = mysql_fetch_array(mysql_query("Select hours from quote_details Where quote_id='".$quote['id']."' AND job_type_id = 1")); 
		
		//echo $result = getPaymentWorkReport($r['id'], $quote_details['hours']);
		?>
	</td>
    <td>
      <?  echo 	getPaymentDetails($r['id']);?>     
	  
    <p class="text11_red">&nbsp;</p></td>
    <td>
    <!-- starts here -->
    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="table_bg">
      <tr class="header_td">
        <td width="3%" bgcolor="#EEEBFA">Type</td>
        <td width="3%" bgcolor="#EEEBFA">Total</td>
        <td width="5%" bgcolor="#ECEFF0">Staff</td>
        <td width="3%" bgcolor="#ECEFF0">Staff Share</td>
        
        <td width="3%" bgcolor="#ECEFF0">Staff Paid</td>
        <td width="5%" bgcolor="#ECEFF0">Staff Date</td>
        <td width="3%" bgcolor="#CDE2E2">BCIC Share</td>
         <?php  /* if($_SESSION['payment_report']['quote_for'] == 2 ){  ?>
           <td width="3%" bgcolor="#ECEFF0">Marchent fee</td>
         <?php  } */ ?>
		 <?php  if($_SESSION['admin'] != 11) { ?>  
					<td width="3%" bgcolor="#CDE2E2">BCIC Paid</td>
					<td width="3%" bgcolor="#EFF8EF">Bank Checked</td>
					<td width="5%" bgcolor="#EFF8EF">Bank Date</td>
					<td width="3%" bgcolor="#F9F4F0">Admin Check</td>
					<td width="3%" bgcolor ="#ebebeb" >Job Status</td>
					<td width="3%" bgcolor ="#ebebeb">Inv Status</td>
					<td width="3%" bgcolor="#F9F4F0">Pay Staff</td>
					<td width="3%" bgcolor="#F9F4F0">Account Completed</td>
					<td width="3%" bgcolor="#F9F4F0">Payment Hold</td>
		 <?php  } ?>
        <td style="background-color:<? echo $tr_color?>;">Comments</td>
      </tr>
    
      <?php
		
		$job_picker_x = "";
		
		//echo  "SELECT COUNT(id) as countrecords  FROM `job_details` WHERE `job_id` = ".$r['id']." AND status != 2";
		
		$getTotalJob = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) as countrecords , sum(amount_total) as totaljobAmount FROM `job_details` WHERE `job_id` = ".$r['id']." AND status != 2"));
		
		//print_r($getTotalJob);
		$k = 1;
		$job_details = mysql_query("select * from job_details where job_id= ".$r['id']." and status=0");
		
		 //echo  "SELECT count(staff_id) as staffresult, staff_id ,  job_id  FROM `job_details` WHERE  job_date >= '".date('Y-m-d', strtotime('-7 days'))."' And job_date <= '".date('Y-m-d')."' and status != 2 AND job_id in (SELECT id  from jobs WHERE status = 5 ) GROUP by job_id"; 
		
		 
		//echo $getTotalReclean;
		
		// print_r($getTotalReclean);
		
        while($jdetails = mysql_fetch_assoc($job_details))
		{ 
			$color = "green";
			$tr_style=""; $bcic_paid_clr=""; $staff_paid_clr="";
				if($jdetails['payment_check']=="1"){ 
					$tr_style=" style=\"background-color:#d3efda!important\"; "; 
				}
				if($jdetails['bcic_paid']=="1"){ 
					$bcic_paid_clr=" class=\"table_cells_green\" "; 
				}else{ 
					$bcic_paid_clr = 'bgcolor="#CDE2E2"';
				}
				
				if($jdetails['staff_paid']=="1"){ 
					$staff_paid_clr=" class=\"table_cells_green\" "; 
				}else{
					$staff_paid_clr ='bgcolor="#ECEFF0"';	
				}
			
		
			
			if($jdetails['payment_completed']=="1"){ $jdet_color['payment_completed'] = "#f1d7c3"; }else{ $jdet_color['payment_completed'] = "#F9F4F0"; }
			if($jdetails['pay_staff']=="1"){ $jdet_color['pay_staff'] = "#f1d7c3"; }else{ $jdet_color['pay_staff'] = "#F9F4F0"; }
			if($jdetails['acc_payment_check']=="1"){ $jdet_color['acc_payment_check'] = "#f1d7c3"; }else{ $jdet_color['acc_payment_check'] = "#F9F4F0"; }
			if($jdetails['payment_onhold']=="1"){ $jdet_color['payment_onhold'] = "#f1d7c3"; }else{ $jdet_color['payment_onhold'] = "#F9F4F0"; }
			
			
			   $totalamount = $jdetails['amount_total'];
				$staff_bcic_total = $jdetails['amount_staff'] + $jdetails['amount_profit'];
			    
				if($totalamount != $staff_bcic_total){
					  $alert_danger_tr = '#e64545';
				}else{
					  $alert_danger_tr = '#EEEBFA'; 
				}
			
			     /*  echo  "SELECT count(staff_id) as staffresult, staff_id ,  job_id  FROM `job_details` WHERE  job_date >= '".date('Y-m-d', strtotime('-7 days'))."' AND staff_id = ".$jdetails['staff_id']." And job_date <= '".date('Y-m-d')."' and status != 2 AND job_id in (SELECT id  from jobs WHERE status = 5 ) GROUP by job_id";   */
				 
			
				/* $recl_sql = mysql_query("SELECT count(staff_id) as staffresult, staff_id ,  job_id  FROM `job_details` WHERE  job_date >= '".date('Y-m-d', strtotime('-7 days'))."' AND staff_id = ".$jdetails['staff_id']." And job_date <= '".date('Y-m-d')."' and status != 2 AND job_id in (SELECT id  from jobs WHERE status = 5 ) GROUP by job_id");
				
				
				$getStaff = mysql_fetch_assoc($recl_sql); */
				
				 $getRecleandata = $getReCleandata[$jdetails['staff_id']];
				//echo  get_totalResultStatus($jdetails['staff_id'],1);
				
				/* $comp_sql = mysql_query("SELECT count(staff_id) as comp_staffid, staff_id ,  job_id  FROM `job_details` WHERE  job_date >= '".date('Y-m-d', strtotime('-7 days'))."' AND staff_id = ".$jdetails['staff_id']." And job_date <= '".date('Y-m-d')."' and status != 2 AND job_id in (SELECT id  from jobs WHERE status = 4 ) GROUP by job_id");
				$comp_data = mysql_fetch_assoc($comp_sql) */;

				 $starttime__ = 'N/A';
				 $endtime__ = 'N/A';
				 $starttime_1 = '';
				 $endtime_1 = '';
				if($jdetails['start_time'] != '0000-00-00 00:00:00') {
					$starttime__ = date('H:i' , strtotime($jdetails['start_time']));
					$starttime_1 = date('H:i:s' ,strtotime($jdetails['start_time']));
				}
				
				if($jdetails['end_time'] != '0000-00-00 00:00:00') {
					$endtime__ = date('H:i' , strtotime($jdetails['end_time']));
					$endtime_1 = date('H:i:s' ,strtotime($jdetails['end_time']));
				}
			
			
				echo '<tr class="table_cells" '.$tr_style.'>
					  <td bgcolor="#EEEBFA" title='.$starttime_1.'-'.$endtime_1.'>'.$jdetails['job_type'].' <br/>('.$starttime__.' -'.$endtime__.')</td>';	
					  
					  
				unset($starttime__);	  
				unset($endtime__);	  
				unset($starttime_1);	  
				unset($endtime_1);	 

				
					if($jdetails['pay_staff'] == 0) {  
					 
					  echo  '<td bgcolor="'.$alert_danger_tr.'"><input name="amount_total_'.$jdetails['id'].'" type="text" id="amount_total_'.$jdetails['id'].'" style="width:100%" value="'.$jdetails['amount_total'].'" onblur="javascript:edit_field(this,\'job_details.amount_total\','.$jdetails['id'].');"></td>';
					}else {
					  echo '<td bgcolor="'.$alert_danger_tr.'">'.$jdetails['amount_total'].'</td>';
					}
					
					if(!empty($getRecleandata)) {	
		 			
					    foreach($getRecleandata as $key=>$jobids){
						
						    if($jobids['staffresult'] > 3 && $jobids['staff_id'] == $jdetails['staff_id']) {
							  $staff_bcColor = '#f1b8b8';
						    }else {
						       $staff_bcColor = '#ECEFF0';
				        	}	
							
							if($jobids['staffresult'] > 0) { $totalRe =  $jobids['staffresult']; }else { $totalRe =  0; }
					    }
						 
					}
					
		 			
                  /*   if($getStaff['staffresult'] > 3 && $getStaff['staff_id'] == $jdetails['staff_id']) {
						$staff_bcColor = '#f1b8b8';
					}else {
						$staff_bcColor = '#ECEFF0';
					}			
					    if($getStaff['staffresult'] > 0) { $totalRe =  $getStaff['staffresult']; }else { $totalRe =  0; } */
                    
                   
	
					//######### CHECK ON HOLD for payment and highlight staff box with style
					if( $jdetails['payment_onhold'] == 1 )				
					{
						$onHoldPay = 'color: rgb(169, 68, 66); background-color: rgb(242, 222, 222); border-color: rgb(235, 204, 209);';
					}
					else if( $jdetails['payment_onhold'] == 0 )				
					{
						$onHoldPay = '';
					}
					
					//	1 = active, 2 = cancelled , 3 = completed, 4 = complaint ,  5 = Re-Clean, 6 = On-Hold/* 
	               // echo '<td style="'.$onHoldPay.'" class="reclean_'.$jdetails['id'].' staffUserName" bgcolor='.$staff_bcColor.'>'.get_rs_value("staff","name",$jdetails['staff_id']).'</td>';	
					 if($_SESSION['admin'] != 11) {
					 echo  '<td style="'.$onHoldPay.'" class="reclean_'.$jdetails['id'].' staffUserName staffUserNameNew" bgcolor='.$staff_bcColor.' >
							<div class="tooltip_div_new tooltip_div staff_name_tooltip">
								<div class="leftBox">
									<span class="name_text">Last Week Result</span>
									<span class="name_text">Total Active : '.get_totalResultStatus($jdetails['staff_id'],1).'</span>
									<span class="name_text">Total cancelled : '.get_totalResultStatus($jdetails['staff_id'],2).'</span>
									<span class="name_text">Total completed : '.get_totalResultStatus($jdetails['staff_id'],3).'</span>
									<span class="name_text">Total complaint : '.get_totalResultStatus($jdetails['staff_id'],4).'</span>
									<span class="name_text">Total Re-Clean : '.get_totalResultStatus($jdetails['staff_id'],5).'</span>
									<span class="name_text">Total On-Hold : '.get_totalResultStatus($jdetails['staff_id'],6).'</span>
								</div>
								<div class="rightBox" style="width:50%;float:right;">							
									<span class="name_text" style="font-size:14px;" >Next Week assigned job</span>
									<span class="name_text" style="font-size:14px;">Total assigned : '.get_total_job_assign($jdetails['staff_id']).'</span>
								</div>	
							</div>'
							.get_rs_value("staff","name",$jdetails['staff_id']).'
					    </td>';
					}else{
				echo '<td style="'.$onHoldPay.'" class="reclean_'.$jdetails['id'].' staffUserName" bgcolor='.$staff_bcColor.'>'.get_rs_value("staff","name",$jdetails['staff_id']).'</td>';		
					}  
					 
			if($jdetails['pay_staff'] == 0) {  		 
				 echo '<td '.$staff_paid_clr.'><input name="amount_staff_'.$jdetails['id'].'" type="text" id="amount_staff_'.$jdetails['id'].'" style="width:100%" value="'.$jdetails['amount_staff'].'" onblur="javascript:edit_field(this,\'job_details.amount_staff\','.$jdetails['id'].');"></td>';
			}else {
				echo '<td '.$staff_paid_clr.'>'.$jdetails['amount_staff'].'</td>';
			}
			
	
			
				 
		   echo  '<td '.$staff_paid_clr.'>'.$getsyvalue[$jdetails['staff_paid']].'</td>';
					  echo '<td bgcolor="#ECEFF0">'.$jdetails['staff_paid_date'].'</td>';	
					  
			if($jdetails['pay_staff'] == 0) {  			  
					  echo '<td '.$bcic_paid_clr.'><input name="amount_profit_'.$jdetails['id'].'" type="text" id="amount_profit_'.$jdetails['id'].'" style="width:100%" value="'.$jdetails['amount_profit'].'" onblur="javascript:edit_field(this,\'job_details.amount_profit\','.$jdetails['id'].');"></td>';			
			}else {
				echo '<td '.$bcic_paid_clr.'>'.$jdetails['amount_profit'].'</td>';
			}		  
			
       /* if($_SESSION['payment_report']['quote_for'] == 2 ){
		    
		   echo '<td><input name="marchent_fee_'.$jdetails['id'].'" type="text" id="marchent_fee_'.$jdetails['id'].'" style="width:100%" value="'.$jdetails['marchent_fee'].'" onblur="javascript:edit_field(this,\'job_details.marchent_fee\','.$jdetails['id'].');"></td>'; 
		}  */   
                 
				if($_SESSION['admin'] != 11) {
					  
					  echo '<td '.$bcic_paid_clr.'>'.$getsyvalue[$jdetails['bcic_paid']];
					 // echo create_dd_value("bcic_paid_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.bcic_paid',".$jdetails['id'].");\"",$jdetails['bcic_paid']);                
					  echo '</td><td bgcolor="#EFF8EF">';
					  echo $getsyvalue[$jdetails['payment_check']];
					 // echo create_dd_value("payment_check_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.payment_check',".$jdetails['id'].");\"",$jdetails['payment_check']);                
					echo'</td>';
					echo '<td bgcolor="#EFF8EF">'.$jdetails['payment_check_date'].'</td>';		
                   
				    if($jdetails['pay_staff'] == 0) {
					
					
						echo '<td align="center" bgcolor="'.$jdet_color['payment_completed'].'">';
							if($jdetails['job_type_id'] == 11) {	
								 echo create_dd_value("payment_completed_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.payment_completed',".$jdetails['id'].");\"",$jdetails['payment_completed']);
							}else {
								
								if($jdetails['payment_completed'] == '0' && $jdetails['amount_staff'] > 0 ) 
								{
								   echo create_dd_value("payment_completed_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.payment_completed',".$jdetails['id'].");review_email(this.value,".$jdetails['job_id'].",'job');\"",$jdetails['payment_completed']);	
								   
								 }else{
									 echo create_dd_value("payment_completed_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.payment_completed',".$jdetails['id'].");\"",$jdetails['payment_completed']);	
								} 
							}
						echo "</td>";
					}else{
						echo '<td bgcolor="'.$jdet_color['payment_completed'].'"></td>';
					}
					
						if($k == 1) {
							
							 if($jdetails['pay_staff'] == 0 || $jdetails['payment_completed'] == 0){								
										
									   echo "<td bgcolor ='#ebebeb' rowspan=".$getTotalJob['countrecords'].">".create_dd("status","system_dd","id","name",'type=26 AND id != 2',"onchange=\"javascript:edit_field(this,'jobs.status',".$r['id'].");\"",$r,'field_id')."</td>";
									   
									   echo "<td  bgcolor ='#ebebeb' rowspan=".$getTotalJob['countrecords'].">".create_dd("invoice_status","system_dd","id","name",'type=21',"onchange=\"javascript:edit_field(this,'jobs.invoice_status',".$r ['id'].");\"",$r,'field_id')."</td>";
								
							}else {
								echo "<td bgcolor ='#ebebeb' rowspan=".$getTotalJob['countrecords']." ></td>";
								echo "<td bgcolor ='#ebebeb' rowspan=".$getTotalJob['countrecords']."></td>";
							} 
						}
					
					
					echo '<td align="center" bgcolor="'.$jdet_color['pay_staff'].'">';
					echo $getsyvalue[$jdetails['pay_staff']];
					

					  //echo  $jdetails['pay_staff'];
					  
					echo '</td><td align="center" bgcolor="'.$jdet_color['acc_payment_check'].'">';
					echo $getsyvalue[$jdetails['acc_payment_check']];
					echo '</td>';
					
					if($jdetails['pay_staff'] == 0) {  			
						 echo '<td align="center" bgcolor="'.$jdet_color['payment_onhold'].'">'; 
						echo create_dd_value("payment_onhold_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.payment_onhold',".$jdetails['id'].");\"",$jdetails['payment_onhold']); 					
						 echo '</td>'; 
					}else {
						echo '<td bgcolor="'.$jdet_color['payment_onhold'].'">'.$getsyvalue[$jdetails['payment_onhold']].'</td>';
					}
				}
					if($jdetails['pay_staff'] == 0) { 	
					   echo '<td><textarea name="pay_comments_'.$jdetails['id'].'"  type="text" id="pay_comments_'.$jdetails['id'].'" style="width:100%;height:45px;" onblur="javascript:edit_field(this,\'job_details.pay_comments\','.$jdetails['id'].');">'.$jdetails['pay_comments'].'</textarea></td>';
					}else {
						echo '<td style="width:100%;height:45px;background: #f3dddd;"></td>';
					}
					echo '</tr>';	
                $k++;					
			}
	   echo  '<tr><td colspan="2"><strong> Total:  '.$getTotalJob['totaljobAmount'].'</strong></td></tr>'; 		  		
		?>
    </table>
    <!-- end here -->    
    </td>   
  </tr>
  <? } ?>

</table>


<? }else{  
	echo "No Records Found";
} 
?>