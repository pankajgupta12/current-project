<br>
<?
if(!isset($_SESSION['sales']['from_date'])){ $_SESSION['sales']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['sales']['to_date'])){ $_SESSION['sales']['to_date'] = date("Y-m-t"); }
 
 $dateString = date("Y-m-1").'|'.date("Y-m-t");
?>
<script language="javascript">

</script>
<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        
		 <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['sales']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['sales']['to_date']?>">
        </li> 
		 
         <li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_sales_report(1);">	
		</li>    		 
        <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_sales_report('<?php echo $dateString; ?>' , 1);" name="reset" value="Reset" />
		</li>			
         
    </ul>
				
</div>



<br/><br/>
<div id="daily_view">
  <? include("xjax/view_sales_reports.php"); ?>
</div>
<script>
        $(function() {
			  $("#from_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#to_date").datepicker({dateFormat:'yy-mm-dd'});
        });
    </script>