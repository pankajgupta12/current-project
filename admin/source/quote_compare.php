<?
if(!isset($_SESSION['quote_compare']['from_date'])){ $_SESSION['quote_compare']['from_date'] = date("Y-m-d" , strtotime('-7 day')); }
if(!isset($_SESSION['quote_compare']['to_date'])){ $_SESSION['quote_compare']['to_date'] = date("Y-m-d"); }
 
 $dateString = date("Y-m-d" , strtotime('-7 day')).'|'.date("Y-m-d");
?>
<script language="javascript">

</script>
<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
       
        <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['quote_report_dashboard']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['quote_report_dashboard']['to_date']?>" >
        </li> 		
        <li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_quote_compare_report();">	
		</li>       
	   <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_quote_compare_report_dashboard('<?php echo $dateString; ?>','from_date|to_date');" name="reset" value="Reset" />
		</li>			
         
    </ul>
				
</div>



<br>
<div id="daily_view">
  <? include("xjax/view_quote_compare.php"); ?>
</div>
<script>
        $(function() {
			  $("#from_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#to_date").datepicker({dateFormat:'yy-mm-dd'});
        });
    </script>