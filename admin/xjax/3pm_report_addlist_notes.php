<div id="quote_notes_div">
<div class="form-group">
	<textarea name="comments" id="comments" class="form-control" placeholder="<?php echo $typeNotes['name']; ?> Type a Note Here" onkeypress="return check_press_enter_quote(event);" ></textarea>
    <input id="comments_button" name="comments_button" type="button" value="add" onclick="javascript:add_quote_cehck_notes_comment(document.getElementById('comments'), '<?php echo $id;?>', '<?php echo $getdata['jid'];?>', '<?php echo $getdata['qid'];?>','<?php echo $type;?>')" style="display:none; height:100%; width:100%">
	
	
	<input id="referesh_comments_button" name="referesh_comments_button" type="button" value="add" onclick="javascript:referesh_quote_comment('<?php echo $quote_id;?>')" style="display:none; height:100%; width:100%">
</div>


    <div class="bci_jobs_files" id="quote_notes_comments_div">
		<? 
		//echo "select * from 3pm_notes where j_id=".$getdata['jid']." order by date desc";
         $q_notes_data = mysql_query("select * from 3pm_notes where j_id=".$id." order by date desc");
        
        while($qnotes = mysql_fetch_assoc($q_notes_data)){ 		
            
            echo ' <div class="bci_points">
                    <p class="bci_jdetail"><strong>'.$qnotes['heading'].'</strong><br />'.$qnotes['comment'].'</p>
                    <span class="bci_jname">By '.$qnotes['staff_name'].'</span>
                    <span class="bci_jdate">'.date("h:i a dS M Y",strtotime($qnotes['date'])).'</span>
                </div>';        
        } 
        
        ?>
    </div><!--bci_jobs_files-->
</div>