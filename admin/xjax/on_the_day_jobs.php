	<style>
	 
		
	</style>
	<?php $getcount = OndayJobs(0 , $today  , $_SESSION['operation']['job_type_id'] ,$adminid); ?>
	
	
	<h3 class="cnt_t_total">Total Jobs <?php  echo  count($getcount[0]); ?> 
	
    <span class="selt-left"><?php echo  create_dd("job_type_id","job_type","id","name","id in (1,2,3,8,11)","onchange=javascript:get_operation_jib_type_id_page(this.value);",$_SESSION['operation']); ?></span>
	
	</h3>
	
	
	
	<div class="content cnt_box long_div get" id="re_page">    
	<div class="row">
    <div class="mrg_btm20 ">
     <?php  
	 
	 
	     foreach($stagesdata as $stageskey=>$getsalesheding) 
		{  
		?>
        <div class="col-md-2 mrg_btm20 ">
	   
	    <?php  
		    $getAlldata =   OndayJobs($stageskey , $today, $_SESSION['operation']['job_type_id'] ,$adminid);
		    $count  = count($getAlldata[$stageskey]);
		  ?>
	   
		<h2><?php echo  $getsalesheding;  if($count > 0) { ?> (<?php echo $count; ?>) <?php  } ?> </h2>
		<div class="scroll_c ui-droppable" id="container<?php echo $stageskey;?>">
		 
		<?php   
		if($count > 0) 
		{  
		   ?>
		   <?php  	 
			 $i = 1;
				foreach($getAlldata[$stageskey] as $getKey=>$data) {
	   
				$arg = "select id , name ,response ,  booking_id , step , amount , denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND id = ".$data['qid']."";
		   
				$getquesql = mysql_query($arg);
			 
			if(mysql_num_rows($getquesql) > 0) {
				
				   
				
		    while($getq = mysql_fetch_assoc($getquesql)) {

						$sql_icone = ("select job_type_id , start_time , end_time ,  staff_id ,  job_type from job_details where  status != 2 AND quote_id=".$getq['id']);  
						$quote_details = mysql_query($sql_icone);	

                       $boxcolor = '';
						 if($data['end'] != '0000-00-00 00:00:00') {
							 $boxcolor = 'green_box';
						 }						
			
			    $trackidsql = mysql_query("SELECT id , job_id  FROM `sales_task_track` WHERE `job_id` = ".$getq['booking_id']." and track_type = 2 Limit 0 , 1");
			   $trackid = 0;
			    $trackcount = mysql_num_rows($trackidsql);
					if($trackcount > 0) {
						$trackiddata = mysql_fetch_assoc($trackidsql);
						$trackid = $trackiddata['id'];
					}
					
		//$getq['site_id']			
			//
		 $sitesdetails1 = mysql_fetch_array(mysql_query("SELECT id , abv , ctime  FROM `sites` WHERE `id` = ".$getq['site_id'].""));	
	     
		 // print_r($sitesdetails1);
		?>	
		 
		 
		
		   	<div class="box panel panel-info box-item box_color_1 <?php echo $boxcolor; ?> getresponse_data<?php echo $data['id']; ?>"  id="<?php echo $data['id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>" >
			
                 <?php // print_r($data); ?>		
				 
			  
			    <?php if($trackid > 0) { ?>
			       <span class="glyphicon glyphicon-pencil" onclick="OprationsopenModal('<?php echo $trackid; ?>|2|<?php echo $stageskey;?>')"></span>
			    <?php  } ?> 
			   
			    <div class="panel-heading td_back " >
				  <div class="row"> 
				  <div class="col-md-12">
				     
					<?php if($trackid > 0) { ?>
					   <span class="glyphicon glyphicon-check que_pencil" onclick="OprationsopenQuesModal('<?php echo $trackid; ?>' , '2', '<?php echo $stageskey; ?>' )"></span>
					<?php  } ?> 
					 
				   <h3><p class="glyphicon glyphicon-user geticone"><?php echo $getq['name']; ?> </p></h3>
				    
					<p class="glyphicon glyphicon-ok geticone"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $getq['booking_id']; ?>','1200','850')"><?php echo $getq['booking_id']; ?></a></p>
					
					<p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $getq['phone']; ?>"><?php echo $getq['phone']; ?></a> ( <?php echo $sitesdetails1['abv']; ?>  )</p>
						   
				   
					<?php $Ctime = $sitesdetails1['ctime'];  ?>
				 <p class="glyphicon glyphicon-time geticone" style="font-weight: bold;">Crnt TIme  <?php echo date("h:i A", strtotime($Ctime.' minutes')); ?> </p>
					
				    <p class="glyphicon glyphicon-usd geticone" style="font-weight: bold;"><?php echo  $getq['amount']; ?> ( <?php echo $data['jtime'];?> )</p>
					
					
						 
					
			        <p class="glyphicon glyphicon-time geticone"><?php if($data['start'] != '0000-00-00 00:00:00') { echo changeDateFormate($data['start'],'hi'); }else{echo 'N/A';}  ?> - <?php if($data['end'] != '0000-00-00 00:00:00') { echo changeDateFormate($data['end'],'hi'); }else{echo 'N/A';}  ?> </p>
					
					 <?php if($data['upselldenied'] != 0) {  ?>
					<p style="float: right;margin-top: 6px;margin-left: 6px;font-weight: 600;font-size: 11px;">
					(Upsell)
						 <p data-id="0"  <?php if($data['upselldenied'] == 1) {  ?> class="op-box_circle_green" title="Approved" <?php  } elseif($data['upselldenied'] == 2) {  ?> title="Denied"  class="op-box_circle_red"  <?php  }  ?>></p>
						 
						
						  <p  data-id="1" <?php if($data['upselladmin'] == 0) { ?> class="op-box_circle_red"  title="No Upsell Manager" <?php  }elseif($data['upselladmin'] != 0) { ?> class="op-box_circle_green"  title="<?php  echo get_rs_value("admin","name",$data['upselladmin']); ?>" <?php  } ?> style="margin-right: 2px;" ></p>
						 
						
							<p data-id="2" <?php if($data['upsellrequired'] == 0) { ?>  class="op-box_circle_red" title="Required" <?php  }elseif($data['upsellrequired'] != 0) { ?> class="op-box_circle_green"  title="Complete" <?php  } ?>  style="margin-right: 2px;"></p>
						 
					 </p>
					 <?php  } ?>
				     <?php   
             //upsellrequired upselladmin
					 while($qd = mysql_fetch_assoc($quote_details)){      
			    	      //$job_icon =  get_rs_value("job_type","job_icon",$qd['job_type_id']);
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
				  
				  </div>
				  
			    </div>
			    </div>
				
			</div>	  
		<?php   } } $i++;  } 
		} else {?>	
			 
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
	                <!---<span class="show_data">
						  <div class="modal fade" id="myModal" role="dialog">
						  
						      <div class="modal-content" id="getdata">
							    
							  </div>
						  </div>
						
					</span>	-->  
					
					  <span class="show_data">
						  <div class="modal fade" id="myModal" role="dialog">
						  
						      <div class="modal-content getquedata" id="getdata">
							     
							  </div>
						  </div>
						
					</span>	  
					
					 <span class="show_data_qus">
						  <div class="modal fade" id="myModal_data" role="dialog">
						  
						      <div class="modal-content" id="getdata_1">
							     
							  </div>
						  </div>
						
					</span>	
	
<span id="updateed"></span>

</div>
</div>

<script>

	
	function set_message_type(id , fname){
		 var str = id+'|'+fname;
		 //var div = fname+'_'+id;
		 send_data(str , 556 , 'quote_view');
	} 
	
</script>
<script src="../adminsales_system/js/bootstrap.min.js"></script>