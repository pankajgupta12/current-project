<br/>
<?

$_SESSION['page_type']['page_type'] = 3;
if(!isset($_SESSION['page_type']['cleaning_type'])){ $_SESSION['page_type']['cleaning_type'] = 1; }
if(!isset($_SESSION['daily_report']['from_date'])){ $_SESSION['daily_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['daily_report']['to_date'])){ $_SESSION['daily_report']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['daily_report']['site_id'])){ $_SESSION['daily_report']['site_id'] = "0"; }
if(!isset($_SESSION['daily_report']['staff_id'])){ $_SESSION['daily_report']['staff_id'] = "0"; }
if(!isset($_SESSION['daily_report']['job_type'])){ $_SESSION['daily_report']['job_type'] = "1"; }

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
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['daily_report']['from_date']?>" onChange="javascript:refresh_daily_report('from_date');">
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['daily_report']['to_date']?>" onChange="javascript:refresh_daily_report('to_date');">
        </li>        
        <li>
            <label>Site</label>
            <span><?php echo create_dd("site_id","sites","id","name","","onchange=\"javascript:refresh_daily_report('site_id');\"", $_SESSION['daily_report']);?></span>
         </li>	 
        <li>
            <label>Staff</label>
            <span><?php echo create_dd("staff_id","staff","id","name","status=1","onchange=\"javascript:refresh_daily_report('staff_id');\"", $_SESSION['daily_report']);?></span>
         </li>	      
		  <li>
            <label>Job Type</label>
            <span><?php echo create_dd("job_type","system_dd","id","name","type=83","onchange=\"javascript:refresh_daily_report('job_type');\"", $_SESSION['daily_report']);?></span>
         </li>	 
         
    </ul>
	
	<div class="col-md-4" style="float: right;margin-top: -59px;margin-right: 44px;">
		  <ul class="dispatch_top_ul">
		  
		  
		  
		    <!--<li>
					<span style="width: 200px;">
					   <?php echo create_dd("cleaning_type","system_dd","id","name","type=83","Onchange=\"dashboard_pagechange(this.value,".$_SESSION['page_type']['cleaning_type'].");\"", $_SESSION['page_type']);?>
				   </span>
			 </li>-->	
		  
		  <li>
			<span style="width: 200px;">
			   <?php echo create_dd("page_type","system_dd","id","name","type=89","Onchange=\"dashboard_pagechange(this.value,".$_SESSION['page_type']['cleaning_type'].");\"", $_SESSION['page_type']);?>
		   </span>
		  </li>
        </ul>  		  
	 </div>
				
</div>

<div id="daily_view">
  <? include("xjax/daily_report.php"); ?>
</div>
