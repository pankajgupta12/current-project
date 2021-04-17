<?php 

	if(!isset($_SESSION['amt_report']['amt_report_from'])){ $_SESSION['amt_report']['amt_report_from'] = date("2019-02-18"); }
	if(!isset($_SESSION['amt_report']['amt_report_to'])){ $_SESSION['amt_report']['amt_report_to'] = date("Y-m-t"); }

	 $startdate = '2019-02-18';
	 
      $resultsPerPage = resultsPerPage;
	// print_r($_SESSION['amt_report']);
	 
	// die;
	 $sql = "SELECT QN.quote_to_job_date as qjd, J.job_id as jobid, Q.description as descri , J.quote_id as qid,J.amt_share_type as amt_share , J.job_date as jdate ,J.amount_total as tamt, J.amount_staff as staffamt   FROM `job_details` J , quote_details Q  , quote_new QN WHERE Q.quote_id = J.quote_id AND Q.quote_id = QN.id AND  Q.job_type_id = 1 AND  J.job_type_id = 1 and J.status != 2";
	 
	  if($_SESSION['amt_report']['site_id'] != 0 && $_SESSION['amt_report']['site_id']  != '') {
		  $sql .= " AND QN.site_id =  ".$_SESSION['amt_report']['site_id']."";
	  }
	  
	  if($_SESSION['amt_report']['staff_id'] != 0 && $_SESSION['amt_report']['staff_id']  != '') {
		  $sql .= " AND  J.staff_id =  ".$_SESSION['amt_report']['staff_id']."";
	  }
	  
	  
	  if($_SESSION['amt_report']['staff_type_all'] != 0 && $_SESSION['amt_report']['staff_type_all']  != '') {
		  $sql .= "  AND  J.staff_id in (SELECT id FROM `staff` WHERE better_franchisee = ".$_SESSION['amt_report']['staff_type_all'].") ";
	  }
	  
	  /* else{
		 $sql .= " AND  J.staff_id in (SELECT id FROM `staff` WHERE better_franchisee = 2) ";
	  } */
	  
	  if($_SESSION['amt_report']['amt_report_from'] != Null && $_SESSION['amt_report']['amt_report_to']  != '') {
		 $sql.= " AND  QN.quote_to_job_date  >= '".$_SESSION['amt_report']['amt_report_from']."' and QN.quote_to_job_date  <= '".$_SESSION['amt_report']['amt_report_to']."'";
	  }else{
		 $sql .= " AND QN.quote_to_job_date >= '".$startdate."'";
	  }
	 
	  $countsql = $sql;
	 //$sql.= " order by QN.quote_to_job_date ,QN.id Desc Limit 0 ,60";
	   //$arg.=" order by id desc limit 0,$resultsPerPage";
	  $sql.= " order by QN.quote_to_job_date desc Limit 0 ,$resultsPerPage";
	 
	 //echo $sql;
	
 $query = mysql_query($sql);
  
   $countResult = mysql_num_rows(mysql_query($countsql));
?>

<div class="midle_staff_box"> <span class="midle_text" style="left: 150%;margin-top: -1px;">Total Records <?php echo $countResult; ?></span></div>
 <br>
 <br>
	<div id="quote_view">
			<table class="user-table" border="1px">
					<thead >
						<tr>
							<th>Job ID</th>
							<th>Quote Converted Date</th>
							<th style="    width: 30%;">Description</th>
							<th>Total Amt</th>
							<th>Amount Share <br/>(60%)</th>
							<th>Fixed Amt </th>
							<th>Diffrence</th>
							<th>Share Type</th>
						</tr>
					</thead>
					  
					<tbody>
					
					<?php 
               //echo mysql_num_rows($query);
			   
					if(mysql_num_rows($query) > 0) { 
					
					 $flag = 0;
					$nextdate = $startdate;
					$totalamt = 0;
					$totalshare = 0;
					$totalfixed = 0;
					$totaldiff = 0;
					  while($getdata =  mysql_fetch_assoc($query)) {
					
						  $amtShare = ($getdata['tamt'] * 60)/100;
						  
						  $amtdif = ($getdata['staffamt'] - $amtShare);
						  
						 /*  $totalamt +=$getdata['tamt'];
						  $totalshare +=$amtShare;
						  $totalfixed +=$getdata['staffamt'];
						  $totaldiff +=$amtdif; */
					?>
					
					  <tr class="parent_tr <?php  if($amtdif > 0) { echo ' alert_danger_tr '; } ?>" >
					   
						 <td><a href="javascript:scrollWindow('popup.php?task=jobs&job_id= <?php echo $getdata['jobid']; ?> ','1200','850')"> <?php echo $getdata['jobid']; ?> </a></td>
						 <td> <?php echo changeDateFormate($getdata['qjd'], 'datetime'); ?> </td>
						 <td> <?php echo $getdata['descri']; ?> </td>
						 <td> <?php echo $getdata['tamt']; ?> </td>
						 <td> <?php echo $amtShare; ?> </td>
						 <td> <?php echo $getdata['staffamt']; ?> </td>
						 <td> <?php echo $amtdif; ?> </td>
						 <td> <?php echo $getdata['amt_share']; ?> </td>
					  </tr>
					  <?php   }  ?>
					  
					    <!--<tr>
							 <td  colspan="3"><strong>Total</strong></td>
							 <td> <strong><?php echo $totalamt ?> </strong></td>
							 <td> <strong><?php echo $totalshare; ?> </strong></td>
							 <td> <strong><?php echo $totalfixed; ?> </strong></td>
							 <td> <strong><?php echo $totaldiff; ?> </strong></td>
							 <td> </td>
					    </tr>-->
					    
					  <?php  } ?>
					
					<?php if($countResult >= $resultsPerPage) { ?>
					<tr class="load_more">
					    <td colspan="30"><button class="loadmore" data-page="2" >Load More</button></td>
					</tr>
					<?php } ?>  
					
					
					</tbody>
					
			</table>		
    </div>
	
	<script>
	    $(document).on('click','.loadmore',function () {
				  $(this).text('Loading...');
						$.ajax({
					  url: 'xjax/ajax/loadmore_cleaning_amt_report.php',
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