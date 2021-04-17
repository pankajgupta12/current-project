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
</script>
<?

function get_job_details_payment($job_id){
	
}

// job status 1 = active, 2 = cancelled, 3 = completed, 4 = complaints	
// from date , to_date , site_id, staff_id

// select * from jobs a inner join quote b on(a.id=b.booking_id) where a.status=3 and a.site_id=1 and (b.booking_date>='2016-08-01' and b.booking_date<='2016-08-31') and a.payment_completed=0 order by booking_date desc limit 0,50

if(!isset($_SESSION['payment_report']['from_date'])){ $_SESSION['payment_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['payment_report']['to_date'])){ $_SESSION['payment_report']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['payment_report']['job_id'])){ $_SESSION['payment_report']['job_id'] = ""; }
if(!isset($_SESSION['payment_report']['job_status'])){ $_SESSION['payment_report']['job_status'] = "0"; }
if(!isset($_SESSION['payment_report']['payment_completed'])){ $_SESSION['payment_report']['payment_completed'] = "3"; }
if(!isset($_SESSION['payment_report']['pay_staff'])){ $_SESSION['payment_report']['pay_staff'] = "0"; }
if(!isset($_SESSION['payment_report']['acc_payment_check'])){ $_SESSION['payment_report']['acc_payment_check'] = "0"; }


$arg = "select * from jobs where id in (select distinct(job_id) from job_details where status!=2 and 
job_date>='".$_SESSION['payment_report']['from_date']."' and job_date<='".$_SESSION['payment_report']['to_date']."'";

if($_SESSION['payment_report']['payment_completed']==1){ $arg.= " and payment_completed=1"; 
}else if($_SESSION['payment_report']['payment_completed']=="2"){ $arg.= " and payment_completed=0"; } 

if($_SESSION['payment_report']['pay_staff']=="1"){ $arg.=" and pay_staff=1";  
}else if($_SESSION['payment_report']['pay_staff']=="2"){ $arg.=" and pay_staff=0"; } 

if($_SESSION['payment_report']['acc_payment_check']==1){ $arg.=" and acc_payment_check=1"; 
}else if($_SESSION['payment_report']['acc_payment_check']=="2"){ $arg.=" and acc_payment_check=0"; } 
$arg.=") ";

if(($_SESSION['payment_report']['job_id']!="") && ($_SESSION['payment_report']['job_id']!="0")){ $arg.= " and id=".$_SESSION['payment_report']['job_id']." "; }
if($_SESSION['payment_report']['job_status']!="0"){ 
	$arg.= " and status=".$_SESSION['payment_report']['job_status']." ";
}
$arg.= " order by date desc ";
//echo $arg;
$data = mysql_query($arg);

if (mysql_num_rows($data)>0){ 
?>
<link href="../css/general.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" align="center" cellpadding="6" cellspacing="3" class="tableScroll table_bg">  
  <tr class="header_td">
    <td width="2%">Job Id</td>
    <td width="2%">Site Id</td>
    <td width="3%">Name</td>
	 <!--<td width="3%">Job Status</td>
    <td width="3%">Inv Status</td>-->
    <td width="5%">Job Date</td>
    <td width="20%">Amt Rec</td>
    <td width="65%">Jobs</td>    
  </tr>
  <?php 
  while($r=mysql_fetch_assoc($data)){   	

	//$r =  mysql_fetch_assoc(mysql_query("select * from jobs where id=".$job_details['job_id'].""));
	$quote = mysql_fetch_assoc(mysql_query("select * from quote_new where booking_id=".$r['id'].""));	  	
	//$staff_name = get_sql("staff","name"," where id in (select staff_id from job_details where job_id=".$r['id']." and job_type='Cleaning' )");	  
	$tdclass="";
	if($r['status']=="3"){ $tdclass='#c5eaca'; }elseif($r['status']=="1"){ $tdclass='#eacec5'; }else if($r['status']=="4"){ $tdclass='#efda8d'; } 
	if($tr_color=="#ebebeb"){ $tr_color="#fff"; }else{ $tr_color = "#ebebeb"; } 
 ?>
  <tr class="table_cells" style="background-color:<? echo $tr_color?>; height:55px!Important;">
    <td><a href="javascript:scrollWindow('popup.php?task=jobs&amp;job_id=<? echo $r['id'];?>','1200','850')"><? echo $r['id'];?></a></td>
    <td><? echo get_rs_value("sites","name",$quote['site_id']);?></td>
			<td style="background-color:<?php echo $tdclass;?>"><a title="<?php echo  getSystemDDname($r['status'],26); ?>"  <?php if($r['status']=="5"){ ?>class="posRelNew"  <?php } ?> href="javascript:showdiv('namediv_<?php echo $r['id'];?>');"><? echo $quote['name'];?></a>
				<div id="namediv_<?php echo $r['id'];?>" style="display:none"><? echo $quote['phone'];?><br>
				<? echo $quote['address'];?><br />Bed: <? echo $quote['bed'];?>, Bath: <? echo $quote['bath'];?>
				</div>
			</td>
			
	 
    <td><? echo $quote['booking_date'];?></td>
    <td>
      <? 
	/*$job_payment_data = mysql_query("SELECT sum(amount) as total_amt FROM `job_payments` WHERE job_id=".$r['id']." and deleted=0");
	$job_payment = mysql_fetch_array($job_payment_data);
	echo $job_payment['total_amt'];	*/
	
	 $pgateway_details = mysql_query("select * from job_payments where job_id=".$r['id']."");
	
	if(mysql_num_rows($pgateway_details)){ 
    $total_amount_1=0;
    $sum_amount=0;
	echo '<table width="100%" border="0" cellspacing="3" cellpadding="3" class="table_bg"> 
			<tr class="header_td">
			  <td class="table_cells">Date</td>
			  <td class="table_cells">Amount</td>
			  <td class="table_cells">Payment Method</td>
			  <td class="table_cells">Taken By</td>
			</tr>';
	
	while($pgateway = mysql_fetch_assoc($pgateway_details)){ 
			$total_amount_1+=$pgateway['amounr'];
			$sum_amount = $sum_amount +  $pgateway['amount'];
			//$staff_name  = get_rs_value("staff","name",$jdetails['staff_id']);
			echo '<tr class="table_cells">
				  <td class="table_cells">'.rotatedate($pgateway['date']).'</td>
				  <td class="table_cells">'.$pgateway['amount'].'</td>
				  <td class="table_cells">'.$pgateway['payment_method'].'</td>
				  <td class="table_cells">'.$pgateway['taken_by'].'</td>				  
				</tr>';
			}		
	  echo '<tr><td colspan="5"><strong> Total Amount : '.$sum_amount.' </strong></td></tr>';		
	echo '</table>';
	}else{
		echo "No Payment Received";
	}
	
	
	?>     
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
	  <?php 	if($_SESSION['admin'] != 11) { ?>
        <td width="3%" bgcolor="#CDE2E2">BCIC Paid</td>
        <td width="3%" bgcolor="#EFF8EF">Bank Checked</td>
        <td width="5%" bgcolor="#EFF8EF">Bank Date</td>
        <td width="3%" bgcolor="#F9F4F0">Admin Check</td>
		
		    <td width="3%" bgcolor ="#ebebeb" >Job Status</td>
			<td width="3%" bgcolor ="#ebebeb">Inv Status</td>
		
        <td width="3%" bgcolor="#F9F4F0">Pay Staff</td>
        <td width="3%" bgcolor="#F9F4F0">Account Completed</td>
        <!--<td width="3%" bgcolor="#F9F4F0">Payment Hold</td>-->
	  <?php } ?>
        <td style="background-color:<? echo $tr_color?>;">Comments</td>
      </tr>
    
      <?php
		
		$job_picker_x = "";
		
		$getTotalJob = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) as countrecords , sum(amount_total) as totaljobAmount FROM `job_details` WHERE `job_id` = ".$r['id']." AND status != 2"));
		
		$k = 1;
		$job_details = mysql_query("select * from job_details where job_id=".$r['id']." and status=0");
        while($jdetails = mysql_fetch_assoc($job_details)){ 
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
			
			/*if($jdetails['payment_completed']!=$r['payment_completed']){				
				$jdetails['payment_completed']=$r['payment_completed'];
				$bool1= mysql_query("update job_details set payment_completed=".$r['payment_completed']." where id=".$jdetails['id']."");
			}
			if($jdetails['pay_staff']!=$r['pay_staff']){				
				$jdetails['pay_staff']=$r['pay_staff'];
				$bool1= mysql_query("update job_details set pay_staff=".$r['pay_staff']." where id=".$jdetails['id']."");
			}
			if($jdetails['acc_payment_check']!=$r['acc_payment_check']){				
				$jdetails['acc_payment_check']=$r['acc_payment_check'];
				$bool1= mysql_query("update job_details set acc_payment_check=".$r['acc_payment_check']." where id=".$jdetails['id']."");
			}*/
			
			if($jdetails['payment_completed']=="1"){ $jdet_color['payment_completed'] = "#f1d7c3"; }else{ $jdet_color['payment_completed'] = "#F9F4F0"; }
			if($jdetails['pay_staff']=="1"){ $jdet_color['pay_staff'] = "#f1d7c3"; }else{ $jdet_color['pay_staff'] = "#F9F4F0"; }
			if($jdetails['acc_payment_check']=="1"){ $jdet_color['acc_payment_check'] = "#f1d7c3"; }else{ $jdet_color['acc_payment_check'] = "#F9F4F0"; }
			if($jdetails['payment_onhold']=="1"){ $jdet_color['payment_onhold'] = "#f1d7c3"; }else{ $jdet_color['payment_onhold'] = "#F9F4F0"; }
			
			
			//Automate detect amount BCIC & Staff 10-13-17
			/*  $getshareamount = mysql_fetch_assoc(mysql_query("select * from staff_share_amount where job_type_id=".$jdetails['job_type_id']." AND staff_id ='".$jdetails['staff_id']."'"));
			
			        if($getshareamount['amount_share_type'] == 1) {
					    // 1 For percentage   
						$bcicshear  = ($jdetails['amount_total']*$getshareamount['value'])/100;
						$staffamount = ($jdetails['amount_total'] - $bcicshear);
						
				    }else if($getshareamount['amount_share_type'] == 2){
						// 2 For fixed
						$staffamount = ($jdetails['amount_total'] - $getshareamount['value']);
						$bcicshear =  ($jdetails['amount_total'] - $staffamount);
					}
					
			  if(($staffamount != $jdetails['amount_staff']) || ($bcicshear != $jdetails['amount_profit'])) {  $alert_danger_tr = '#e64545';}else { $alert_danger_tr = '#EEEBFA'; } */
			  
			  $totalamount = $jdetails['amount_total'];
				$staff_bcic_total = $jdetails['amount_staff'] + $jdetails['amount_profit'];
			    
				  if($totalamount != $staff_bcic_total){
					  $alert_danger_tr = '#e64545';
				  }else{
					  $alert_danger_tr = '#EEEBFA'; 
				  }
				  
					$recl_sql = mysql_query("SELECT count(staff_id) as staffresult, staff_id ,  job_id  FROM `job_details` WHERE  job_date >= '".date('Y-m-d', strtotime('-7 days'))."' AND staff_id = ".$jdetails['staff_id']." And job_date <= '".date('Y-m-d')."' and status != 2 AND job_id in (SELECT id  from jobs WHERE status = 5 ) GROUP by job_id");

					$getStaff = mysql_fetch_assoc($recl_sql);
				  
			
				echo '<tr class="table_cells" '.$tr_style.'>
					  <td bgcolor="#EEEBFA">'.$jdetails['job_type'].'</td>					  
					  <td bgcolor="'.$alert_danger_tr.'"><input name="amount_total_'.$jdetails['id'].'" type="text" id="amount_total_'.$jdetails['id'].'" style="width:100%" value="'.$jdetails['amount_total'].'" onblur="javascript:edit_field(this,\'job_details.amount_total\','.$jdetails['id'].');"></td>';
					  
					  
					if($getStaff['staffresult'] > 3 && $getStaff['staff_id'] == $jdetails['staff_id']) {
						$staff_bcColor = '#f1b8b8';
					}else {
						$staff_bcColor = '#ECEFF0';
					}					
					
					if($getStaff['staffresult'] > 0) { $totalRe =  $getStaff['staffresult']; }else { $totalRe =  0; }		

					
					if( $jdetails['payment_onhold'] == 1 )				
					{
						$onHoldPay = 'color: rgb(169, 68, 66); background-color: rgb(242, 222, 222); border-color: rgb(235, 204, 209);';
					}
					else if( $jdetails['payment_onhold'] == 0 )				
					{
						$onHoldPay = '';
					}
					
					//	1 = active, 2 = cancelled , 3 = completed, 4 = complaint ,  5 = Re-Clean, 6 = On-Hold
	
					echo  '<td style="'.$onHoldPay.'" class="reclean_'.$jdetails['id'].' staffUserName" bgcolor='.$staff_bcColor.' >
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
					  
					  
					echo '<td '.$staff_paid_clr.'><input name="amount_staff_'.$jdetails['id'].'" type="text" id="amount_staff_'.$jdetails['id'].'" style="width:100%" value="'.$jdetails['amount_staff'].'" onblur="javascript:edit_field(this,\'job_details.amount_staff\','.$jdetails['id'].');"></td>					  
					  <td '.$staff_paid_clr.'>';					  
						echo get_sql("system_dd","name","type=18 and id=".$jdetails['staff_paid']."");
						//echo create_dd_value("staff_paid_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.staff_paid',".$jdetails['id'].");\"",$jdetails['staff_paid']);                
                	  echo '</td>';
					  echo '<td bgcolor="#ECEFF0">'.$jdetails['staff_paid_date'].'</td>';					  
					  echo '<td '.$bcic_paid_clr.'><input name="amount_profit_'.$jdetails['id'].'" type="text" id="amount_profit_'.$jdetails['id'].'" style="width:100%" value="'.$jdetails['amount_profit'].'" onblur="javascript:edit_field(this,\'job_details.amount_profit\','.$jdetails['id'].');"></td>';			
					  
                if($_SESSION['admin'] != 11) {		
				
					  echo '<td '.$bcic_paid_clr.'>'.get_sql("system_dd","name","type=18 and id=".$jdetails['bcic_paid']."");
					  //echo create_dd_value("bcic_paid_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.bcic_paid',".$jdetails['id'].");\"",$jdetails['bcic_paid']);                
					  echo '</td><td bgcolor="#EFF8EF">';
					  echo get_sql("system_dd","name","type=18 and id=".$jdetails['payment_check']."");
					 // echo create_dd_value("payment_check_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.payment_check',".$jdetails['id'].");\"",$jdetails['payment_check']);                
					  echo'</td>';
					  echo '<td bgcolor="#EFF8EF">'.$jdetails['payment_check_date'].'</td>';					  
					echo '<td align="center" bgcolor="'.$jdet_color['payment_completed'].'">';
					
					echo create_dd_value("payment_completed_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.payment_completed',".$jdetails['id'].");\"",$jdetails['payment_completed']);

                  echo "</td>";
				  
				    if($k == 1) {
						if($jdetails['payment_completed'] != 1){
								
								   echo "<td bgcolor ='#ebebeb' rowspan=".$getTotalJob['countrecords'].">".create_dd("status","system_dd","id","name",'type=26',"onchange=\"javascript:edit_field(this,'jobs.status',".$r['id'].");\"",$r,'field_id')."</td>";
								   
								   echo "<td  bgcolor ='#ebebeb' rowspan=".$getTotalJob['countrecords'].">".create_dd("invoice_status","system_dd","id","name",'type=21',"onchange=\"javascript:edit_field(this,'jobs.invoice_status',".$r ['id'].");\"",$r,'field_id')."</td>";
							
						}else {
							/* echo "<td bgcolor ='#ebebeb' >".getSystemDDname($r['status'],26)."</td>";
								echo "<td bgcolor ='#ebebeb'>".getSystemDDname($r['invoice_status'],21)."</td>"; */
								
								echo "<td bgcolor ='#ebebeb' rowspan=".$getTotalJob['countrecords']."></td>";
								echo "<td bgcolor ='#ebebeb' rowspan=".$getTotalJob['countrecords']."></td>";
						}
				    }
					
					echo '<td align="center" bgcolor="'.$jdet_color['pay_staff'].'">';
					
					echo get_sql("system_dd","name","type=18 and id=".$jdetails['pay_staff']."");
					//echo create_dd_value("pay_staff_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.pay_staff',".$jdetails['id'].");\"",$jdetails['pay_staff']);
					
					echo '</td><td align="center" bgcolor="'.$jdet_color['acc_payment_check'].'">';
					echo get_sql("system_dd","name","type=18 and id=".$jdetails['acc_payment_check']."");
					
					//echo create_dd_value("acc_payment_check_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.acc_payment_check',".$jdetails['id'].");\"",$jdetails['acc_payment_check']); 

             echo  '</td>';					
					
				/* 	echo '<td align="center" bgcolor="'.$jdet_color['payment_onhold'].'">'; 
					echo create_dd_value("payment_onhold_".$jdetails['id']."","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'job_details.payment_onhold',".$jdetails['id'].");\"",$jdetails['payment_onhold']); 					
					 echo '</td>'; */
				}
					echo '<td><textarea name="pay_comments_'.$jdetails['id'].'" type="text" id="pay_comments_'.$jdetails['id'].'" style="width:100%;height:45px;" onblur="javascript:edit_field(this,\'job_details.pay_comments\','.$jdetails['id'].');">'.$jdetails['pay_comments'].'</textarea></td>';
					echo '</tr>';	

                 $k++; 					
			}
		 echo  '<tr><td colspan="2"> <strong> Total:  '.$getTotalJob['totaljobAmount'].'</strong></td></tr>'; 		
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