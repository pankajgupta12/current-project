<br/>
<?
if(!isset($_SESSION['quote_call']['from_date'])){ $_SESSION['quote_call']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['quote_call']['to_date'])){ $_SESSION['quote_call']['to_date'] = date("Y-m-t"); }

?>

<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        <li>
            
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['quote_call']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['quote_call']['to_date']?>" >
        </li>        
        <li>
            <label>Location</label>
                <span>
					<?php echo create_dd("site_id","sites","id","name","","", $_SESSION['quote_call']);?>
				</span>
         </li>	 
       	         
		<li>
				<strong>&nbsp;</strong>
				  <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="quote_call_search(1);" >	
		</li>

		<li>
				<strong>&nbsp;</strong>
				    <input type="reset" name="reset" value="Reset" class="offsetZero btnSet a_search_box1"  onClick="quote_call_reset('<?php echo  date("Y-m-1");  ?>' ,'<?php echo  date("Y-m-t");  ?>');">	
		</li>		 
         
    </ul>
				
</div>

<div id="daily_view">
  <? include("xjax/view_quote_call_queue.php"); ?>
</div>

<script>
  function quote_call_search(){
	var from_date =   $('#from_date').val();
	var todate =   $('#to_date').val();
	var site_id =   $('#site_id').val();
	var str = from_date+'|'+todate+'|'+site_id;
	send_data(str , 523, 'daily_view');
  }
  
   function quote_call_reset(from_date ,  to_date){
	   $('#from_date').val(from_date);
	   $('#to_date').val(to_date);
	   $('#site_id').val(0);
	   
	   var str = from_date+'|'+to_date+'|0';
	  send_data(str , 523, 'daily_view');
   }
</script>