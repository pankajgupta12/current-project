<?php

if(isset($_POST)) {
	 
	 //print_r($_POST);
	/* $headingdata = unserialize($_POST['fheading']);
	$export_data = unserialize($_POST['export_data']); */
     $delimiter = '';
    ob_clean();
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $fromdate1 = date('dS_M_Y',strtotime($from_date));
    $to_date = date('dS_M_Y',strtotime($to_date));
    
	 $filename = $fromdate1.'_'.$to_date.'.csv';
    
     $file = fopen($filename,"w");
     
    $export_data = unserialize($_POST['export_data']);
     $fheading = unserialize($_POST['fheading']);
    
    fputcsv($file,$fheading);
    
   

     foreach ($export_data as $line){
            
        fputcsv($file,$line);
     }
    
    fclose($file);
    
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