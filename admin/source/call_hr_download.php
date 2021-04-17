<?php

if(isset($_POST)) {
    $delimiter = '';
    ob_clean();
    $fromdate = $_POST['from_date'];
    $todate =  $_POST['to_date'];
    $fromdate1 = date('dS_M_Y',strtotime($fromdate));
    $todate1 = date('dS_M_Y',strtotime($todate));
    
    $filename = $fromdate1.'_to_'.$todate1.'.csv';
    
     $file = fopen($filename,"w");
     
    $export_data = unserialize($_POST['export_data']);
     $fheading = unserialize($_POST['fheading']);
    
    fputcsv($file,$fheading);
    //[] = 'Out | In'
    
    fputcsv($file, unserialize($_POST['inout'])); 

     foreach ($export_data as $line){
            
        fputcsv($file,$line);
     }
    fputcsv($file, unserialize($_POST['totaldata']));  
    
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