<?php  
if(!isset($_SESSION['imagelink']['jobdate_from'])){ $_SESSION['imagelink']['jobdate_from'] = date("Y-m-1"); }
if(!isset($_SESSION['imagelink']['jobdate_to'])){ $_SESSION['imagelink']['jobdate_to'] = date('Y-m-d', strtotime(' + 2 days')); }
?>
    <div class="view_quote_back_box">
	

	    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
				
				
				
				    <li>
						<label>Location</label>
						<span>
						<?php echo create_dd("site_id","sites","id","name","","", $_SESSION['imagelink']);?>
						</span>
					</li>
					
					<li>
						<label>Booking Date From</label>
						<input class="date_class" type="text" name="jobdate_from" id="jobdate_from" value="<?php if( isset($_SESSION['imagelink']['jobdate_from']) && $_SESSION['imagelink']['jobdate_from']!= NULL  ) { echo $_SESSION['imagelink']['jobdate_from']; }?>" >
					</li>
					<li>
						<label>Booking Date To</label>
						<input class="date_class" type="text" name="jobdate_to" id="jobdate_to" value="<?php if( isset($_SESSION['imagelink']['jobdate_to']) && $_SESSION['imagelink']['jobdate_to']!= NULL  ) { echo $_SESSION['imagelink']['jobdate_to']; } ?>">
					</li>
					
					<li>
					<label>&nbsp;</label>
				    		<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box_one" onclick="javascript:search_imagelink();">
					<li>					
					<label>&nbsp;</label>
				    	<!--<a style="color: #fff; padding: 9px !important; background-color: #00b8d4; position: relative;top: 36px;" href="index.php?task=dispatch_report">RESET FILTER</a>-->			
				    		<!-- <input type="reset" onclick="javascript:send_data('reset',94,'quote_view'); resetfilter('<?php echo date('Y-m-d',strtotime('yesterday')); ?>');" name="reset" value="Reset" style="cursor: pointer;" />-->
				    		 <input type="reset" onclick="reset_imagelink('<?php echo date("Y-m-1"); ?>' , '<?php echo date('Y-m-d', strtotime(' + 2 days')); ?>');" name="reset" value="Reset" style="cursor: pointer;" />
					</li>
					
		</ul>
	</div>
	
	<div id="iamgelink">
	  <?php  include('xjax/view_imagelink.php'); ?>
	</div>
	<script>
	
		function search_imagelink(){
			
			  var site_id = $('#site_id').val();
			  var jobdate_from = $('#jobdate_from').val();
			  var jobdate_to = $('#jobdate_to').val();
			  
			  var string = site_id+'|'+jobdate_from+'|'+jobdate_to;
			  
		     send_data(string  ,533 , 'iamgelink');
	    }
		
		function reset_imagelink(from_date, to_date){
	   
			  $('#site_id').val('0');
			  $('#jobdate_from').val(from_date);
			  $('#jobdate_to').val(to_date);
			  
			  var string = '0|'+from_date+'|'+to_date;
			  
			  send_data(string  ,533 , 'iamgelink');
        }
  </script>
	
 
	 