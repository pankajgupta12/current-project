
 
	<div class="content cnt_box long_div" id="re_page">
	   
	<div class="row">
    <div class="mrg_btm20 ">
        <?php  
	     foreach($stagesdata as $stageskey=>$getsalesheding) 
		{
	     ?>
        <div class="col-md-2 mrg_btm20 ">
	   
			<?php
			 $getdata =  getAfterJobs_data($stageskey, $adminid);		
			 $count = count($getdata[$stageskey]); 
			?>
	   
		<h2><?php echo $getsalesheding;  if($count > 0) { ?> (<?php echo $count; ?>) <?php  } ?> </h2>
		<div class="scroll_c ui-droppable" id="container<?php echo $stageskey;?>">
		 
		<?php 
		if($count > 0) { 
		
			$i = 1;
		
			foreach($getdata[$stageskey] as $key=>$data){
	   
				$arg = "select id , name ,response ,  booking_id , step , amount , denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND booking_id = ".$data['id']."";
		   
				$getquesql = mysql_query($arg);
			 
			    if(mysql_num_rows($getquesql) > 0) {
				
		        while($getq = mysql_fetch_assoc($getquesql)) {

						$sql_icone = ("select job_type_id , start_time , end_time ,  staff_id ,  job_type from job_details where  status != 2 AND quote_id=".$getq['id']);  
						$quote_details = mysql_query($sql_icone);	
					$trackid = 0;
					
					if(in_array($stageskey, array(5,6))) {
					  $trackdetails = mysql_fetch_assoc(mysql_query("SELECT id , quote_id , job_id ,fallow_created_date ,  fallow_time   FROM `sales_task_track` WHERE  track_type = 2 AND job_id = ".$data['id']." "));
						$trackid =  $trackdetails['id'];						  
					}
		?>	
		 
		 
		
		   	<div class="box panel panel-info box-item box_color_1 getresponse_data<?php echo $data['id']; ?>"  id="<?php echo $data['id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>" >
			   
			  <?php if($trackid > 0) { ?>
			   <span class="glyphicon glyphicon-pencil" onclick="OprationsopenModal('<?php echo $trackid; ?>|3|<?php echo $stageskey;?>')"></span>
			 <?php  } ?>
			 
			    <div class="panel-heading td_back "  >
				  <div class="row"> 
				  <div class="col-md-12">
				
				   <h3><p class="glyphicon glyphicon-user geticone" title="<?php echo $getq['email']; ?>"><?php echo $getq['name']; ?></p></h3>
				   
				    <p class="glyphicon glyphicon-ok geticone">
						Q# <?php echo  $getq['id']; ?>
						
					  <?php  if($stageskey == 2) {
               ////https://www.beta.bcic.com.au/admin/popup.php?task=client_site_image&img_type=before&imgtype=1&jobstatus=job&job_id=4758
					  ?>	
					   ( J# <a href="javascript:scrollWindow('popup.php?task=client_site_image&img_type=after&imgtype=2&jobstatus=job&job_id=<?php echo $getq['booking_id']; ?>','1200','850')"><?php echo $getq['booking_id']; ?></a>)
						
					  <?php  }else{  ?>
					    
						( J# <a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $getq['booking_id']; ?>','1200','850')"><?php echo $getq['booking_id']; ?></a>)
						
					  <?php  } ?>
				    </p>
					
					 <p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $getq['phone']; ?>"><?php echo $getq['phone']; ?></a>(<?php echo $getsite[$getq['site_id']]; ?> )</p>
					 
					 <?php  if($stageskey == 7) { ?>
					 <p class="glyphicon glyphicon-time geticone"><?php echo changeDateFormate($data['review_call_done'] , 'timestamp'); ?> </p>	
				    <?php  } ?>
					
						   
				    <p class="glyphicon glyphicon-usd geticone"><?php echo  $getq['amount']; ?>(<?php if($getq['booking_date'] != '0000-00-00') { echo changeDateFormate($getq['booking_date'] , 'datetime');  } ?>)</p>
					
					
					
					<?php 
					
					if($stageskey == 8) {
                        $reviewdata =   getOverallReview($getq['booking_id']);
						//echo $yellow_star;
						$yellow_star = $reviewdata['yellow_star'];
						$review_date = $reviewdata['review_date'];
					    $white_star = 5 - $yellow_star;
					  echo "<ul class='review_ratting'><li title='".changeDateFormate($review_date , 'datetime')."'>"; 
					  
					  
					  for($r = 1; $r <= $yellow_star; $r++) {
						 echo  '<p class="glyphicon glyphicon-star checked1" ></p>';
					  }
					  
					  for($r1 = 1; $r1 <= $white_star; $r1++) {
						 echo  '<p class="glyphicon glyphicon-star" ></p>';
					  }
					  ?>
					  ( <a href="javascript:scrollWindow('client_review_popup.php?task=review&type=1&job_id=<?php echo $getq['booking_id']; ?>','1200','850')"><?php echo $yellow_star; ?></a> )
					  </li></ul>
					   
			    	<?php  
					} 
					?>
					
					  <?php    while($qd = mysql_fetch_assoc($quote_details)){
						  
							$smobile =  get_rs_value("staff","mobile",$qd['staff_id']);
							$job_icon =  $jobicon[$qd['job_type_id']];

							$job_icon =  $jobicon[$qd['job_type_id']];
							if($qd['start_time'] == '0000-00-00 00:00:00') {
							$iconfol = 'job_type_red';

							}else{
							$iconfol = 'job_type32';
							}

							$start = '';
							$endt = '';
							if($qd['start_time'] != '0000-00-00 00:00:00' && $qd['end_time'] != '0000-00-00 00:00:00') {
							$start = changeDateFormate($qd['start_time'] ,'hi');
							$endt = changeDateFormate($qd['end_time'] ,'hi');
							}	  
						  
						  
			          ?><a  href="tel:<?php echo $smobile; ?>"><img class="image_icone" src="icones/<?php echo $iconfol;  ?>/<?php echo $job_icon." "; ?>" alt="<?php echo $qd['job_type']." "; ?>" title="<?php echo $staffdetails[$qd['staff_id']].' '.$smobile.' ('.$qd['job_type'].') ' .$start .' - '.$endt; ?>">
					  </a>
					  <?php }   ?>	
				      
				   </p>
				  </div>
				
               
			    </div>
			    </div>
				
			</div>	  
		<?php   } } $i++;  } } else {?>	
			 
			<div class="box panel panel-info box_color">
			   <div class="panel-heading">
				  Not Found
			   </div>
			</div>  
	 <?php }  ?>
        </div>
	    <span id="updateed"></span>	 
		  </div>
		  
		 
		<?php }  ?>  
			

  
	<div id="myModal11">
		   
		   </div>   
	</div>
	</div>
	</div>
	
	 <!-- Modal -->
	                <span class="show_data">
						  <div class="modal fade" id="myModal" role="dialog">
						  
						      <div class="modal-content" id="getdata">
							    
							  </div>
						  </div>
						
					</span>	  
	
<span id="updateed"></span>

</div>
</div>

<script src="../adminsales_system/js/bootstrap.min.js"></script>