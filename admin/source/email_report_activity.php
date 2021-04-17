<?php

if(isset($_POST)) {
    $delimiter = '';
    ob_clean();
    $fromdate = $_POST['from_date'];
    $admin_id = $_POST['admin_id'];
    $fromdate1 = date('dS_M_Y',strtotime($fromdate));
    
	 if($admin_id != 0) {
		   $adminname = get_rs_value("admin","name",$admin_id);
          $filename = $adminname. '_on_'.$fromdate1.'.csv';
	 }else{
		 $filename = $fromdate1.'.csv';
	 }
    
     $file = fopen($filename,"w");
     
    $export_data = unserialize($_POST['export_data']);
     $fheading = unserialize($_POST['fheading']);
    
    fputcsv($file,$fheading);
    
   

     foreach ($export_data as $line){
            
        fputcsv($file,$line);
     }
    //fputcsv($file, unserialize($_POST['totaldata']));  
    
    fclose($file);
    
   // download
   
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=".$filename);
    header("Content-Type: application/csv; ");  
     ob_clean();
    
    readfile($filename);
     ob_flush();
      unlink($filename);
    exit();
}
?>