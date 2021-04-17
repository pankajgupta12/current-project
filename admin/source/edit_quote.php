<? 
// unset($_SESSION['temp_quote_id'],$_SESSION['quote_id']);
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
  
  unset($_SESSION['edit_quote_id']);
  $_SESSION['edit_quote_id'] = mres($_GET['quote_id']);
  
 $details = mysql_fetch_array(mysql_query("select * from quote_new where id=".mres($_GET['quote_id']).""));
 
   $job_id = $details['booking_id'];
   
    if($job_id == '0') {
			$sql_1 = ("select id , booking_date as jobdate from quote_details where  quote_id=".mres($_GET['quote_id'])." AND job_type_id = 11");
			$field_tabe = 'quote_details.booking_date';
			
	}else{
			$sql_1 = ("select id, job_date as jobdate from job_details where  status != 2 AND quote_id=".mres($_GET['quote_id'])." AND job_type_id = 11");  
			$field_tabe = 'job_details.job_date';
	}
	$getjob_details = mysql_fetch_assoc(mysql_query($sql_1));
      // print_r($getjob_details);
 
 ?> 
 <script>
 
   $(document).ready(function(e)
{	
	$('body').on('click','.bc_click_btn',function(e){
		
			 if(document.getElementById('suburb').value==""){ 
				alert("Please Select Suburb ");
				return false;
			}else if(document.getElementById('site_id').value==""){ 
				alert("Please Select Site Id is Empty");
				return false;
			}else if(document.getElementById('booking_date').value==""){ 	
				alert("Please Select Booking Date");
				return false;
			}else {
				
				 $( "#quote_div3" ).toggleClass( "toggle" );
				 $('.black_screen1').fadeIn(700);
				 check_availability();
				 $('.cret_left').addClass('parentDisable');
				 $('.black_screen1').css('display','block');
	        }
	});
		 $('.black_screen1').click(function(e)
		{
			$('#quote_div3').removeClass('toggle');
			$('.cret_left').removeClass('parentDisable');
			$('.black_screen1').fadeOut(700);		
		});  
});
 
		$(function() {
			  $("#booking_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#job_date").datepicker({dateFormat:'yy-mm-dd'});
			  $(".removal_date").datepicker({dateFormat:'yy-mm-dd'});
			  
		});	
	  $( function() {
		$( "#jobdate" ).datepicker();
		$( "#inspectdate" ).datepicker();
	  } );		  
	  
	    $(document).ready(function(e) {
			$('.menu').click(function(e) {
			$('.main_menu').slideToggle(700);    
			});
			
			$('#booking_date').on('change', function(){   
			  //console.log($(this).val());
			  
			  	//edit_field($(this).val(),'quote_new.booking_date','<? echo $_GET['quote_id']?>');			  
				edit_field_date($(this).val(),'booking_date','quote_new.booking_date','<? echo $_GET['quote_id']?>');			  
			  });
			  
	    });
	  
function select_suburb_edit(suburb,site_id){
	document.getElementById('suburb').value=suburb;
	document.getElementById('postcode_div').innerHTML="";
	document.getElementById('postcode_div').style.display="none";
	if(site_id!=""){
		document.getElementById('site_id').value=site_id;
	}
	
	var str = suburb+"|quote_new.suburb|<? echo $_GET['quote_id']?>|"+site_id;
	//alert(str);
	send_data(str,21,'suburb');	
}

