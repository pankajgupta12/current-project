<br>
<?
if(!isset($_SESSION['bbc_leads']['from_date'])){ $_SESSION['bbc_leads']['from_date'] = date("Y-m-d"); }
// $dateString = date("Y-m-1").'|'.date("Y-m-t");
?>

<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        
		 <li>
            <label>Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['bbc_leads']['from_date'];?>" >
        </li>
       
         <li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:bbc_leads_quote();">	
		</li>    		 
       		
         
    </ul>
				
</div>
<br/><br/>
<div id="daily_view">
  <? include("xjax/view_bbc_leads.php"); ?>
</div>

<script>
	function bbc_leads_quote(){
		from_date = $('#from_date').val();
		
		str = from_date;
		send_data(str , 600 , 'daily_view');
	}

	
</script>