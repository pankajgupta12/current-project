
<br>
<br>
<?php  
  /*  $getAgentDetails = mysql_fetch_array(mysql_query("select real_estate_agency_name, agent_name,agent_number,agent_email from job_details where job_id=".mysql_real_escape_string($_REQUEST['job_id'])." AND status != 2")); */
   
    $getAgentDetails = mysql_fetch_array(mysql_query("select real_estate_agency_name, agent_address , agent_landline_num , agent_name,agent_number,agent_email from job_details where job_id=".mysql_real_escape_string($_REQUEST['job_id'])." AND status != 2 limit 0 , 1"));
  
 // print_r($getrecleanAgentDetails);
?>
 
               <span class="job_detail_text">Real Estate Agent Details </span>
				<ul class="input_list input_list3 real_estate_details">
				
					<li><label> <strong>Agency Name: </strong></label><br/><?php if($getAgentDetails['real_estate_agency_name'] != '') { echo $getAgentDetails['real_estate_agency_name']; } else { echo "N/A";}?></li>
					 
					 <li><label><strong>Agent Name:</strong> </label><br/><?php if($getAgentDetails['agent_name'] != '') { echo $getAgentDetails['agent_name']; } else { echo "N/A"; }?></li>
					 
					
					<li><label><strong>Agent Number:</strong> </label><?php if($getAgentDetails['agent_number'] != '') { echo $getAgentDetails['agent_number']; } else { echo "N/A"; }?></li>
					
					 <li><label><strong>Agent Email:</strong> </label><?php if($getAgentDetails['agent_email'] != '') { echo $getAgentDetails['agent_email']; } else { echo "N/A"; }?></li>
					 
					  <li><label><strong>Agent landLine No:</strong> </label><?php if($getAgentDetails['agent_landline_num'] != '') { echo $getAgentDetails['agent_landline_num']; } else { echo "N/A"; }?></li>
					  
					   <li><label><strong>Agent Address:</strong> </label><?php if($getAgentDetails['agent_address'] != '') { echo $getAgentDetails['agent_address']; } else { echo "N/A"; }?></li>
					 
				</ul>

<span class="job_detail_text">Add reclean job type</span>
    <div id="tab-1">
     <div class="container"> 
		<div class="reclean_popup_left_bar"> 
			<div class="f_table_main">
			
			
			<?php $jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($_REQUEST['job_id'])."")); ?>
			
			   <div class="input_list_table_below">
				<table>
					<thead>
						<th>Job Type</th>
						<th>Staff</th>
						<th>Reclean Date</th>
						<th>Time</th>
						<th></th>
					</thead>
					<tbody>
						<tr>
						
							<td style="padding-left:5px;">
								<span>
									<?php 
									 //$a_onchange = "onchange=\"javascript:send_data('a_job_type','','get_staff_div');\"";
									  $a_onchange = "onchange=\"javascript:get_staff_reclean_details('".$jobs['id']."');\"";
									  echo create_dd("reclean_job_type","job_details","job_type_id","Job_type"," job_id=".$jobs['id']." and status!=2 AND job_type_id NOT in (SELECT job_type_id FROM `job_reclean` WHERE job_id=".$jobs['id']." AND status != 2)",$a_onchange,$details); 
									?>
								</span>
							</td>
							<td>
								<div id="get_staff_div">
									<span>
										<?php
										  $job_type = get_rs_value("job_type","name",$job_type_id);
										  echo create_dd_staff("reclean_staff_id","job_details","staff_id","staff_id"," job_id=".$jobs['id']." and status!=2 AND reclean_job != 2","","");
										?>
									</span>
								</div>
							</td>
							

							<td><input name="reclean_job_date" type="text" id="reclean_job_date" size="10" value="<?php echo $jdetails['job_date'];?>"></td>
							<td><input name="reclean_job_time" type="text" id="reclean_job_time" size="10" value="8:00 AM"></td>
							<td style="background:#7b7b7b;"><input type="button" name="submit_button" id="submit_button" value="Add reclean job type" onclick="javascript:add_reclean_job_type(<?php echo $_REQUEST['job_id'];?>);" /></td>
						</tr>
					</tbody>
				</table>
				</div>
			</div>


            <span class="job_detail_text">Reclean job types</span>

    
			<div class="f_table_main">
			   <div class="input_list_table_below" id="job_type_div">
				<?php
					$job_id=$_REQUEST['job_id'];
					include("xjax/view_reclean_job_details.php");
				?>  
				</div>
			</div>
		</div>

        <div class="reclean_popup_right_bar">
		
		    <div>
				<input type="button" value="All notes" class="staff_button_over" id="all_notes" onclick="show_noraml_notes('all');changeclass(1);" style="float:left; margin-right:10px;">
				<input type="button" value="For Staff" class="staff_button" id="staff_notes" onclick="show_staff_notes('staff');changeclass(2);" style="float:left; margin-right:10px;">
		    </div>
		
		   
		     <div class="text_box all_notes" style="margin-top: 13px;">
               <textarea name="reclean_comments" id="reclean_comments" class="textarea_box_notes" placeholder="Type a Re-Clean Note Here" ></textarea>
                <span class="textarea_add_btn">
                	<input id="reclean_comments_button" name="reclean_comments_button"  type="button" value="add" onclick="javascript:add_comment_reclean(document.getElementById('reclean_comments'),'<?php echo $jobs['id'];?>')" style="height:100%; width:100%">
                </span>
            </div>
			
			 <div class="text_box staff_details" style="margin-top: 13px; display:none;">
               <textarea name="specfic_reclean_comments" id="specfic_reclean_comments" class="textarea_box_notes" placeholder="Re-Clean Note For Staff" ></textarea>
                <span class="textarea_add_btn">
                	<input id="specfic_reclean_comments_button" name="specfic_reclean_comments_button"  type="button" value="add" onclick="javascript:specfic_add_comment_reclean(document.getElementById('specfic_reclean_comments'),'<?php echo $jobs['id'];?>')" style="height:100%; width:100%">
                </span>
            </div>
            
            
			<div id="job_notes_div">
        			<?php 
            			$job_id=$jobs['id'];
            			include("xjax/reclean_notes.php");
        			?>
            </div>
        </div>
     </div>
    </div>

<script>
	$("#reclean_comments").keyup(function(event){
		if(event.keyCode == 13){
			$("#reclean_comments_button").click();
		}
	});
	
	$("#specfic_reclean_comments").keyup(function(event){
		if(event.keyCode == 13){
			$("#specfic_reclean_comments_button").click();
		}
	});
	
	$(function() {
		  $("#reclean_job_date").datepicker({dateFormat:'yy-mm-dd'});
	});		
	
</script>

