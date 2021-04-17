<?php 
	$staff_notification= ("select * from site_notifications where notifications_status = '0'  AND notifications_type IN (5) "); 
	//$_SESSION['order_by'] = 'desc';
	if(isset($_SESSION['order_by'])) { 
	$staff_notification .= ' ORDER BY id '.$_SESSION['order_by']; 
	} else { 
	$staff_notification .= ' ORDER BY id desc';
	$_SESSION['order_by'] = 'desc';
	}
	//echo $notification; 
	$staff_notificationText = mysql_query($staff_notification);

	$staffcountnotef = mysql_num_rows($staff_notificationText);
 
?>
    <ul class="qulist1">
                 <?php if(mysql_num_rows($staff_notificationText)>0) { 

            while($data_n = mysql_fetch_array($staff_notificationText)) {
				 ?>
						<li class="quote_notification latest" id="quote_notification_1" onclick="job_details_show1('5366|2869','quote_notification_1');" style="cursor: pointer;"><span class="bd_list_border"><span class="red"><a style="color:#FFF;" href="tel:<? echo get_rs_value("staff","mobile",$data_n['staff_id']); ?>"><? echo get_rs_value("staff","name",$data_n['staff_id']); ?></a></span><p><?php  echo changeDateFormate($data_n['date'],'datetime'); ?></p><br> <b><?php echo ucfirst($data_n['heading']); ?></b></span>
						</li>
				 <?php  } }else {	?>	
					<li class="quote_notification"  id="quote_notification"   style="cursor: pointer;"><span class="bd_list_border<?php // echo $j; ?>"><span class="red"></span><p></p><br> <b>No record found</li>	
					<?php  } ?> 
	</ul>