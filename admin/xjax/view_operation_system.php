
<div id="quote_view">
<?php 
           
		  // echo $_SESSION['op_adminid']['task_manage_type'];
			
		    if($_SESSION['op_adminid']['task_manage_type'] == 'all' &&  $_SESSION['op_adminid']['task_manage_type'] != '' && $_SESSION['op_adminid']['task_manage_type'] != '0'){
				$adminid = 'all';
			}elseif($_SESSION['op_adminid']['task_manage_type'] != 'all' && $_SESSION['op_adminid']['task_manage_type'] != '' && $_SESSION['op_adminid']['task_manage_type'] != '0') {
				
				if($_SESSION['op_adminid']['task_manage_type'] != '' && $_SESSION['op_adminid']['task_manage_type'] != 0) {
					$adminid = $_SESSION['op_adminid']['task_manage_type'];
				}else{
					$adminid = $_SESSION['admin'];
				}
		    }else{
				$adminid = $_SESSION['admin'];
			}
			
		    
		
		  // echo $adminid;
		
		$jobicon = jobIcone();
		$getsite = getSite(2);
		$staffdetails =  getAllStaffname();
        $today = date('Y-m-d');
        
	    if($_SESSION['operation']['task_type'] != '0' && $_SESSION['operation']['task_type'] == 1) {
		   $stagesdata = system_dd_type(113,'ordering');
		   include('before_job_day.php');
	    }elseif($_SESSION['operation']['task_type'] == 2) {
		   $stagesdata = system_dd_type(116);
		   include('on_the_day_jobs.php'); 
	    }elseif($_SESSION['operation']['task_type'] == 3) {
		    $stagesdata = system_dd_type(117);
		   include('after_job_day_jobs.php');
	    }elseif($_SESSION['operation']['task_type'] == 4) {
		   $stagesdata = system_dd_type(123);
		   include('reclean_jobs_page.php'); 
	    }elseif($_SESSION['operation']['task_type'] == 5) {
		   $stagesdata = system_dd_type(131);
		   include('reclean_task.php'); 
	    }elseif($_SESSION['operation']['task_type'] == 6) {
		   $stagesdata = system_dd_type(137);
		   include('complaint_track.php'); 
	    }elseif($_SESSION['operation']['task_type'] == 7) {
		   $stagesdata = system_dd_type(138);
		   include('complaint_cleaner_haandling_track.php'); 
	    }elseif($_SESSION['operation']['task_type'] == 8) {
		   $stagesdata = system_dd_type(152);
		   include('review_system.php'); 
	    }elseif($_SESSION['operation']['task_type'] == 9) {
		   $stagesdata = system_dd_type(55,'ordering');
		   include('application_system.php'); 
	    }
		
		
?>
</div>
<script src="../adminsales_system/js/bootstrap.min.js"></script>
<script>
 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
   

    function saveFormData(salesid , trackid , trackheadid) {
	 
	    // and_data qus
		var question = $('input[name^=qus]').map(function(idx, elem) {
		  return $(elem).val();
		}).get();
		
		
			  var ans = $('input[name^=ans_data]:checked').map(function(idx, elem) {
			return $(elem).val();
			}).get();  
		
			str = 	salesid+'|'+trackid+'|'+trackheadid+'|'+question+'|'+ans;
			//alert(str);
			  //alert(salesid + ' ====== '+ trackid + ' ====== '+ trackheadid);
			 /*  console.log(question);
			  console.log(ans); */
			  send_data(str , 586 , 'getdata_1');
	 
    } 

	  function OprationsopenModal(id)
	{
		 $('#myModal').modal();
		   var DataString = 'id='+id;
				$.ajax({
					url: 'xjax/ajax/call_operations_task_popup.php',
					type: 'POST',
					datatype: 'html',
					data: DataString,
					success: function(resp){
						$('#getdata').html(resp);
					} 

				});  
	}

    function OprationsopenQuesModal(id , track_id , trackid_head){
		 
			$('#myModal_data').modal();
			var DataString = 'id='+id+'&track_id='+track_id+'&trackid_head='+trackid_head;
				$.ajax({
						url: 'xjax/ajax/call_operations_question_popup.php',
						type: 'POST',
						datatype: 'html',
						data: DataString,
						success: function(resp){
							$('#getdata_1').html(resp);
						} 
				}); 
	}	
</script>