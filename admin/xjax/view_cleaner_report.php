<?php
if(!isset($_SESSION['cleaner_report']['from_date'])){ $_SESSION['cleaner_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['cleaner_report']['to_date'])){ $_SESSION['cleaner_report']['to_date'] = date("Y-m-t"); }

$sqlStaff = "select * from staff where status = 1";

$staffSql = mysql_query($sqlStaff);



//$getStaffno_work = array();
 while($getStatff = mysql_fetch_assoc($staffSql)) {
	 //print_r($getStatff);
	  $getStaffName[] = $getStatff['name'];
	  $getStaffID[] = $getStatff['id']; 
	  $getStaffno_work[] = $getStatff['no_work'];
	 // unset($getStaffno_work);
 }
 
//print_r(getcleaner_value());

?>

    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
		<tr class="table_cells">
		  <td><strong>Staff ID</strong></td>
		  <td><strong>Staff</strong></td>
		  <td><strong>Notes</strong></td>
		  <td><strong>Total Job</strong></td>
		  <?php  foreach(getcleaner_value() as $key=>$value1) { ?>
		     <td><strong><?php echo $value1; ?></strong></td>
		  <?php  } ?>
		  
		  
		</tr>  
		
		<?php  	
		
		 $fromdate = $_SESSION['cleaner_report']['from_date'];
		 $todate = $_SESSION['cleaner_report']['to_date'];
    		foreach($getStaffName as $key=>$value) {
            $i++; 
			
			$getjob = get_total_job($fromdate , $todate, $getStaffID[$key]);
			
			//echo "SELECT * FROM `application_notes`  where staff_id = ".$getStaffID[$key]."";
			$sqlnotes = mysql_query("SELECT * FROM `application_notes`  where staff_id = ".$getStaffID[$key]."");
			
			$countresult = mysql_num_rows($sqlnotes);
			
		?>
		
		<tr class="table_cells <?php  if($getStaffno_work[$key] == 2) { echo 'alert_danger_tr ';}  ?>" >
		
		   <td><?php  echo $getStaffID[$key];?></td>
		   <td><?php  echo $value;?></td>
		   <td><?php if($countresult > 0) {?><a  href="javascript:showdiv('ediv_<?php echo $getStaffID[$key]; ?>');">View (<?php echo $countresult; ?>)</a><?php  }else {echo '-'; } ?></td>
		   
		   <td>
		     <?php  if($getjob['total_job'] != 0) { ?>
			 
		        <a href="javascript:scrollWindow('cleaner_report_popup.php?task=cleaner_report_list&staff_id=<?php echo $getStaffID[$key]; ?>&date=<?php echo $fromdate.'/'.$todate; ?>','1200','850')"><?php  echo $getjob['total_job'];?></a>
				
			 <?php  }else { ?>   
			     <?php  echo $getjob['total_job'];?>
			 <?php  } ?>  
			 
			 </td>
			 
		    <?php  $j = 1; foreach(getcleaner_value() as $cleaner_key=>$cleaner_value1) { 
			
			 $getissuetype = get_issue_type_job($fromdate , $todate, $getStaffID[$key] , $cleaner_key );
			
			?>
			   <td><?php  echo $getissuetype['jobtotal']; ?></td>
		   <?php  $j++;  } ?>     
		   
		</tr>
		   
		    <tr>
					    <td colspan="20"  id="ediv_<?php echo $getStaffID[$key]; ?>" style="display:none;">
							<table class="inside_table">
								<tr>
									<td><b>Heading</b></td>
									<td><b>Message</b></td>
									<td><b>Date</b></td>
								</tr>
								    <?php  
								        if($countresult >0) {
										while($data1 = mysql_fetch_assoc($sqlnotes)) {
									?>  
										<tr>
											<td><?php echo $data1['heading']; ?></td>
											<td><?php echo $data1['comment']; ?></td>
											<td><?php echo $data1['date']; ?></td>
										</tr>
									<?php 
										} 
								    }  								
								?>
							</table>
						</td>
					</tr>
		   
		<?php  } ?>
		<style>
			  .inside_table{
				  width: 80%;
				  margin: 0px auto;
			  }
	    </style>
		 
		
    </table>		 