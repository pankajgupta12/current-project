<?php

if(!isset($_SESSION['review_report_notes']['from_date'])){ $_SESSION['review_report_notes']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['review_report_notes']['to_date'])){ $_SESSION['review_report_notes']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['review_report_notes']['fault_type'])){ $_SESSION['review_report_notes']['fault_type'] = 0; }
if(!isset($_SESSION['review_report_notes']['staff_type'])){ $_SESSION['review_report_notes']['staff_type'] = 0; }

?>
<div class="body_container">
	<div class="body_back body_back_disp">
    	<div class="wrapper">
            <div class="nav_form_main">
				<form name="dispatch_report" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" name="task" value="dispatch_report">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
				
				    
				   
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php  if( isset($_SESSION['review_report_notes']['from_date']) && $_SESSION['review_report_notes']['from_date']!= NULL  ) { echo $_SESSION['review_report_notes']['from_date']; }?>" >
					</li>
					
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php if( isset($_SESSION['review_report_notes']['to_date']) && $_SESSION['review_report_notes']['to_date']!= NULL  ) { echo $_SESSION['review_report_notes']['to_date'];  } ?>" >
					</li>
					
					<li>
						<label>Fault</label>
						<span><?php echo create_dd("fault_type","system_dd","id","name","type=97","",$_SESSION['review_report_notes']);?> </span>
					</li>

<!-- Start Adding Dropdown Section -->  

					<li>
					<label>Staff Type</label>
					<span>
					<?php echo create_dd("staff_type","quote_for_option","id","name","status = 1 AND id != 4","onchange=\"javascript:send_data(this.value,594,'staff_id');\"", $_SESSION['review_report_notes'] ,'quote_a');	?>
					</span>
					</li>


					<li>
					<label>Staff Name</label>
					<span>
					<select name="staff_id" class="formfields" id="staff_id">
					<option value="0">Select</option>
					</select> 
					</span>
					</li>
					<!-- Start Rating System-->  

					<li>
					<label>Rating</label>
					<span>
					<select name="rating" class="formfields" id="rating">
					<option value="" >Select</option>
					<?php 
					 
					for($r=0; $r<=5; $r++){
						 $select = '';
						 if(isset($_SESSION['review_report_notes']['rating']) && $_SESSION['review_report_notes']['rating'] == $r) {
							 $select = "selected";
						 }
					   echo "<option value=".$r." ".$select.">".$r."</option>";
					} ?>  
					</select> 
					</span>
					</li>

<!-- End Rating System-->
<!-- End Adding Dropdown Section -->


					
					
					<li>					
					  <label>&nbsp;</label>
				    	<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box_one" onclick="javascript:get_review_roport_notes();">
					</li>
					
					<li>					
					<label>&nbsp;</label>
				    		 <input type="reset" onclick="javascript:reset_get_cleaner_roport_notes('<?php echo date("Y-m-1").'|'.date("Y-m-t"); ?>',548,'quote_view'); resetcleaner_report_notes('<?php echo date("Y-m-1"); ?>' ,'<?php echo date("Y-m-t"); ?>' );" name="reset" value="Reset" style="cursor: pointer;" />
					</li>
					
					
				</ul>
				</form>
				
			</div>	
  <br>  
  <br/>
			<br/>
			<br/>
  
			<div id="quote_view">
			
			<? 
			include("xjax/view_review_reports_notes.php"); ?>
			</div>
</div>
</div>
</div>
<script>
    function get_review_roport_notes(){
	   var from_date = $('#from_date').val();
	   var to_date = $('#to_date').val();
	   var fault_type = $('#fault_type').val();
	   
	   var staff_type = $('#staff_type').val();
	   var staff_id = $('#staff_id').val();
	   var rating = $('#rating').val();
	   
	  var str = from_date +'|'+to_date+'|'+fault_type+'|'+staff_type+'|'+staff_id+'|'+rating;
	  send_data(str , 548 , 'quote_view');
    }
    function reset_get_cleaner_roport_notes(str , case_id , div_id){
	   send_data(str+'|0|0|0|' , case_id , div_id);
    }
    function resetcleaner_report_notes(from_date , todate){
		 $('#from_date').val(from_date);
		 $('#to_date').val(todate);
		 $('#fault_type').val(0);
		 
		 $('#staff_type').val(0);
		 $('#staff_id').val(0);
		 $('#rating').val('');
    }
	
		$(function() {
		// Handler for .ready() called.
		});
		$( document ).ready(function() {
		   //console.log( "ready!" );
		   stafftype = <?php  echo  $_SESSION['review_report_notes']['staff_type']; ?>;
		   //alert('dsds'+stafftype);
		   send_data(stafftype,594,'staff_id');
		});

	
</script>