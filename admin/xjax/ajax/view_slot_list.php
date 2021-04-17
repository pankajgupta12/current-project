<?php 

  /* if(!isset($_SESSION['schedule']['from_date'])) { $_SESSION['schedule']['from_date'] = date("Y-m-1"); }
 if(!isset($_SESSION['schedule']['to_date']))   {  $_SESSION['schedule']['to_date'] = date("Y-m-t");  } */
 
   $resultsPerPage = resultsPerPage;
   
   $time = date('H:i');
  
  
    //print_r($_SESSION);
   
    $arg = "select 
	       *
		   from 
		   
			( 
			    SELECT 
					* 
				FROM 
				call_schedule_report 
				WHERE 
				 1 = 1";
		
		
		      $arg .=	" ORDER BY 
				quote_id DESC 
			) 
			  as 
			call_schedule_report1
			where  quote_id in 
			(select id from quote_new where booking_id = 0 AND   step not in (8,9,10) AND  denied_id = 0";
	
			// CASE RatingID     ->       WHEN 'R' THEN 'Under 17 requires an adult.'
	
		//if($_SESSION['schedule']['job_date'] != ''){
			
		 //  $arg .= " AND step in (5,6,7) and denied_id > 0";	
		//}
		
		if($_SESSION['schedule']['job_date'] != ''){
			
		   $arg .= " AND booking_date = '".$_SESSION['schedule']['job_date']."'";	
		}	
		
        if($_SESSION['schedule']['mobile'] != ''){
		   $arg .= " AND phone Like '%".$_SESSION['schedule']['mobile']."%'";	
		}		
			
		if($_SESSION['schedule']['response'] != '' && $_SESSION['schedule']['response'] != 0){
		   $arg .= " AND response = ".$_SESSION['schedule']['response']."";	
		}

        if($_SESSION['schedule']['step'] != '' && $_SESSION['schedule']['step'] != 0){
		   $arg .= " AND step = ".$_SESSION['schedule']['step']."";	
		}		
				
		$arg .=")";	
	
	if(isset($_SESSION['slot_quote_action']))
	{ 
		
		if($_SESSION['slot_quote_action']=="1")
		{
			
			$currenttime = date('Y-m-d H:i:s' , strtotime('-30 minutes'));
			$arg .= " AND  schedule_date_time <= '".$currenttime."'";
		}
		if($_SESSION['slot_quote_action']=="2")
		{
			$currenttimefrom = date('Y-m-d H:i:s' , strtotime('-30 minutes'));
			$currenttimeto = date('Y-m-d H:i:s' , strtotime("+30 minutes")); 
			
		
			$arg .= " AND schedule_date = '".date("Y-m-d")."' AND (schedule_date_time >= '".$currenttimefrom."' AND  schedule_date_time <= '".$currenttimeto."')";
		}
		
		if($_SESSION['slot_quote_action']=="3")
		{	
			$upcommingtime = date('Y-m-d H:i:s' , strtotime('+60 minutes'));
			$arg .= " AND schedule_date_time >= '".$upcommingtime."' ";
		}
		
	
		
		if($_SESSION['slot_quote_action']=="5")
		{		
	    	$arg .= ' AND quote_id in (SELECT quote_id FROM quote_details WHERE job_type_id = 11)';
		}
		 else
		{		
	    	$arg .=  ' AND quote_id in (SELECT quote_id FROM quote_details WHERE job_type_id != 11)';
		}
		
		
		
 		
	}
	 
	    if($_SESSION['slot_quote_action']=="4")
		{
			$arg .= " AND call_done = '1' AND status = 0 ";
		} else {
		    $arg .= " AND call_done = '0' AND status = 1 ";	
		}
	
	 if($_SESSION['slot_quote_action'] != "3")
	{
	
		if($_SESSION['schedule']['from_date'] != '' && $_SESSION['schedule']['to_date'] != '') {
			
			$arg.= " AND schedule_date >= '".date('Y-m-d' , strtotime($_SESSION['schedule']['from_date']))."' and schedule_date <= '".$_SESSION['schedule']['to_date']."'";
		}
	} 
	
	if($_SESSION['schedule']['quote_id'] != '0' &&  $_SESSION['schedule']['quote_id'] != '') {
		
		$arg.= " AND  quote_id = '".$_SESSION['schedule']['quote_id']."'";
	}
	
	if($_SESSION['schedule']['site_id'] != '0' &&  $_SESSION['schedule']['site_id'] != '') {
		
		$arg.= " AND  site_id = '".$_SESSION['schedule']['site_id']."'";
	}
	
	$count = $arg;	
	
     if($_SESSION['slot_quote_action'] == "3")
	{
        $arg.=" order by call_schedule_report1.schedule_date asc,call_schedule_report1.schedule_time_value asc";
	}else {
		
		$arg.=" order by call_schedule_report1.login_id asc,call_schedule_report1.org_created_date desc, call_schedule_report1.quote_id asc";
	}
	
    $arg.="  limit 0,$resultsPerPage";
	
	echo $arg;
    $counttotal = mysql_num_rows(mysql_query($count));
   
    $sql = mysql_query($arg);
   
    $countresult = mysql_num_rows($sql);
?>
    <div class="right_text_boxData right_text_box">
	  <div class="midle_staff_box"><span class="midle_text">Total Records <?php  echo $counttotal; ?></span></div>
	</div>
	
	
	<table class="user-table">
		<thead class="myTable">
			<tr>
				<th>Q Id</th>
				<th>#Q For</th>
				 <th>Ref</th>
				<th>Site</th>
				<th>Name</th>
				<th>Phone</th>
				<th>Q Date</th>
				<th>Call Date</th>
				<th>Call Time</th>
				<th>Job Date</th>
				<th>Job Type</th>
				<th>Call history</th>
				<th>Take Call</th>
				<th>Re-Schedule</th>
				<th>Schedule Date</th>
				<?php 	if($_SESSION['slot_quote_action']=="4") { ?>
					<th>Call Reverse</th>
				 <?php  } else { ?>	
					<th>Call Done</th>		 
				<?php  } ?>
				<th>Response</th>
				<th>Status</th>
				<th>Admin</th>
			</tr>
		</thead>
		  
		<tbody>
		    <?php   
			    if($countresult > 0) { 
				
				$i = 1;
			        while($call_r = mysql_fetch_assoc($sql)) {
			        
					    $r = mysql_fetch_array(mysql_query("Select * from quote_new where id = ".$call_r['quote_id'].""));	
					
						
					    $sql_icone = ("select job_type_id , job_type from quote_details where  status != 2 AND quote_id=".$r['id']);
		                $quote_details = mysql_query($sql_icone); 
					
					    $siteDetails = mysql_fetch_array(mysql_query("Select name ,abv,area_code from sites where id = ".$r['site_id'].""));	
					
					
							$startDatehours  = date('Y-m-d H:i:s');
							$endDatehours = $call_r['createdOn'];
							$minutes = round((strtotime($startDatehours) - strtotime($endDatehours))/60, 2);
							
							$getjobtypeid = get_sql("quote_details","job_type_id"," where job_type_id='11' AND quote_id='".$r['id']."'");
							if($r['quote_for'] == 2 || $getjobtypeid == 11) {
								
								$class = 'alert_warning '; // take call 
							}else {
								if($minutes < 10 && $call_r['take_call'] == 0) {
									$class = ''; // less 10 mnt
								}elseif($minutes > 10 && $call_r['take_call'] == 0){ 
									$class = 'alert_danger_tr'; // take call 
								}elseif($call_r['schedule_date'] != '' && $call_r['schedule_time'] != ''){ 
									$class = 'alert_orange_tr'; // schedual date
								}elseif($call_r['take_call'] == 1){ 
									$class = 'alert_danger_success'; //
								}
							}
			
			
			 $getsql11 = mysql_query("select * from call_schedule_report where quote_id = ".$r['id']."  order by id asc");
			 $counttotalCall =    mysql_num_rows($getsql11);
			
			?>
			 
				<tr class="parent_tr <?php  echo $class; ?>" id="slot_<?php echo $r['id'];  ?>">
				   
					<td class="pick_row bc_click_btn"><a href="javascript:scrollWindow('edit_quote_popup.php?task=edit_quote&quote_id=<?php echo $r['id']; ?>','1300','850')"><?php echo $r['id']; ?></a></td>
					 <td class="bc_click_btn pick_row "><?  echo get_rs_value("quote_for_option","name",$r['quote_for']);?></td>
					
					<td class="bc_click_btn" title="<?php if($r['job_ref'] != '0') { echo $r['job_ref']; } ?>"><img class="image_icone" src="icones/ref/<?php echo getRefIcons($r['job_ref']); ?>" alt="<?php echo $r['job_ref']; ?>"></td>
					<td class="pick_row bc_click_btn" title="<? echo $siteDetails['name']; ?>"><? echo $siteDetails['abv']; ?></td>
					
					<td class="bc_click_btn" title="<? echo $r['name'];?>"><? echo $r['name'];?></td>
					
					<td class="bc_click_btn"><a href="tel:<? echo $siteDetails['area_code'].$r['quote_for'].$r['phone'];?>"><? echo $r['phone'];?></a></td>
						 
					
					<td class="pick_row bc_click_btn" title="<? echo changeDateFormate($r['createdOn'],'timestamp'); ?>"><? echo changeDateFormate($r['createdOn'],'dt'); ?></td>		
					
					<td class="pick_row bc_click_btn" title=""><? echo changeDateFormate($call_r['schedule_date'],'datetime'); ?></td>	
					<td class="pick_row bc_click_btn">
					    <?php 
                     	if($call_r['schedule_time_value'] == '') {
						   echo date('H:i',strtotime($call_r['org_created_date'])).'-'.date('H:i',strtotime('+10 minutes',strtotime($call_r['org_created_date'])));
    					 }else{
							echo $call_r['schedule_time_value'];
						}
						?>
				    </td>	
					
					
					<td class="pick_row bc_click_btn"><?php  if($r['booking_date'] != '0000-00-00') { echo changeDateFormate($r['booking_date'] , 'datetime'); } ?></td>
					
				    <td class="bc_click_btn bc_click_btn" style="width: 90px;">
						<? 
							  while($qd = mysql_fetch_assoc($quote_details)){      
									$job_icon =  get_rs_value("job_type","job_icon",$qd['job_type_id']);
							  ?><img class="image_icone" src="icones/job_type32/<?php echo $job_icon." "; ?>" alt="<?php echo $qd['job_type']." "; ?>" title="<?php echo $qd['job_type']." "; ?>">
					    <?php }  ?>
					</td>	
					
					<td class="pick_row ">
					   <?php if($counttotalCall > 1) { ?><a  href="javascript:showdiv('ediv_<?php echo $r['id']; ?>');">View (<?php echo $counttotalCall; ?>)</a> 
					   <?php  }else { echo 'Not'; }  ?>
					</td>
					
					
					<td class="pick_row take_call_<?php echo $r['id']; ?>" id="call_take_<?php echo $r['id']; ?>">
					 
					  <button type="submit" onClick="javascript:take_call('<?php echo $r['id']; ?>' , 'take_call' , 'call_take_<?php echo $r['id']; ?>');">Take Call</button>
					</td>	
					
					<td class="pick_row reshedule_call_<?php echo $r['id']; ?>"><button type="submit" onClick="javascript:reshedule_call('<?php echo $r['id']; ?>' , 'reshedule_call' , 'reshedule_call_<?php echo $r['id']; ?>');">Call Re-Schedule</button></td>		
					
					<td class="pick_row custom_call_<?php echo $r['id']; ?>" id="schedule_date_time_<?php echo $r['id']; ?>">
					    <input type="text" style="border: 1px solid;width: 150px;padding: 4px;" id="schedule_date_<?php echo $r['id']; ?>"  value="<?php echo $call_r['schedule_date']; ?>" />
						
						    <span>
							    <select name="schedule_time"  id="schedule_time_<?php echo $r['id']; ?>">
								<option value=''>Select</option>
								  <?php  
								    $minutes = get_minutes('01:00', '23:00');  
								    foreach($minutes as $key=>$minute) {
									   if(($call_r['schedule_time_value'] == $minute) && ($call_r['time_type'] == 2)) { $selected = 'selected'; }else { $selected = '';}
									   echo '<option value='.$minute.' '.$selected.'>'.$minute .'</option>';  
                                    }  
								  ?>
								
								</select>
								
						        <?php //echo create_dd("schedule_time","site_time_slot","id","schedule_time","site_id = ".$r['site_id']."","",$call_r, 'field_id_time'); ?>
							</span>
							
						<button type="submit" onclick="schedule_timing('<?php echo $r['id']; ?>' , 'schedule_date_time_<?php 
						echo $r['id']; ?>');">Save</button>
					</td>	
					
					<td class="pick_row call_done_<?php echo $r['id']; ?>" id="call_done_<?php echo $r['id']; ?>">
					
					   <?php if($_SESSION['slot_quote_action']== "4") { ?>
					  
					    <button type="submit" onClick="javascript:send_data('<?php echo $r['id']; ?>' , '521' , 'call_done_<?php echo $r['id']; ?>');">Call Reverse</button>
					
					  <?php  } else { ?>
					  
					    <button type="submit" onClick="javascript:take_call('<?php echo $r['id']; ?>' , 'call_done' , 'call_done_<?php echo $r['id']; ?>');">Call Done</button>
					  
					  <?php  } ?>  
					
					</td>		
					
					<!--<td class="pick_row"><?php  echo  getSystemvalueByID($r['response'],33); ?></td>-->
					<!--<td class="pick_row"><?php  echo  getSystemvalueByID($r['step'],31); ?></td>-->
					 <td id="response">
			          <?php echo create_dd("response","system_dd","id","name","type=33","Onchange=\"view_quote_response(this.value,".$r['id'].");\"",$r);?>    
			         </td>
			 		<td id="getstatus">
			           <?php echo create_dd("step","system_dd","id","name","type=31","Onchange=\"return view_quote_status_change(this.value,".$r['id']." , 2);\"",$r);
					   
					   
						if($tr_removal > 0){
							if($r['step'] == 6) {
							     echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=99","Onchange=\"return view_quote_admin_denied(this.value,".$r['id'].");\"",$r);
							}
							}else {
								if($r['step'] == 6) {
								echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=91","Onchange=\"return view_quote_admin_denied(this.value,".$r['id'].");\"",$r);
								}else if($r['step'] == 5){
								echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=93","Onchange=\"return view_quote_admin_denied(this.value,".$r['id'].");\"",$r);
								}else if($r['step'] == 7){
								echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=94","Onchange=\"return view_quote_admin_denied(this.value,".$r['id'].");\"",$r);
							  }
					    	}
					   ?>
			       </td>	
					<td class="pick_row" id="admin_name_<?php echo $r['id']; ?>"><?php if($call_r['staff_name'] != '') { echo $call_r['staff_name']; }else {echo 'Site'; }?></td>
					 
				</tr>
				    <tr>
					    <td colspan="20"  id="ediv_<?php echo $r['id']; ?>" style="display:none;">
							<table class="inside_table">
								<tr>
									<td><b>Schedule Date</b></td>
									<td><b>Schedule Time</b></td>
									<td><b>Take Call</b></td>
									<td><b>Call Done</b></td>
									<td><b>Call Reverse</b></td>
									<td><b>Auto/Custom</b></td>
									<td><b>Admin Name</b></td>
									<td><b>Create On</b></td>
								</tr>
								<?php  
								    if($counttotalCall >0) {
										while($data1 = mysql_fetch_assoc($getsql11)) {
									?>  
										<tr>
											<td><?php echo changeDateFormate($data1['schedule_date'] , 'datetime'); ?></td>
											<td><?php if($data1['schedule_time_value'] != '') { echo $data1['schedule_time_value']; } ?></td>
											<td><?php if($data1['take_call'] == '1') {  echo 'Yes';}else {echo 'No'; } ?></td>
											<td><?php if($data1['call_done'] == '1') {  echo 'Yes';}else {echo 'No'; } ?></td>
											<td><?php if($data1['call_reverse'] == '2') {  echo 'Yes';}else {echo 'No'; } ?></td>
											<td><?php if($data1['time_type'] == '1') { echo 'Auto'; }else {echo 'Custom'; }?></td>
											<td><?php if($data1['staff_name'] != '') { echo $data1['staff_name']; }else {echo 'Site'; }?></td>
											<td style="width: 35%;"><?php echo changeDateFormate($data1['createdOn'] , 'timestamp'); ?></td>
										</tr>
									<?php 
										} 
								    }  								
								?>
							</table>
						</td>
					</tr>
				
				
					<script>
						$(function() {
						   $( "#schedule_date_<?php echo $r['id']; ?>" ).datepicker({dateFormat:'yy-mm-dd'});
						});
					</script>
			    <?php $i++; }  ?>
			
			   <?php   if($counttotal >= $resultsPerPage) {  ?>
				<tr class="load_more">
				   <td colspan="30"><button class="loadmore" data-page="2" >Load More</button></td>
				</tr>
			    <?php }  ?>  
			  
			<?php }else { ?>
			 <tr>
			   <td colspan="20">No Record found</td>
			  </tr>
			
			<?php } ?>
		</tbody>	
	</table>	
	
	<style>
	  .inside_table{
		  width: 80%;
          margin: 0px auto;
	  }
	</style>
	
	<script>
	    function take_call(id , field_name , div_id){
		   var str = id+'|'+field_name;
		   send_data(str , 516 , div_id);
	    }
		
		function reshedule_call(id , field_name , div_id){
			 var str = id+'|'+field_name;
		     send_data(str , 518 , div_id);
		}
		/* function call_reverse(id , field_name , div_id){
			var str = id+'|'+field_name;
			//alert(str);
			send_data(str , 520 , div_id);
		} */
		
		
			$(document).on('click','.loadmore',function () {
				  $(this).text('Loading...');
						$.ajax({
					  url: 'xjax/ajax/loadmore_slot.php',
					  type: 'POST',
					  datatype: 'html',
					  data: {
							  page:$(this).data('page'),
							},
						success: function(response){
							if(response){
								$('.load_more').remove();
								$( "tr.parent_tr:last" ).after( response );
							 }
							} 
							 
				   }); 
	        });
		
	</script>