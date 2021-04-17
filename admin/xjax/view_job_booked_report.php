 <br/> <br/> <br/>
 <?php  
   //if(!isset($_SESSION['job_booked_report']['date'])){ $_SESSION['job_booked_report']['date'] = date('Y-m-d'); }
   
    if(!isset($_SESSION['job_booked_report']['from_date'])){ $_SESSION['job_booked_report']['from_date'] = date('Y-m-d' , strtotime('-1 day')); }
    if(!isset($_SESSION['job_booked_report']['to_date'])){ $_SESSION['job_booked_report']['to_date'] = date('Y-m-d'); }
    if(!isset($_SESSION['job_booked_report']['login_id'])){ $_SESSION['job_booked_report']['login_id'] = 0; }
    
    
   // print_r($_SESSION['job_booked_report']);
   
  ?>
 <?php  
    $admininfo = getadminnamedata(); 
    $bookedJobs =  getBookedJobs($_SESSION['job_booked_report']['from_date'] , $_SESSION['job_booked_report']['to_date'] , $_SESSION['job_booked_report']['login_id']);
   // $callinfo =   getCallInfo($_SESSION['job_booked_report']['date']);
    $jobstatus = system_dd_type(26);
    
   // print_r($jobstatus);
     // booking_date, date , 
 ?>
 
 
         <div class="right_text_boxData right_text_box">
        	  <div class="midle_staff_box"><span class="midle_text" style="margin-top: 39px;">Total Records <?php  echo count($bookedJobs); ?></span></div>
    	</div>
    	
       <table class="user-table">
        	  <thead>
        	  <tr>
        	    <th>Quote Id</th>
        		<th>Job Id</th>
        		<th>Quote date</th>
        		<th>Job date</th>
        		<th>Status</th>
        		
        		<?php foreach($admininfo as $admin=>$adminname) { ?>
        		   <th><?php  echo $adminname; ?></th>
        		<?php  } ?>
        		<th>Admin Id</th>
        	    <th>Check</th>
        	  </tr>
        	  </thead>
        	   <tbody id="get_loadmoredata" >
        	       
        	       <?php   foreach($bookedJobs as $key=>$val) { ?>
        			    <tr class="parent_tr " >
        			         <td><?php echo $val['id']; ?></td>
        					<td class=" pick_row"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $val['booking_id'] ?>','1200','850')"><?php echo $val['booking_id'] ?></a></td>
                             <td><?php echo date('d M Y', strtotime($val['date'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($val['booking_date'])); ?></td>
                           
                            <td><?php echo $jobstatus[$val['boostatus']]; ?></td>
        					 <?php 
        			    	$callinfo = 	 getCallDetails($val['id'] ,  $val['booking_date']);
        					 
        					 
        					 foreach($admininfo as $admin=>$adminname) { ?>
                                    <td <?php if($val['boostatus'] == 2) {  ?> style="background: #d8a8a8";  <?php  }  ?>><?php  if(count($callinfo[$val['id']][$admin]) > 0) {  $durationCall =  array_column($callinfo[$val['id']][$admin], 'duration');  echo  getArrayTime($durationCall);  echo  ' ( ' .count($callinfo[$val['id']][$admin]).' )';   }  //echo $adminname; ?></td>
                               
                                <?php  unset($durationCall);  } ?> 
                                
                            <td><?php echo $val['loginname'] ?></td>
                             <td><input type="checkbox" name="checkadmin" id="checkadmin_<?php echo $val['id']; ?>" onClick="checkCall('<?php echo $val['id']; ?>');;" value="<?php echo  $val['call_check']; ?>"    <?php  if($val['call_check'] != '0000-00-00 00:00:00') { echo 'checked'; } ?>/></td>
        			    </tr>	
        			 <?php  unset($callinfo);  } ?>
        		</tbody>
		</table>