function select_real_estate_name_edit(name,id){
	document.getElementById('real_estate_id').value=name;
	 document.getElementById('real_estate_name_div').innerHTML="";
	 $('#real_estate_id').attr('for',id);
	document.getElementById('real_estate_name_div').style.display="none";
		
	var str = id+"|quote_new.real_estate_id|<? echo $_GET['quote_id']?>";
	send_data(str,21,'real_estate_id');	 
} 

   $(document).ready(function(e) {
		var job_ref = '<?php echo $details['job_ref']; ?>';
		var quotefor = '<?php echo $details['quote_for']; ?>';
		//alert(job_ref);
		 if(job_ref == 'Staff') {
			// alert('asa'); edit_better_staff_list
			if(quotefor == 1) {
	             $('.edit_staff_list').show();
	             $('.edit_better_staff_list').hide();
			}else if(quotefor == 2){
			     $('.edit_staff_list').hide();
			      $('.edit_better_staff_list').show();
			}else{
			     $('.edit_staff_list').hide();
			     $('.edit_better_staff_list').hide();
			}
			
		 }else {
			 // alert('asa11111');
		    $('.edit_staff_list').hide();
		    $('.edit_better_staff_list').hide();
		 } 
    });
	
	function getstaffname(obj,fielddata,quoteid){
	    var quotefor1 = $('#quote_for').val();
	   
	  
		 if(obj.value == 'Staff') {
		     if(quotefor1 == 1) {
		        $('.edit_staff_list').show();
	             $('.edit_better_staff_list').hide();
		     }else if(quotefor1 == 2){
			     $('.edit_staff_list').hide();
			      $('.edit_better_staff_list').show();
		     }else{
		       $('.edit_staff_list').hide();
		       $('.edit_better_staff_list').hide();
		    }
		 }else {
		   $('.edit_staff_list').hide();
		    $('.edit_better_staff_list').hide();
		 }
		edit_field(obj,fielddata,quoteid);	
	} 
	
	
	function editcheckjob_type(id){
		
		    if(id == 11) {
				$('#br_address').show();
				$('#br_check_avail').show();
				$('#view_br_quote').show();
			}else{
			 $('#br_address').hide();	
			 $('#br_check_avail').hide();	
			 $('#view_br_quote').hide();	
			}	
	}
	
	   function checklevelform(value){ 
			if(value == 1) {
				// is_lift_from  house_type_from door_distance_from
				$('#is_lift_from').val(2);
				$('#house_type_from').val(2);
				$('#door_distance_from').val(1);
			}
		}
		
		function checklevelto(value){
			if(value == 1) {
				// is_lift_from  house_type_from door_distance_from
				$('#is_lift_to').val(2);
				$('#house_type_to').val(2);
				$('#door_distance_to').val(1);
			}
		}
	
	function save_address(quote_id){
		//alert(quote_id);
 		var el = document.getElementById("address"); 
		updateaddress11(el,'quote_new.address',quote_id);		
	}
	
	/*function getQuoteQuestions(quote_id, case_id, div_id){
		var str = quote_id+"|"+"jobs";
		$( "#quote_div3" ).toggleClass( "toggle" );
		$('.black_screen1').fadeIn(700);
		send_data(str,case_id,div_id);
		$('.cret_left').addClass('parentDisable');
		$('.black_screen1').css('display','block');
	}*/

</script>

