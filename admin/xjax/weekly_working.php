<?php  

	  for($i = 6; $i>=0; $i--) {
		  $getDate[] = date('Y-m-d', strtotime('-'.$i.'day'));
	  }
	  
	$adminid = $_REQUEST['id'];
?>

  
 <br/>
 <br/>
		<div class="right_text_boxData right_text_box">
		  <div class="midle_staff_box"><span class="midle_text">Total Records <?php echo   $count; ?> </span></div>
		</div>
<br/>
  <h2><?php  echo  get_rs_value('admin','name',$adminid); ?> Weekly Working<h2>
            <table class="user-table" border="1px">
					<thead>
					    <tr>
						<th>Date</th> 
						<?php  foreach($getDate as $key=>$val) {  ?>
							<th><?php echo $val.' ('.date('l', strtotime($val)).')'; ?></th> 
						<?php  } ?>
						</tr>
					</thead>
					
					   
					   
					    <tr>
							<td>Start Time</td>
							<?php  foreach($getDate as $key=>$val) {  
							
							  $startTime =  getlAdminoginTime($val, $adminid , 1);
							
							?>
							<td><?php if($startTime != '') { echo changeDateFormate($startTime , 'timestamp'); } ?></td> 
						   <?php  } ?>
						</tr>
						
						<tr>
							<td>Lunch start Time</td>
							<?php  foreach($getDate as $key=>$val) {  
							$lasttime =  getlunchTime($val, $adminid , 1);
							?>
							<td><?php if($lasttime != '') { echo changeDateFormate($lasttime , 'timestamp'); } ?></td> 
						   <?php  } ?>
						</tr>
						
						<tr>
							<td>Lunch Finish Time</td>
							<?php  foreach($getDate as $key=>$val) {
                             $finishtime =  getlunchTime($val, $adminid , 2);
							?>
							<td><?php if($finishtime != '') { echo changeDateFormate($finishtime , 'timestamp'); } ?></td> 
						   <?php  } ?>
						</tr>
						<tr>
							<td>End time</td>
							<?php  foreach($getDate as $key=>$val) { 
                            $lasttime =  getlAdminoginTime($val, $adminid , 2);
							?>
							<td><?php if($lasttime != '') { echo changeDateFormate($lasttime , 'timestamp'); } ?></td> 
						   <?php  } ?>
						</tr>
					  
				<tbody>
				</tbody>
            </table>