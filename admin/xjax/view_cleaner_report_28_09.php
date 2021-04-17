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
			
			//echo '<pre>'; print_r($getjob);
		?>
		
		<tr class="table_cells <?php  if($getStaffno_work[$key] == 2) { echo 'alert_danger_tr ';}  ?>" >
		
		   <td><?php  echo $getStaffID[$key];?></td>
		   <td><?php  echo $value;?></td>
		   <td><a href="javascript:showdiv('ediv<?php echo $getStaffID[$key]; ?>');"><?php  echo $getjob['total_job'];?></a></td>
		    <?php  $j = 1; foreach(getcleaner_value() as $cleaner_key=>$cleaner_value1) { 
			
			 $getissuetype = get_issue_type_job($fromdate , $todate, $getStaffID[$key] , $cleaner_key );
			
			// echo '<pre>'; print_r($getissuetype);
			
			?>
			   <td><a href="javascript:showdiv('ediv<?php echo $getStaffID[$key]; ?>_<?php  echo $j; ?>');"><?php  echo $getissuetype['jobtotal']; ?></a></td>
		   <?php  $j++;  } ?>     
		   
		</tr>
		    <tr>  
			   
                <td  colspan="3" id="ediv<?php echo $getStaffID[$key]; ?>" style="display: none;" ><?php  if(is_array($getjob['jobs'])) { echo implode(',' , $getjob['jobs']); }else { echo $getjob['jobs']; }?></td>
				
				<?php  $z = 1; foreach(getcleaner_value() as $cleaner_key1=>$cleaner_value1) { 
				
				$getissuetype1 = get_issue_type_job($fromdate , $todate, $getStaffID[$key] , $cleaner_key1 );
			
				?>
				<td  id="ediv<?php echo $getStaffID[$key]; ?>_<?php  echo $z; ?>" style="display: none;" ><?php  if(is_array($getissuetype1['jobs'])) { echo implode(',' , $getissuetype1['jobs']); }else { echo $getissuetype1['jobs']; }?></td>
				<?php $z++; } ?>
		    </tr>	
		
		<?php  } ?>
		
		 
		
    </table>		 