<div class="body_container">
	<div class="body_back">
		<form method="post" id="form">
    	<div class="wrapper">
    	    <div class="black_screen1"></div>
        	<div class="formAreaNew cret_left">
            	
            	<span class="main_head">Edit Quote <div style="font-size: 16px;float:right;text-transform: none;color: #6c6c6c;">
				    <?php  if($details['contact_type'] != "") { ?>Contact Type: <?php echo getContactType($details['contact_type']); ?><?php  } ?>
					<?php  if($details['mode_of_contact'] != "") { ?>, Mode of Contact:<?php echo getmodeOFContact($details['mode_of_contact']); ?> <?php  } ?></div></span>
               
			    <ul class="bci_creat_first_quote1">
                    <li class="bb_post">
                    	<label>Quote For <em>*</em></label>
						<?php echo create_dd("quote_for","quote_for_option","id","name","status=1","onChange=\"javascript:edit_field(this,'quote_new.quote_for','".$_GET['quote_id']."');\"",$details);?>  
                    </li>
                    
      			    <li class="bb_post">
                    	<label>Post Code <em>*</em></label>
                        <input name="suburb" type="text" class="input_search" id="suburb" onKeyup="javascript:get_postcode_edit(this)" autocomplete="off" value="<? echo $details['suburb'];?>" />
                         <div class="clear"></div>
                        <div id="postcode_div" style="display:none;"></div>
                    </li>
                    <li>
                    	<label>Site Id <em>*</em></label>
                        <?php echo create_dd("site_id","sites","id","abv","","Onchange=\"updateSiteid(this.value);\"",$details);?>
                    </li>
                    <li>
                        <label>Job Date</label>
                         <div class="docs-datepicker">
                          <div class="input-group">
                            <?php /*?><input type="text" class="form-control docs-date" name="date" placeholder="Pick a date"><?php */
							// onChange="editcheckbooked(this.value,'<? echo $details['booking_date'];
							?>
                            <input name="booking_date" type="text" class="form-control docs-date" id="booking_date" value="<? echo get_field_value($details,"booking_date");?>">
                          </div>
                        </div>
                        <span></span>
                    </li>	
                     <li>
                    <div class="bt_check"><a href="javascript:void(0);" class="bc_click_btn">Check Availability</a></div>                    
                    </li>
                </ul>   
				
              
                <span class="main_head" style="margin-top: 30px;">Select Job Details</span>
					<span class="heading_area">
						<p class="sub_head">Job Type</p> 
							<?php		
				 
							 echo create_dd("job_type_id","job_type","id","name","","class=\"heading_drop\" onchange=\"javascript:show_data('job_type_id','54','show_add_item');editcheckjob_type(this.value);\"",$details);
							?>
						
						<input name="real_estate_id" type="hidden" placeholder="Enter real estate name..." class="input_search real_estate_field" id="real_estate_id"  value='0'/>
					</span>
				
                <div id="show_add_item" ></div>
		<div id="br_address" style="display:none;">	
			<?php 
							if(!empty($getjob_details) && $getjob_details != '') {
								
								$onclick_flour_from  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.is_flour_from','".$_GET['quote_id']."');checklevelform(this.value);\"";
								$onclick_flour_to  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.is_flour_to','".$_GET['quote_id']."');checklevelto(this.value);\"";
								$onclick_lift_from  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.is_lift_from','".$_GET['quote_id']."');\"";
								$onclick_lift_to  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.is_lift_to','".$_GET['quote_id']."');\"";
								$onclick_type_from  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.house_type_from','".$_GET['quote_id']."');\"";
								$onclick_type_to  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.house_type_to','".$_GET['quote_id']."');\"";
								$onclick_distance_from  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.door_distance_from','".$_GET['quote_id']."');\"";
								$onclick_distance_to  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.door_distance_to','".$_GET['quote_id']."');\"";
								
								$onclick_depot_to_job_time  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.depot_to_job_time','".$_GET['quote_id']."');\"";
								
								$onclick_travel_time  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.travel_time','".$_GET['quote_id']."');\"";
								
								$onclick_traveling  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.traveling','".$_GET['quote_id']."');\"";
								
								$onclick_loading_time  = "onChange=\"javascript:edit_quote_edit_field(this,'quote_new.loading_time','".$_GET['quote_id']."');\"";
							}else{
								$onclick_flour_from = "onChange=\"javascript:checklevelform(this.value);\"";
								$onclick_flour_to = "onChange=\"javascript:checklevelto(this.value);\"";
								$onclick_lift_from = '';
								$onclick_lift_to = '';
								$onclick_type_from = '';
								$onclick_type_to = '';
								$onclick_distance_from = '';
								$onclick_distance_to = '';
								$onclick_travel_time = '';
							}
						
						?> 
				<ul class="create_quote_lst_new_new create_quote_lst create_quote_lst_new" style="margin-left: 28px;">	
				
				   <li>
                    	<label>Moving From</label>
                       <input type="text" name="moving_from" for="<? echo $_GET['quote_id']?>" id="moving_from" style="height: 74px !important;" value="<? echo get_field_value($details,"moving_from");?>">
                    </li>
					
					<input type="hidden" id="moving_from_lat_long">
					<input type="hidden" id="moving_to_lat_long">
					
					<li>
                    	<label>Moving To</label>
                       <input type="text" name="moving_to" for="<? echo $_GET['quote_id']?>" id="moving_to" style="height: 74px !important;" value="<? echo get_field_value($details,"moving_to");?>">
                    </li>
					
				</ul>
			
				<ul class="create_quote_lst create_quote_lst_new" >
				
                    <li>
                    	<label>On Level From <em>*</em></label>
                        <span class="newSelectBox"><?php echo create_dd("is_flour_from","system_dd_br","id","name","type=1",$onclick_flour_from,$details) ;?></span>
                    </li>
                    
                    <li>
                    	<label>Has Lift/Elevator From</label>
                       <span class="newSelectBox"><?php echo create_dd("is_lift_from","system_dd_br","id","name","type=2",$onclick_lift_from,$details) ;?></span>
                    </li>					
					
					<li>
                    	<label>Home Type From<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("house_type_from","system_dd_br","id","name","type=3",$onclick_type_from,$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Door Distance From<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("door_distance_from","system_dd_br","id","name","type=4",$onclick_distance_from,$details) ;?></span>
                    </li>
                </ul>
				
				<ul class="create_quote_lst create_quote_lst_new" >
					
					<li>
                    	<label>On Level To<em>*</em></label>
                        <span class="newSelectBox"><?php echo create_dd("is_flour_to","system_dd_br","id","name","type=1",$onclick_flour_to,$details) ;?></span>
                    </li>
                   
					<li>
                    	<label>Has Lift/Elevator To</label>
                       <span class="newSelectBox"><?php echo create_dd("is_lift_to","system_dd_br","id","name","type=2",$onclick_lift_to,$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Home Type To<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("house_type_to","system_dd_br","id","name","type=3",$onclick_type_to,$details) ;?></span>
                    </li>
				
					<li>
                    	<label>Door Distance To<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("door_distance_to","system_dd_br","id","name","type=4",$onclick_distance_to,$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Day Time<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("travel_time","system_dd_br","id","name","type=5",$onclick_travel_time,$details) ;?></span>
                    </li>
                </ul>
				
		</div>		
							  
			<br/>	
				
				<span class="main_head" style="margin-top: 10px;">Quote  Details</span>
					<span class="heading_area-quote-details" id="bcic_job_type">
					    
					     
					     <!-- <div class="area-quote-details-main">
							<p class="sub_head long_text_size">lift at property </p> 
							<span><?php echo create_dd("lift_property","system_dd","id","name","type = 29","onChange=\"javascript:edit_field(this,'quote_new.lift_property','".$_GET['quote_id']."');\"",$details);?></span> 
						</div>	
						
						
						<div class="area-quote-details-main" style="width: 32%; !importent;">
							<p class="sub_head long_text_size">floor</p> 
							<input type="text" name="quote_floor" id="quote_floor"  onblur="javascript:edit_field(this,'quote_new.quote_floor','<? echo $_GET['quote_id']?>');"  style="background: #fff;border-radius: 5px;height: 30px;font-size: 14px;color: #6c6c6c;padding: 0px 4px;float: right;width: 40%;border: 1px solid #e8e7e7;margin-right: 0px;" value="<? echo get_field_value($details,"quote_floor");?>">	
						</div>	
						
						
						<div class="area-quote-details-main">
							<p class="sub_head long_text_size">Stains</p> 
							<span><?php echo create_dd("stains","system_dd","id","name","type = 29","onChange=\"javascript:edit_field(this,'quote_new.stains','".$_GET['quote_id']."');\"",$details);?></span> 
						</div>	 -->
					     
					
						  <div class="area-quote-details-main">
							<p class="sub_head long_text_size">White Goods</p> 
							<span><?php echo create_dd("white_goods","system_dd","id","name","type = 29","onChange=\"javascript:edit_field(this,'quote_new.white_goods','".$_GET['quote_id']."');\"",$details);?></span> 
						</div>	
						
						
						<div class="area-quote-details-main">
						   <p class="sub_head long_text_size">Parking</p> 
						   <span><?php echo create_dd("parking","system_dd","id","name","type = 141","onChange=\"javascript:edit_field(this,'quote_new.parking','".$_GET['quote_id']."');\"",$details);?></span>
                        </div>						

						<div class="area-quote-details-main">
							<p class="sub_head long_text_size"> Would you like a removal quote .?</p>
							 <span>
									<?php echo create_dd("have_removal","system_dd","id","name","type = 90","onChange=\"javascript:edit_field(this,'quote_new.have_removal','".$_GET['quote_id']."');\"",$details);?>
							</span>
						</div>
						
						<div class="area-quote-details-main">
						    <p class="sub_head long_text_size">Pets on Property </p> 
						   <span><?php echo create_dd("pets_property","system_dd","id","name","type = 29","onChange=\"javascript:edit_quote_edit_field(this,'quote_new.pets_property','".$_GET['quote_id']."');\"",$details);?></span> 
                       </div>						
						
						<div class="area-quote-details-main">
							<p class="sub_head long_text_size">How long you have lived in the property? </p>
							<span><?php echo create_dd("lived_property","system_dd","id","name","type = 120","onChange=\"javascript:edit_quote_edit_field(this,'quote_new.lived_property','".$_GET['quote_id']."');\"",$details);?></span>
						  </div>	

                     <div class="area-quote-details-main">
                        <p class="sub_head long_text_size">How much Bond are we aiming to secure? </p> 
						<span><?php echo create_dd("bond_amiming","system_dd","id","name","type = 118","onChange=\"javascript:edit_quote_edit_field(this,'quote_new.bond_amiming','".$_GET['quote_id']."');\"",$details);?></span>
					 </div>		
					 
					<div class="area-quote-details-main">
                        <p class="sub_head long_text_size">Client Type </p> 
						 <span><?php echo create_dd("client_type","system_dd","id","name","type = 105 ","class=\"heading_drop\" onchange=\"javascript:edit_field(this,'quote_new.client_type','".$_GET['quote_id']."');check_real_estate_details(this.value);\"",$details);?></span>  
					</div>
						
			    <div class="client_list_input" id="show_real_estate" style="display:none;">	
					  <ul class="bci_creat_first_quote  realestatedetails"  >
							<li>
								<label>Agency Name</label>
							   <input type="text" name="agency_name" id="agency_name"  <?php  if($job_id != 0) {echo  'disabled';  ?> style="background: #f0ebeb;" <?php  } ?>  onblur="javascript:edit_field(this,'quote_new.agency_name','<? echo $_GET['quote_id']?>');"  value="<? echo get_field_value($details,"agency_name");?>">						
							</li>
							
							<li>
								<label>Agent Name</label>
							   <input type="text" name="agent_name" id="agent_name" <?php  if($job_id != 0) {echo  'disabled';  ?> style="background: #f0ebeb;" <?php  } ?>  onblur="javascript:edit_field(this,'quote_new.agent_name','<? echo $_GET['quote_id']?>');"   value="<? echo get_field_value($details,"agent_name");?>">						
							</li>
							
							<li>
								<label>Agent Number:</label>
							   <input type="text" name="agent_number" onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required title="Please enter 10 digits" id="agent_number" <?php  if($job_id != 0) {echo  'disabled';  ?> style="background: #f0ebeb;" <?php  } ?>  onblur="javascript:edit_field(this,'quote_new.agent_number','<? echo $_GET['quote_id']?>');"  value="<? echo get_field_value($details,"agent_number");?>">						
							</li>
							
							<li>
								<label>Agent Email:</label>
							   <input type="text" name="agent_email" id="agent_email" <?php  if($job_id != 0) {echo  'disabled';  ?> style="background: #f0ebeb;" <?php  } ?> onblur="javascript:edit_field(this,'quote_new.agent_email','<? echo $_GET['quote_id']?>');"  value="<? echo get_field_value($details,"agent_email");?>">						
							</li>
							
							<li>
								<label>Agent LandLine No:</label>
							   <input type="text" name="agent_landline_num" id="agent_landline_num"  <?php  if($job_id != 0) {echo  'disabled';  ?> style="background: #f0ebeb;" <?php  } ?>  onblur="javascript:edit_field(this,'quote_new.agent_landline_num','<? echo $_GET['quote_id']?>');"  value="<? echo get_field_value($details,"agent_landline_num");?>">						
							</li>
							
							<li>
								<label>Agent address</label>
							   <input type="text" name="agent_address" id="agent_address" <?php  if($job_id != 0) {echo  'disabled';  ?> style="background: #f0ebeb;" <?php  } ?>  onblur="javascript:edit_field(this,'quote_new.agent_address','<? echo $_GET['quote_id']?>');"  value="<? echo get_field_value($details,"agent_address");?>">						
							</li>
						
				        </ul>		
				 </div>		
											
					</span>
				
                <br />
				
			
				
		
	 			
                <span class="main_head">Personal Details</span>
                <ul class="create_quote_lst">
                    <li>
                    	<label>Name <em>*</em></label>
                        <input name="name" type="text" id="name" size="45" value="<? echo get_field_value($details,"name");?>" onblur="javascript:edit_field(this,'quote_new.name','<? echo $_GET['quote_id']?>');">
                    </li>
					
					<li><label>Email</label>
                        <input name="email" type="text" id="email" value="<? echo get_field_value($details,"email");?>" size="55" onblur="javascript:edit_field(this,'quote_new.email','<? echo $_GET['quote_id']?>');">
                    </li>
					
					<!--<li>
                    	<label>Reference</label>
                        <span><?php echo create_dd("job_ref","system_dd","name","name","type=28","onblur=\"javascript:edit_field(this,'quote_new.job_ref','".$_GET['quote_id']."');\"",$details);?></span>
                    </li>-->
					
					<li>
                    	<label>Phone <em>*</em></label>
                        <input name="phone" type="text" id="phone" onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required title="Please enter 10 digits" value="<? echo get_field_value($details,"phone");?>" size="45" onblur="javascript:edit_field(this,'quote_new.phone','<? echo $_GET['quote_id']?>');">
                    </li>
					
					
					
                   <li class="quote_address">
                    	<label>Address</label>
						<input type="button" value="Save Add" style="width: 76px;margin-top: 43px;background: #ECCFD2;cursor: pointer;" onclick="save_address('<?php echo $_GET['quote_id']; ?>');">
						<span id="searchBoxContainer"></span>
						<input type="text" for="<? echo $_GET['quote_id']?>"  id="address" style="width: 49%;height: 60px;"  value="<? echo get_field_value($details,"address");?>">
						
						<!--<textarea name="address" for="<? echo $_GET['quote_id']?>" cols="45" rows="3" id="address" onblur="javascript:edit_field(this,'quote_new.address','<? echo $_GET['quote_id']?>');"><? echo get_field_value($details,"address");?></textarea>-->
						
						
                    </li>
				
					
                    <li class="offsetLargeNag">
                    	<label>Comments</label>
                        <textarea style="height: 126px;" name="comments" cols="45" rows="3" id="comments" onblur="javascript:edit_field(this,'quote_new.comments','<? echo $_GET['quote_id']?>');" ><? echo get_field_value($details,"comments");?></textarea>
						
						<input name="lat_long" type="hidden" id="lat_long" >
						<input name="quote_id" type="hidden" id="quote_id_edit"  value="<? echo $_GET['quote_id']?>">
                    </li>

					 <?php if($details['job_ref'] != 'Crm') { ?>
                    <li>
                        <label>Reference</label>
                        <span class="newSelectBox"><?php echo create_dd("job_ref","system_dd","name","name","type=28","onChange=\"javascript:getstaffname(this,'quote_new.job_ref','".$_GET['quote_id']."');\"",$details);?></span>
                    </li>
					 <?php  } ?>
                    
                    
					
					<li>
						<label>Best time to contact</label>
						<span>
							<select name="best_time_contact" onchange="javascript:edit_quote_edit_field(this,'quote_new.best_time_contact','<?php echo $_GET['quote_id']; ?>')"  id="best_time_contact">
								<option value=''>Select</option>
								  <?php  
									//$minutes = get_minutes('07:30', '18:00');   
									$minutes = get_minutes('07:30', '17:30');  
									//print_r($minutes);
									
									//print_r
									 foreach($minutes as $key=>$minute) {
										 //$selected = '';
										if(($details['best_time_contact'] == $minute)) { $selected = 'selected'; }else { $selected = '';} 
									   echo '<option value='.$minute.' '.$selected.'>'.$minute .'</option>';  
									}   
								  ?>
											
							</select>
						</span>
					</li>
					<li  style="display:none;"  class="edit_staff_list">
                        <label>BCIC Staff</label>
                        <span class="newSelectBox"><?php echo create_dd("referral_staff_name","staff","id","name","status=1 AND better_franchisee = 1 Order by name","onChange=\"javascript:edit_field(this,'quote_new.referral_staff_name','".$_GET['quote_id']."');\"", $details);?></span>
                    </li>
                    
                    <li  style="display:none;" class="edit_better_staff_list">
						<label>BFG Staff</label>
						<span class="newSelectBox"><?php echo create_dd("referral_staff_name","staff","id","name","status=1 AND better_franchisee = 2 Order by name","onChange=\"javascript:edit_field(this,'quote_new.referral_staff_name','".$_GET['quote_id']."');\"", $details);?></span>
					</li>
					
                    
                </ul>
				
				
				
				
              
				
        	</div>
            
            <div class="cret_right">
				<div id="quote_div">
					<?php 
					echo edit_quote_str($_SESSION['edit_quote_id']);
					?>
				</div>
                <div id="quote_div2">
					
				</div>
				
					<div id="quote_div3">
					
						
					</div>
            </div>
        </div>
		</form>
    </div>
</div>

<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNbPo9LhGJDYCNL89pu2DXmqT9Bbg_3Gg&amp;libraries=places" type="text/javascript"></script>-->
 <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYWS1g-S0kOegy8SA1bjImzVMBi9qqmww&amp;libraries=places" type="text/javascript"></script>-->
 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo&amp;libraries=places" type="text/javascript"></script>
<!--<script language="JavaScript" src="jscripts/googleapis_map.js"></script>-->
<script language="JavaScript" src="jscripts/google_address_kit.js"></script>
<script language="JavaScript" src="jscripts/get_address.js"></script>


  <!--<script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=AtzLXzCRLu1l2ZKArO20gUULTyrBH5lkdQzctKD_WFMa0t3eVU8TNsBqFFS8EzvA&callback=loadMapScenario' async defer></script>
  <script language="JavaScript" src="jscripts/address_search.js"></script>-->

<p>&nbsp;</p>
<script type="text/javascript">
$(function() {
			  $("#inspection_date").datepicker({dateFormat:'yy-mm-dd'});
			  
        });
</script>
<script>

$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

	$(document).ready(function(e) {
		 <?php  if($details['client_type'] == 2) { ?>
		   check_real_estate_details('<?php  echo $details['client_type']; ?>');
		 <?php  } ?>
		
		$(this).click(function(e) {
			$("#postcode_div").fadeOut(500);		
		});
    });
</script>
