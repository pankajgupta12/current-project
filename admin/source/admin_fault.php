<?php  
 if(!isset($_SESSION['admin_fault_data']['from_date'])){ $_SESSION['admin_fault_data']['from_date'] = date('Y-m-1'); }
if(!isset($_SESSION['admin_fault_data']['to_date'])){ $_SESSION['admin_fault_data']['to_date'] = date('Y-m-t'); }

 ?>
<div class="body_container">
                
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
				
				   
				   
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['admin_fault_data']['from_date']; ?>" autocomplete="off">
					</li>
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['admin_fault_data']['to_date']; ?>" autocomplete="off">
					</li>
					
					<li>
						<label>Admin Name</label>
						
						<span><?php 
						echo  create_dd("admin_id","admin","id","name","is_call_allow = 1 AND status = 1","",$r);
						 
						?></span>
					</li>
					
					<li>
					   <label>&nbsp;</label>
					    <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="search_admin_fault();">
					</li>
					
					<li>					
					 <label>&nbsp;</label>
				    	 <input type="reset" onclick="restedata('<?php echo date('Y-m-1'); ?>' ,'<?php echo date('Y-m-t'); ?>');" name="reset" value="Reset" style="cursor: pointer;">
					</li>
					
				</ul>
			</div>
                 
 
	
	<div>
		
	</div>
	<div id="quote_view">
		<?php
			include('xjax/view_admin_fault.php' );
		?>
	</div>
	
<script>
	   function search_admin_fault(){
		 var fromdata = $('#from_date').val();
		 var to_date =  $('#to_date').val();
		 var admin_id =   $('#admin_id').val();
		 var str = fromdata+'|'+to_date+'|'+admin_id;
		 
		 send_data(str , 574, 'quote_view');
	   }
	   
	   function restedata(fromdata , todate){
		   $('#from_date').val(fromdata);
		   $('#from_date').val(todate);
		   $('#admin_id').val(0);
		   var str = fromdata+'|'+todate+'|0';
		   send_data(str , 574, 'quote_view');
	   }
</script>	