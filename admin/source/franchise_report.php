<?php  

if(!isset($_SESSION['franchise_report']['from_date'])){ $_SESSION['franchise_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['franchise_report']['to_date'])){ $_SESSION['franchise_report']['to_date'] = date("Y-m-t"); }
 $dateString = date("Y-m-1").'|'.date("Y-m-t");

?>

    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
	
	    <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['franchise_report']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['franchise_report']['to_date']?>" >
        </li> 	
		
		
		
		<li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Generate Franchise Report"  onClick="franchise_report();"  class="offsetZero btnSent a_search_box" >	 
			
		</li>  
	</ul>

<div id="daily_view">
  <?php  include('xjax/view_franchise_report.php'); ?>
</div>

<script>
   function franchise_report(){
	  
		var from_date = $('#from_date').val();
		var todate = $('#to_date').val();
		
		 var str = from_date+'|'+todate;
		
	    send_data(str,400,'daily_view');
  } 
   
</script>
