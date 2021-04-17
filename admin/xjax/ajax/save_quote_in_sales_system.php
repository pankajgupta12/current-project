<?php  

session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

    if(isset($_POST)) {
      
		
			$schedule_time_value = $_POST['schedule_time_id'];
			$quote_id = $_POST['qid'];
			$stage_id = $_POST['stage_id'];
			$fallow_created_date = $_POST['fallow_created_date'];


			$schedule_date_time = $fallow_created_date.' '.$schedule_time_value;
			//$fallow_date = $fallow_created_date.' '.$schedule_time_value;

			$admin_name = get_rs_value("admin","name",$_SESSION['admin']);

			$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id).""));

			$call_she  = mysql_query("insert into sales_system set quote_id='".mres($quote_id)."', staff_name='".$admin_name."', admin_id='".$_SESSION['admin']."',site_id=".$quote['site_id'].",stages=".$stage_id.", status=1, task_manage_id='".$_SESSION['admin']."' , task_type='admin' ,  createOn='".date('Y-m-d H:i:s')."'"); 
			
			$lastid = mysql_insert_id();
			
			$call_she1  = mysql_query("insert into sales_task_track set quote_id='".mres($quote_id)."', staff_name='".$admin_name."', admin_id='".$_SESSION['admin']."',site_id=".$quote['site_id'].",stages=".$stage_id.", status=1, fallow_date='".$schedule_date_time."' ,fallow_created_date='".$schedule_date_time."' ,task_manage_id='".$_SESSION['admin']."' , task_type='admin' ,  fallow_time='".$schedule_time_value."' , task_status='1' ,sales_task_id = '".$lastid."' , createOn='".date('Y-m-d H:i:s')."'"); 
			
			$track_lastid = mysql_insert_id();
			
			
			$call_she11  = mysql_query("insert into task_manager set quote_id='".mres($quote_id)."', response_type='0', admin_id='".$_SESSION['admin']."', status=1, fallow_date='".$schedule_date_time."' ,fallow_time='".$schedule_time_value."' , task_type='1' , task_id = '".$track_lastid."' , created_date='".date('Y-m-d H:i:s')."'"); 
			$task_mange_id = mysql_insert_id();
			
			$update11 = mysql_query("UPDATE sales_task_track SET task_manager_id = '".$task_mange_id."'   WHERE id = '".$track_lastid."'" );	
			

			$fallow_time = date('Y-m-d H:i:s' , strtotime("+15 minutes"));

			$saleid = mysql_insert_id();
			$next_action = '';
			$task_result = 'Add New Quote from admin';
			add_sales_follow($saleid , $quote_id , $fallow_time ,$next_action , $task_result );
		
    }
  ?>
  