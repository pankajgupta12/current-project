<?php  
$sql = mysql_query("SELECT * FROM `re_quote_notes` WHERE re_quote_id = '".$requoteid."' ORDER BY id desc");

$count = mysql_num_rows($sql);
 ?>


<div class="bci_jobs_files" >
             <?php   if($count > 0) { 
             
               while($data1 = mysql_fetch_array($sql)) {
             ?>
		         <div class="bci_points">
                    <p class="bci_jdetail"><strong><?php echo $data1['heading']; ?></strong><br><?php echo $data1['comment']; ?> </p>
                    <span class="bci_jname">By <?php echo $data1['staff_name']; ?> </span>
                    <span class="bci_jdate"><?php echo $data1['date']; ?></span>
                </div>
            <?php } }else { ?>    
             
               <div class="bci_points">
                    <p class="bci_jdetail"><br>No Comments... </p>
                    
                </div>
            
            <?php  } ?>
</div><style>
  .called_details {
    list-style-type: none;
   
}
 .called_details li {
    float: left;
}

#quote_notes_div {
    display: inline-block;
}
</style>