<br>
<?
if(!isset($_SESSION['track']['from_date'])){ $_SESSION['track']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['track']['to_date'])){ $_SESSION['track']['to_date'] = date("Y-m-t"); }
 
 $dateString = date("Y-m-1").'|'.date("Y-m-t");
?>

<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        
		 <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['track']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['track']['to_date']?>">
        </li> 
		 
         <li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_track_report();">	
		</li>    		 
        <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_track_report('<?php echo date("Y-m-1"); ?>', '<?php  echo date("Y-m-t"); ?>');" name="reset" value="Reset" />
		</li>			
         
    </ul>
				
</div>
<br/><br/>
<div id="daily_view">
  <? include("xjax/view_sales_track_report.php"); ?>
</div>

<script>
	function search_track_report(){
		from_date = $('#from_date').val();
		to_date = $('#to_date').val();
		
		str = from_date+'|'+to_date;
		send_data(str , 577 , 'daily_view');
	}

	function reset_track_report(fromdate , todate){
		
		 $('#from_date').val(fromdate);
		 $('#to_date').val(todate);
		 
		 str = fromdate+'|'+todate;
		send_data(str , 577 , 'daily_view');
		
	}
</script>