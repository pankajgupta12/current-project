<? 
 unset($_SESSION['temp_quote_id'],$_SESSION['quote_id'], $_SESSION['temp_quote']);
 $details['booking_date']="0000-00-00";
 $details['email']="quote@bcic.com.au";
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
 
 $details['travel_time'] = 1;
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
	});
	
	  $( function() {
		$( "#jobdate" ).datepicker();
		$( "#inspectdate" ).datepicker();
	  } );		  
	  
	  $(document).ready(function(e) {
			$('.menu').click(function(e) {
			$('.main_menu').slideToggle(700);    
			});
	  });
	  
	  
		function br_moving_details(id){
			//alert(id);
			if(id == 3) {
			  $('#moving_details').show();
			}else{
			  $('#moving_details').hide();	
			 
			}
			
		}
		
		function checkjob_type(id){
			if(id == 11) {
				$('#br_address').show();
				$('.br_check_avail').show();
			}else{
			  $('#br_address').hide();	
			  $('.br_check_avail').hide();
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
		
		function getDate(date){
			//alert(date);
			$('#job_date').val(date);
		}
	  
</script>


<div class="body_container">
	<div class="body_back">
		<form method="post" id="form" onsubmit="return validate_quote();">
    	<div class="wrapper">
		<div class="black_screen1" ></div>
        <div class="black_screen2" ></div>
        	<div class="formAreaNew cret_left">
            	
            	<span class="main_head">Create Quote <span style="float:right"><a href="javascript:send_data('<?php echo $_SESSION['edit_quote_id'];?>',58,'quote_div');">Refresh >></a></span></span>
                
                
                <ul class="bci_creat_first_quote1">
					
					<li class="bb_post">
                    	<label>Quote For <em>*</em></label>
						<?php echo str_replace( '<option value="0">Select</option>', '', create_dd("quote_for","quote_for_option","id","name","status=1","onchange=\"javascript:br_moving_details(this.value);\"",$details) );?>  
                    </li>
               

  				    <li class="bb_post">
                    	<label>Post Code <em>*</em></label>
                        <input name="suburb" type="text" placeholder="enter suburb or postcode..." class="input_search" id="suburb" onKeyup="javascript:get_postcode(this)" autocomplete="off" value="<? echo get_field_value($details,"postcode");?>" />
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
                            <input name="booking_date" type="text" class="form-control docs-date"  onChange="getDate(this.value);" id="booking_date" value="<? echo get_field_value($details,"booking_date");?>">
                          </div>
                        </div>
                        <span></span>
                    </li>	
					
                    <li>
                     <div class="bt_check"><a href="javascript:void(0);" class="bc_click_btn">Check Availability</a></div>                    
                    </li>
                </ul>
				
				<!--<ul class="bci_creat_first_quote1" style="width: 270px;">

  				    <li class="bb_post">
                    	<label>Real Estate Name</label>
                        <input name="real_estate_id" type="text" placeholder="Enter real estate name..." class="input_search" id="real_estate_id" onKeyup="javascript:get_real_estate_name(this)" autocomplete="off" value="<? echo get_field_value($details,"real_estate_id");?>" />
                         <div class="clear"></div>

                        <div id="real_estate_name_div" style="display:none;"></div>
                    </li>
				</ul>-->
				
				<span class="main_head" style="margin-top: 10px;">Quote  Details</span>
					<span class="heading_area" id="bcic_job_type">
					
						<p class="sub_head">White Goods</p> 
						<span><?php echo create_dd("white_goods","system_dd","id","name","type = 29","",$details);?></span>  	
						
						
						<p class="sub_head">Parking</p> 
						<span><?php echo create_dd("parking","system_dd","id","name","type = 54","",$details);?></span>  	

						
						<p style="font-size: 12px;font-weight: 600;color: #00b8d4;padding-left: 11px;padding-right: -29px;">( Have You booked your removal )</p>
						<div class="real_estate_searchingbox"> 
						    <?php echo create_dd("have_removal","system_dd","id","name","type = 40","",$details);?>
						</div>
						
											
					</span>
				
				
					<span class="main_head" style="margin-top: 40px;">Select Job Details</span>
					<span class="heading_area" id="bcic_job_type">
					
						<p class="sub_head">Job Type</p> 
						<span><?php echo create_dd("job_type_id","job_type","id","name","","class=\"heading_drop\" onchange=\"javascript:show_data('job_type_id','46','show_add_item');checkjob_type(this.value);\"",$details);?></span>  	

                        <!--<div class="real_estate_searchingbox"> 
							<p class="sub_head">Real Estate Name</p> 
							<input name="real_estate_id" type="text" placeholder="Enter real estate name..." class="input_search real_estate_field" id="real_estate_id" onKeyup="javascript:get_real_estate_name(this)" autocomplete="off" value="<? echo get_field_value($details,"real_estate_id");?>" />
							<div class="clear"></div>
							<div id="real_estate_name_div" style="display:none;"></div>			
	                    </div>-->
						<input name="real_estate_id" type="hidden" placeholder="Enter real estate name..." class="input_search real_estate_field" id="real_estate_id"  value='0'/>
						
						
						
						
							<!--<input name="job_date" type="text" class="form-control docs-date" style="margin-left: 344px;" id="job_date" value="<? //echo get_field_value($details,"booking_date");?>">

							<div class="bt_check br_check_avail" id="br_check_avail"  style="margin-left: 18px;display:none;"><a href="javascript:void(0);" class="bc_click_btn">Removal Check Availability</a></div>-->  							
					</span>
					
					
					
					<input name="quote_id1" type="hidden" id="quote_id_edit"  value="0">
                <div id="show_add_item" style="min-height:40px;"></div>
			<div  id="br_address" style="display:none;">
			
				 <ul class="create_quote_lst_new_new create_quote_lst create_quote_lst_new" style="margin-left: 28px;">
						<li>
							<label>Moving From</label>
						   <input type="text" name="moving_from" id="moving_from" style="width: 70%;height: 74px;" value="<? echo get_field_value($details,"moving_from");?>">						
						</li>
						
						<li>
							<label>Moving To</label>
						   <input type="text" name="moving_to" id="moving_to" style="width: 70%;height: 74px;" value="<? echo get_field_value($details,"moving_to");?>">
							
						</li>
						
						
						<input type="hidden" id="moving_from_lat_long">
						<input type="hidden" id="moving_to_lat_long">
						
				</ul>		
			
			
				<ul class="create_quote_lst create_quote_lst_new">
					 
                    <li>
                    	<label>On Level From <em>*</em></label>
                        <span class="newSelectBox"><?php echo create_dd("is_flour_from","system_dd_br","id","name","type=1","Onchange=\"checklevelform(this.value);\"",$details) ;?></span>
                    </li>
                    
                    <li>
                    	<label>Has Lift/Elevator From</label>
                       <span class="newSelectBox"><?php echo create_dd("is_lift_from","system_dd_br","id","name","type=2","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Home Type From<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("house_type_from","system_dd_br","id","name","type=3","",$details) ;?></span>
                    </li>
					
					
					<li>
                    	<label>Door Distance From<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("door_distance_from","system_dd_br","id","name","type=4","",$details) ;?></span>
                    </li>
                </ul>
				
				<ul class="create_quote_lst create_quote_lst_new">
					
					<li>
                    	<label>On Level To<em>*</em></label>
                        <span class="newSelectBox"><?php echo create_dd("is_flour_to","system_dd_br","id","name","type=1","Onchange=\"checklevelto(this.value);\"",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Has Lift/Elevator To</label>
                       <span class="newSelectBox"><?php echo create_dd("is_lift_to","system_dd_br","id","name","type=2","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Home Type To<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("house_type_to","system_dd_br","id","name","type=3","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Door Distance To<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("door_distance_to","system_dd_br","id","name","type=4","",$details) ;?></span>
                    </li>
					
					<li class="create_quote_lst_new1">
                    	<label>Day Time <em>*</em></label>
					   <span class="newSelectBox"><?php echo create_dd("travel_time","system_dd_br","id","name","type=5","",$details) ;?></span>
                    </li>
					
					<div class="bb_add" ><input style="margin-left: 333px;" type="button" class="frm_btn" value="Add" onclick="javascript:add_quote_item(11);"></div>
					
                </ul>
		</div>		
				
                <br />
				
				
                <span class="main_head">Personal Details</span>
                <ul class="create_quote_lst ">
				
                    <li>
                    	<label>Name <em>*</em></label>
                        <input name="name" type="text" id="name" size="45" value="<? echo get_field_value($details,"name");?>">
                    </li>
                    
                    <li>
                    	<label>Email </label>
                        <input name="email" type="text" id="email" value="<? echo get_field_value($details,"email");?>" size="55">
                    </li>
					<li>
                    	<label>Phone <em>*</em></label>
                        <input name="phone" type="text" id="phone" onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required title="Please enter 10 digits"  value="<? echo get_field_value($details,"phone");?>" size="45">
                    </li>
					 <li style="display:none;" class="staff_list">
						<label></label>
					</li>
					
                   				
                    <li>
                    	<label>Address</label>
                        <!--<textarea name="address" cols="45" rows="3" id="address"><? echo get_field_value($details,"address");?></textarea>-->
						<input type="text" name="address" id="address" style="width: 70%;height: 74px;" value="<? echo get_field_value($details,"address");?>">
						
                    </li>
                    <li class="offsetLargeNag">
                    	<label>Comments</label>
                        <textarea style="height: 126px;" name="comments" cols="45" rows="3" id="comments"><? echo get_field_value($details,"comments");?></textarea>
						
						<input name="lat_long" type="hidden" id="lat_long" value="" />
                    </li>
					
					
                    <li>
                    	<label>Reference</label>
                        <span class="newSelectBox"><?php echo create_dd("job_ref","system_dd","name","name","type=28","onchange=\"javascript:showstafflisting(this.value);\"",$details) ;?></span>
                    </li>	
					<li  style="display:none;" class="staff_list">
						<label>BCIC Staff</label>
						<span class="newSelectBox"><?php echo create_dd("staff_id","staff","id","name","status=1 AND better_franchisee = 1 Order by name","", $details);?></span>
					</li>
					
					<li  style="display:none;" class="better_staff_list">
						<label>BFG Staff</label>
						<span class="newSelectBox"><?php echo create_dd("better_staff_id","staff","id","name","status=1 AND better_franchisee = 2 Order by name","", $details);?></span>
					</li>
				
                </ul>
                
				<div id="map" style="display:none;"></div>
        	</div>
			
            <div class="cret_right" id="myModal">
				<div id="quote_div">
					
				</div>
                <div id="quote_div2">
					
				</div>
				 <div id="quote_div3">
					
				</div>
				<!--<a href="#" class="bok_now"><i class="fa fa-briefcase" aria-hidden="true"></i>Book Now</a>-->
            </div>
        </div>
		</form>
    </div>
</div>



<p>&nbsp;</p>
<script type="text/javascript">
$(function() {
			  $("#inspection_date").datepicker({dateFormat:'yy-mm-dd'});
        });
        
		
		 
</script>

<script>

var place;
var address;
var latitude;
var longitude;
var mesg;

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
    $(this).click(function(e) {
        $("#postcode_div").fadeOut(500);		
    });
});

function get_blinds_type(id){
	
	if(id == 'Venetians' || id == 'Shutters') {
		$('#blinds_number_value').show();
	}else{
	  $('#blinds_number_value').hide();	
	}
}


</script>


	
  <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNbPo9LhGJDYCNL89pu2DXmqT9Bbg_3Gg&libraries=places" type="text/javascript"></script>-->
  <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYWS1g-S0kOegy8SA1bjImzVMBi9qqmww&amp;libraries=places" type="text/javascript"></script>-->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo&amp;libraries=places" type="text/javascript"></script>
  <!--<script language="JavaScript" src="jscripts/googleapis_map.js"></script>-->
  <script language="JavaScript" src="jscripts/google_address_kit.js"></script>
  <script language="JavaScript" src="jscripts/get_address.js"></script>