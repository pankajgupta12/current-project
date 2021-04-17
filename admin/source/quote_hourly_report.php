<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
<div class="body_container">
                
              
            <div class="nav_form_main">
				<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 ">
				   
					<!--<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php if( isset($_SESSION['hourly_quote']['quote_date']) && $_SESSION['hourly_quote']['quote_date']!= NULL  ) { echo $_SESSION['hourly_quote']['quote_date']; } else { echo  date('Y-m-d',strtotime('-1 week')); } ?>" onchange="javascript:show_data('from_date',190,'quote_view');">
					</li>
					
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php if(isset($_SESSION['hourly_quote']['to_date']) && $_SESSION['hourly_quote']['to_date']!= NULL  ) { echo $_SESSION['hourly_quote']['to_date']; } else { echo  date('Y-m-d',strtotime('yesterday')); } ?>" onchange="javascript:show_data('to_date',194,'quote_view');">
					</li>-->
					<li>
						<label>From Date</label>
						<input class="date_class" type="text" name="from_date" id="from_date" value="<?php if( isset($_SESSION['hourly_quote']['quote_date']) && $_SESSION['hourly_quote']['quote_date']!= NULL  ) { echo $_SESSION['hourly_quote']['quote_date']; } else { echo  date('Y-m-d',strtotime('-1 week')); } ?>" >
					</li>
					
					<li>
						<label>To Date</label>
						<input class="date_class" type="text" name="to_date" id="to_date" value="<?php if(isset($_SESSION['hourly_quote']['to_date']) && $_SESSION['hourly_quote']['to_date']!= NULL  ) { echo $_SESSION['hourly_quote']['to_date']; } else { echo  date('Y-m-d',strtotime('yesterday')); } ?>" >
					</li>
					
					<li>
			            <input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:quote_dashboard_hourly_report();">	
		            </li>    
				
				   
					<li>
					    <label>&nbsp;</label>
						<input type="reset" onclick="javascript:reset_hourlyreport('<?php echo date('Y-m-d',strtotime('-1 week')); ?>','<?php echo date('Y-m-d',strtotime('yesterday')); ?>');" name="reset" value="Reset" />
					</li>	
					
				</ul>
			</div>
                 
 
	
	<div>
		
	</div>
	<div id="quote_view">
		<?php
			include('xjax/quote_hourly_report.php');
		?>
	</div>
	