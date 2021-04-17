<?php 
// print_r($_SESSION['schedule']);

if(!isset($_SESSION['schedule']['from_date'])) { $_SESSION['schedule']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['schedule']['to_date']))   {  $_SESSION['schedule']['to_date'] = date("Y-m-t");  }
 
   $resultsPerPage = resultsPerPage;
   
    $arg = "select * from quote_new where 1 = 1 AND booking_id = 0 AND  deleted = 0 AND site_id != 0 AND job_ref = 'Site'  AND step not in (7)";
    $arg .= ' AND call_done = 0 ';
	$arg.= ' AND schedule_date <=  "'.date("Y-m-d").'" OR date =  "'.date("Y-m-d").'"';
	
   /*  if($_SESSION['schedule']['from_date'] != '' && $_SESSION['schedule']['to_date'] != '') {
	 
	  $arg.= ' AND schedule_date >=  "'.$_SESSION['schedule']['from_date'].'" AND schedule_date <=  "'.$_SESSION['schedule']['to_date'].'"';
	} */
	if($_SESSION['schedule']['site_id'] != 0)
		{
			$arg .= " AND site_id = ".$_SESSION['schedule']['site_id'];
		}
		
	$count = $arg;	
   $arg.=" order by id desc limit 0,$resultsPerPage";
   
  // echo $arg;
   $counttotal = mysql_num_rows(mysql_query($count));
   
   $sql = mysql_query($arg);
   
   $countresult = mysql_num_rows($sql);
?>

	<table class="user-table">
		<thead class="myTable">
			<tr>
				<th>Id</th>
				<th>Site</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Q Date</th>
				<th>Job Date</th>
				<th>Job Type</th>
				<th>Take Call</th>
				<th>Re-Schedule</th>
				<th>Schedule Date</th>
				<th>Call Done</th>
				<th>Status</th>
			</tr>
		</thead>
		  
		<tbody>
		    <?php   
			    if($countresult > 0) { 
				
			        while($r = mysql_fetch_assoc($sql)) {
			        
					    $sql_icone = ("select job_type_id , job_type from quote_details where  status != 2 AND quote_id=".$r['id']);
		                $quote_details = mysql_query($sql_icone); 
					
					    $siteDetails = mysql_fetch_array(mysql_query("Select name ,abv,area_code from sites where id = ".$r['site_id'].""));	
					
					
					$startDatehours  = date('Y-m-d H:i:s');
					$endDatehours = $r['createdOn'];
					$minutes = round((strtotime($startDatehours) - strtotime($endDatehours))/60, 2);
					
					if($minutes < 10 && $r['take_call'] == 0) {
						$class = ''; // less 10 mnt
					}elseif($r['schedule_date'] != ''){ 
						 $class = 'alert_orange_tr'; // schedual date
					}elseif($minutes > 10 && $r['take_call'] == 0){ 
						 $class = 'alert_danger_tr'; // take call 
					}elseif($r['take_call'] == 1){ 
						 $class = 'alert_danger_success'; //
					}
			
			?>
			 
				<tr class="parent_tr <?php  echo $class; ?>" id="slot_<?php echo $r['id'];  ?>">
				
					<td class="bc_click_btn pick_row "><?php echo $r['id']; ?></td>
					
					<td class="pick_row bc_click_btn"><? echo get_rs_value("sites","name",$r['site_id']); ?></td>
					
					<td class="bc_click_btn" title="<? echo $r['email'];?>"><a href="mailto:<? echo $r['email'];?>"><? echo substr($r['email'], 0, 10)."...";?></a></td>
					
					<td class="bc_click_btn"><a href="tel:<? echo $siteDetails['area_code'].$r['quote_for'].$r['phone'];?>"><? echo $r['phone'];?></a></td>
						 
					
					<td class="pick_row bc_click_btn" title="<? echo changeDateFormate($r['createdOn'],'timestamp'); ?>"><? echo changeDateFormate($r['createdOn'],'dt'); ?></td>		
					
					<td class="pick_row bc_click_btn"><?php  if($r['booking_date'] != '0000-00-00') { echo changeDateFormate($r['booking_date'] , 'datetime'); } ?></td>	
					
				    <td class="bc_click_btn bc_click_btn" style="width: 90px;">
					  <? 
					  while($qd = mysql_fetch_assoc($quote_details)){      
							$job_icon =  get_rs_value("job_type","job_icon",$qd['job_type_id']);
					  ?><img class="image_icone" src="icones/job_type32/<?php echo $job_icon." "; ?>" alt="<?php echo $qd['job_type']." "; ?>" title="<?php echo $qd['job_type']." "; ?>"><?php }   ?>
					</td>	
					
					<td class="pick_row take_call_<?php echo $r['id']; ?>" id="call_take_<?php echo $r['id']; ?>"><button type="submit" onClick="javascript:take_call('<?php echo $r['id']; ?>' , 'take_call' , 'call_take_<?php echo $r['id']; ?>');">Take Call</button></td>	
					
					<td class="pick_row reshedule_call_<?php echo $r['id']; ?>"><button type="submit" onClick="javascript:reshedule_call('<?php echo $r['id']; ?>' , 'reshedule_call' , 'reshedule_call_<?php echo $r['id']; ?>');">Call Re-Schedule</button></td>		
					
					<td class="pick_row custom_call_<?php echo $r['id']; ?>" id="schedule_date_time_<?php echo $r['id']; ?>">
					    <input type="text" style="border: 1px solid;width: 150px;padding: 4px;" id="schedule_date_<?php echo $r['id']; ?>"  value="<?php echo $r['schedule_date']; ?>" />
						
						<?php  //print_r($r); ?>
						
						    <span>
						        <?php  echo create_dd("schedule_time","site_time_slot","id","schedule_time","site_id = ".$r['site_id']."","",$r, 'field_id'); ?>
							</span>
						
						
						<button type="submit" onclick="schedule_timing('<?php echo $r['id']; ?>' , 'schedule_date_time_<?php 
						echo $r['id']; ?>');">Save</button>
					</td>	
					
					<td class="pick_row call_done_<?php echo $r['id']; ?>" id="call_done_<?php echo $r['id']; ?>"><button type="submit" onClick="javascript:take_call('<?php echo $r['id']; ?>' , 'call_done' , 'call_done_<?php echo $r['id']; ?>');">Call Done</button></td>		
					
					<td class="pick_row"><?php  echo  getSystemvalueByID($r['step'],31); ?></td>
					
				</tr>
					<script>
						$(function() {
						   $( "#schedule_date_<?php echo $r['id']; ?>" ).datepicker({dateFormat:'yy-mm-dd'});
						});
					</script>
			<?php }  ?>
			
			   <?php  if($counttotal >= $resultsPerPage) {  ?>
				<tr class="load_more">
				   <td colspan="30"><button class="loadmore" data-page="2" >Load More</button></td>
				</tr>
			    <?php } ?>  
			  
			<?php } ?>
		</tbody>	
	</table>	
	
	<script>
	    function take_call(id , field_name , div_id){
		   var str = id+'|'+field_name;
		   send_data(str , 516 , div_id);
	    }
		
		function reshedule_call(id , field_name , div_id){
			 var str = id+'|'+field_name;
		     send_data(str , 518 , div_id);
		}
		
		
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