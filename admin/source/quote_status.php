<link href="../css/general.css" rel="stylesheet" type="text/css">
<br>
<?
if(!isset($_SESSION['quote_with_status']['from_date'])){ $_SESSION['quote_with_status']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['quote_with_status']['to_date'])){ $_SESSION['quote_with_status']['to_date'] = date("Y-m-t"); }
 
 $dateString = date("Y-m-1").'|'.date("Y-m-t");
?>
<script language="javascript">

</script>
<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        <!--<li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['quote_with_status']['from_date']?>" onChange="javascript:quote_with_status('from_date');">
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['quote_with_status']['to_date']?>" onChange="javascript:quote_with_status('to_date');">
        </li> 
		 <li>
            <label>Site</label>
            <span><?php echo create_dd("site_id","sites","id","name","","onchange=\"javascript:quote_with_status('site_id');\"", $_SESSION['quote_with_status']);?></span>
         </li>-->
		 
		 <li>
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['quote_with_status']['from_date']?>" >
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['quote_with_status']['to_date']?>">
        </li> 
		 <li>
            <label>Site</label>
            <span><?php echo create_dd("site_id","sites","id","name","","", $_SESSION['quote_with_status']);?></span>
         </li>
         <li>
			<input type="button" style="margin-top:26px !important;cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="javascript:search_quote_status_report();">	
		</li>    		 
        <li>
			<label>&nbsp;</label>
			<input type="reset"  id="reset" onclick="javascript:reset_quote_with_status('<?php echo $dateString; ?>','from_date|to_date|site_id');" name="reset" value="Reset" />
		</li>			
         
    </ul>
				
</div>



<br>
<div id="daily_view">
  <? include("xjax/quote_with_status.php"); ?>
</div>
<script>
        $(function() {
			  $("#from_date").datepicker({dateFormat:'yy-mm-dd'});
			  $("#to_date").datepicker({dateFormat:'yy-mm-dd'});
        });
    </script>