<div class="usertable-overflow usertable-overflowNew">
 <br><br>
   <h5 class="br_heading">BR Inventory Details Notes</h5>
   <br>
    <table class="user-table">
	  <thead class="myTable">
	  <tr>
		<th>Id</th>
		<th>Message</th>
		<th>Name</th>
		<th>Date</th>
	  </tr>
	  </thead>
	  <tbody id="get_loadmoredata">
	    <?php  
		$q_id = $_GET['quote_id'];
		 $sql = mysql_query("SELECT * FROM `inventory_status_notifications` WHERE quote_id = ".$q_id." ORDER by id desc"); ?>
	  <?php  if(mysql_num_rows($sql) > 0) {
		  
		   while($noti_data = mysql_fetch_assoc($sql)) {
		  ?>
		  <tr class="parent_tr  " style="">
			<td class="bc_click_btn pick_row "><?php  echo $noti_data['id']; ?></td>
			<td class="bc_click_btn pick_row "><?php  echo $noti_data['comment']; ?></td>
			<td class="bc_click_btn pick_row "><?php  echo $noti_data['staff_name']; ?></td>
			<td class="bc_click_btn pick_row "><?php  echo changeDateFormate($noti_data['date'],'timestamp'); ?></td>
			     
	      </tr>
		   <?php } }else{ ?>  
	     <tr class="parent_tr  " style="">
			<td >No Record found</td>
		</tr>	
	  <?php  } ?>
		  
	     
	</tbody></table>

    </div>