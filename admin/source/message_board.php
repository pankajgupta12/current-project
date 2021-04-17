<br/>
<?
if(!isset($_SESSION['message_board']['from_date'])){ $_SESSION['message_board']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['message_board']['to_date'])){ $_SESSION['message_board']['to_date'] = date("Y-m-t"); }

 $totaldate = $_SESSION['message_board']['from_date'] .'/'.$_SESSION['message_board']['to_date'];

?>
<script language="javascript">
function refresh_daily_report(field){
	var str = field+"|"+document.getElementById(field).value;
	//alert(str);
	send_data(str,43,'daily_view');
}
</script>
<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        <li>
            
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['message_board']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['message_board']['to_date']?>" >
        </li>        
        <li>
            <label>Job ID</label>
             <input class="" type="text" name="job_id" id="job_id" value="<?php echo $_SESSION['message_board']['job_id']?>" >
         </li>	 
       	         
		<li>
				<strong>&nbsp;</strong>
				  <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="message_board_search(1);" >	
		</li>

		<li>
				<strong>&nbsp;</strong>
				    <input type="reset" name="reset" value="Reset" class="offsetZero btnSet a_search_box1"  onClick="message_board_reset('<?php echo  date("Y-m-1");  ?>' ,'<?php echo  date("Y-m-t");  ?>');">	
		</li>		 
         
    </ul>
				
</div>

<div id="daily_view">
  <? include("xjax/view_message_board.php"); ?>
</div>