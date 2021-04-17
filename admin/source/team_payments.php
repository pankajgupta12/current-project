
<br>
<?
if(!isset($_SESSION['tpayment_report']['from_date'])){ $_SESSION['tpayment_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['tpayment_report']['to_date'])){ $_SESSION['tpayment_report']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['tpayment_report']['site_id'])){ $_SESSION['tpayment_report']['site_id'] = "0"; }
if(!isset($_SESSION['tpayment_report']['staff_id'])){ $_SESSION['tpayment_report']['staff_id'] = "0"; }
if(!isset($_SESSION['tpayment_report']['staff_type'])){ $_SESSION['tpayment_report']['staff_type'] = "1"; }

?>

<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 aba_file_download">
	    
		<li>
            <label>Staff Type</label>
            	<span>
			  	<?php echo create_dd("staff_type","quote_for_option","id","name","status=1","",$_SESSION['tpayment_report']) ;?>  
               </span>
        </li>
		
        <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['tpayment_report']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['tpayment_report']['to_date']?>" >
        </li>        
        <li>
            <label>Site</label>
            <span><?php echo create_dd("site_id","sites","id","name","","", $_SESSION['tpayment_report']);?></span>
         </li>	 
        <li>
            <label>Staff</label>
            <span><?php echo create_dd("staff_id","staff","id","name","status=1","", $_SESSION['tpayment_report']);?></span>
        </li>	   
		 
		<li style="margin-top: 19px;">
            <input class="" type="button" name="submit" id="submit" value="submit" onClick="javascript:search_team_payment();">
        </li>	
		
		<li style="margin-top: 19px;">
            <input class="" type="button" name="Reset" id="Reset" value="Reset" onClick="javascript:rest_team_payment('<?php echo date("Y-m-1"); ?>', '<?php echo date("Y-m-t"); ?>');">
        </li>	
		
        <!--<li style="width:14%;">
           <a href="../admin/images/aba/TeamPayment.aba" class="aba_download" download>Download ABA</a>
        </li>	
          <li style="width:14%;">
           <a href="../admin/images/aba/TeamPayment.csv" class="aba_download" download>Download ABA Excel</a>
        </li>-->			
         
    </ul>
				
</div>

<br>
<div id="view_quote_page">
  <? include("xjax/view_team_payments.php"); ?>
</div>
<script>
	 function search_team_payment(){
		 
		 //from_date  to_date site_id staff_id
		var from_date =  $('#from_date').val();
		var to_date =  $('#to_date').val();
		var site_id =  $('#site_id').val();
		var staff_id =  $('#staff_id').val();
		var staff_type =  $('#staff_type').val();
		
		var str = from_date+'|'+to_date+'|'+site_id+'|'+staff_id+'|'+staff_type;		
		send_data(str , 601,'view_quote_page');
		str = '';
		 
	 }
 
    function rest_team_payment(fromdate, todate){
	  
	   $('#from_date').val(fromdate);
	   $('#to_date').val(todate);
	   $('#site_id').val(0);
	   $('#staff_id').val(0);
	   $('#staff_type').val(0); 
	   
	   var str = fromdate+'|'+todate+'|0|0|';
		send_data(str , 601,'view_quote_page');
	   
    }
 

        $(function() {
			  $("#from_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#to_date").datepicker({dateFormat:'yy-mm-dd'});
        });
    </script>