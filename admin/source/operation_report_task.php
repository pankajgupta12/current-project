<br>
<?
if(!isset($_SESSION['operation_task']['from_date'])){ $_SESSION['operation_task']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['operation_task']['to_date'])){ $_SESSION['operation_task']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['operation_task']['operation_type'])){ $_SESSION['operation_task']['operation_type'] = 1; }
 
 $dateString = date("Y-m-1").'|'.date("Y-m-t");
?>

<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        
		 <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['operation_task']['from_date']?>" >
        </li>
        <li>
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['operation_task']['to_date']?>">
        </li> 
		
		 <li>
            <label>Operation Type</label>
            <span><?php echo  create_dd("operation_type","system_dd","id","name","type = 112","",$_SESSION['operation_task']); ?></span>
        </li> 
		
		 
         <li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_new_operation();">	
		</li>    		 
        <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_search_new_operation('<?php echo date("Y-m-1"); ?>', '<?php  echo date("Y-m-t"); ?>');" name="reset" value="Reset" />
		</li>			
         
    </ul>
				
</div>
<br/><br/>
<div id="daily_view">
  <? include("xjax/view_operation_report_task.php"); ?>
</div>

<script>
	 function search_new_operation(){
		from_date = $('#from_date').val();
		to_date = $('#to_date').val();
		operation_type = $('#operation_type').val();
		
		str = from_date+'|'+to_date+'|'+operation_type;
		send_data(str , 589 , 'daily_view');
	}

	function reset_search_new_operation(fromdate , todate){
		
		 $('#from_date').val(fromdate);
		 $('#to_date').val(todate);
		 $('#operation_type').val(1);
		 
		 str = fromdate+'|'+todate+'|1';
		send_data(str , 589 , 'daily_view');
		
	} 
</script>