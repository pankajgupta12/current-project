<?php 
	$notification= ("select * from site_notifications where notifications_status = '0'  AND notifications_type IN (0,2,3,4) "); 
	//$_SESSION['order_by'] = 'desc';
	if(isset($_SESSION['order_by'])) { 
	$notification .= ' ORDER BY id '.$_SESSION['order_by']; 
	} else { 
	$notification .= ' ORDER BY id desc';
	$_SESSION['order_by'] = 'desc';
	}
	//echo $notification; 
	$notificationText = mysql_query($notification);

	$countnotef = mysql_num_rows($notificationText);
 
?>
 
<div class="modal-content bd_noti_pop"> 
<div class="container-refresh "><a class="reload" href="#" onClick="send_data('2','74','site_notification');"> <img class="image" src="images/refresh.png"/> </a></div>
 <p class="noti_head"><span id="order_by" style="margin-left: -89px;padding: 12px;"><img src="images/asc.png" onClick="send_data('desc','78','site_notification');" style="height: 21px;cursor: pointer;<?php if($_SESSION['order_by'] == 'desc') {  ?>  background: #fff;<?php } ?>">
 <img src="images/up.png" onClick="send_data('asc','78','site_notification');" style="height: 21px;cursor: pointer;<?php if($_SESSION['order_by'] == 'asc') {  ?>  background: #fff;<?php } ?>"></span>Notification<span class="new-notification" id="notification_count"> <?php echo $countnotef; ?></span></p>

		<!--<div class="allJobsTabs">
		  <ul class="navNewBar nav nav-tabs">
            <li class="one active" id="tab1" onClick="getvalue(1);"><a href="javascript:void(0);"> All</a></li>
            <li class="two" id="tab2" onClick="getvalue(2);"><a href="javascript:void(0);"> Staff</a></li>
          </ul>
        </div>-->
<!--<div class="tab2 animated fadeInDown" style="display: none; padding:15px;">
     <?php // include('staff_notification.php'); ?>
</div>-->

   
<div class="tab1">
   <div class="bd_noti_quote">
     <div class="tabs-wrapper">
		<input type="radio" name="tab" id="tab1" class="tab-head" checked="checked"/>
		<!--<label for="tab1">Quote</label>
		<input type="radio" name="tab" id="tab2" class="tab-head" />
		<label for="tab2">Job</label>-->
		
		<div class="tab-body-wrapper">
			<div id="tab-body-1" class="tab-body">
				
				<p> <div class="bd_quote_list scrollbar" id="style-5">
            <ul class="qulist1">
			    <?php  if(mysql_num_rows($notificationText)>0) { 
							   $j = 0;
							   $i = 1;
							   while($notificationDataQuote = mysql_fetch_array($notificationText)) {
								   
							//	print_r($notificationDataQuote);
								   
								if($j%7 == 0){ $j = 1;  }			
			   	if( $notificationDataQuote['notifications_type'] == 1 )	{
					
					 $contact_type = get_rs_value("quote_new","contact_type",$notificationDataQuote['quote_id']);	
					 $mode_of_contact = get_rs_value("quote_new","mode_of_contact",$notificationDataQuote['quote_id']);	
					$str = ($notificationDataQuote['heading']);
					
					if($contact_type != '' || $mode_of_contact != '') {
						$str .= ", <br /> [<strong>Contact</strong> - ";
						
						if($contact_type != '') {
						   $str .= getContactType($contact_type);
						}

						if($mode_of_contact != '') {
						   $str .= ', '.getmodeOFContact($mode_of_contact);
						}
					$str .= "]"; 
					} 
					
					
					
					
					?>
						<li class="quote_notification"  id="quote_notification_<?php echo $i; ?>" onclick="quote_details_show('<?php echo $notificationDataQuote['id'].'|'.$notificationDataQuote['quote_id']; ?>','quote_notification_<?php echo $i; ?>');" style="cursor: pointer;"><span class="bd_list_border<?php // echo $j; ?>"><span class="red">Quote#<?php echo $notificationDataQuote['quote_id']; ?></span><p><?php  echo changeDateFormate($notificationDataQuote['date'],'datetime'); ?></p><br> <b><?php echo ucfirst($str); ?></b></li>
					 <?php
						} else if( $notificationDataQuote['notifications_type'] == 2 )	{
						     $quotename = get_sql("quote_new","name","where booking_id=".$notificationDataQuote['job_id']);
						      $suburb = get_sql("quote_new","suburb","where booking_id=".$notificationDataQuote['job_id']);
						       $customer_paid_amount = get_sql("jobs","customer_paid_amount","where id=".$notificationDataQuote['job_id']);
						      
					?>
							<li class="quote_notification"  id="job_notification_<?php echo $i; ?>" onclick="job_details_show('<?php echo $notificationDataQuote['id'].'|'.$notificationDataQuote['job_id'];  ?>','job_notification_<?php echo $i; ?>');" style="cursor: pointer;">
								<div class="bd_listing2"><span class="notificationHeadingNew">Job#<?php echo $notificationDataQuote['job_id']; ?></span><span class="bd_id_name"><?php  echo changeDateFormate($notificationDataQuote['date'],'datetime'); ?></div> 
								<div class="bd_list3"><p class="notificationHeading"><?php echo ucfirst($notificationDataQuote['heading']); ?></p></div>
							</li>	
					<?php	}elseif( $notificationDataQuote['notifications_type'] == 3 )	{	?>
					
						<li class="quote_notification"  id="quote_notification_<?php echo $i; ?>"  onclick="job_details_show('<?php echo $notificationDataQuote['id'].'|'.$notificationDataQuote['job_id'];  ?>','quote_notification_<?php echo $i; ?>');"  style="cursor: pointer;"><span class="bd_list_border<?php // echo $j; ?>"><span class="red">Staff#<?php echo $notificationDataQuote['staff_id']; ?></span><p><?php  echo changeDateFormate($notificationDataQuote['date'],'datetime'); ?></p><br> <b><?php echo ucfirst($notificationDataQuote['heading']); ?></b></li>
						
					<?php }	else if( $notificationDataQuote['notifications_type'] == 4 )	{  ?>
					<li class="quote_notification"  id="quote_notification_<?php echo $i; ?>"  onclick="memberdetails('<?php echo $notificationDataQuote['id']; ?>','quote_notification_<?php echo $i; ?>');" style="cursor: pointer;"><span class="bd_list_border<?php // echo $j; ?>"><span class="red">Member email#</span><p><?php  echo changeDateFormate($notificationDataQuote['date'],'datetime'); ?></p><br> <b><?php echo ucfirst($notificationDataQuote['heading']); ?></li>	
				<?php }	$i++; 	} 	}else {	?>	
					<li class="quote_notification"  id="quote_notification"   style="cursor: pointer;"><span class="bd_list_border<?php // echo $j; ?>"><span class="red"></span><p></p><br> <b>No record found</li>	
					<?php  } ?>
            </ul>
              </div></p>
			</div>
		 </div>
	    </div>
	</div>
</div>
</div>

