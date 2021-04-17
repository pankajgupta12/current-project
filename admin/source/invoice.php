<?php  

if(!isset($_SESSION['all_invoice_data']['from_date'])){ $_SESSION['all_invoice_data']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['all_invoice_data']['to_date'])){ $_SESSION['all_invoice_data']['to_date'] = date("Y-m-t"); }
 $dateString = date("Y-m-1").'|'.date("Y-m-t");

?>

    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
	
	    <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['all_invoice_data']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['all_invoice_data']['to_date']?>" >
        </li> 	
		
		<!--<li>
            <label>Staff ID</label>
             <span><?php echo create_dd("staff_id","staff","id","name","status = 1 ","",$_SESSION['all_invoice_data']);?></span>
        </li>--> 	
		
		<li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Invoice Generate" class="offsetZero btnSent a_search_box" onclick="javascript:invoice_generate();">	
			
			<!--<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_all_invoice_report();">-->	
			
		</li>  
		<!--<li>
          <label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_all_invoice_report('<?php echo $dateString; ?>');" name="reset" value="Reset" />
        </li>-->			
	</ul>

<div id="daily_view">
  <?php  include('xjax/view_invoice.php'); ?>
</div>

<script>
  function invoice_generate(){
	  
		var from_date = $('#from_date').val();
		var todate = $('#to_date').val();
		var staff_id = $('#staff_id').val();
		
		 if(staff_id == '' || staff_id == 0 ||  staff_id == undefined) {
			var   staff_id = 0;
		 }else{
			 staff_id = staff_id;
		 }
		 
		 var str = from_date+'|'+todate+'|'+staff_id;
		
	    send_data(str,405,'daily_view');
  }
   
</script>
