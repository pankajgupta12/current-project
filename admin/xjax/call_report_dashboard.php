<?php 

if(!isset($_SESSION['call_report_dashboard']['from_date'])){ $_SESSION['call_report_dashboard']['from_date'] = date("Y-m-01"); }
 
if(!isset($_SESSION['call_report_dashboard']['to_date'])){ $_SESSION['call_report_dashboard']['to_date'] = date("Y-m-t"); }

 

echo '<span class="staff_text" style="margin-bottom:25px;">3cx Monthly Report</span><br/>';

//SELECT count(id),call_date FROM `c3cx_calls` group by call_date

	$getSql = "SELECT * FROM `c3cx_calls` where 1 = 1 "; 
	
	 if(isset($_SESSION['call_report_dashboard']['from_date']) && $_SESSION['call_report_dashboard']['to_date'] != NULL )
	{ 
		$getSql .= " AND call_date >= '".date('Y-m-d',strtotime($_SESSION['call_report_dashboard']['from_date']))."' AND call_date <= '".$_SESSION['call_report_dashboard']['to_date']."'"; 
	} 
	
	$getSql .= " GROUP BY call_date";
	
  //echo $getSql;
 $getimport =  mysql_query($getSql);
	
	$getUseradmin = mysql_query("SELECT * FROM `c3cx_users` WHERE is_active = 1 and calling_type = 1");
	while($getUserData = mysql_fetch_array($getUseradmin)) {
		  $getUserstaff[] = $getUserData['3cx_user_name'];
		  $getUserStaffadmin[] = $getUserData['id'];
		    $getteam_type[] = $getUserData['team_type'];
	}
	
	//print_r($getUserstaff);
echo '<table width="100%" id="getdata" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
	
	
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
			while($getimport1 = mysql_fetch_array($getimport)){
			// print_r($getimport);
			  $getAllDetails = get3cxdetailsBydate($getimport1['call_date']);
		?>
			<tr class="table_cells">
			 <td><?php  echo  date('dS M ', strtotime($getimport1['call_date'])); ?> (<?php  echo  date('l', strtotime($getimport1['call_date'])); ?>)</td>
			  <td><?php  echo $getAllDetails['getTotalRecords'];?></td>
			  <td><?php  echo $getAllDetails['totalrecive'];?></td>
			  <td><?php  echo $getAllDetails['totalcallbyadmin'];?></td>
			  <td><?php  echo $getAllDetails['totalcallstaff'];?></td>
			  <?php  foreach($getUserStaffadmin as $key=>$adminID) { ?>  
			 <td class="remove_name<?php  echo $getteam_type[$key]; ?>"><?php if(get3cxdetailsByname($adminID,$getimport1['call_date'],1) == 0) {echo "-"; }else { echo get3cxdetailsByname($adminID,$getimport1['call_date'],1); }  ?></td>
			  <td class="remove_name<?php  echo $getteam_type[$key]; ?>"><?php  if(get3cxdetailsByname($adminID,$getimport1['call_date'],2) == 0) { echo "-"; }else {echo get3cxdetailsByname($adminID,$getimport1['call_date'],2); } ?></td>
			  <?php  } ?>
			</tr>
	<?php } }else {  ?>
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
				
				newWin.document.write("<h1>3cx Monthly Report</h2>")

				newWin.document.write(htmlToPrint);
				newWin.document.title = 'call_monthly_reports_'+fromdate+'_to_'+todate;
				newWin.print();
				
				newWin.close();

			//setTimeout(function(){newWin.close();},10);

		}
</script>	