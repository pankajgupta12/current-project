
<?
if(!isset($_SESSION['daily_email_report_data']['from_date'])){ $_SESSION['daily_email_report_data']['from_date'] = date("Y-m-d"); }
?>

<form method='post' action='../admin/index.php?task=download_daily_send_email'>
	<div class="nav_form_main" style="margin-bottom: 40px;">
		<ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
		
			<li>
				<label>Date</label>
				<input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['daily_email_report_data']['from_date']?>" >
			</li>
			
			
			<li style="margin-top: 21px;">
				<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="dailyemailreport();">	
			</li>
			
			 <li style="margin-top: 21px;">
				<input type="reset" name="" value="Reset" class="offsetZero btnSent a_search_box" onClick="resetdailyemailreport('<?php echo date("Y-m-d"); ?>');">	
			</li>
			
			<li style="margin-top: 21px;">
				 <input type='submit' value='Daily Email Send Export' name='daily_report_export'>
			</li>
			 
		</ul>
		
		
					
	</div>

	<br>
	<br>
	<br>

	<div id="daily_view">
	  <? include("xjax/view_daily_send_email_report.php"); ?>
	</div>
</form>

<script>
 function dailyemailreport(){
	 var fdate =  $('#from_date').val();
	 send_data(fdate , 560, 'daily_view');
 }
 function resetdailyemailreport(today){
	 $('#from_date').val(today);
	 send_data(today , 560, 'daily_view');
 }
</script>

