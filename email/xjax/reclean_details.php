<?php //print_r($_SESSION['reclean_email']);

   //echo "SELECT * FROM `quote_new` WHERE booking_id = ".$_SESSION['reclean_email']['job_id']."";
   
   //echo mysql_query("SELECT * FROM `quote_new` WHERE booking_id = ".$_SESSION['reclean_email']['job_id']."");

   $getJobDetails =  mysql_fetch_assoc(mysql_query("SELECT * FROM `quote_new` WHERE booking_id = ".$_SESSION['reclean_email']['job_id'].""));
  
   
 ?>

<h4 style="color: rgb(51, 51, 51);">
    <span style="font-weight: bold;">Re-Clean Advice</span>
	    </h4>
		
		<?php  if(!empty($getJobDetails)) {
  
               $getAgentDetails = mysql_fetch_assoc(mysql_query("SELECT real_estate_agency_name , agent_name ,agent_landline_num , agent_address ,  agent_number , agent_email  FROM `job_details` WHERE job_id = ".$getJobDetails['booking_id']." AND status != 2 limit 0, 1"));
				

		?>
		
			 <div><span style="font-weight: 700;">Job number:</span>  <?php echo $getJobDetails['booking_id']; ?></div>
			 <div><span style="font-weight: 700;">Job Client name:</span> <?php echo $getJobDetails['name']; ?></div>
			 <div><span style="font-weight: 700;">Client Number: </span> <?php echo $getJobDetails['phone']; ?></div>
			 <div><span style="font-weight: 700;">Client Address: </span> <?php echo $getJobDetails['address']; ?></div>
			 <br/>
			 <div><span style="font-weight: 700;">Agents Details:</span> </div>
			    <?php  if($getAgentDetails['agent_name'] != '' && $getAgentDetails['agent_email'] != '') { ?>
					<br/>
					<div><span style="font-weight: 700;">Agency Name:</span> <?php echo $getAgentDetails['real_estate_agency_name']; ?></div>
					<div><span style="font-weight: 700;">Agent Name:</span> <?php echo $getAgentDetails['agent_name']; ?></div>
					<div><span style="font-weight: 700;">Agent Number: </span> <?php echo $getAgentDetails['agent_number']; ?></div>
					<div><span style="font-weight: 700;">Agent Email: </span> <?php echo $getAgentDetails['agent_email']; ?></div>
					<div><span style="font-weight: 700;">Agent Landline Num: </span> <?php echo $getAgentDetails['agent_landline_num']; ?></div>
					<div><span style="font-weight: 700;">Agent Address: </span> <?php echo $getAgentDetails['agent_address']; ?></div>
					
		<?php  } else {  echo 'Contact client for Reclean';  } } else{?>
		    <div><span style="font-weight: 700;">&nbsp; &nbsp; &nbsp; &nbsp;Job Client name:&nbsp;</span></div>
			<div><span style="font-weight: 700;">&nbsp; &nbsp; &nbsp; &nbsp;Client Number:&nbsp;&nbsp;</span></div>
			<div><span style="font-weight: 700;">&nbsp; &nbsp; &nbsp; &nbsp;Client Address:&nbsp;</span></div>
			<div><span style="font-weight: 700;">&nbsp; &nbsp; &nbsp; &nbsp;Agents Details:&nbsp;&nbsp;</span></div>
		<?php  } ?>
		
		 <div><span style="font-weight: 700;"><br></span></div>
		 
		 <h4 style="color: rgb(51, 51, 51);">
		     <span style="font-weight: 700;">Steps you need to take</span>
		 </h4>
		 <div><span style="font-weight: 700;">1. Review email below</span><br></div>
		 <div><span style="font-weight: 700;">2. Inform office of any issues</span><br></div>
		 <div><div><span style="font-weight: 700;">3. Contact client/agent to arrange re-clean (if applicable)</span></div><div><span style="font-weight: 700;">4. Inform office of arrangements (if applicable)&nbsp;</span></div></div>
		 <div><br></div>
		 Please advise the office of the outcome so you can be paid.<br><br>
		
		