<style>
    .long_div .col-md-2 {
       width: 14.2%; 
    }
</style>

	<div class="content cnt_box long_div" id="re_page">
	   
	<div class="row">
    <div class="mrg_btm20 ">
     <?php  
	 
	 // $staffdetails1 =  getAllStaffname();
	    foreach($stagesdata as $stageskey=>$getsalesheding) 
		{  
		
		
		 ?>
        <div class="col-md-2 mrg_btm20 ">
	   
	    <?php  
		    $getReClandata = reclean_job_data($stageskey,  $adminid);

		//  print_r($getReClandata);
		
		$count = count($getReClandata[$stageskey]); 
		
	
		//$count = 0; 
		  ?>
	   
		<h2><?php echo $getsalesheding;  if($count > 0) { ?> (<?php echo $count; ?>) <?php  } ?> </h2>
		<div class="scroll_c ui-droppable" id="container<?php echo $stageskey;?>">
		 
		<?php  
      //echo $arg;		
		//echo $fata;   
		 if($count > 0) {  
		   ?>
		   <?php  	 
			 $i = 1;
			//while($data = mysql_fetch_assoc($argsql)) {
				
			 foreach($getReClandata[$stageskey] as $key=>$data) {
	   
				$arg = "select id , name ,response ,  booking_id , step , amount , denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND booking_id = ".$data['id']."";
		   
				$getquesql = mysql_query($arg);
			 
			    if(mysql_num_rows($getquesql) > 0) {
				
		        while($getq = mysql_fetch_assoc($getquesql)) {

				        //SELECT job_id ,  reclean_date, start_time , end_time , job_type_id FROM `job_reclean` WHERE DATE(reclean_date) = '2020-01-27'
						if($stageskey == 1) {
						  $sql_icone = ("select job_type_id , start_time , end_time ,  staff_id ,  job_type from job_details where  status != 2 AND quote_id=".$getq['id']);  
						}else{
							$sql_icone = ("select job_type_id , start_time , end_time ,  staff_id ,  job_type from job_reclean where  status != 2 AND quote_id=".$getq['id']);  
						}
						$quote_details = mysql_query($sql_icone);	
						
					    $trackid = 0;
					
					 /* if(in_array($stageskey, array(1 , 7))) {
					  $tracksql = mysql_query("SELECT id , quote_id , job_id ,fallow_created_date ,  fallow_time   FROM `sales_task_track` WHERE  track_type = 2 AND job_id = ".$data['id']." ");
					  $trackcount = mysql_num_rows($tracksql);
					  if($trackcount > 0) {
					       $trackdetails = mysql_fetch_assoc($tracksql);
						   $trackid =  $trackdetails['id'];
					  }else{
						  $trackid = 0;
					  }
					  						  
					}  */
				$getdata = getReCleanJobsOntheDay($stageskey , $getq['id']);	
				//print_r($getdata);
					
		?>	
		 
		 
		
		   	<div class="box panel panel-info box-item box_color_1 getresponse_data<?php echo $data['id']; ?>"  id="<?php echo $data['id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>" >
			   
			  <?php /* if($trackid > 0  && $stageskey == 1) { ?>
			   <span class="glyphicon glyphicon-pencil" onclick="OprationsopenModal('<?php echo $trackid; ?>|4|<?php echo $stageskey;?>')"></span>
			 <?php  }  */?>
			 
			    <div class="panel-heading td_back "  >
				  <div class="row"> 
				  <div class="col-md-12">
				
				    <?php /* if($trackid > 0 && $stageskey == 7) { ?>
					   <span class="glyphicon glyphicon-check que_pencil" onclick="OprationsopenQuesModal('<?php echo $trackid; ?>' , '4', '<?php echo $stageskey; ?>' )"></span>
					<?php  } */ ?> 
				 
				   <h3><p class="glyphicon glyphicon-user geticone" title="<?php echo $getq['email']; ?>"><?php echo $getq['name']; ?></p></h3>
				   
				   <p class="glyphicon glyphicon-ok geticone">
				    Q# <?php echo  $getq['id']; ?>
				   <?php // if($stageskey == 1 || $stageskey == 2) { ?>
					   ( J# <a href="javascript:scrollWindow('popup.php?task=job_reclean&job_id=<?php echo $getq['booking_id']; ?>','1200','850')"><?php echo $getq['booking_id']; ?></a>)
				   <?php // } ?>
				  </p>

					
					 <p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $getq['phone']; ?>"><?php echo $getq['phone']; ?></a>(<?php echo $getsite[$getq['site_id']]; ?> )</p>
					 
					
		           <p class="glyphicon glyphicon-usd geticone"><?php echo  $getq['amount']; ?>(<?php if($getdata[0]['reclean_date'] != '0000-00-00') { echo changeDateFormate($getdata[0]['reclean_date'] , 'datetime');  } ?>)</p>
				   
				  
                     <?php if($stageskey == 7) { ?>  
					      <p><a href="javascript:scrollWindow('reclean_agent_email.php?job_id=<?php  echo  $data['id']; ?>','750','750')">Send Email</a></p>
					  <?php 
					  } 
					   foreach($getdata as $key1=>$qd) {
						  
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
							
							// print_r($qd);

						
						  
						  
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
		  
		 
		<?php 
		}  
		?>  
  
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
					 <span class="show_data_qus">
						  <div class="modal fade" id="myModal_data" role="dialog">
						  
						      <div class="modal-content" id="getdata_1">
							     
							  </div>
						  </div>
						
	
<span id="updateed"></span>

</div>
</div>

<script src="../adminsales_system/js/bootstrap.min.js"></script>