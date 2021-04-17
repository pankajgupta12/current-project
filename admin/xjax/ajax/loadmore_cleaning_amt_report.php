<?php 
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");
 
if(isset($_POST['page'])) {
	$pageid = $_POST['page'];

    if(!isset($_SESSION['amt_report']['amt_report_from'])){ $_SESSION['amt_report']['amt_report_from'] = date("2019-02-18"); }
	if(!isset($_SESSION['amt_report']['amt_report_to'])){ $_SESSION['amt_report']['amt_report_to'] = date("Y-m-t"); }
    $startdate = '2019-02-18';
   $resultsPerPage = resultsPerPage;
   
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
	
      $sql.= " order by QN.quote_to_job_date desc ";
 if($pageid>0){
     //   echo 'test'; die;
          // $page_limit=$resultsPerPage*($pageid-1);
           $page_limit=$resultsPerPage*($pageid - 1);
           $sql.=" LIMIT  $page_limit , $resultsPerPage";
           }else{
        //  echo 'test11'; die;
        $sql.=" LIMIT 0 , $resultsPerPage";
     }
     
//echo $arg;
   $query = mysql_query($sql);
   
   //$countresult = mysql_num_rows($sql);
?>
		  
		
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
			 
				    <tr class="parent_tr <?php  if($amtdif > 0) { echo ' alert_danger_tr '; } ?>">
				 	   
						 <td><a href="javascript:scrollWindow('popup.php?task=jobs&job_id= <?php echo $getdata['jobid']; ?> ','1200','850')"> <?php echo $getdata['jobid']; ?> </a></td>
						 <td> <?php echo changeDateFormate($getdata['qjd'], 'datetime'); ?> </td>
						 <td> <?php echo $getdata['descri']; ?> </td>
						 <td> <?php echo $getdata['tamt']; ?> </td>
						 <td> <?php echo $amtShare; ?> </td>
						 <td> <?php echo $getdata['staffamt']; ?> </td>
						 <td> <?php echo $amtdif; ?> </td>
						 <td> <?php echo $getdata['amt_share']; ?> </td>
					</tr>
			<?php $i++; }  ?>
			
			   <?php //if($$counttotal >= $resultsPerPage) { ?>
				<tr class="load_more">
				   <td colspan="30"><button class="loadmore" data-page="<?php echo  ($pageid+1); ?>" >Load More</button></td>
				</tr>
			    <?php// } ?>  
			  
<?php } } ?>
	
	