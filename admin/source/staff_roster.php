<link href="../admin/css/calendar.css" type="text/css" rel="stylesheet" />
<div class="job_wrapper">
<div class="job_back_box">
<span class="add_jobs_text">Modify Staff</span>
<?php
//include 'source/class/admin_calendar.php';
//include 'source/class/admin_calendar.php';
include 'source/class/calendar.php';
 
$calendar = new Calendar();
 
//other information
echo $calendar->show();
?>
<style>
#calender-loading {
  left: 40%;
  position: absolute;
  top: 150px;
  width: 150px;
  z-index: 9999;
  display:none;
}

.box-content {
  position: relative;
}
 #bodydisabled{
			opacity: 0.5;
		   pointer-events: none;
		}
</style>
<script>
//job_back_box
//This Code For One day Change Yes Or No
    function dateMarked(id,date , status){
		
		//alert(id+ '========='+date +'===='+status);
		
	    $('#calender-loading').show();
	    $('.job_back_box').attr('id','bodydisabled');
	  
	            $.ajax({
					  url: './xjax/dateMarked.php',
					  type: 'get',
					  data: {'id': id,'date':date , 'status':status},
					  success: function(data) {
						  window.location.reload();
						  $('#calender-loading').hide();
						  $('.job_back_box').attr('id','');
					  }
		        });
    } 
  
  //Thic Code For Nex Month
  
    function DateMarckedFornextMonth(id,month,year){
		
		var page = 'DateMarckedFornextMonth';
		$('#calender-loading').show();
		$('.job_back_box').attr('id','bodydisabled');
	  
	        $.ajax({
					  url: './xjax/nextmonthmarked.php',
					  type: 'post',
					  data: {'id': id,'month':month,'year':year},
					  success: function(data) {
						
						window.location.href = "staff_details.php?task=staff_roster&id="+ id +"&month="+ month +"&year="+year;
						$('#calender-loading').hide();
						$('.job_back_box').attr('id','');
						
					  }
		        }); 
    }
</script>

</div>
</div>