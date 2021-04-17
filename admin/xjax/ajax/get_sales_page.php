 <?php   $getRespoType = system_dd_type(111); ?>
        <script type="text/javascript">
            $(document).ready(function () {
				 $('.follow_date_class').datepicker({dateFormat:'yy-mm-dd'});
            }); 
        </script>
	        <div class="modal-content">
			
						<div class="modal-header">
						   <button type="button" class="close" data-dismiss="modal<?php //echo $data['id']; ?>">&times;</button>
						   <h4 class="modal-title" ><?php  echo ucfirst($getqdetails['name']);  ?> ( Q#<?php echo $getdata['quote_id']; ?>)    <span>Amount $<?php echo $getqdetails['amount']; ?></span></h4>
						</div>
						

					 
					  
						<div class="modal-body">
						
							<span class="glyphicon glyphicon-phone"><a href="tel:<?php echo $getqdetails['phone']; ?>"><?php echo $getqdetails['phone']; ?></a></span>
   							
							
								<p class="glyphicon glyphicon-time left-time-tab"><?php echo changeDateFormate($getdata['fallow_created_date'] , 'datetime'); ?>  <?php echo $getdata['fallow_time']; ?></p>	
								
						    <ul class="full-info-btn-new">
							
							   <?php  if($getdata['ans_date'] != '0000-00-00 00:00:00') { ?>
								
								     Answer <span class="glyphicon glyphicon-ok" ></span>
								     Left Message <span class="glyphicon glyphicon-remove" ></span>
									 
									  <br/>
									  <br/>
											
									
							   <?php }else if($getdata['left_sms_date'] != '0000-00-00 00:00:00') { ?>
								
								     Answer <span class="glyphicon glyphicon-remove" ></span>
								     Left Message <span class="glyphicon glyphicon-ok" ></span>
									 
									  <br/>
									  <br/>
											
									
							    <?php } ?>
							
							       <li id="ans_date_<?php echo $getdata['id']; ?>">
									  <button type="button" onclick="set_message_type_button('<?php echo $getdata['id']; ?>' ,'ans_date');" class="btn btn-primary btn-sm">Answer</button>
									</li>
									 
									<li id="left_sms_date_<?php echo $getdata['id']; ?>">
									  <button type="button" onclick="set_message_type_button('<?php echo $getdata['id']; ?>' ,'left_sms_date');" class="btn btn-info btn-sm">Left Message</button>
									</li>
							
							
							
								<?php   if($getdata['ans_date'] != '0000-00-00 00:00:00' ||  $getdata['left_sms_date'] != '0000-00-00 00:00:00' ) { 
								
								  $follow_data1 =  dd_value(119);
								 // print_r($follow_data);
								?>	
								
        							    <li id="sms_date_<?php echo $getdata['id']; ?>" style="margin-top: 19px;"> 
										 
        								  <!--<button type="button" class="btn btn-info btn-sm" onClick="savefallowdate('<?php echo $getdata['id']; ?>',2);">Auto Follow</button>
        								  <button type="button" class="btn btn-info btn-sm" onClick="show_schedule(3);">Follow</button>-->
										  
										 <?php   foreach($follow_data1 as $keyid=>$followvalue) {  
										   $ct = date('H:i');
										    if($ct < $followvalue) {
												$daytime = '';
											}else{
												$daytime = 'Next';
											}
										 
										 ?> 
										 
										   <button type="button" class="btn btn-info btn-sm" onClick="savefallowdate('<?php echo $getdata['id']; ?>',2, '<?php  echo $keyid; ?>');"><?php echo  $daytime .' ' .$followvalue; ?></button>
											<?php //} 
											} ?>
										 <button type="button" class="btn btn-info btn-sm" onClick="show_schedule(3);">Custom</button>
        								  <button type="button" class="btn btn-danger btn-sm" onClick="show_schedule(2);">Lost</button>
        								</li>	
							<?php  } ?>	
						</ul>	
							  
							<div class="full_info_data">	
								<div class="last_activity">
								<?php  $getdata_1 = get_sales_activity($getdata['quote_id'] , 1 , 1); 
								
								 //print_r($getdata_1);
								 
								 foreach($getdata_1 as $key=>$value) {
									 $adminname = get_rs_value('admin' , 'name' , $value['admin_id']);
								?>
								
								   <div class="follow-div">
									   <p><b><?php echo  ucwords($getRespoType[$value['response_type']]);  ?></b></p>
									   <span>(<?php echo  $adminname;  ?>)</span> 
									   <p style="float: right;"><?php echo  changeDateFormate($value['created_date'] , 'ts');  ?></p> 
								   </div>
								 <?php   } ?>
								</div>
								
								
								<div class="last_activity_123">
								<?php  $getdata_11 = get_sales_activity($getdata['quote_id'] , 1 ,2); 
								
								 //print_r($getdata_1);
								 
								 foreach($getdata_11 as $key=>$value) {
									 $adminname = get_rs_value('admin' , 'name' , $value['admin_id']);
								?>
								
								   <div class="follow-div">
									   <p><b><?php echo  ucwords($getRespoType[$value['response_type']]);  ?></b></p>
									   
									   <span>(<?php echo  $adminname;  ?>)</span> 
									   <p style="float: right;"><?php echo  changeDateFormate($value['created_date'] , 'ts');  ?></p> 
								   </div>
								 <?php   } ?>
								   
								</div>
							</div>	
								
							
								
								<span id="show_schedule" style="display:none;">
								   <input size="16" type="text"  name="fallow_created_date" value="<?php echo $getdata['fallow_created_date']; ?>" id="fallow_created_date" class="follow_date_class">
									<span>
										<select name="fallow_time"  id="schedule_time">
										<option value=''>Select</option>
										  <?php  
											$minutes = get_minutes('01:00', '23:00');  
											foreach($minutes as $key=>$minute) {
												if(($getdata['fallow_time'] == $minute)) { $selected = 'selected'; }else { $selected = '';} 
											   echo '<option value='.$minute.' '.$selected.'>'.$minute .'</option>';  
											}  
										  ?>
										
										</select>
									
									</span>
								
								   <button type="button" class="btn btn-success btn-sm" onClick="savefallowdate('<?php echo $getdata['id']; ?>',1,0);">Save</button>
								</span>
								
								
								<p class="placeholder_icon" id="quote_step" style="display:none;">
								 
								  <?php    echo create_dd("step","system_dd","id","name","type=31","Onchange=\"return quote_step(this.value,".$getqdetails['id']." , 'step' , ".$getdata['id'].");\"",$getqdetails);


											if($getqdetails['step'] == 6) {

										    	echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=91","Onchange=\"return view_quote_admin_denied(this.value,".$getqdetails['id']." , 1);\"",$getqdetails);
											}else if($getqdetails['step'] == 5){

											     echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=93","Onchange=\"return view_quote_admin_denied(this.value,".$getqdetails['id']." , 1);\"",$getqdetails);
											}else if($getqdetails['step'] == 7){

											    echo '<br/>'.create_dd("denied_id","system_dd","id","name","type=94","Onchange=\"return view_quote_admin_denied(this.value,".$getqdetails['id']." , 1);\"",$getqdetails);
											}
								  ?>
					            </p>
					 			
						<?php   if($getdata['ans_date'] != '0000-00-00 00:00:00' ||  $getdata['left_sms_date'] != '0000-00-00 00:00:00' ) { ?>	

                                	
						
								<span><h3>SMS</h3>
								
									  <?php   if($getqdetails['moving_from'] != '' && $getqdetails['is_flour_from'] > 0) { ?>
											
											  <?php if($getdata['first_sms'] == '0000-00-00 00:00:00')  { ?>	
											
												<button type="button" class="btn btn-success btn-sm" onClick="send_details_to_cl('<?php echo $getdata['id']; ?>' , 'first_sms' ,2 , 7);">Removal SMS </button>
												
											<?php  }else { ?>
											Removal SMS  <span class="glyphicon glyphicon-ok" ></span> <?php  echo changeDateFormate($getdata['first_sms'] , 'dt'); ?>
											<?php  } ?>
									
								
									
										
									<?php  }else { ?>
									    
										  	<?php if($getdata['first_sms'] == '0000-00-00 00:00:00')  { ?>	
											
												<button type="button" class="btn btn-success btn-sm" onClick="send_details_to_cl('<?php echo $getdata['id']; ?>' , 'first_sms' ,2 , 1);">SMS 1</button>
												
											<?php  }else { ?>
											SMS 1 <span class="glyphicon glyphicon-ok" ></span> 
											<?php  } ?>
											
											
											<?php if($getdata['second_sms'] == '0000-00-00 00:00:00')  { ?>	
												<button type="button" class="btn btn-success btn-sm" onClick="send_details_to_cl('<?php echo $getdata['id']; ?>' , 'second_sms', 2 , 2);">SMS 2</button>
											<?php  }else { ?>
											SMS 2 <span class="glyphicon glyphicon-ok" ></span> 
											<?php  } ?>
											
											
											<?php if($getdata['threed_sms'] == '0000-00-00 00:00:00')  { ?>	
											  <button type="button" class="btn btn-success btn-sm" onClick="send_details_to_cl('<?php echo $getdata['id']; ?>' , 'threed_sms', 2 , 3);">SMS 3</button>
											<?php  }else { ?>
											SMS 3 <span class="glyphicon glyphicon-ok" ></span> 
											<?php  } ?>
									<?php  } ?>		
									   
							    </span>
							   
							    <br/>
							    <br/>
								
								
							    <span><h3>Email</h3>
							     
							        <?php if($getdata['first_email'] == '0000-00-00 00:00:00')  { ?>	
									
									<button type="button" class="btn btn-success btn-sm" onClick="send_details_to_cl('<?php echo $getdata['id']; ?>' , 'first_email', 1 , 4);">Email 1</button>
									
									<?php  }else { ?>
   									    Email 1 <span class="glyphicon glyphicon-ok" ></span> 
										<?php  echo changeDateFormate($getdata['first_email'] , 'dt'); ?>
									<?php  } ?>
									
									 &nbsp;&nbsp;&nbsp;
									 <?php if($getdata['second_email'] == '0000-00-00 00:00:00')  { ?>	
									 
									   <button type="button" class="btn btn-success btn-sm" onClick="send_details_to_cl('<?php echo $getdata['id']; ?>' , 'second_email', 1 , 5);">Email 2</button>
									   
									<?php  } else { ?>
									
   									  Email 2<span class="glyphicon glyphicon-ok" ></span> 
									  
										<?php  echo  changeDateFormate($getdata['second_email'] , 'dt'); ?>
									
									<?php  } ?>
									&nbsp;&nbsp;&nbsp;
									 <?php /* if($getdata['threed_email'] == '0000-00-00 00:00:00')  { ?>	
									<button type="button" class="btn btn-success btn-sm" onClick="send_details_to_cl('<?php echo $getdata['id']; ?>' , 'threed_email', 1 , 4);">Email 1</button>
									<?php  }else { ?>
   									Email 3 <span class="glyphicon glyphicon-ok" ></span> 
									<?php  }  */?>
									
									
									
							   </span>	
						<?php  } ?>	   
							 
						</div>
						
					<div class="modal-footer" style="margin-top: 78px;">
					  <button type="button" class="btn btn-default" data-dismiss="modal<?php// echo $data['id']; ?>">Close</button>
					</div>
			</div>