<style>
    .long_div .col-md-2 {
       width: 14.2%; 
    }
</style>

	<div class="content cnt_box long_div" id="re_page">
	   
	<div class="row">
    <div class="mrg_btm20 ">
     <?php  
	 
	 //print_r($jobicon); die;
	 
	 // $staffdetails1 =  getAllStaffname();
	    foreach($stagesdata as $stageskey=>$getsalesheding) 
		{  
		
		
		 ?>
        <div class="col-md-2 mrg_btm20 ">
	   
	    <?php  
		    //$getReClandata = reclean_job_data($stageskey,  $adminid);
		    $getReClandata = getComplaintsCleanerHandling($stageskey,  $adminid);
		    //$getReClandata = array();
		
           $count = count($getReClandata[$stageskey]); 	 
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
				
			 foreach($getReClandata[$stageskey] as $key=>$data) {
	   
	   
	         $arg = "select id , name ,response ,  booking_id , step , amount , denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND booking_id = ".$data['job_id']."";
		   
				$getquesql = mysql_query($arg);
				
				$boxcolor='';
			 
			    if(mysql_num_rows($getquesql) > 0) {
				$trackid = 0;
		        while($getq = mysql_fetch_assoc($getquesql)) {
					
										
				   /*  if($stageskey == 1){
                          $qtime = $data['complaint_handling_date']; 
					     $next24hr =  date('Y-m-d H:i:s', strtotime(" -24 hours"));
  					
					 //echo $qtime .' <= '.$next24hr;
						//$boxcolor = '';				
						if($qtime <= $next24hr) {
							
							$boxcolor = 'red_box';
						}	
				    } */
		
		      
		            if($stageskey == 2)
					{		
				
				     // echo $data['complaint_handling_date'];
				
                          // $boxcolor = 'orange_box';
						   
						     $qtime1 = date('Y-m-d H:i:s' , strtotime($data['complaint_handling_date'])); 
					         $next2day =  date('Y-m-d H:i:s', strtotime(" -24 hours"));
                          			
                              //$timedata = $qtime1 . '' .	$next7day;
		 
							if($qtime1 <= $next2day) {
							     $boxcolor = 'orange_box';
						    }							
					}
					
					 if($stageskey == 3)
					{		
				
				       $boxcolor = 'red_box';		
					}
					
					if($stageskey == 7 && $data['complaint_date'] != '0000-00-00 00:00:00')
					{		
				
				       $boxcolor = 'green_box';		
					}
						
				$trackidsql = mysql_query("SELECT id , job_id  FROM `sales_task_track` WHERE `job_id` = ".$getq['booking_id']." and track_type = 2 Limit 0 , 1");
			   $trackid = 0;
			    $trackcount = mysql_num_rows($trackidsql);
					if($trackcount > 0) {
						$trackiddata = mysql_fetch_assoc($trackidsql);
						$trackid = $trackiddata['id'];
					}		
					
					
		?>	
		 
		 
		
		   	<div  <?php  echo $timedata ; ?> class="box panel panel-info box-item box_color_1 <?php echo $boxcolor; ?> getresponse_data<?php echo $data['job_id']; ?>"  id="<?php echo $data['job_id']; ?>" itemid="itm-<?php echo $i.'_'.$stageskey;?>" >
			   
					   <?php  if($trackid > 0 && $stageskey == 7) { ?>
						   <span class="glyphicon glyphicon-pencil" onclick="OprationsopenModal('<?php echo $trackid; ?>|7|<?php echo $stageskey.'_'.$data['id'];?>')"></span>
						<?php  }  ?> 
						
			   
			    <div class="panel-heading td_back "  >
				  <div class="row"> 
				    <div class="col-md-12">
				  
				  
						<?php /*  if($trackid > 0 && ($stageskey == 8 || $stageskey == 1)) { ?>
							   <span class="glyphicon glyphicon-check que_pencil" onclick="OprationsopenQuesModal('<?php echo $trackid; ?>' , '6', '<?php echo $stageskey; ?>' )"></span>
						<?php  }  */?> 
				
				
				
				   <h3><p class="glyphicon glyphicon-user geticone" title="<?php echo $getq['email']; ?>"><strong><?php echo $getq['name']; ?></strong></p></h3>
				   
				   <p class="glyphicon glyphicon-ok geticone" title="<?php echo $data['id']; ?>">C#<?php echo $data['id']; ?></p>
				   <p class="glyphicon glyphicon-ok geticone">
				    Q# <?php echo  $getq['id']; ?>
					
					   ( J# <a href="javascript:scrollWindow('popup.php?task=job_reclean&job_id=<?php echo $getq['booking_id']; ?>','1250','800')"><?php echo $getq['booking_id']; ?></a>)
				  
				  </p>

					
					 <p class="glyphicon glyphicon-earphone geticone"><a href="tel:<?php echo $getq['phone']; ?>"><?php echo $getq['phone']; ?></a>(<?php echo $getsite[$getq['site_id']]; ?> )</p>
					 
				<p class="glyphicon glyphicon-time geticone" title="<?php echo changeDateFormate($data['createdOn'], 'dt'); ?>"><?php echo changeDateFormate($data['createdOn'], 'dt'); ?></p>
				
				<?php   if($stageskey == 3) {  ?>
				   
				     <p class="glyphicon glyphicon-earphone geticone"  id="job_handling_by_clnr_<?php echo $data['id'];?>" style="margin: 4px 6px 8px -3px;"><a href="javascript:send_data('<?php echo $data['id'];?>|job_handling_by_clnr' , 608, 'job_handling_by_clnr_<?php echo $data['id'];?>' );" style="border: 1px solid #000;margin: 10px;background: #ded6d6; color: black;">Move In Admin</a></p>
				
				   <!--<p class="glyphicon glyphicon-ok geticone" title="">
					   <?php echo  create_dd("job_handling_by_clnr","system_dd","id","name","type=146","Onchange=\"return change_complaint_status(this,'job_complaint.job_handling_by_clnr' ,".$data['id']." , 'job_handling_by_clnr_".$data['id']."', 'Job Handling');\"",$data); ?>
			        </p>-->
					
					 <p class="glyphicon glyphicon-user geticone" title="">
				      <?php echo  create_dd("admin_id","admin","id","name"," status = 1 AND is_call_allow = 1","Onchange=\"return change_complaint_status(this, 'job_complaint.admin_id',".$data['id'].", 'admin_id_".$data['id']."','Admin Name');\"",$data,'field_id'); ?>
			        </p>
					
				<?php  }  ?>	
				
				
				<?php  if($stageskey != 1 || $stageskey != 2 || $stageskey != 3 ) {  
				
				 //if($stageskey == 4) {
				?>
				   <p class="glyphicon glyphicon-user geticone" title=""><?php echo get_rs_value("admin","name",$data['admin_id']);  ?></p> 
				   
				 <?php   }
				 //} ?>	
					
					
		<?php  /*  if($stageskey == 4 || $stageskey == 5 || $stageskey == 6 || $stageskey == 7) { ?>			
			<p class="glyphicon glyphicon-user geticone" title="">	
			   <?php echo  create_dd("complaint_status","system_dd","id","name","type=124","Onchange=\"return change_complaint_status(this,'job_complaint.complaint_status' ,".$data['id']." , 'complaint_type_".$data['id']."', 'Complaint  Status');\"",$data); ?>
			</p>
				
			<?php 
		} */
		
		        if($stageskey == 1) {
			?>	
				   <p class="glyphicon glyphicon-ok geticone" title="">
				   <?php echo  create_dd("complaint_type","system_dd","id","name","type=125","Onchange=\"return change_complaint_status(this,'job_complaint.complaint_type' ,".$data['id']." , 'complaint_type_".$data['id']."', 'Complaint  Type');\"",$data, 'field_id'); ?>
				   </p>
				   
				<?php  
				    } 
                  if($stageskey == 4 || $stageskey == 5 || $stageskey == 6) {
			   ?>	
				   <p class="glyphicon glyphicon-ok geticone" title="">
				   <?php echo  create_dd("complaint_resolve","system_dd","id","name","type=144","Onchange=\"return change_complaint_status(this,'job_complaint.complaint_resolve' ,".$data['id']." , 'complaint_type_".$data['id']."', 'Complaint Resolve  Status');\"",$data, 'field_id'); ?>
				   </p>
				   
				<?php  
				    } 

/* 					if($stageskey == 2) {
						
				    if($data['email_send_to_cleaner']  !='0000-00-00 00:00:00' &&  $stageskey == 2) { echo 'Email=>Clnr=>' .date("d M/h:i A",strtotime($data['email_send_to_cleaner'])); }else{
				?>   
				     <p class="glyphicon glyphicon-earphone geticone"  id="cmln_to_claener_<?php echo $data['id'];?>" style="margin: 4px 6px 8px -3px;"><a href="javascript:send_data('<?php echo $data['id'];?>|email_send_to_cleaner' , 608, 'cmln_to_claener_<?php echo $data['id'];?>' );" style="border: 1px solid #000;margin: 10px;background: #ded6d6; color: black;">Email=>Clnr</a></p>
					<?php   } 
					  echo '<br/>';
					
					 if($data['info__received']  !='0000-00-00 00:00:00') { echo 'Info Rcvd=>' .date("d M/h:i A",strtotime($data['info__received_'])); }else{
					?>

					 <p class="glyphicon glyphicon-earphone geticone"  id="info__received_<?php echo $data['id'];?>" style="margin: 4px 6px 8px -3px;"><a href="javascript:send_data('<?php echo $data['id'];?>|info__received' , 608, 'info__received_<?php echo $data['id'];?>' );" style="border: 1px solid #000;margin: 10px;background: #ded6d6; color: black;">Info Received</a></p>
					
					 <?php  } }  */ ?>
                        
					<?php  if($stageskey == 1) { ?>
					
					 <p class="glyphicon glyphicon-earphone geticone"  id="move_contact_<?php echo $data['id'];?>" style="margin: 4px 6px 8px -3px;"><a href="javascript:send_data('<?php echo $data['id'];?>|move_contact' , 608, 'move_contact_<?php echo $data['id'];?>' );" style="border: 1px solid #000;margin: 10px;background: #ded6d6; color: black;">Move to Contacted </a></p>
					<?php  } ?>
					
					
					<?php  if($stageskey == 2) { ?>
					
					<p class="glyphicon glyphicon-ok geticone" title="">
					   <?php echo  create_dd("move_from_contract","system_dd","id","name","type=146 ","Onchange=\"return change_complaint_status(this,'job_complaint.move_from_contract' ,".$data['id']." , 'move_from_contract_".$data['id']."', 'Job Handling');\"",$data, 'field_id'); ?>
			        </p>
					     
						   <!--<p class="glyphicon glyphicon-earphone geticone"  id="move_in_overdue_<?php echo $data['id'];?>" style="margin: 4px 6px 8px -3px;"><a href="javascript:send_data('<?php echo $data['id'];?>|move_in_overdue' , 608, 'move_in_overdue_<?php echo $data['id'];?>' );" style="border: 1px solid #000;margin: 10px;background: #ded6d6; color: black;">Move To OD</a></p>
					
					  <p class="glyphicon glyphicon-earphone geticone"  id="move_bcic_<?php echo $data['id'];?>" style="margin: 4px 6px 8px -3px;"><a href="javascript:send_data(' <?php echo $data['id'];?>|move_bcic' , 608, 'move_bcic_<?php echo $data['id'];?>' );" style="border: 1px solid #000;margin: 10px;background: #ded6d6; color: black;">Move To BCIC</a></p>
					 
					    <p class="glyphicon glyphicon-earphone geticone"  id="move_resolved_<?php echo $data['id'];?>" style="margin: 4px 6px 8px -3px;"><a href="javascript:send_data('<?php echo $data['id'];?>|move_resolved' , 608, 'move_resolved_<?php echo $data['id'];?>' );" style="border: 1px solid #000;margin: 10px;background: #ded6d6; color: black;">Move To Resolved</a></p>-->
						
					<?php  } ?>
			
					 <?php  
					 $iconfol = 'job_type32';
					   
                   if($data['job_type_id'] > 0) { 
				   $job_icon =  $jobicon[$data['job_type_id']];
				?>
				
					 <a  href="#"><img class="image_icone" src="icones/<?php echo $iconfol;  ?>/<?php echo $job_icon; ?>" alt="<?php echo $data['job_type_id']." "; ?>" title="<?php echo $data['job_type_id']; ?>" />
					  </a>
				<?php  } ?>	  
				
				<?php  if($stageskey == 7) { ?>
                   <p><?php if($data['complaint_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($data['complaint_date'], 'timestamp'); } else{echo 'Not Complaint';}?> </p>
				<?php  } ?>				
					
		          <!--<p class="glyphicon glyphicon-usd geticone"><?php echo  $getq['amount']; ?>(<?php if($getdata[0]['reclean_date'] != '0000-00-00') { echo changeDateFormate($getdata[0]['reclean_date'] , 'datetime');  } ?>)</p>-->
				  
                   </p>
				  </div>
				
               
			    </div>
			    </div>
				
			</div>	  
			 <?php   }  }} $i++;   } else {?>	
			 
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
<script>
   function saveCompliteInfo(lastid){
	   // who_fault refund_given gift_voucher insurance_case payning_invoice other
	   
	   var who_fault =   $('#who_fault').val();
	   var refund_given =   $('#refund_given').val();
	   var gift_voucher =   $('#gift_voucher').val();
	   var insurance_case =   $('#insurance_case').val();
	   var payning_invoice =   $('#payning_invoice').val();
	   var other =   $('#other').val();
	   
	   var str = who_fault +'__'+refund_given +'__'+gift_voucher +'__'+insurance_case +'__'+payning_invoice +'__'+other+'__'+lastid;
	   
	    // alert(str);
	   send_data(str , 609, 'getdata');
	   
	   
	   
   }
</script>

<script src="../adminsales_system/js/bootstrap.min.js"></script>