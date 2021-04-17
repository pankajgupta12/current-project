<link href="../admin/css/calendar.css" type="text/css" rel="stylesheet" />
<div class="job_wrapper">
<div class="job_back_box">
<span class="add_jobs_text">Modify Admin</span>
<?php
include 'source/class/admin_calendar.php';
 
$calendar = new Calendar();
 
//other information
echo $calendar->show();
?>
<style>
div#calendar ul.label li {
    margin: 0px;
    padding: 0px;
    margin-right: 5px;
    float: left;
    list-style-type: none;
    width: 77px;
    height: 40px;
    line-height: 40px;
    vertical-align: middle;
    text-align: center;
    color: #000;
    font-size: 15px;
    background-color: transparent;
}

div#calendar ul.dates li {
    background-color: #ddd;
    color: #000;
    float: left;
    font-size: 25px;
    height: 77px;
    list-style-type: none;
    margin: 5px 5px 0 0;
    padding: 0;
    position: relative;
    text-align: center;
    vertical-align: middle;
    width: 77px;
}
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
    function dateAdminMarked(id,date , status){
		
		//alert(id+ '========='+date +'===='+status);
		
	    $('#calender-loading').show();
	    $('.job_back_box').attr('id','bodydisabled');
	  
	            $.ajax({
					  url: './xjax/dateadminMarked.php',
					  type: 'get',
					  data: {'id': id,'date':date , 'status':status},
					  success: function(data) {
						 // window.location.reload();
						  $('#calender-loading').hide();
						  $('.job_back_box').attr('id','');
					  }
		        });
    } 
  
  //Thic Code For Nex Month
  
    function DateMarckedAdminFornextMonth(id,month,year){
		
		var page = 'DateMarckedFornextMonth';
		$('#calender-loading').show();
		$('.job_back_box').attr('id','bodydisabled');
	  
	        $.ajax({
					  url: './xjax/nextmonthmarked_admin.php',
					  type: 'post',
					  data: {'id': id,'month':month,'year':year},
					  success: function(data) {
						
						window.location.href = "admin_popup.php?task=admin_roster&id="+ id +"&month="+ month +"&year="+year;
						$('#calender-loading').hide();
						$('.job_back_box').attr('id','');
						
					  }
		        }); 
    }
</script>

</div>
</div>