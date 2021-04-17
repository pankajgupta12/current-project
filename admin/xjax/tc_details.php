 <?php 
 
	    $jobdetailsD = mysql_fetch_assoc(mysql_query("SELECT id , accept_terms_status , tc_ip_address , tc_address , tc_createdOn   FROM `jobs` WHERE  id = ".$job_id." AND `tc_ip_address` != '' AND `accept_terms_status` = '1'  AND tc_createdOn != '0000-00-00 00:00:00' ORDER BY `id` DESC"));
		
		 if(!empty($jobdetailsD)) {
		     
		     
		     $filename = $_SERVER['DOCUMENT_ROOT'].'/tc/tc_files/tc_'.$jobdetailsD['id'].'.pdf';
		     
	 ?>
	            <div class="tab3_table1">
					<table class="start_table_tabe3">
							<thead>
							  <tr>
								<th>IP Address</th>
								<th>TC Address</th>
								<th>TC DateTime</th>
								<th>TC Status</th>
								<th>Download TC</th>
							  </tr>
							</thead>
							<tbody>
								<tr>
								  <td><?php echo $jobdetailsD['tc_ip_address']; ?></td>
								  <td style="width: 2px;"><?php echo $jobdetailsD['tc_address']; ?></td>
								  <td><?php echo $jobdetailsD['tc_createdOn']; ?></td>
								  <td><?php if($jobdetailsD['accept_terms_status'] == 1) {  echo 'Yes'; }else {echo 'No'; }?></td>
								   <td>
							    	<?php if (file_exists($filename)) { ?>  
								     <a href="../../tc/tc_files/tc_<?php echo $jobdetailsD['id']; ?>.pdf" download>Download</a>
								   <?php  } ?></td>
								</tr>
							</tbody>
					</table>   
		<?php  } ?>