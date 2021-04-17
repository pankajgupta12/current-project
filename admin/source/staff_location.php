<?php  
$staff_id = mysql_real_escape_string($_REQUEST['id']);
?>
<!--<div id="datepicker"></div>-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <?php 
     if($_SESSION['staff_location']['staff_location_date'] == "") {
      $_SESSION['staff_location']['staff_location_date'] = date('Y-m-d',strtotime('yesterday'));
    } ?>
  
<br><br><br>
<div class="dateRange">  
<label>Select Date: </label><input type="text" class="formControler" id="datepicker" name="datepicker" value="<?php if( isset($_SESSION['staff_location']['staff_location_date']) && $_SESSION['staff_location']['staff_location_date']!= NULL  ) { echo $_SESSION['staff_location']['staff_location_date']; } else { echo  date('Y-m-d',strtotime('yesterday')); } ?>" onChange="get_staff_location(this.value,'<?php echo $staff_id; ?>');" />

<input type="button" value="Show Hide Map" class="staff_button" onclick="javascript:show_hide_map();" style="float: right;
    margin-right: 70%;
    height: 36px;
    margin-top: 0px">
<!--LightBox--------->	
</div>	
<br>
<script>
$( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});

function show_hide_map(){
	
	if($(".myNewMapArea").attr('style')==null || $(".myNewMapArea").attr('style')=='display: flex;'){
		//$(".location-list").css({"overflow":"auto", "width":"100%", "height":"650px"});
		//$(".location-list").css({"overflow":"auto", "width":"100%", "height":"650px"});
	}
	else{
		//$(".location-list").css({"overflow":"auto", "width":"100%", "height":"260px"});
	}
	
	$("#show_hide_map").toggle();
	$(".myNewMapArea").toggle();
}


</script> 
	<div id="tab-5" >
		<?php  include('xjax/staff_location.php'); ?>
	</div>
	
	
	