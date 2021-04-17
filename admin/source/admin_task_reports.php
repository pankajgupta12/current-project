<br>
<?
if(!isset($_SESSION['task']['from_date'])){ $_SESSION['task']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['task']['to_date'])){ $_SESSION['task']['to_date'] = date("Y-m-t"); }
 
 $dateString = date("Y-m-1").'|'.date("Y-m-t");
?>

<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        
		 <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['task']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['task']['to_date']?>">
        </li> 
		 
         <li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_new_sales();">	
		</li>    		 
        <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_search_new_sales('<?php echo date("Y-m-1"); ?>', '<?php  echo date("Y-m-t"); ?>');" name="reset" value="Reset" />
		</li>			
         
    </ul>
				
</div>
<br/><br/>
<div id="daily_view">
  <? include("xjax/view_admin_task_reports.php"); ?>
</div>

<script>
	function search_new_sales(){
		from_date = $('#from_date').val();
		to_date = $('#to_date').val();
		
		str = from_date+'|'+to_date;
		send_data(str , 575 , 'daily_view');
	}

	function reset_search_new_sales(fromdate , todate){
		
		 $('#from_date').val(fromdate);
		 $('#to_date').val(todate);
		 
		 str = fromdate+'|'+todate;
		send_data(str , 575 , 'daily_view');
		
	}
</script>