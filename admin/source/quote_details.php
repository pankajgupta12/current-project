<?
if($_REQUEST['quote_id']!=""){ 
$quote_data = mysql_query("select * from quote where id=".mysql_real_escape_string($_REQUEST['quote_id'])."");
$details = mysql_fetch_array($quote_data);
?>

<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
 <? 
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
 ?>
 
<!--<script src="../../jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../../jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<link href="../../jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../../jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../../jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->

<script>
 
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
	
</script>

<form method="post" id="form" onsubmit="return validate_quote();">
<div id="tab-2">
    <div class="body_back">
    	<div class="wrapper">
        	<div class="cret_left">
            	<form>
            	<span class="main_head">Edit Quote</span>
                <span class="main_para">May I know how many bedrooms and bathrooms are there in the property?</span>
               <ul class="create_quote_lst">
                	<li>
                    	<label>Suburb</label>
                        <input name="suburb" type="text" id="suburb" value="<? echo get_field_value($details,"suburb");?>" size="55" onKeyUp="javascript:get_postcode(this);">
                        <div id="postcode_div"></div>
                    </li>
                    <li>
                    	<label>Site Id</label>
                        <span><?php echo create_dd("site_id","sites","id","name","","",$details);?></span>
                    </li>
                					
                    <li>
                    	<label>Name</label>
                        <input name="name" type="text" id="name" size="45" value="<? echo get_field_value($details,"name");?>">
                    </li>
                    <li>
                    	<label>Phone</label>
                        <input name="phone" type="text" id="phone" value="<? echo get_field_value($details,"phone");?>" size="45">
                    </li>
                    <li>
                    	<label>Email</label>
                        <input name="email" type="text" id="email" value="<? echo get_field_value($details,"email");?>" size="55">
                    </li>
                    <li>
                    	<label>Reference</label>
                        <span><?php echo create_dd("job_ref","system_dd","name","name","type=28","",$details);?></span>
                    </li>	
                    <li>
                    	<label>Address</label>
                        <textarea name="address" cols="45" rows="3" id="address"><? echo get_field_value($details,"address");?></textarea>
                    </li>
                    <li>
                    	<label>Comments</label>
                        <textarea name="comments" cols="45" rows="3" id="comments"><? echo get_field_value($details,"comments");?></textarea>
                    </li>
                </ul>
                <div class="sect_2">
                	<span class="main_head">Cleaning Details</span>
                    <ul class="create_quote_lst create_quote_lst2">
                        <li>
                            <label>Bed</label>
                            <input name="bed" type="text" id="bed" value="<? echo get_field_value($details,"bed");?>" >
                        </li>
                        <li>
                            <label>Bath</label>
                            <input name="bath" type="text" id="bath" value="<? echo get_field_value($details,"bath");?>" >
                        </li>
                        <li>
                            <label>Job Date</label>
                            <span><input name="booking_date" type="text" id="booking_date" value="<? echo get_field_value($details,"booking_date");?>"></span>
                        </li>
                        <li>
                            <label>Inspection Date</label>
                            <span><input name="inspection_date" type="text" id="inspection_date" value="<? echo get_field_value($details,"inspection_date");?>"></span>
                        </li>
                    </ul>
                    <ul class="clean_lst">
                    	<li>
                        	<label>Furnished </label>
                            <span>
							<? echo create_dd("furnished","system_dd","name","name","type=18","",$details); ?>
                            <?php /*?><select name="furnished" id="furnished">
                            <option <? if($_POST['furnished']=="No"){ echo "selected"; } ?> value="No">No</option>
                            <option <? if($_POST['furnished']=="Yes"){ echo "selected"; } ?> value="Yes">Yes</option>
                            </select><?php */?>
                            </span>
                        </li>
                    	<li>
                        	<label>House Type </label>
                            <span>
                            <select name="property_type" id="property_type">
                            <option <? if(get_field_value($details,"property_type")=="Unit"){ echo "selected"; } ?> value="Unit">Unit</option>
                            <option <? if(get_field_value($details,"property_type")=="House"){ echo "selected"; } ?> value="House"> House</option>
                            <option <? if(get_field_value($details,"property_type")=="Duplex"){ echo "selected"; } ?> value="Duplex">Duplex</option>
                            <option <? if(get_field_value($details,"property_type")=="Two Story"){ echo "selected"; } ?> value="Two Story">Two Story</option>
                            </select>
                            </span>
                        </li>
                    	<li>
                        	<label>Blinds</label>
                            <span>
                            <select name="blinds_type" id="blinds_type">
                            <option <? if(get_field_value($details,"blinds_type")=="No Blinds"){ echo "selected"; } ?> value="No Blinds">No Blinds</option>
                            <option <? if(get_field_value($details,"blinds_type")=="Verticals"){ echo "selected"; } ?> value="Verticals">Verticals</option>
                            <option <? if(get_field_value($details,"blinds_type")=="Venetians"){ echo "selected"; } ?> value="Venetians">Venetians(wooden)</option>
                            <option <? if(get_field_value($details,"blinds_type")=="Roller Blinds"){ echo "selected"; } ?> value="Roller Blinds">Roller Blinds</option>
                            </select>
                            </span>
                        </li>
                    </ul>
				</div>
                <div class="sect_2">
                	<span class="main_head">Carpet Area</span>
                    <ul class="create_quote_lst create_quote_lst2">
                        <li>
                            <label>Carpet</label>
                            <span>
							<? echo create_dd("carpet","system_dd","name","name","type=18","",$details); ?>
                            <?php /*?> <select name="carpet" id="carpet">
                            <option <? if(get_field_value($details,"carpet")=="No"){ echo "selected"; } ?> value="No">No</option>
                            <option <? if(get_field_value($details,"carpet")=="Yes"){ echo "selected"; } ?> value="Yes">Yes</option>
                            </select><?php */?>                            
                            </span>
                        </li>
                        <li>
                            <label>Bed</label>
                            <input name="c_bedroom" type="text" id="c_bedroom" value="<? echo get_field_value($details,"c_bedroom");?>">
                        </li>
                        <li>
                            <label>Lounge</label>
                            <span>
							 <? echo create_dd("c_lounge","system_dd","name","name","type=18","",$details); ?>
                            <?php /*?><select name="c_lounge" id="c_lounge">
                            <option <? if($_POST['c_lounge']=="No"){ echo "selected"; } ?> value="No">No</option>
                            <option <? if($_POST['c_lounge']=="Yes"){ echo "selected"; } ?> value="Yes">Yes</option>
                            </select><?php */?></span>
                        </li>
                        <li>
                            <label>Stairs:</label>
                          	<input name="c_stairs" type="text" id="c_stairs" value="<? echo get_field_value($details,"c_stairs");?>">
                        </li>
                    </ul>
                    <input name="button2" type="button" class="frm_btn" id="button2" value="Get Quote" onClick="javascript:get_quote();">
				</div>
                
        	</div>
            <div class="cret_right" >
            	
                	<div id="quote_div">
                    <ul class="frm_rght_lst">
                    	<li>
                        	<label>Number of Hours</label>
                        	<input name="cleaning_hours" type="text" id="cleaning_hours" 
      value="<? echo get_field_value($details,"cleaning_hours");?>" onchange="javascript:recalc_quote('cleaning_hours');">
                        </li>
                        <li>
                        	<label>Per Hour</label>
                        	<input name="per_hour" type="text" id="per_hour" 
      value="<? echo get_field_value($details,"per_hour");?>" onchange="javascript:recalc_quote('cleaning_hours');">
                        </li>
						 <?php
							$other_types = mysql_query("Select * from job_type");
							while($r = mysql_fetch_assoc($other_types)){
							echo '
								<li>
									<label>'.$r['name'].' Amount</label>
									<input name="'.strtolower($r['name']).'_amount" type="text" id="'.strtolower($r['name']).'_amount" 
									value="'.get_field_value($details,strtolower($r['name']).'_amount').'"  onchange="javascript:recalc_quote(\''.strtolower($r['name']).'_amount\',\''.$_REQUEST['quote_id'].'\');">
								</li>';
							
							
							}
                        ?>
                        <li>
                        	<label>Total Amount</label>
                        	<input name="amount" type="text" id="amount" value="<? echo get_field_value($details,"amount");?>">
                        </li>
                    </ul>
                   </div>

                  <input name="button" type="submit" class="frm_btn" id="button" value="Save Quote">
                  <input type="hidden" name="step" id="step" value="1">
                  <input type="hidden" name="task" id="task" value="edit_quote">
                  <input type="hidden" name="quote_id" id="quote_id" value="<?php echo $_REQUEST['quote_id'];?>">
          
          
				 <?php if($details['booking_id']=="0"){  ?>
                  <tr class="table_cells">
                    <td  align="center" class="table_cells">
                    
<?php /*?>                    <input name="button3" type="button" class="fcontrol" id="button3" value="Send Quote Email" onclick="javascript:scrollWindow('email_quote.php?quote_id=<?php echo $_REQUEST['quote_id'];?>','1200','850');"><?php */?>
                    
                     <a href="javascript:void(0);" onclick="javascript:scrollWindow('email_quote.php?quote_id=<?php echo $_REQUEST['quote_id'];?>','1200','850');" class="bok_now"><i class="fa fa-briefcase" aria-hidden="true"></i>Send Quote Email</a>
                    </td>
                  </tr>
                  <tr class="table_cells" id="book_now_div">
                    <?php /*?><td  align="center" class="table_cells" id="book_now_div"><input name="button3" type="button" class="fcontrol" id="button3" value="Book Now" onclick="javascript:book_now(<?php echo $_REQUEST['quote_id'];?>);"><?php */?>
                    
                    <a href="javascript:void(0);" onclick="javascript:book_now(<?php echo $_REQUEST['quote_id'];?>);" class="bok_now"><i class="fa fa-briefcase" aria-hidden="true"></i>Book Now</a>
                    </td>
                  </tr>
                  <?php } ?>
            </div>
        </div>
    </div>
</div>
</form>




<script type="text/javascript">
$(function() {
			  $("#inspection_date").datepicker({dateFormat:'yy-mm-dd'});
        });
</script>
<? }else{
		echo error("Need a Quote Id First ");	
}?>