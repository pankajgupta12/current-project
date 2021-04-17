  <style>
    .cnt_box .col-md-2 {
       width: 12.2%;
    }
  </style>

	<div class="content cnt_box" id="re_page">
	   
	<div class="row">
    <div class="mrg_btm20 ">
     <?php  
	 
	foreach($stagesdata as $stageskey=>$getsalesheding) 
	{
		if(in_array($_SESSION['operation']['task_type'] , array(0,1)) && ($stageskey == 6)) 
		{
			include('daybefor_job.php');
		}
		else 
		{ 
		
		 ?>
        <div class="col-md-2 mrg_btm20 ">
	   
	    <?php  
		
		$getdata =  getBefor_jobDay($stageskey, $adminid);
		
		// $getdata =  getBefor_jobDay($stageskey, $adminid);
		
		 
		  $count = count($getdata[$stageskey]);
		  ?>
	   
		<h2><?php echo $getsalesheding;  if($count > 0 ) { ?> (<?php echo $count; ?>) <?php  } ?> </h2>
		
		<div class="scroll_c ui-droppable" id="container<?php echo $stageskey;?>">
		 
			<?php   
			
			if($count > 0 ) 
			{  
			   ?>
			   <?php  	 
				 $i = 1;
					
				foreach($getdata[$stageskey] as $key=>$data)	{
		   
					$arg = "select id , name ,response ,  booking_id , step , amount , denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND id = ".$data['quote_id']."";
			   
					$getquesql = mysql_query($arg);
				 
				if(mysql_num_rows($getquesql) > 0) 
				{
					
				    while($getq = mysql_fetch_assoc($getquesql)) {

					   $date1=date_create(date('Y-m-d'));
					   $date2=date_create($getq['booking_date']);
					
							$boxcol = '';
							$diff=date_diff($date1,$date2);
							if($diff->format("%a") < 4) {
								$boxcol =  'orange_box';
							}elseif($diff->format("%a") > 4 && $diff->format("%a") < 8){
							   $boxcol =  'grey_box';
							}elseif($diff->format("%a") > 8){
							   $boxcol =  '';
							}
					
			if($stageskey == 3 && $data['assigning_status'] == 2) {
				$boxcol =  'red_box'; 
			}elseif($stageskey == 3 && $data['assigning_status'] == 1){
				$boxcol =  'green_box';
			}		
					
				//op-box_circle_red op-box_circle_green	
					
		$trackdetails = mysql_fetch_assoc(mysql_query("SELECT id , quote_id , job_id ,fallow_created_date ,  fallow_time   FROM `sales_task_track` WHERE  track_type = 2 AND job_id = ".$data['id']." "));			
				//$status = get_rs_value("jobs","status",$getq['booking_id']);	
                 							
				$geticondata = GetBeforeJobIcon($getq['id'], $jobicon , $staffdetails);
				
				//$data['job_acc_deny']
				
				if($geticondata['job_acc_deny'] == 1 && $stageskey == 4) {
				        $boxcol =  'green_box'; 
				}else if($geticondata['job_acc_deny'] == 0 && $stageskey == 4) {
				        $boxcol =  'red_box'; 
				}
				
				if($geticondata['job_time_change_date'] == '0000-00-00 00:00:00' && $stageskey == 7) {
				        $boxcol =  'red_box'; 
				}
				
				//if($stageskey == 1 && $data['cl_sms_date_for_img'] != '0000-00-00 00:00:00') {
				
					if(($data['cl_sms_date_for_img'] != '0000-00-00 00:00:00'  && $stageskey == 1) && ( $stageskey == 1 && $data['cl_email_date_for_img'] != '0000-00-00 00:00:00')) {
					   $boxcol =  'red_box'; 
						//$get11= 'pankaj';
					}
				 
				if($stageskey == 5) {
				    
					  if($data['client_info_update_date'] != '0000-00-00 00:00:00') {
						  $boxcol =  'green_box';
					  }elseif($data['client_info_update_date'] == '0000-00-00 00:00:00') {
						  
						  $boxcol =  'red_box';
					  }
				}
			
			?>	
		 
		 
		
		   	<div class="box panel panel-info box-item box_color_1 <?php echo $boxcol; ?> getresponse_data<?php echo $trackdetails['id']; ?>"  id="<?php echo $trackdetails['id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>">
			  
			 <?php if($trackdetails['id']  != 0 && $trackdetails['id']  != '') { ?>
			   <span class="glyphicon glyphicon-pencil" onclick="OprationsopenModal('<?php echo $trackdetails['id']; ?>|1|<?php echo $stageskey;?>')"></span>
			 <?php  } ?>
			  
			    <div class="panel-heading td_back " >
				  <div class="row"> 
					<div class="col-md-12">
					<?php if($trackdetails['id']  != 0 && $trackdetails['id']  != '') { ?>
					 <span class="glyphicon glyphicon-check que_pencil" onclick="OprationsopenQuesModal('<?php echo $trackdetails['id']; ?>' , '1', '<?php echo $stageskey; ?>' )"></span>
					<?php  } ?> 
						<!--<h3><p class="glyphicon glyphicon-user geticone"><?php echo $getq['name']; ?>  </p></h3>-->
						
						<h3><p class="glyphicon glyphicon-user geticone"><?php echo $getq['name']; ?>  </p></h3>

						<p class="glyphicon glyphicon-ok geticone"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $getq['booking_id']; ?>','1200','850')"><?php echo $getq['booking_id']; ?></a></p>	
						<p class="glyphicon glyphicon-time geticone"><?php echo changeDateFormate($trackdetails['fallow_created_date'] , 'datetime'); ?> <?php echo $trackdetails['fallow_time']; ?></p>	

						<p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $getq['phone']; ?>"><?php echo $getq['phone']; ?></a> ( <?php echo $getsite[$getq['site_id']]; ?> )</p>

						<p class="glyphicon glyphicon-usd geticone"><?php echo  $getq['amount']; ?> ( <?php if($getq['booking_date'] != '0000-00-00') { echo changeDateFormate($getq['booking_date'] , 'datetime');  } ?>)</p>
                        <?php  
					        $getcount = check_question_is_cehcked($trackdetails['id'] , 1 , $stageskey);
					    ?>
						 <p  <?php echo $getcount; if($getcount > 0) { if($getcount == 2) { ?> class="op-box_circle_red"  <?php  } elseif($getcount == 1) {  ?>  class="op-box_circle_green"  <?php  } } ?>>
						 </p>
					
                  <?php if($stageskey == 5) { ?>					
						
						<p class="glyphicon glyphicon-user geticone">Send SMS -> <?php  if($data['sms_to_client_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($data['client_info_update_date'] , 'datetime');  } else{ echo 'N/A'; }?>  </p>
						
						<p class="glyphicon glyphicon-user geticone">Info Rcvd -> <?php  if($data['client_info_update_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($data['client_info_update_date'] , 'datetime');  } else{ echo 'N/A'; }?>  </p>
						
						<!--<p class="glyphicon glyphicon-user geticone"><?php echo $data['start_time']; ?>  </p>
						<p class="glyphicon glyphicon-user geticone"><?php echo $data['get_entry']; ?>  </p>
						<p class="glyphicon glyphicon-user geticone"><?php echo $data['cleaner_park']; ?>  </p>-->
				<?php  } ?>
						 
						<?php  

						unset($geticondata['job_time_change_date']);
						unset($geticondata['job_acc_deny']);
						
							 foreach($geticondata as $jobkey=>$jobdetails) {	 
										$iconfol = $jobdetails['iconfol'];
										$smobile = $jobdetails['smobile'];
										$staff_name = $jobdetails['staff_name'];
										$job_icon = $jobdetails['job_icon'];
										$job_type = $jobdetails['job_type'];
						?>
						   <?php  if($smobile != 'N/A') { ?><a  href="tel:<?php echo $smobile; ?>" ><?php  }  ?> <img class="image_icone" src="icones/<?php echo $iconfol; ?>/<?php echo $job_icon." "; ?>" alt="<?php echo $job_type." "; ?>"  title="<?php echo $staff_name.' '.$smobile.' ('.$job_type.')'; ?>"><?php  if($smobile != 'N/A') { ?></a><?php }  }   ?>	

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
	} 
	?>  
	</div>
	</div>
	</div>
	
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
	
	
			
			
	function opr_set_message_type_button(id , fname, fielddata= 0){
				
				//alert('cx');
				
				 var DataString = 'id='+id+'&page=fdata&fname='+fname;
				  
				  //alert(DataString);
				  
						$.ajax({
							url: 'xjax/ajax/operations_button_show.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#getdata').html(resp);
								//get_task_page(id);
							} 

						});  
	} 
	
	function opr_send_details_to_cl(id , fname , type, textid){
		  var DataString = 'id='+id+'&type='+type+'&fname='+fname+'&page=emailsms&textid='+textid;
		  
		            $.ajax({
							url: 'xjax/ajax/operations_button_show.php',
							type: 'POST',
							datatype: 'html',
							data: DataString,
							success: function(resp){
								$('#getdata').html(resp);
								
								
							} 
					});  
	}	

			
	
</script>
<script src="../adminsales_system/js/bootstrap.min.js"></script>