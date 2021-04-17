<?php  
	
    $arg = '';
    $arg .= "SELECT * FROM `quote_new` where deleted != 1 AND step != 10 ";
	
	$flag = false;
	
	if(strpos($_SESSION['search_popup']['key'], 'x') !==false || strpos($_SESSION['search_popup']['key'], 'X')!==false){
		$idArray = array();
		$cc_num = preg_replace("/[^0-9]/", '', str_replace(' ', '', $_SESSION['search_popup']['key']));
		$qryPaymentGateway = mysql_query("SELECT job_id FROM payment_gateway WHERE cc_num LIKE '%".trim($cc_num)."' AND (job_id != 0 OR job_id != NULL) GROUP BY job_id ORDER BY job_id DESC");

		while($getJob = mysql_fetch_assoc($qryPaymentGateway)){
			array_push($idArray, $getJob['job_id']);
		}
		$arg .= " AND booking_id IN (".implode(',',$idArray).")";
		
	}else if (is_numeric($_SESSION['search_popup']['key']) && (strlen($_SESSION['search_popup']['key']) <= 6)) {
		$arg .= " AND (id like '%".$_SESSION['search_popup']['key']."%' or  booking_id  like '%".$_SESSION['search_popup']['key']."%')";
	}else if(is_numeric($_SESSION['search_popup']['key']) && (strlen($_SESSION['search_popup']['key']) > 6)) {
	//$searchKey  = $_SESSION['search_popup']['key'];
		$arg .= " AND  phone like '%".$_SESSION['search_popup']['key']."%'";
	}else { 
	    $flag = true;
		$arg .= " AND (email like '%".$_SESSION['search_popup']['key']."%' or name like '%".$_SESSION['search_popup']['key']."%' or suburb like '%".$_SESSION['search_popup']['key']."%' or address like '%".$_SESSION['search_popup']['key']."%')";
	}
	$arg .= " Order by id desc Limit 0, 25";
  //echo $arg;
	 
	$sqlQuery = mysql_query($arg);
	$countersearch = mysql_num_rows($sqlQuery);
//echo $arg;
//echo $countersearch;

?>
<div class="messageBox modal-content bd_noti_pop bd_noti_pop_new">   
<div class="tab1">
	        <div class="messageArea">
				<span>Keyword Search : <span class="search_name_text"><?php echo $_SESSION['search_popup']['key']; ?></span></span>
				<?php if(strpos($_SESSION['search_popup']['key'], 'x') !==false){?>
					<span>Display records : <span class="search_name_text">BY CreditCard</span></span>
				<?php } ?>
			</div>

	<?php  /* if($flag ==  true) { 
	   
	  $staff_sql =  mysql_query("SELECT * from staff where 1 = 1 and status = 1   AND name like '%".$_SESSION['search_popup']['key']."%'");
	  
	  if(mysql_num_rows($staff_sql) >0 ) {
		  
		  
	
	?>		
			<div class="bd_noti_quote bd_noti_quote_new">
                 <div class="tabs-wrapper">
				  <?php  while($staffDetails = mysql_fetch_assoc($staff_sql)) { ?>
			           <ul class="qulist1">
							<li class="quote_notification" id="job_notification_1" style="cursor: pointer;">
								<a href="../admin/index.php?task=edit_quote&amp;quote_id=23091">
								<ul class="first_info">
									   <li>S# <?php echo $staffDetails['id']; ?> </li>
									   <li>-- </li>
									</ul>
									<ul class="second_info">
									   <li><?php echo $staffDetails['name']; ?> </li>
									   <li><?php echo $staffDetails['mobile']; ?> </li>
									   <!--<li></li>-->
									</ul>
									
								</a>
							</li>	
					
						</ul>
				  <?php  } ?>		
			
	            </div>
	        </div>
		<hr>	
	  <?php }  }  */?>
			
   <div class="bd_noti_quote bd_noti_quote_new">
     <div class="tabs-wrapper">
			<ul class="qulist1">
					<?php 
					if($countersearch >  0) {
					while($getDetails = mysql_fetch_assoc($sqlQuery)) { 
					
					
					$bbcstaffid = $getDetails['bbcapp_staff_id'];
					
					?>
					
							<li class="quote_notification" id="job_notification_1"  style="cursor: pointer;  background: <?php if($bbcstaffid > 0) { echo '#c1efea;'; }  ?>">
							<?php  if($getDetails['booking_id'] == 0) { ?>
								<a href="../admin/index.php?task=edit_quote&quote_id=<?php echo $getDetails['id']; ?>">
							<?php  }else { ?>
							   <a href="javascript:scrollWindow('../admin/popup.php?task=jobs&job_id=<?php echo $getDetails['booking_id']; ?>','1200','850')">
							<?php  } ?>
									<ul class="first_info">
									   <li>Q# <?php echo $getDetails['id']; ?> </li>
									   <li><?php if($getDetails['booking_id'] != 0) { echo 'J# '.$getDetails['booking_id'];  }else { echo '--'; } ?> </li>
									</ul>
									<ul class="second_info">
									   <li><?php echo $getDetails['name']; ?> </li>
									   <li><?php echo $getDetails['phone']; ?> </li>
									   <!--<li><?php // echo $getDetails['suburb'].' '.$getDetails['postcode']; ?></li>-->
									</ul>
									<ul class="third_info">
										<li><?php echo $getDetails['suburb'].' '.$getDetails['postcode']; ?></li>
										 <li><?php echo changeDateFormate($getDetails['booking_date'],'datetime'); ?> </li>
									</ul>
									<ul class="third_info">
										<li style="white-space:  nowrap;font-size: 14px;"><?php echo $getDetails['address']; ?></li>
									</ul>
									
								</a>
							</li>	
					
					<?php  } }else { ?>
					 <li class="no_record_found">No Record found..</li>
					<?php  } ?>
			</ul>
			
	    </div>
	</div>
	
	

	
</div>
</div>