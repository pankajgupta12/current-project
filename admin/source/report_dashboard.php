<br/>
<?
$_SESSION['page_type']['page_type'] = 2;
//$_SESSION['page_type']['cleaning_type'] = 1;
if(!isset($_SESSION['page_type']['cleaning_type'])){ $_SESSION['page_type']['cleaning_type'] = 1; }
if(!isset($_SESSION['dashboard_report']['from_date'])){ $_SESSION['dashboard_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['dashboard_report']['to_date'])){ $_SESSION['dashboard_report']['to_date'] = date("Y-m-t"); }
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
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['dashboard_report']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['dashboard_report']['to_date']?>">
        </li>        
        <li style="    margin-top: 21px;">
			<input type="button" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_report_dashboard();">	
		</li>
         
    </ul>
	
	<div class="col-md-4" style="float: right;margin-top: -43px;margin-right: 24px;">
			<ul class="dispatch_top_ul">
				  
					<!--<li>
						<span style="width: 200px;">
						   <?php echo create_dd("cleaning_type","system_dd","id","name","type=83","Onchange=\"dashboard_pagechange(this.value , ".$_SESSION['page_type']['cleaning_type'].");\"", $_SESSION['page_type']);?>
					   </span>
				   </li>-->	
				  
				  <li>
					<span style="width: 200px;">
					   <?php echo create_dd("page_type","system_dd","id","name","type=89","Onchange=\"dashboard_pagechange(this.value , ".$_SESSION['page_type']['cleaning_type'].");\"", $_SESSION['page_type']);?>
				   </span>
				  </li>	
			</ul>  	  
	</div>
				
</div>

<div id="daily_view">
  <? include("xjax/view_report_dashboard.php"); ?>
</div>

<script>
 function search_report_dashboard(){
	 
	 from_date = $('#from_date').val();
	 to_date = $('#to_date').val();
	 var str = from_date+'|'+to_date;
	 send_data(str , 539, 'daily_view');
 }
</script>
