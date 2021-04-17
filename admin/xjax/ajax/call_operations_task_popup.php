
<?php  

session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

  if(isset($_POST)) {

     
    $complaint_id = 0;
	 $vars = explode('|',$_POST['id']);
     
	 $id = $vars[0];
	 $track_id = $vars[1];
	 
	 if($track_id == 6 || $track_id == 7){
	  
	     $tracksub = explode('_',$vars[2]);
		 
		 $trackid_head = $tracksub[0];
		 $complaint_id = $tracksub[1];
	 
	 }else{
	   $trackid_head = $vars[2];
	 }
	 
	// echo $complaint_id;
	 
	$gettrackdata =  dd_value(112);
	$getsubdata = getsubheading($track_id);
	 
   $argsql1 = mysql_query("select * from sales_task_track  where id = ".$id." order by id desc limit 0 , 1"); 
   $getdata = mysql_fetch_array($argsql1) ;
   
   $getqdetails = mysql_fetch_assoc(mysql_query("select id  , best_time_contact , booking_id ,name , emailed_client  ,  sms_quote_date , amount ,  step ,denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND id = ".$getdata['quote_id'].""));
   
 ?>        

    
	
	 	 <?php  include_once('get_operations_sales_page.php'); ?>
  <?php  } ?>	