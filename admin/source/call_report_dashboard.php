<link href="../css/general.css" rel="stylesheet" type="text/css">
<br>
<?
if(!isset($_SESSION['call_report_dashboard']['from_date'])){ $_SESSION['call_report_dashboard']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['call_report_dashboard']['to_date'])){ $_SESSION['call_report_dashboard']['to_date'] = date("Y-m-t"); }
 
 $dateString = date("Y-m-1").'|'.date("Y-m-t");
 
	$fromdate = str_replace(' ' , '_', changeDateFormate($_SESSION['call_report_dashboard']['from_date'] , 'datetime'));
	$to_date =  str_replace(' ' , '_', changeDateFormate($_SESSION['call_report_dashboard']['to_date'] , 'datetime'));
 
?>
<script language="javascript">

</script>
<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        <li>
            
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['call_report_dashboard']['from_date']?>" onChange="javascript:call_report_dashboard('from_date');">
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['call_report_dashboard']['to_date']?>" onChange="javascript:call_report_dashboard('to_date');">
        </li> 
        <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_report_dashboard('<?php echo $dateString; ?>','from_date|to_date');" name="reset" value="Reset" />
		</li>	

            <li style="    margin-top: 17px;">
		      <input type='button' id='btn' value='Print' onclick="printDiv('<?php echo $fromdate?>' , '<?php echo $to_date?>');">
			</li>		
         
    </ul>
				
</div>



<br>
<div id="daily_view">
  <? include("xjax/call_report_dashboard.php"); ?>
</div>
<script>
        $(function() {
			  $("#from_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#to_date").datepicker({dateFormat:'yy-mm-dd'});
        });
    </script>