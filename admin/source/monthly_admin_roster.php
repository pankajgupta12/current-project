<?php  
 if(!isset($_SESSION['monthly_admin_roster']['from_date'])){ $_SESSION['monthly_admin_roster']['from_date'] = date('Y-m-1'); }
if(!isset($_SESSION['monthly_admin_roster']['to_date'])){ $_SESSION['monthly_admin_roster']['to_date'] = date('Y-m-t'); }
if(!isset($_SESSION['monthly_admin_roster']['permanent_role'])){ $_SESSION['monthly_admin_roster']['permanent_role'] = 0; }

 ?>
<div class="body_container">
                
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
				
				   
				   
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['monthly_admin_roster']['from_date']; ?>" autocomplete="off">
					</li>
					
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['monthly_admin_roster']['to_date']; ?>" autocomplete="off">
					</li>
					
					<li>
    					<label>Role</label>
    					<span><?php echo  create_dd("permanent_role","system_dd","id","name","type = 155","",$_SESSION['monthly_admin_roster']);?></span>
					</li>
					
					<li>
					   <label>&nbsp;</label>
					    <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="search_monthly_admin_roster();">
					</li>
					
					<li>					
					 <label>&nbsp;</label>
				    	 <input type="reset" onclick="reste_search_monthly_admin_roster('<?php echo date('Y-m-1'); ?>' ,'<?php echo date('Y-m-t'); ?>');" name="reset" value="Reset" style="cursor: pointer;">
					</li>
					
				</ul>
			</div>
                 
 
	
	<div>
		
	</div>
	<div id="quote_view">
		<?php
			include('xjax/view_monthly_admin_roster.php');
		?>
	</div>
	
<script>
	    function search_monthly_admin_roster(){
		 var fromdata = $('#from_date').val();
		 var to_date =  $('#to_date').val();
		 var permanent_role = $('#permanent_role').val();
		 var str = fromdata+'|'+to_date+'|'+permanent_role;
		 
		 send_data(str , 623, 'quote_view');
	   }
	   
	   function reste_search_monthly_admin_roster(fromdata , todate){
		   $('#from_date').val(fromdata);
		   $('#to_date').val(todate);
		   $('#permanent_role').val(0);
		   
		   var str = fromdata+'|'+todate+'|0';
		   
		   send_data(str , 623, 'quote_view');
	   } 
</script>	