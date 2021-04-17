
<?php  

session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

  if(isset($_POST)) { 
    
     
   $argsql1 = mysql_query("select * from sales_task_track  where id = ".$_POST['id']." order by id desc limit 0 , 1"); 
   $getdata = mysql_fetch_array($argsql1) ;
   
   $getqdetails = mysql_fetch_assoc(mysql_query("select id , booking_id ,name ,moving_from ,is_flour_from ,  emailed_client  ,  sms_quote_date , amount ,  step ,denied_id , site_id , email , phone , date,booking_date , booking_id from quote_new  where 1 = 1  AND id = ".$getdata['quote_id'].""));
   
 ?>        

    
	
	 	 <?php  include_once('get_sales_page.php'); ?>
  <?php  } ?>	