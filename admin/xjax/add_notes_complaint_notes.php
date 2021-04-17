
<div id="quote_notes_div">

<span>
	<?php// echo  create_dd("notes_type","system_dd","id","name","type = 126","Onchange=\"return cehck_notestype(this.value);\"",''); ?>				
	<?php echo  create_dd("notes_type","system_dd","id","name","type = 126","",''); ?>				
</span>

<div class="form-group">
	<textarea name="comments" id="comments" class="form-control" placeholder="Complaint type a Note Here" onkeypress="return check_press_enter_quote(event);" ></textarea>
    <input id="comments_button" name="comments_button" type="button" value="add" onclick="javascript:add_complaite_cehck_notes_comment(document.getElementById('comments'), '<?php echo $jobid;?>', '<?php echo $id;?>')" style="display:none; height:100%; width:100%">
	
</div>


    <div class="bci_jobs_files" id="quote_notes_comments_div">
		<? 
		 $id = $id;
		 
		// echo $id; die;
		   $getComplaintData =  getComplaintsEmail($id);
		   
		   // print_r($getComplaintData);
		   
		   foreach($getComplaintData as $key=>$comdata) {
			    
						$notes_type = '';
						$emailtype = '';
						if($comdata[1] == 0) {
						   $notes_type = '(' .getSystemvalueByID($qnotes['notes_type'], 126).')';
						}
				
				
				 
				 if($comdata['admin_name'] != '' && $comdata[1] == 1)  {
					 
					 $adminname = $comdata['admin_name'];
					 $comment = $comdata['comments'];
					 $heading = $comdata['heading'];
				 }else{
					 $adminname = $comdata[0];
					 $comment = '';
					  
					  //?task=view_job_emails&job_id=19818
					  
                    $heading  =  "<a href=\"javascript:scrollWindow('popup.php?task=view_job_emails&job_id=".$comdata['job_id']."','1300','850')\"><strong>".$comdata['heading']."</strong></a>";
					
						//echo '<strong>#'.$jobs['id'].'</strong></a>";

        			    if($comdata['folder_type'] == 'INBOX') {
					         $emailtype = ' (IN) ';
					    }else if($comdata['folder_type'] == 'Sent') {
					         $emailtype = ' (OUT) ';
					    }
				 
				 }
				
				 echo ' <div class="bci_points">
                    <p class="bci_jdetail"><strong>'.$heading.' '.$notes_type.' </strong><br />'.$comment.'</p>
                    <span class="bci_jname">By '.$adminname.  $emailtype.'</span>
                    <span class="bci_jdate">'.date("h:i a dS M Y",strtotime($comdata['createOn'])).'</span>
                </div>';        
		   } 
			
		/*    $q_notes_data = mysql_query("select * from complaint_notes where complaint_id=".$id." order by createOn  desc");
        
        while($qnotes = mysql_fetch_assoc($q_notes_data)){ 		
            
			$notes_type = '';
			if($qnotes['notes_type'] > 0) {
			  $notes_type = '(' .getSystemvalueByID($qnotes['notes_type'], 126).')';
			}
			
            echo ' <div class="bci_points">
                    <p class="bci_jdetail"><strong>'.$qnotes['heading'].' '.$notes_type.' </strong><br />'.$qnotes['comments'].'</p>
                    <span class="bci_jname">By '.$qnotes['admin_name'].'</span>
                    <span class="bci_jdate">'.date("h:i a dS M Y",strtotime($qnotes['createOn'])).'</span>
                </div>';        
        } */ 
         
        ?>
    </div><!--bci_jobs_files-->
</div>