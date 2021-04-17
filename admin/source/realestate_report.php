<?php  
if(!isset($_SESSION['realestate']['jobdate_from'])){ $_SESSION['realestate']['jobdate_from'] = date("Y-m-1"); }
if(!isset($_SESSION['realestate']['jobdate_to'])){ $_SESSION['realestate']['jobdate_to'] = date('Y-m-t'); }
?>
    <div class="view_quote_back_box">
	    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
				
				    <li>
						<label>Location</label>
						<span>
						<?php echo create_dd("site_id","sites","id","name","","", $_SESSION['realestate']);?>
						</span>
					</li>
					
					<li>
						<label>Booking Date From</label>
						<input class="date_class" type="text" name="jobdate_from" id="jobdate_from" value="<?php if( isset($_SESSION['realestate']['jobdate_from']) && $_SESSION['realestate']['jobdate_from']!= NULL  ) { echo $_SESSION['realestate']['jobdate_from']; }?>" >
					</li>
					<li>
						<label>Booking Date To</label>
						<input class="date_class" type="text" name="jobdate_to" id="jobdate_to" value="<?php if( isset($_SESSION['realestate']['jobdate_to']) && $_SESSION['realestate']['jobdate_to']!= NULL  ) { echo $_SESSION['realestate']['jobdate_to']; } ?>">
					</li>
					
					<li>
						<label>Search value</label>
						 <input type="text" name="search_val" id="search_val" value="">
					</li>
					
					
					
					<li>
					<label>&nbsp;</label>
				    		<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box_one" onclick="javascript:search_realestatereport();">
					<li>					
					  <label>&nbsp;</label>
				    	 <input type="reset" onclick="reset_realestatereport('<?php echo date("Y-m-1"); ?>' , '<?php echo date('Y-m-t'); ?>');" name="reset" value="Reset" style="cursor: pointer;" />
					</li>
					
		</ul>
	</div>
	
	<div id="iamgelink">
	    <?php  include('xjax/view_real_estate_report.php'); ?>
	</div>
	
	<script>
	
    	 	function search_realestatereport(){
			
			  var site_id = $('#site_id').val();
			  var search_val = $('#search_val').val();
			  var jobdate_from = $('#jobdate_from').val();
			  var jobdate_to = $('#jobdate_to').val();
			  
			  var string = site_id+'|'+search_val+'|'+jobdate_from+'|'+jobdate_to;
			  
		     send_data(string  ,538 , 'iamgelink');
	    }
		
		function reset_realestatereport(from_date ,to_date){
	   
			  $('#site_id').val('0');
			  $('#search_val').val('');
			  
			  $('#jobdate_from').val(from_date);
			  $('#jobdate_to').val(to_date);
			  
			  var string = '0||'+from_date+'|'+to_date;
			  
			  send_data(string  ,538 , 'iamgelink');
        } 
		
    </script>
	
 
	 