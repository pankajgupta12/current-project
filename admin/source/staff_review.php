<div class="body_container">
	<div class="body_back">
		<span class="main_head">Staff  Review</span>
		  <div class="container"> 
 <?php 
   $stafid = $_GET['id'];
   $sql = "SELECT * FROM `bcic_review` WHERE job_id in (SELECT job_id FROM `job_details`  WHERE staff_id = ".$stafid."  and job_type_id = 1) ORDER by review_date DESC";


  $query = mysql_query($sql);
  
  $cnt = mysql_num_rows($query)
 
  ?>



		   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table staff-loc-list">	 
            		<thead style="text-align:center;">
            			<tr class="table_cells" style="height:50px;">
            				  <td><strong>Job Id</strong></td>
            				  <td><strong>Total Ratting</strong></td>
            				  <td><strong>Negative</strong></td>
            				   <td><strong>Positive</strong></td>
            				   <td><strong>Review Date</strong></td>
            			</tr>
            		</thead>
            		
            		<?php  
            		if($cnt > 0) {
            		while($data = mysql_fetch_array($query)) { ?>
            		
            		
                    		   <tr>
                				  <td><?php echo $data['job_id']; ?></td>
                				  <td><?php echo $data['overall_experience']; ?></td>
                				  <td><?php echo $data['negative_comment']; ?></td>
                				  <td><?php echo $data['positive_comment']; ?></td>
                				  <td><?php echo $data['review_date']; ?></td>
                    			</tr>
            		
            		
            		<?php  } }else { ?>
            		
            		<tbody class="table_scrol_location">
            						<tr class="table_cells">
            				   <td colspan="3">No result</td>
            				   
            				</tr>
            					</tbody>
            			<?php  } ?>
            			
            				
         	</table>

		</div>
		
    </div>
</div>