<?php  

//if(!isset($_SESSION['amt_report']['amt_report_from'])){ $_SESSION['amt_report']['amt_report_from'] = date("Y-m-1"); }
if(!isset($_SESSION['amt_report']['amt_report_from'])){ $_SESSION['amt_report']['amt_report_from'] = date("2019-02-18"); }
if(!isset($_SESSION['amt_report']['amt_report_to'])){ $_SESSION['amt_report']['amt_report_to'] = date("Y-m-t"); }
?>
<div class="view_quote_back_box">
	
	   <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
				
				
				
				    <li>
						<label>Location</label>
						<span>
						<?php echo create_dd("site_id","sites","id","name","","", $_SESSION['amt_report']);?>
						</span>
					</li>
					
					<li>
						<label>Staff Type</label>
						 <span>
						 <?php echo create_dd("staff_type_all","system_dd","id","name","type = 41 ","", $_SESSION['amt_report']);?>
						</span>
					</li>
					
					<li>
						<label>BBC Staff</label>
						<span>
						<?php echo create_dd("staff_id","staff","id","name","status = 1 ","", $_SESSION['amt_report']);?>
						</span>
					</li>
				   
					<li>
						<label>Booking From</label>
						<input class="date_class" type="text" name="amt_report_from" id="amt_report_from" value="<?php if( isset($_SESSION['amt_report']['amt_report_from']) && $_SESSION['amt_report']['amt_report_from']!= NULL  ) { echo $_SESSION['amt_report']['amt_report_from']; }?>" >
					</li>
					<li>
						<label>Booking To</label>
						<input class="date_class" type="text" name="amt_report_to" id="amt_report_to" value="<?php if( isset($_SESSION['amt_report']['amt_report_to']) && $_SESSION['amt_report']['amt_report_to']!= NULL  ) { echo $_SESSION['amt_report']['amt_report_to']; } ?>">
					</li>
					
					
					
					<li>
					<label>&nbsp;</label>
				    		<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box_one" onclick="javascript:search_cleaning_amt();">
					<li>					
					<label>&nbsp;</label>
				    	<!--<a style="color: #fff; padding: 9px !important; background-color: #00b8d4; position: relative;top: 36px;" href="index.php?task=dispatch_report">RESET FILTER</a>-->			
				    		<!-- <input type="reset" onclick="javascript:send_data('reset',94,'quote_view'); resetfilter('<?php echo date('Y-m-d',strtotime('yesterday')); ?>');" name="reset" value="Reset" style="cursor: pointer;" />-->
				    		 <input type="reset" onclick="reset_cleaningreport('<?php echo date("2019-02-18"); ?>' , '<?php echo date("Y-m-t"); ?>');" name="reset" value="Reset" style="cursor: pointer;" />
					</li>
					
					
				</ul>
				
				
</div>

 <h2>BBC Cleaning Amount report</h2>
<script>

 $(function() {
  /*   $( ".date_class_1" ).datepicker({
        minDate: dateToday // minDate: '0' would work too
    }); */
	//$("#amt_report_from").datepicker({ minDate:0});
//	$("#amt_report_from").datepicker({ dateFormat: 'yy-mm-dd' }).
//	$("#amt_report_to").datepicker({ dateFormat: 'yy-mm-dd' }).
});

  function search_cleaning_amt(){
	  var site_id = $('#site_id').val();
	  var staff_id = $('#staff_id').val();
	  var amt_report_from = $('#amt_report_from').val();
	  var amt_report_to = $('#amt_report_to').val();
	  var stafftype = $('#staff_type_all').val();
	  
	  var string = site_id+'|'+staff_id+'|'+amt_report_from+'|'+amt_report_to+'|'+stafftype;
	  
	  send_data(string  ,532 , 'cleaning_report');
  }
  
   function reset_cleaningreport(from_date, to_date){
	   
	  $('#site_id').val('0');
	  $('#staff_id').val('0');
	  $('#amt_report_from').val(from_date);
	  $('#amt_report_to').val(to_date);
	  $('#staff_type_all').val('0');
	  
	  var string = '0|0|'+from_date+'|'+to_date+'|0';
	  
	  send_data(string  ,532 , 'cleaning_report');
   }
</script>
 
 <div id="cleaning_report">
<?php 
 include('xjax/view_cleaning_amt_report.php');
?>    
</div>


	
	