<?php

if(!isset($_SESSION['cleaner_report']['from_date'])){ $_SESSION['cleaner_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['cleaner_report']['to_date'])){ $_SESSION['cleaner_report']['to_date'] = date("Y-m-t"); }

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
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php  if( isset($_SESSION['cleaner_report']['from_date']) && $_SESSION['cleaner_report']['from_date']!= NULL  ) { echo $_SESSION['cleaner_report']['from_date']; }?>" >
					</li>
					
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php if( isset($_SESSION['cleaner_report']['to_date']) && $_SESSION['cleaner_report']['to_date']!= NULL  ) { echo $_SESSION['cleaner_report']['to_date'];  } ?>" >
					</li>
					
					
					
					<li>					
					  <label>&nbsp;</label>
				    	<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box_one" onclick="javascript:get_cleaner_roport();">
					</li>
					
					<li>					
					<label>&nbsp;</label>
				    		 <input type="reset" onclick="javascript:reset_get_cleaner_roport('<?php echo date("Y-m-1").'|'.date("Y-m-t"); ?>',514,'quote_view'); resetcleaner_report('<?php echo date("Y-m-1"); ?>' ,'<?php echo date("Y-m-t"); ?>' );" name="reset" value="Reset" style="cursor: pointer;" />
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
			include("xjax/view_cleaner_report.php"); ?>
			</div>
</div>
</div>
</div>
<script>
   function get_cleaner_roport(){
	   var from_date = $('#from_date').val();
	   var to_date = $('#to_date').val();
	   
	   var str = from_date +'|'+to_date;
	   send_data(str , 514 , 'quote_view');
   }
   function reset_get_cleaner_roport(str , case_id , div_id){
	   send_data(str , case_id , div_id);
   }
   function resetcleaner_report(from_date , todate){
	 $('#from_date').val(from_date);
	 $('#to_date').val(todate);
   }
</script>