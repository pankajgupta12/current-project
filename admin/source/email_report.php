
<?
if(!isset($_SESSION['email_report_data']['from_date'])){ $_SESSION['email_report_data']['from_date'] = date("Y-m-d"); }
?>

<form method='post' action='../admin/index.php?task=email_report_activity'>
	<div class="nav_form_main" style="margin-bottom: 40px;">
		<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
		
			<li>
				<label>Date</label>
				<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['email_report_data']['from_date']?>" >
			</li>
			
			<li>
				
				<label>Admin</label>
				<span><?php echo create_dd("admin_id","admin","id","name","is_call_allow=1 AND status = 1 ","",$_SESSION['email_report_data']);?> </span>
			</li>        
			
			<li style="margin-top: 21px;">
				<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="emailreportsearch();">	
			</li>
			
			 <li style="margin-top: 21px;">
				<input type="reset" name="" value="Reset" class="offsetZero btnSent a_search_box" onClick="resetEmailreport('<?php echo date("Y-m-d"); ?>');">	
			</li>
			
			<li style="margin-top: 21px;">
				 <input type='submit' value='Email Report Export' name='email_report_export'>
			</li>
			 
		</ul>
		
		
					
	</div>

	<br>
	<br>
	<br>

	<div id="daily_view">
	  <? include("xjax/view_email_report.php"); ?>
	</div>
</form>

