<?
if(!isset($_SESSION['bbc_weekly_report']['from_date'])){ $_SESSION['bbc_weekly_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['bbc_weekly_report']['to_date'])){ $_SESSION['bbc_weekly_report']['to_date'] = date("Y-m-t"); }
 
 //$dateString = date("Y-m-1").'|'.date("Y-m-t");
?>
<script language="javascript">

</script>
<div class="nav_form_main" onclick="$('#postcode_div').hide();">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 job_report_5">
        
		<li class="bb_post">
			<label>Statff Type</label>
			<span>
			 <?php echo create_dd("better_franchisee","quote_for_option","id","name","status = 1 AND id != 4","", $_SESSION['bbc_weekly_report'] ,'quote_a');	?>
			</span> 
        </li>
		
		<li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php  echo $_SESSION['bbc_weekly_report']['from_date']?>">
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['bbc_weekly_report']['to_date']?>">
        </li> 
		
	
		<li>
			<label>&nbsp;</label>
			<input type="button"  id="reset" class="offsetZero btnSent a_search_box" onClick="bbc_search_staff_job_reports();"  name="reset" value="Search" />
		</li>	
        <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset"  name="reset" onClick="reset_bbc_job_reports('<?php echo date("Y-m-1");  ?>' , '<?php echo date("Y-m-t");  ?>'); "value="Reset" />
		</li>			
         
    </ul>
				
</div>



<br>
<div id="daily_view">
  <? include("xjax/view_bbc_weekly_job_reports.php"); ?>
</div>
<script>
        $(function() {
			  $("#from_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#to_date").datepicker({dateFormat:'yy-mm-dd'});
        });
		
		function bbc_search_staff_job_reports(){
			
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var better_franchisee = $('#better_franchisee').val();
			
			var str = from_date+'|'+to_date+'|'+better_franchisee;
			//alert(str);
			send_data(str , 593 , 'daily_view');
		}
		
		
		function reset_bbc_job_reports(fromdate , todate){
			$('#from_date').val(fromdate);
			$('#to_date').val(todate);
			$('#better_franchisee').val(0);
			
			var str = fromdate+'|'+todate+'|0';
			//alert(str);
			send_data(str , 593 , 'daily_view');
		}
    </script>