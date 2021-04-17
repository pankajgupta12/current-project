<?php
    $reclean_id = 0;    
	$jobID = escapeString($_GET['id']);
	 $notes = staffNotes($jobID);  
	 
	 $jobdetails =  mysql_fetch_assoc(mysql_query("SELECT *  FROM `job_details` WHERE `job_id` = ".$jobID." AND `staff_id` = ".$_SESSION['staff']['staff_id']."  AND status !=2"));
	 
		if(!empty($jobdetails))
		{
			$startTime = ($jobdetails['start_time'] != "0000-00-00 00:00:00") ? date("dS M Y h:i:s A" ,strtotime($jobdetails['start_time'])) : "Not Started";		
			$finishTime = ($jobdetails['end_time'] != "0000-00-00 00:00:00") ? date("dS M Y h:i:s A" ,strtotime($jobdetails['end_time'])) : "Not Finished";			
		}
	
		$getAlljobTypedetails = getAlljobType($jobID);
		$getAllresult = $getAlljobTypedetails['result'];
		$str = '';
		foreach($getAllresult as $key=>$value) {  
			$getdesc = getDesc($value['quote_id'],$value['job_type_id']);
			 $jobTYpe = get_rs_value("job_type","short_name",$value['job_type_id']); 
				$str.= '<strong>'.$jobTYpe .':</strong>'.$getdesc['description'].'<br/>'; 
		}
		
	//$status = get_rs_value("jobs","status",$jobID);	
	
?>
<!DOCTYPE html>
<html>
<head>
  <title>Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <?php include('head.php'); ?>
