<script>
        $(function() {
			 // $("#job_date").datepicker({dateFormat:'yy-mm-dd'});			  	  
			  $(".staff_date_class").datepicker({dateFormat:'yy-mm-dd'});			  	  
        });
		
    </script>
<?php
$staff_id = mysql_real_escape_string($_REQUEST['id']);
if(!isset($_SESSION['staff_invoice_1']['from_date'])){ $_SESSION['staff_invoice_1']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['staff_invoice_1']['to_date'])){ $_SESSION['staff_invoice_1']['to_date'] = date("Y-m-t"); }
 $dateString = date("Y-m-1").'|'.date("Y-m-t");
?>


<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
	
	 <li>
            <label>From Date</label>
            <input class="staff_date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['staff_invoice_1']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="staff_date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['staff_invoice_1']['to_date']?>" >
        </li> 	
		
		<li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_invoice_report('<?php echo $staff_id; ?>');">	
		</li>  
		<li>
          <label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_invoice_report('<?php echo $dateString; ?>','<?php echo $staff_id; ?>');" name="reset" value="Reset" />
        </li>			
	 </ul>
				
</div>	
<div id="daily_view">
    <?php 
	  include('xjax/staff_view_invoice.php'); 
	?>
</div >  


  