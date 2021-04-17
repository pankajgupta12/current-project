<?php 

if(!isset($_SESSION['quote_call']['from_date'])){ $_SESSION['quote_call']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['quote_call']['to_date'])){ $_SESSION['quote_call']['to_date'] = date("Y-m-t"); }

      $arg = "select schedule_date from call_schedule_report where 1 = 1 ";
  
       if($_SESSION['quote_call']['from_date'] != '' && $_SESSION['quote_call']['to_date'] != '') {
			
			$arg.= " AND schedule_date >= '".date('Y-m-d' , strtotime($_SESSION['quote_call']['from_date']))."' and schedule_date <= '".$_SESSION['quote_call']['to_date']."'";
		}
		 $arg.= " GROUP by schedule_date ORDER by schedule_date asc ";
	
	$sqlquery = mysql_query($arg);
  $count = mysql_num_rows($sqlquery);
  
  //echo  $count;
?>  
<div id="daily_view">
 <span class="staff_text" style="margin-bottom:25px;"> Call Quote Queue </span>
<br/>
  <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-table">
       <tbody>
	   
	    <tr class="table_cells">
		  <td colspan=""> <strong>Call Date</strong></td>
		  <td colspan="3"><strong>Call Queue</strong></td>
		  <td colspan="15"><strong>Call By Admin</strong></td>
		</tr>
	   
	   
	    <tr class="table_cells">
			  <td>&nbsp;</td>
			  <td>Total Call</td>
			  <td>Total Take Call</td>
			  <td>Call Pending</td>
			  <td>Call Schedule </td>
			  <td>Call Done</td>
			<?php  foreach(getAdminname() as $key=>$adminname) { ?>
			  <td><?php echo $adminname; ?></td>
			<?php  } ?>
			  
		</tr>
			
	
	   <?php while($getdata = mysql_fetch_assoc($sqlquery)) {
             $gettotalCall = gettotalCall($getdata['schedule_date'],'' , ''); 
             $totalgettotalCall += gettotalCall($getdata['schedule_date'],'' , ''); 
			 
			 $gettotaltakeCall = gettotalCall($getdata['schedule_date'],1 , ''); 
             $totalgettotaltakeCall += gettotalCall($getdata['schedule_date'],1 , ''); 
			 

             /*  $call_take = gettotalCall($getdata['schedule_date'],2, ''); 
             $totalcall_take += gettotalCall($getdata['schedule_date'],2, ''); 
			  */
             $call_pending = gettotalCall($getdata['schedule_date'],3 , ''); 
             $totalcall_pending += gettotalCall($getdata['schedule_date'],3 , '');
			 
             $call_done = gettotalCall($getdata['schedule_date'],4, ''); 
             $totalcall_done += gettotalCall($getdata['schedule_date'],4, ''); 
             
			 
			// print_r($gettotalCall);
	   ?>
		<tr>	
			  <td><?php echo $getdata['schedule_date']; ?></td>
			  <td><?php echo $gettotalCall; ?></td>
			  <td><?php echo $gettotaltakeCall; ?></td>
			  <td><?php echo $call_pending; ?></td>
			  <td><?php if($getdata['schedule_date'] < date('Y-m-d')) {echo '-';}else { echo $call_pending;} ?></td>
			  <td><?php echo $call_done; ?></td>
			  <?php  foreach(getAdminname() as $adminid=>$adminname) { 
			    $admincall = gettotalCall($getdata['schedule_date'],5,$adminid); 
			    $totaladmincall[$adminid] += gettotalCall($getdata['schedule_date'],5,$adminid); 
			  ?>
			  <td><?php if($admincall == 0) {  echo '-'; }else { echo $admincall;  } ?></td>
			<?php  } ?>
		</tr>
	   <?php   }?>
	   
	    <tr>	
			  <td><strong>Total</strong></td>
			  <td><strong><?php echo $totalgettotalCall; ?></strong></td>
			 <td><strong><?php echo $totalgettotaltakeCall; ?></strong></td>
			  <td><strong><?php echo $totalcall_pending; ?></strong></td>
			  <td><strong></strong></td>
			  <td><strong><?php echo $totalcall_done; ?></strong></td>
			  <?php  foreach(getAdminname() as $adminid1=>$adminname) { 
			  ?>
			  <td><strong><?php if($totaladmincall[$adminid1] == '0') { echo '-'; }else {  echo $totaladmincall[$adminid1]; } ?></strong></td>
			<?php  } ?>
		</tr>
	   
	   
		 </tbody>
    </table>		
	</div>