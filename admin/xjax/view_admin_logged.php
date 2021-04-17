<?php 


   $date = date('Y-m-d');
   $fromdate = date('Y-m-d 00:00:00' , strtotime($date));
   $todate = date('Y-m-d 23:59:00' , strtotime($date));

   $country = array('2'=>'Australia Team' , '1'=>'India Team');
			
		$file1 = "tpl_admin_log.php";
		ob_start(); // start buffer
		include ($_SERVER['DOCUMENT_ROOT']."/admin/crons/crons_tpl/".$file1);
		$str1_data = ob_get_contents(); // assign buffer contents to variable
		ob_end_clean(); // end buffer and remove buffer contents	
		
	//	echo $str1_data;
	
  
  ?>
  
    	
		<?php  
		  echo  $str1_data;
		
		 ?>