</head>
<body ng-app="">
   <div class="slidebar" id="slidebar">
		 <?php include('side_panel.php'); ?>
    </div>

  <header>
      <div class="miniHeaderNew">
        <div class="jobsHeader">
         <a href="javascript:window.history.go(-1);"><span class="fsLg pull-left fa fa-angle-left" aria-hidden="true"></span></a>
          <strong>Job Details</strong>
          <span class="pnt pull-right fa fa-list-ul" aria-hidden="true" onclick="myDiv()"></span>
        </div>
      </div>
  </header>
    <section>
      <div class="detailFirst">
        <div class="detailSection">
          <div class="detailListing">
            <div class="pnt col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <strong>Job Details</strong> <span class="arrow fa fa-angle-down pull-right"></span>
             </div>
           </div>
         </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <ul class="details" ng-init="tittles=[name='Job Id']">
             <li>
				<span class="tittle pull-left">Job Id </span>
				<span class="value pull-right">#<?php echo $jobdetails['job_id']; ?></span> 
			</li>
            
			<li>
				<span class="tittle pull-left">Date </span>
				<span class="value pull-right"><?php echo date("dS M Y" ,strtotime($jobdetails['job_date'])); ?></span> 
			</li>
            
			<li>
				<span class="tittle pull-left">Start Time </span>
				<span class="value pull-right"><?php echo $jobdetails['job_time']; ?></span> 
			</li>
            
			<li>
				<span class="tittle pull-left">Amount </span>
				<span class="value pull-right">$ <?php echo $getAlljobTypedetails['totalAmount']; ?></span> 
			</li>  
            
			<li>
				<span class="tittle pull-left">Status </span>
				<span class="value pull-right">
				<?php  echo (checkCustemerPaid($jobdetails['job_id'])); ?>
				</span> 
			</li>
            
			<li><span class="tittle pull-left">Job Details </span>
			  <span class="value pull-right">
			     <?php echo $str; ?>
			  </span>
			</li>
             <li><span class="tittle pull-left">Job Start Time </span><span class="value pull-right"><?php  echo $startTime; ?></span> </li>
             <li><span class="tittle pull-left">Job Finish Time </span><span class="value pull-right"><?php echo $finishTime; ?></span> </li>
             <li>
              <span class="tittle pull-left">Upsell </span>
              <span  class="radioSection">
              <span class="radio">
                <input id="radio-1" name="radio" type="radio" checked>
                <label for="radio-1" class="radio-label">Agreed</label>
              </span>
              <span class="radio">
                <input id="radio-2" name="radio" type="radio">
                <label  for="radio-2" class="radio-label">Denied</label>
              </span> 
              </span> 
            </li>
           </ul>
         </div>
        </div>
      </div>
      <div class="detailSecond">
      <div class="detailSection">
        <div class="detailListing">
          <div class="pnt col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <strong>Client Details</strong> <span class="arrow fa fa-angle-down pull-right"></span>
           </div>
         </div>
       </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <ul class="details">
           <li><span class="tittle pull-left">Name </span><span class="value pull-right"><?php echo get_rs_value("quote_new","name",$jobdetails['quote_id']); ?></span> </li>
           <li><span class="tittle pull-left">Phone </span><span class="value pull-right"><a href="tel:<?php echo get_rs_value("quote_new","phone",$jobdetails['quote_id']); ?>"><?php echo get_rs_value("quote_new","phone",$jobdetails['quote_id']); ?></a></span> </li>
           <li><span class="tittle pull-left">Address </span><span class="value pull-right"><?php echo get_rs_value("quote_new","address",$jobdetails['quote_id']); ?></span> </li>  
         </ul>
       </div>
      </div>
    </div>
    <div class="detailFourth">
	<?php if(!empty($notes)) { ?>
        <div class="detailSection">
            <div class="detailListing">
			  <div class="pnt col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<strong>Notes</strong> <span class="arrow fa fa-angle-down pull-right"></span>
			   </div>
            </div>
        </div>
	<?php  } ?>
	   <?php //print_r($notes); ?>
		  <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
		   <? foreach($notes as $nt) { if($nt['heading'] != "") { ?>
			<div class="offsetnewbottom col-lg-12 col-md-12 col-sm-12 col-xs-12">
		       <strong class="tittle pull-left"><?php echo $nt['heading']; ?></strong>
			   <span class="value pull-right"></span>
			</div>
			
		    <div class="offsetbottomNew col-lg-12 col-md-12 col-sm-12 col-xs-12">
		     <strong class="tittle pull-left">By :  </strong><span><?php echo  $nt['staff_name']; ?></span>
			  <span class="value pull-right">
			 <strong></strong><? echo date('dS M Y h:i:s A', strtotime($nt['date']) ); ?> <br>			  
			  </span>
			</div>
			
		   <div class="topBorder col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
			 <p class="footerNote"><?php if($nt['comment'] == "") { echo $nt['heading']; }else{ echo $nt['comment']; } ?></p>
			
		   </div>
		 <? } } ?>   
		  </div>
		  
    </div>
    
    </section> 
	<div class="footerList wow slideInUp">
    <ul>   
	 <?php  ?>
	    <?php  if($jobdetails['job_acc_deny'] != 4) { ?>
	    <? if( $jobdetails['staff_work_status'] == '' && checkCustemerPaid($jobdetails['job_id']) == 'Paid'){ ?>
         <li><a onClick="Startjob('<?php echo $jobID; ?>');" ><span class="fa fa-play-circle-o"></span>Start</a></li>	
	    <? } elseif($jobdetails['staff_work_status'] == 1) {  ?>     
	     <li><a onClick="Finishjob('<?php echo $jobID; ?>');" ><span class="fa fa-play-circle-o"></span>Finish</a></li>	
	    <?php  } } ?>
      <li><a href="index.php?task=upload-images&rid=<? echo $reclean_id; ?>&jobid=<?php echo $jobID; ?>"><span class="fa fa-picture-o"></span>Images</a></li>
      <li><a href="index.php?task=chat&rid=<? echo $reclean_id; ?>&jobid=<?php echo $jobID; ?>"><span class="fa fa-comment-o"></span>Chat</a></li>
      <li><a href="index.php?task=checklist&rid=<? echo $reclean_id; ?>&jobid=<?php echo $jobID; ?>"><span class="fa fa-indent"></span>Checklist</a></li>
    </ul>
  </div>
  
 <?php include('footer.php'); ?>
</body>
</html>
