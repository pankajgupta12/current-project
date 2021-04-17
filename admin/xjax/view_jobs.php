<?php

$data = mysql_query("select * from quote where booking_id!=0 and booking_id in (select id from jobs where status=1) order by id desc limit 0,50");
if (mysql_num_rows($data)>0){ 
?>
<link href="../admin/css/general.css" rel="stylesheet" type="text/css">

<table width="100%" border="0" align="center" cellpadding="6" cellspacing="3" class="table_bg">
  <tr class="table_cells">
    <td colspan="12" class="text11_red">View Jobs</td>
  </tr>
  <tr class="header_td">
    <td width="5%">Id</td>
    <td width="5%">Site</td>
    <td width="5%">Job Date</td>
    <td width="10%">Name</td>
    <td width="10%">Email</td>
    <td width="10%">Phone</td>
    <td width="10%">Property Details</td>
    <td width="15%">Job Details</td>
    <td width="5%">Amount</td>
  </tr>
  <?php 
  while($r=mysql_fetch_assoc($data)){ 
  ?>
  <tr class="table_cells" onclick="index.php?task=quote_details&id=<?php $r['id']?>">
    <td><? echo $r['id'];?></td>
    <td><? echo get_rs_value("sites","name",$r['site_id']);?></td>
    <td><? echo $r['booking_date'];?></td>
    <td><? echo $r['name'];?></td>
    <td><a href="mailto:<? echo $r['email'];?>"><? echo $r['email'];?></a></td>
    <td><a href="tel:<? echo $r['phone'];?>"><? echo $r['phone'];?></a></td>
    <td><? echo $r['bed'];?> Bed, <? echo $r['bath'];?> Bath<br>
		<?php echo $r['address'];?> 
</td>
    <td><?
		$job_details = mysql_query("select * from job_details where job_id=".$r['booking_id']." and status!=2");
        while($jdetails = mysql_fetch_assoc($job_details)){ 
			$staff_name = get_rs_value("staff","name",$jdetails['staff_id']);
			echo $jdetails['job_type']." - ".$staff_name."<br>";
		}
	?></td>
    <td>$<? echo $r['amount'];?></td>
  </tr>
  <? } ?>

</table>
<? }else{  
	echo "No Quotes Found";
} 
?>