 <? 
 unset($_SESSION['temp_quote_id'],$_SESSION['quote_id'], $_SESSION['temp_quote']);
 $details['booking_date']="0000-00-00";
 $details['email']="quote@bcic.com.au";
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
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
	  
	  /* bcic_job_type 
				bbc_job_type
				br_job_type */
	    function showJobdetails(id){
			$('#show_add_item').empty();
			if(id == 1){
				$('#bcic_job_type').show(); 
				$('#bbc_job_type').hide(); 
				$('#br_job_type').hide(); 
			}else if(id == 2){
				$('#bcic_job_type').hide(); 
				$('#bbc_job_type').show(); 
				$('#br_job_type').hide(); 
			}else if(id == 3) {
				$('#bcic_job_type').hide(); 
				$('#bbc_job_type').hide(); 
				$('#br_job_type').show(); 
			}
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
                    
					<?php // echo create_dd("quote_for","system_dd","id","name","type=41","onchange=\"javascript:showJobdetails(this.value);\"",$details); ?>
					
					<li class="bb_post">
                    	<label>Quote For <em>*</em></label>
						<?php echo str_replace( '<option value="0">Select</option>', '', create_dd("quote_for","quote_for_option","id","name","status=1","onchange=\"javascript:show_quote_type(this.value);\"",$details) );?>  
                     </li>
               

  				    <li class="bb_post">
                    	<label>Post Code <em>*</em></label>
                        <?php /*?><input class="input_search" name="suburb" type="text" id="suburb" value="<? echo get_field_value($details,"postcode");?>" onKeyUp="javascript:get_postcode(this);" autocomplete="off"><?php */?>
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
                            <?php /*?><input type="text" class="form-control docs-date" name="date" placeholder="Pick a date"><?php */
							//onChange="checkquotebooked(this.value);"
							?>
                            <input name="booking_date" type="text" class="form-control docs-date"  id="booking_date" value="<? echo get_field_value($details,"booking_date");?>">
                          </div>
                        </div>
                        <span></span>
                    </li>	
                    <li>
                     <div class="bt_check"><a href="javascript:void(0);" class="bc_click_btn">Check Availability</a></div>                    
                    </li>
                </ul>
				
				 
				
				
					<span class="main_head">Select Job Details</span>
					<span class="heading_area" id="bcic_job_type">
						<p class="sub_head">Job Type</p> 
						<span><?php echo create_dd("job_type_id","job_type","id","name","","class=\"heading_drop\" onchange=\"javascript:show_data('job_type_id','46','show_add_item');\"",$details);?></span>            
					</span>
					
					<span class="heading_area" id="br_job_type" style="display:none;">
						<p class="sub_head">Better Removals Job Type</p> 
						<span><?php echo create_dd("br_job_type_id","br_inventory_type","id","name","status=1","class=\"heading_drop\" onchange=\"javascript:show_data('br_job_type_id','83','show_add_item');\"",$details) ;?></span>                   
					</span>
					
					<span class="heading_area" id="bbc_job_type" style="display:none;">
						<p class="sub_head">Better Bond Cleaning Job Type</p> 
						<span><?php echo create_dd("bbc_job_type_id","bbc_job_type","id","name","type=2","class=\"heading_drop\" onchange=\"javascript:show_data('bbc_job_type_id','82','show_add_item');\"",$details) ;?></span>                    
					</span>
				
                <div id="show_add_item" style="min-height:100px;"></div>
				
                <br />
                <span class="main_head">Personal Details</span>
                <ul class="create_quote_lst">
				
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
				
			<div id="moving_details" style="display:none;">	
				<span class="main_head">Moving <==> Details</span>
                <ul class="create_quote_lst">
				
				    <li>
                    	<label>Moving From</label>
                       <input type="text" name="moving_from" id="moving_from" style="width: 70%;height: 74px;" value="<? echo get_field_value($details,"moving_from");?>">
						
                    </li>
					
					
					<li>
                    	<label>Moving To</label>
                       <input type="text" name="moving_to" id="moving_to" style="width: 70%;height: 74px;" value="<? echo get_field_value($details,"moving_to");?>">
						
                    </li>
					
					 
                    <li>
                    	<label>On Level From <em>*</em></label>
                        <span class="newSelectBox"><?php echo create_dd("is_flour_from","system_dd_br","id","name","type=1","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>On Level To<em>*</em></label>
                        <span class="newSelectBox"><?php echo create_dd("is_flour_to","system_dd_br","id","name","type=1","",$details) ;?></span>
                    </li>
                    
                    <li>
                    	<label>Has Lift/Elevator From</label>
                       <span class="newSelectBox"><?php echo create_dd("is_lift_from","system_dd_br","id","name","type=2","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Has Lift/Elevator To</label>
                       <span class="newSelectBox"><?php echo create_dd("is_lift_to","system_dd_br","id","name","type=2","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Home Type From<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("house_type_from","system_dd_br","id","name","type=3","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Home Type To<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("house_type_to","system_dd_br","id","name","type=3","",$details) ;?></span>
                    </li>
					
					
					<li>
                    	<label>Door Distance From<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("door_distance_from","system_dd_br","id","name","type=4","",$details) ;?></span>
                    </li>
					
					<li>
                    	<label>Door Distance To<em>*</em></label>
                       <span class="newSelectBox"><?php echo create_dd("door_distance_to","system_dd_br","id","name","type=4","",$details) ;?></span>
                    </li>
					
                </ul>
			</div>	
                
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
</script>

	<style>
		#map {
		 height: 100%;
		}

		html, body {
		height: 100%;
		margin: 0;
		padding: 0;
		}

		.gm-style > div:nth-child(10){
		  display:none;
		}
    </style>
	
  <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNbPo9LhGJDYCNL89pu2DXmqT9Bbg_3Gg&libraries=places" type="text/javascript"></script>-->
  <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYWS1g-S0kOegy8SA1bjImzVMBi9qqmww&amp;libraries=places" type="text/javascript"></script>-->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo&amp;libraries=places" type="text/javascript"></script>
  <!--<script language="JavaScript" src="jscripts/googleapis_map.js"></script>-->
  <script language="JavaScript" src="jscripts/google_address_kit.js"></script>