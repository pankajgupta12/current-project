<?php  
//print_r($_SESSION['bbc_weekly_report']); 

if(!isset($_SESSION['bbc_weekly_report']['from_date'])){ $_SESSION['bbc_weekly_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['bbc_weekly_report']['to_date'])){ $_SESSION['bbc_weekly_report']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['bbc_weekly_report']['better_franchisee'])){ $_SESSION['bbc_weekly_report']['better_franchisee'] = 0; }

$fromdate = $_SESSION['bbc_weekly_report']['from_date'];
$todate = $_SESSION['bbc_weekly_report']['to_date'];
$better_franchisee = $_SESSION['bbc_weekly_report']['better_franchisee'];




?>

	 <span class="staff_text" style="margin-bottom:25px;margin-left: 20px;"> Weekly Job Report </span><br/>
	
	
	<?php 
   	$getstaffall = getStaff($better_franchisee); 
	 foreach($getstaffall as $staff) {
	     $getbbcData =  getBBCWeeklyReport($fromdate ,$todate , $staff['id']);          
		 $getdata =   BBCOfferedJobAmount($staff['id'] , $fromdate, $todate , 5,$staff['better_franchisee']);         
		 $deneygetdata =   BBCOfferedJobAmount($staff['id'] , $fromdate, $todate , 2,$staff['better_franchisee']);
		 $getDenyDataByPostcode = BBCJobsByPostCode($staff['id'] , $fromdate, $todate , 2, $staff['primary_post_code'], $staff['better_franchisee']);
		 $getAcceptedDataByPostcode = BBCJobsByPostCode($staff['id'] , $fromdate, $todate , 1, $staff['primary_post_code'], $staff['better_franchisee']);
		 // return array('totaldeniedInpostcode'=>$totaldeniedInpostcode , 'totaldenedamout'=>array_sum($postcodejob) , 'staffdeniedamotamout'=>array_sum($staffamotamout));	
		 
	?>
	
	
	<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
	 <tr><td colspan="12"><h2><?php echo $staff['name']; ?>&nbsp;(<a href="tel:<?php echo $staff['mobile']; ?>"><?php echo $staff['mobile']; ?></a>)</h2></td></tr>
</table >
<table align="center" width="80%"  border="0" cellpadding="5" cellspacing="5" style="    text-align: center;" class="user-payment-table">
	<tbody>
<tr>
<td colspan="3"><strong>Number of Days</strong></td>
<td colspan="3"><strong>Jobs Offered</strong></td>
<td colspan="3"><strong>Jobs Denied</strong></td>
<td colspan="3"><strong>Jobs accepted in Postcodes </strong></td>
<td colspan="3"><strong>Jobs denied in Postcodes </strong></td>

</tr>
  <tr>
	<td>Available</td>
    <td>Unavailable</td>
    <td>Suspend</td>
    <td>Total jobs</td>
    <td>Total Amount</td>
    <td>Total Share</td>
     <td>Total jobs</td>
    <td>Total Amount</td>
    <td>Total Share</td>
     <td>Total jobs</td>
    <td>Total Amount</td>
    <td>Total Share</td>
     <td>Total jobs</td>
    <td>Total Amount</td>
    <td>Total Share</td>
</tr>
  <tr>
   <td><?php if(count($getbbcData[1])>0): echo count($getbbcData[1]); else: echo '--'; endif; ?></td>
	<td><?php if(count($getbbcData[0])>0): echo count($getbbcData[0]); else: echo '--'; endif; ?></td>
	<td>[suspend=yes days]</td>
    <td><?php if(count($getdata['jobid'])>0): echo count($getdata['jobid']); else: echo '--'; endif; ?></td>
	<td><?php if(!empty($getdata['totalamout']) && $getdata['totalamout'] >0): echo '$'.$getdata['totalamout']; else: echo '--'; endif; ?></td>
	<td><?php if(!empty($getdata['staffamotamout']) && ($getdata['staffamotamout'] >0)): echo '$'.$getdata['staffamotamout']; else: echo '--'; endif; ?></td>
    <td><?php if(count($deneygetdata['jobid'])>0): echo count($deneygetdata['jobid']); else: echo '--'; endif; ?></td>	
	<td><?php if(!empty($deneygetdata['totalamout']) && ($deneygetdata['totalamout'] >0)): echo '$'.$deneygetdata['totalamout']; else: echo '--'; endif; ?></td>	
	<td><?php if(!empty($deneygetdata['staffamotamout']) && ($deneygetdata['staffamotamout'] >0)): echo '$'.$deneygetdata['staffamotamout']; else: echo '--'; endif; ?></td>
	 <td><?php if(!empty($getAcceptedDataByPostcode['total_job']) && ($getAcceptedDataByPostcode['total_job'] >0)): echo $getAcceptedDataByPostcode['total_job']; else: echo '--'; endif; ?></td>
	<td><?php if(!empty($getAcceptedDataByPostcode['totalamout']) && ($getAcceptedDataByPostcode['totalamout'] >0)): echo '$'.$getAcceptedDataByPostcode['totalamout']; else: echo '--'; endif; ?></td>
	<td><?php if(!empty($getAcceptedDataByPostcode['staffamout']) && ($getAcceptedDataByPostcode['staffamout'] >0)): echo '$'.$getAcceptedDataByPostcode['staffamout']; else: echo '--'; endif; ?></td>
	<td><?php if(!empty($getDenyDataByPostcode['total_job']) && ($getDenyDataByPostcode['total_job'] >0)): echo $getDenyDataByPostcode['total_job']; else: echo '--'; endif; ?></td>
	<td><?php if(!empty($getDenyDataByPostcode['totalamout']) && ($getDenyDataByPostcode['totalamout'] >0)): echo '$'.$getDenyDataByPostcode['totalamout']; else: echo '--'; endif; ?></td>
	<td><?php if(!empty($getDenyDataByPostcode['staffamout']) && ($getDenyDataByPostcode['staffamout'] >0)): echo '$'.$getDenyDataByPostcode['staffamout']; else: echo '--'; endif; ?></td>
</tr>
</tbody>
</table>
<br/>
<br/>
<?php  } ?>

