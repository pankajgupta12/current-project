<br/>
<?
if(!isset($_SESSION['calling_date']['date'])){ $_SESSION['calling_date']['date'] = date("Y-m-d" , strtotime('-1 day')); }
if(!isset($_SESSION['calling_date']['admin_id'])){ $_SESSION['calling_date']['admin_id'] = 0; }
// $totaldate = $_SESSION['date']['date'];

?>
<script language="javascript">
 function daily_call_get(){
	 var date = $('#date').val();
	 var admin_id = $('#admin_id').val();
	 
	var str = date+"|"+admin_id;
	//alert(str);
	send_data(str,624,'daily_view');
} 
function rest_daily_call_get(calldate){
	
	var date = $('#date').val(calldate);
	var admin_id = $('#admin_id').val(0);
	var str = calldate+"|0";
	
	send_data(str,624,'daily_view');
} 
</script>
<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        <li>
            
            <label> Date</label>
            <input class="date_class" type="text" name="date" id="date" value="<?php echo $_SESSION['calling_date']['date']?>" >
        </li>
		 <li>
		     
            <label> Admin</label>
                <span><?php   echo   create_dd("admin_id","c3cx_users","id","3cx_user_name","is_active = 1 AND team_type = 1","",'',$_SESSION['calling_date']); ?> </span>
       	    </li>      
		<li>
				<strong>&nbsp;</strong>
				  <input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onClick="daily_call_get();" >	
		</li>

		<li>
				<strong>&nbsp;</strong>
				    <input type="reset" name="reset" value="Reset" class="offsetZero btnSet a_search_box1"  onClick="rest_daily_call_get('<?php echo  date("Y-m-d" , strtotime('-1 day'));  ?>');">	
		</li>		 
         
    </ul>
				
</div>

<div id="daily_view">
  <? include("xjax/view_daily_call_report.php"); ?>
</div>