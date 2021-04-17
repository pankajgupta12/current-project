<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
<div class="body_container">
                
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 ">
				    
					<li>
						<label>Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php if( isset($_SESSION['booking']['date']) && $_SESSION['booking']['date']!= NULL  ) { echo $_SESSION['booking']['date']; } ?>" onchange="javascript:show_data('from_date',135,'quote_view');">
					</li>
				
				    <li>
						<label>Location</label>
						<span>
						<?php echo create_dd("site_id","sites","id","name","","onchange=\"send_data(this.value,'136','quote_view');\"", $_SESSION['booking']);?>
						</span>
					</li>

					<li>
					    <label>&nbsp;</label>
						<input type="reset" onclick="javascript:reset_bookreport('reset',137,'quote_view');" name="reset" value="Reset" />
					</li>	
					
				</ul>
			</div>
                 
 
	
	<div>
		
	</div>
	<div id="quote_view">
		<?php
			include('xjax/view_daily_quote_booking.php' );
		?>
	</div>