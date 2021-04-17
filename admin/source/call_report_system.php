<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
<div class="body_container">
                
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 ">
				    
					<li>
						<label>Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php //if( isset($_SESSION['booking']['date']) && $_SESSION['booking']['date']!= NULL  ) { echo $_SESSION['booking']['date']; } else { echo  date('Y-m-d'); } ?>" onchange="javascript:show_data('from_date',141,'quote_view');">
					</li>
				   
				    <li>
						<label>Admin User</label>
                       	<span id="dispatch_staff_div">
						<?php echo create_dd("admin_id","c3cx_users","id","3cx_user_name","","onchange=\"javascript:show_data('admin_id',142,'quote_view');\"", $_SESSION['call_report']); ?>
                         </span>
					</li>
					 <li>
						<label>From/To</label>
                       	<span id="dispatch_staff_div1">
						    <select name="from_to" class="formfields" onchange="javascript:show_data('from_to',144,'quote_view');"  id="from_to"> 
						     <option value="0" <?php if($_SESSION['call_report']['from_to'] == 0) { echo "selected"; } ?>>Select</option>
						     <option value="1" <?php if($_SESSION['call_report']['from_to'] == 1) { echo "selected"; } ?>>From</option>
							 <option value="2" <?php if($_SESSION['call_report']['from_to'] == 2) { echo "selected"; } ?>>To</option>
							</select> 
                        </span>
					</li>
					

					<li>
					    <label>&nbsp;</label>
						<input type="reset" onClick="javascript:reset_callreportsystem('reset',143,'quote_view');" name="reset" value="Reset" />
					</li>	
					
				</ul>
			</div>
                 
 
	
	<div>
		
	</div>
		<div id="quote_view">
			<?php include('xjax/view_call_report_system.php' ); ?>
		</div>