<br/>
<?php  
 $requoteid = $requoteid;
 $Redata = mysql_fetch_assoc(mysql_query("SELECT * FROM `re_quoteing` WHERE id = '".$requoteid."'"));
 
 echo 'Re-Quote Id ' .$requoteid.'<br/>';
  echo 'Job Id ' .$Redata['job_id'].'<br/>';
 
 
 ?>
<br/>

<div class="modal-content"> 
   
	
    <div>
		<span id="message_show"></span>
		<a onclick="javascript:sendrequoteText('8|<?php echo $Redata['job_id']; ?>|<?php echo $requoteid; ?>');"  class="bb_vquote file_icon"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send First Email</a>
		<a onclick="javascript:sendrequoteText('9|<?php echo $Redata['job_id']; ?>|<?php echo $requoteid; ?>');" class="bb_vquote file_icon"><i class="fa fa-comment" aria-hidden="true"></i> Send First SMS</a>
		<a onclick="javascript:sendrequoteText('10|<?php echo $Redata['job_id']; ?>|<?php echo $requoteid; ?>');"  class="bb_vquote file_icon"><i class="fa fa-envelope-o"aria-hidden="true"></i> Send Final Email </a>
		<a onclick="javascript:sendrequoteText('11|<?php echo $Redata['job_id']; ?>|<?php echo $requoteid; ?>');"  class="bb_vquote file_icon"><i class="fa fa-comment" aria-hidden="true"></i> Send Final SMS  </a>
    </div>
	
<br/>
<span>
    
     <textarea rows="3" cols="25"  id="commets" name="commets" onblur="javascript:edit_field(this,'re_quoteing.commets',<?php echo $requoteid; ?>);"><?php echo $Redata['commets'] ?></textarea>
    
</span>
<h4>Add Notes</h4>

<div class="form-group">
	<textarea name="comments" id="comments" class="form-control" placeholder="Type a Note Here" onkeypress="return check_press_enter_quote(event);" style="width:100%"></textarea>
    <input id="comments_button" name="comments_button" type="button" value="add" onclick="javascript:add_re_quote_comment(document.getElementById('comments'),'<?php echo $requoteid; ?>','<?php echo $Redata['job_id']; ?>')" style="display:none; height:100%; width:100%">
</div>

<div id="quote_notes_comments_div">
<?php  include('re_quote_notes.php'); ?>
</div>

</div>

