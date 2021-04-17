<?php
if(!isset($_SESSION['review_report']['from_date'])){ $_SESSION['review_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['review_report']['to_date'])){ $_SESSION['review_report']['to_date'] = date("Y-m-t"); }

//$query = "SELECT review_email_time,id FROM jobs WHERE review_email_time != '0000-00-00 00:00:00'";
$query = "SELECT distinct(date(review_email_time)) as review_email_time  FROM jobs WHERE review_email_time != '0000-00-00 00:00:00'";

if($_SESSION['review_report']['to_date'] != '' && $_SESSION['review_report']['to_date'] != ''){
  $query .=" AND review_email_time >= '".date('Y-m-d' , strtotime($_SESSION['review_report']['from_date']))."' AND review_email_time <= '".$_SESSION['review_report']['to_date']."'";
}

//$query .= " ORDER BY jobs.review_email_time ASC";

//echo $query;

$qry_job_list = mysql_query($query);

?>

    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
		<tr class="table_cells">
		  <td><strong>Review Date</strong></td>
		  <td>
			<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
				<tr class="table_cells" >
					<td><strong>Job Id</strong></td>
				</tr>
			</table>
		  </td>
		</tr>  
		<?php 
		if(mysql_num_rows($qry_job_list) > 0) { 
	
			while($review_job_list = mysql_fetch_array($qry_job_list)) { 
			
		?>
		<tr class="table_cells" >
		   <td style="width: 25%;"><?php echo changeDateFormate($review_job_list['review_email_time'] , 'datetime');?></td>
		   <td>
			   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
					<?php 
					$qry_job_list2 = mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT(id) as jobid FROM jobs WHERE review_email_time LIKE '%".$review_job_list['review_email_time']."%'"));
					$getjob = explode(',' ,$qry_job_list2['jobid']);
					?>
					<tr class="table_cells" >
						<td><?php 
						$i =1;
                        $strjob = '';
						foreach($getjob as $key=>$value) {
							 if($i %25 == 0) {
								 $strjob.= "<br/>";
							 }
							$review_email_time1 =  get_rs_value("jobs","review_email_time",$value);
							
							 $strjob .= '<a title="'.changeDateFormate($review_email_time1, 'timestamp').'" href="javascript:scrollWindow(\'popup.php?task=payment&amp;job_id='.$value.'\',\'1200\',\'850\');">'.$value.'</a> , ';
							 $i++;
						 }
						echo rtrim($strjob , ' ,');?></td>
					</tr>
					
			   </table>
		   </td>
		</tr>
		<?php }  } else { ?>
		<tr>
			<td colspan="2" align="center">Record not available</td>
		</tr>
		<?php } ?>
		<style>
			  .inside_table{
				  width: 80%;
				  margin: 0px auto;
			  }
	    </style>	
    </table>		 