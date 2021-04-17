<?
    if(!isset($_SESSION['bbc_invoice']['from_date'])){ $_SESSION['bbc_invoice']['from_date'] = date('Y-m-d' ,  strtotime('-7 day'));  }
    if(!isset($_SESSION['bbc_invoice']['to_date'])){ $_SESSION['bbc_invoice']['to_date'] = date('Y-m-d'); }
    
    $fromdate = date('Y-m-d' ,  strtotime('-7 day'));
    $todate = date('Y-m-d');
?>
 
 <div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        
        <li>
            <label>From Date</label>
             <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['bbc_invoice']['from_date']?>" >
        </li>
        <li>
            
            <label>To date</label>
           <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['bbc_invoice']['to_date']?>">
        </li> 
       	
       	 <!--<li> 
            <label>Priority</label>
            <span><?php // echo create_dd("p_order","system_dd","id","name"," type = 151","",$_SESSION['urgent_notification']);?></span>
        </li>  -->       
       	         
		<li>
				<strong>&nbsp;</strong>
				  <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="search_bbc_invoive();" >	
		</li>

		<li>
				<strong>&nbsp;</strong>
				    <input type="reset" name="reset" value="Reset" class="offsetZero btnSet a_search_box1"  onClick="urgent_search_invoive('<?php echo $fromdate; ?>', '<?php echo $todate; ?>');">	
		</li>		 
         
    </ul>
				
</div>


<div id="daily_view">
  <? include("xjax/view_bbc_invoice.php"); ?>
</div>

<script>

function search_bbc_invoive(value){
	//var str = document.getElementById('view_qute_field').value+"|"+value;
	
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	
	var str = from_date+'|'+to_date;
	
	send_data(str,643,'daily_view');	
}


function urgent_search_invoive(fromdate, todate){
  
     $('#from_date').val(fromdate);
 	 $('#to_date').val(todate);
 	 
	var str = fromdate+'|'+todate;
	send_data(str,643,'daily_view');	
}

</script>