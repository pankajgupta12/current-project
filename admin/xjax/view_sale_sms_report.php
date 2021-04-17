<?php
if(!isset($_SESSION['sale_sms_report']['from_date'])){ $_SESSION['sale_sms_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['sale_sms_report']['to_date'])){ $_SESSION['sale_sms_report']['to_date'] = date("Y-m-t"); }

$query = "SELECT *  FROM sale_sms_auto WHERE status='Success' AND createdOn != '0000-00-00 00:00:00'";

if($_SESSION['sale_sms_report']['to_date'] != '' && $_SESSION['sale_sms_report']['to_date'] != ''){
  
  $query .=" AND createdOn >= '".date('Y-m-d' , strtotime($_SESSION['sale_sms_report']['from_date']))."' AND createdOn <= '".$_SESSION['sale_sms_report']['to_date']."'";
}

if(isset($_SESSION['sale_sms_report']['call_id']) && $_SESSION['sale_sms_report']['call_id']!='0'){ 

	$query .=" AND sms_type='".$_SESSION['sale_sms_report']['call_id']."'";
} 

//$query .= " ORDER BY jobs.review_email_time ASC";

//echo $query;

$qry_sms_list = mysql_query($query);

?>

    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
		<tr class="table_cells">
		  <td><strong>Quote ID</strong></td>
		  <td><strong>SMS Type</strong></td>
		  <td><strong>From Number</strong></td>
		  <td><strong>To Number</strong></td>
		  <td><strong>Message</strong></td>
		  <td><strong>Create Date</strong></td>
		  <td><strong>In Out</strong></td>
		  
		</tr>  
		<?php 
		if(mysql_num_rows($qry_sms_list) > 0) { 
	
			while($sale_sms_list = mysql_fetch_array($qry_sms_list)) { 
			
		?>
		<tr class="table_cells" >
		   <td><?php echo $sale_sms_list['quote_id']?></td>
		   <td>
		   <?php 
		   echo $sms_type = ($sale_sms_list['sms_type'] == 1 ? '1st Call' : ($sale_sms_list['sms_type'] == 2 ? '2nd Call' : '3rd Call'));
		   ?>
		   </td>
		   <td><?php echo $sale_sms_list['from_num']?></td>
		   <td><?php echo $sale_sms_list['to_num']?></td>
		   <td><a href="javascript:showmsgdiv('ediv_<?php echo $sale_sms_list['quote_id'];?>');">View</a><?php //echo $sale_sms_list['message']?></td>
		   <td style="width: 25%;"><?php echo changeDateFormate($sale_sms_list['createdOn'] , 'timestamp');?></td>
		   <td>
		   <?php 
		   echo $in_out = ($sale_sms_list['in_out'] == 1 ? 'Sent' : ($sale_sms_list['in_out'] == 2 ? 'Recieved' : ''));
		   ?>
		   </td>
		</tr>
		<tr>
			<td colspan ="10" style="padding: 15px;background: #d693932e;display:none;" id="ediv_<?php echo $sale_sms_list['quote_id'];?>" >
				
						<?php echo $sale_sms_list['message']?>
				
			</td>
		</tr>
		<?php }  } else { ?>
		<tr>
			<td colspan="7" align="center">Record not available</td>
		</tr>
		<?php } ?>
		<style>
			  .inside_table{
				  width: 80%;
				  margin: 0px auto;
			  }
	    </style>	
    </table>		 