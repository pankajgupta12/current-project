<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
<div class="body_container">
                
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 ">
				    
					<!--<li>
						<label>Quote Type</label>
						<span>
						    <select name="quote_type" class="formfields" onchange="javascript:show_data('quote_type',134,'quote_view');"  id="quote_type"> 
						     <option value="0" <?php if($_SESSION['quote']['status'] == 0) { echo "selected"; } ?>>Quote</option>
							 <option value="1" <?php if($_SESSION['quote']['status'] == 1) { echo "selected"; } ?>>Booking</option>
							</select>						
						</span>
					</li>
					
					
					<li>
						<label>Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php if( isset($_SESSION['quote']['date']) && $_SESSION['quote']['date']!= NULL  ) { echo $_SESSION['quote']['date']; } ?>" onchange="javascript:show_data('from_date',132,'quote_view');">
					</li>
				
				    <li>
						<label>Location</label>
						<span>
						<?php echo create_dd("site_id","sites","id","name","","onchange=\"send_data(this.value,'131','quote_view');\"", $_SESSION['quote']);?>
						</span>
					</li>-->
					
					<li>
						<label>Quote Type</label>
						<span>
						    <select name="quote_type" class="formfields"   id="quote_type"> 
						     <option value="0" <?php if($_SESSION['quote']['status'] == 0) { echo "selected"; } ?>>Quote</option>
							 <option value="1" <?php if($_SESSION['quote']['status'] == 1) { echo "selected"; } ?>>Booking</option>
							</select>						
						</span>
					</li>
					
					
					<li>
						<label>Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php if( isset($_SESSION['quote']['date']) && $_SESSION['quote']['date']!= NULL  ) { echo $_SESSION['quote']['date']; } ?>" >
					</li>
				
				    <li>
						<label>Location</label>
						<span>
						<?php echo create_dd("site_id","sites","id","name","","", $_SESSION['quote']);?>
						</span>
					</li>
                    
					<li>
			            <input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:quote_dashboard_daily_report();">	
		            </li>
					<!--<li>
						<label>Job ID/Quote ID</label>
                        <input name="name" type="text" id="job_quote" size="45" value="<?php // if($_SESSION['call']['quote_job_id'] != '') { echo $_SESSION['call']['quote_job_id']; } ?>" onKeyup="javascript:send_data(this.value,99,'quote_view');">
					</li>-->	
					<li>
					    <label>&nbsp;</label>
						<input type="reset" onclick="javascript:reset_quotereport('reset',133,'quote_view');" name="reset" value="Reset" />
					</li>	
					
				</ul>
			</div>
                 
 
	
	<div>
		
	</div>
	<div id="quote_view">
		<?php
			include('xjax/view_daily_report_quote.php' );
		?>
	</div>