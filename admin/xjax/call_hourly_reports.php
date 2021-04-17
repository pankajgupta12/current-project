<?php 


if(!isset($_SESSION['call_hourly_report']['from_date'])){ $_SESSION['call_hourly_report']['from_date'] = date('Y-m-d',strtotime('-1 week')); }
if(!isset($_SESSION['call_hourly_report']['to_date'])){ $_SESSION['call_hourly_report']['to_date'] = date('Y-m-d',strtotime('yesterday')); }
 
// $_SESSION['call_hourly_report']['from_date'] = '2017-07-01';
 //$_SESSION['call_hourly_report']['to_date'] = '2017-07-01';
 
// $dateString = date('Y-m-d',strtotime('-1 week')).'|'.date('Y-m-d',strtotime('yesterday'));
echo '<span class="staff_text" style="margin-bottom:25px;">3cx Report Dashboard</span><br/>';

//SELECT count(id),call_date FROM `c3cx_calls` group by call_date

	$getSql = "SELECT * FROM `c3cx_calls` where 1 = 1 "; 
	//$_SESSION['call_hourly_report']['from_date'] = '2017-10-17';
	if($_SESSION['call_hourly_report']['from_date'] != ''  && $_SESSION['call_hourly_report']['to_date'])
	{ 
		//$getSql .= " AND call_date = '".date('Y-m-d',strtotime($_SESSION['call_hourly_report']['from_date']))."'";
         $getSql .= " AND call_date >= '".date('Y-m-d',strtotime($_SESSION['call_hourly_report']['from_date']))."' AND call_date <= '".$_SESSION['call_hourly_report']['to_date']."'"; 		
	} 
	
	$getSql .= " GROUP BY call_date";
	
  // echo $getSql;
 $getimport =  mysql_query($getSql);
	
	$getUseradmin = mysql_query("SELECT 3cx_user_name,id ,team_type  FROM `c3cx_users`");
	while($getUserData = mysql_fetch_array($getUseradmin)) {
		  $getUserstaff[] = $getUserData['3cx_user_name'];
		  $getteam_type[] = $getUserData['team_type'];
		  $getUserStaffadmin[] = $getUserData['id'];
	}
	
	//print_r($getUserstaff);
echo '<table width="100%" border="0" cellpadding="5" id="getdata" cellspacing="5" class="user-payment-table">';
	
	
	 ?>
	<tr class="table_cells">
		  <td>Date</td>
		  <td>Total Calls</td>
		  <td>Received By Admin</td>
		  <td>Call By Admin</td>
		  <td>Staff To Client</td>
		  <!--<td>Outgoing</td>
		  <td>In</td>-->
		<?php  foreach($getUserstaff as $key=>$getuser) { ?>  
		  <td colspan="2" class="remove_name<?php  echo $getteam_type[$key]; ?>"><?php echo $getuser;  ?></td>
		<?php  } ?>
	</tr>
	<?php if(mysql_num_rows($getimport)>0) { ?>
		<tr class="table_cells">
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			<?php  foreach($getUserstaff as $key1=>$getuser) { ?>  
			  <td class="remove_name<?php  echo $getteam_type[$key1]; ?>">Out</td>
			  <td class="remove_name<?php  echo $getteam_type[$key1]; ?>">In</td>
			<?php  } ?>
		</tr>

		<?php  		
		  //echo $getimport1;
		  $getimport1 = mysql_fetch_array($getimport);
		  
			$sum = 0;
		    for($h = 01; $h<24; $h++) {
			 $calldate =  $_SESSION['call_hourly_report']['from_date'];
			 $todate =  $_SESSION['call_hourly_report']['to_date'];
			// print_r($getimport);
			  //$calldate = $getimport1['call_date'];
			  
			  $hr_report =  get2cxhourlyreport($calldate ,$todate,$h);
			  $hr_admin = get2cxHourlyReportReciveByAdmin($calldate ,$todate,$h);
			  $hrcalladmin = get2cxHourlyReportCallByAdmin($calldate ,$todate,$h);
			  $hrclient = get2cxHourlyReportStaffToClient($calldate ,$todate,$h);
			  
			 $getAllDetails +=  $hr_report;
			 $totalReciveadmincall +=  $hr_admin;
			 $totalCalladmincall +=  $hrcalladmin;
			 $totalCallStaffToClient +=  $hrclient;
		
		?>
			<tr class="table_cells">
			  <td><?php   echo str_pad($h, 2, "0", STR_PAD_LEFT); ?>:<?php  echo str_pad($h+1, 2, "0", STR_PAD_LEFT); ?></td>
			  <td><?php  echo $hr_report; ?></td>
			  <td><?php  echo $hr_admin; ?></td>
			  <td><?php  echo $hrcalladmin; ?></td>
			  <td><?php  echo $hrclient; ?></td>
			  <?php  foreach($getUserStaffadmin as $key=>$adminID) {
                 $hrbyname =   get3cxHourlyByname($adminID,$calldate ,$todate,$h,1);
				 $hrbyname2 = get3cxHourlyByname($adminID,$calldate ,$todate,$h,2);
              
			  ?>  
			  <td class="remove_name<?php  echo $getteam_type[$key]; ?>"><?php if($hrbyname == 0) { echo "-"; }else { echo $hrbyname; } ?></td>
			  <td class="remove_name<?php  echo $getteam_type[$key]; ?>"><?php if($hrbyname2 == 0) { echo "-"; }else {echo $hrbyname2; } ?></td>
			  <?php 
                    
              $outGoing[$key] +=  $hrbyname; 
              $inComing[$key] +=  $hrbyname2; 
			  } ?>
			</tr>
	  <?php } ?>
	 <tr>
	   <td><strong>Total</strong></td>
	   <td><strong><?php echo $getAllDetails; ?></strong></td>
	   <td><strong><?php echo $totalReciveadmincall; ?></strong></td>
	   <td><strong><?php echo $totalCalladmincall; ?></strong></td>
	   <td><strong><?php echo $totalCallStaffToClient; ?></strong></td>
	  <?php  foreach($getUserStaffadmin as $key=>$adminID) { ?>   
	   <td class="remove_name<?php  echo $getteam_type[$key]; ?>"><strong><?php echo $outGoing[$key]; ?></strong></td>
	   <td class="remove_name<?php  echo $getteam_type[$key]; ?>"><strong><?php echo $inComing[$key]; ?></strong></td>
	  <?php }?> 
	 </tr>
	<?php  } else {  ?>
	  <tr><td colspan="15">No Record found</td></tr>
	<?php  } ?> 
	  
    </table>
	
<script>
		 function printDiv(fromdate , todate) 
		{

				var divToPrint=document.getElementById('getdata');

				var htmlToPrint = '' +
				'<style type="text/css">' +
				'table th, table td {' +
				'border:1px solid #000;' +
				'padding:0.1em;' +
				'}' +
				'.remove_name2 {' +
					'display:none' +
				'}' +
				'</style>';
				
				htmlToPrint += divToPrint.outerHTML; 
             	newWin = window.open("");
				
				newWin.document.write("<h1>3cx report dashboard</h2>")

				newWin.document.write(htmlToPrint);
				newWin.document.title = 'call_hourly_reports_'+fromdate+'_to_'+todate;
				newWin.print();
				
				newWin.close();

			//setTimeout(function(){newWin.close();},10);

		}
</script>	