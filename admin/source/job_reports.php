<?
if(!isset($_SESSION['job_report']['from_date'])){ $_SESSION['job_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['job_report']['to_date'])){ $_SESSION['job_report']['to_date'] = date("Y-m-t"); }
 
 $dateString = date("Y-m-1").'|'.date("Y-m-t");
?>
<script language="javascript">

</script>
<div class="nav_form_main" onclick="$('#postcode_div').hide();">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5 job_report_5">
        
		<li class="bb_post">
			<label>Statff Type</label>
			<span>
			<?php echo create_dd("better_franchisee","system_dd","id","name","type=41","","",$_SESSION['job_report']);?> 
			</span> 
        </li>
		
		<li>
			<label>Location</label>
			<span>
			<?php echo create_dd("site_id","sites","id","name","", $_SESSION['job_report']);?>
			</span>
		</li>
		
		<li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php  echo $_SESSION['job_report']['from_date']?>">
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['job_report']['to_date']?>">
        </li> 
		
		<li>

			<label>Staff</label>
			<input class="job_report_5_one" type="text" name="staff_id" id="staff_id" onkeyup="javascript:get_allstaffname(this,'postcode_div')" value="<?php echo   get_rs_value("staff","name",$_SESSION['job_report']['staff_id']);?>" >
			<div class="clear"></div>
			<div  id="postcode_div" class="job_report_5_drop" style="display:none;"></div>
			
		</li>	
		<li>
			<label>&nbsp;</label>
			<input type="button"  id="reset" class="offsetZero btnSent a_search_box" onClick="search_staff_job_reports();"  name="reset" value="Search" />
		</li>	
        <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset"  name="reset" onClick="reset_job_reports('<?php echo $dateString;  ?>'); "value="Reset" />
		</li>			
         
    </ul>
				
</div>



<br>
<div id="daily_view">
  <? include("xjax/view_job_reports.php"); ?>
</div>
<script>
        $(function() {
			  $("#from_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#to_date").datepicker({dateFormat:'yy-mm-dd'});
        });
    </script>