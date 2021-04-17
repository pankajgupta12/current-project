
<?php  
if(!isset($_SESSION['realestate']['jobdate_from'])){ $_SESSION['realestate']['jobdate_from'] = date("Y-m-1"); }
if(!isset($_SESSION['realestate']['jobdate_to'])){ $_SESSION['realestate']['jobdate_to'] = date('Y-m-t'); }
	
	
	 $sql = "SELECT   J.job_id  as jobid,J.site_id as sname ,J.job_date as jdate , J.agent_name as aname , Q.address caddress,  J.agent_number anumber ,  J.agent_email as aemail ,    J.real_estate_agency_name as esaname  FROM `job_details` J , quote_new Q , sites S  WHERE Q.booking_id = J.job_id AND  J.agent_name != '' ";
	 
	 if($_SESSION['realestate']['siteid'] != 0 && $_SESSION['realestate']['siteid'] != '') {
		  $sql .= ' AND J.site_id = '.$_SESSION['realestate']['siteid'].'';
	 }
	 
	if($_SESSION['realestate']['jobdate_from'] != Null && $_SESSION['realestate']['jobdate_to']  != '') {
			 $sql.= "  AND  J.job_date  >= '".date('Y-m-d' , strtotime($_SESSION['realestate']['jobdate_from']))."' and J.job_date  <= '".$_SESSION['realestate']['jobdate_to']."'";
		}
	
	if($_SESSION['realestate']['search_val'] != '') {
		  $sql .= " AND  ( J.agent_name = '".$_SESSION['realestate']['search_val']."' OR  J.agent_number = '".$_SESSION['realestate']['search_val']."' OR J.agent_email = '".$_SESSION['realestate']['search_val']."' OR J.real_estate_agency_name = '".$_SESSION['realestate']['search_val']."')";
	 }
	 $sql .= ' GROUP by J.job_id Order by J.job_date desc';
	// echo $sql;
	
	 
	 $query = mysql_query($sql);

?>


 <span class="payment_required">Image Link Details</span>
 <div class="tab3_table1">
      <table class="user-table">
        <thead>
          <tr>
            <th>Job ids</th>
            <th>Job Date</th>
            <th>Site Name</th>
            <th>Agency Name</th>
            <th>Agent Name</th>
            <th>Agent Number</th>
            <th>Agent Email</th>
            <th>Total Job Work Count</th>
          </tr>
        </thead>
		
        <tbody>
		 <?php  while($data = mysql_fetch_assoc($query)) { 
		        $sname= get_rs_value('sites', 'name', $data['sname']);
			  
				// $jobs = '';
				 $totalwork =  getTotalRecleanByAgent($data['esaname'] );
				 $totcount = count(explode(',',strip_tags($totalwork)));
			 
		 ?>		
				  <tr  class="<?php if($totcount > 1) {echo 'alert_danger_tr'; } ?> ">
					<td><?php echo ($totalwork); ?></td>
					<td><?php echo changeDateFormate($data['jdate'] , 'datetime'); ?></td>
					<td><?php echo $sname; ?></td>
					<td><?php echo $data['esaname']; ?></td>
					<td><?php echo $data['aname']; ?></td>
					<td><?php echo $data['anumber']; ?></td>
					<td><?php echo $data['aemail']; ?></td>
					<td><?php echo ($totcount); ?></td>
				  </tr>	
		 <?php  } ?>
        </tbody>
      </table>
     </div>	 