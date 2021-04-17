<br/>
<?php  
 //$requoteid = $requoteid;
// $applicationID = $appid;
 $reviewdata = mysql_fetch_assoc(mysql_query("SELECT * FROM `bcic_review` WHERE id = '".$review_id."'"));
 
 echo '<h3>Application Id ' .$review_id.'</h3><br/>';
 // echo 'Job Id ' .$Redata['job_id'].'<br/>';
 echo '<p id="custsms"></p>';
   
 ?>
       <div>
            <strong>
                <span><?php echo $reviewdata['name']; ?></span><br/>
                <span><?php echo $reviewdata['email']; ?></span><br/>
                <span><?php echo $reviewdata['phone']; ?></span><br/>
           </strong>
         </div>
         <br/>
<div class="modal-content"> 
   
	
    <div>
		<span id="message_show"></span>
            <a href="javascript:void(0);" onclick="send_data('<?php echo $review_id; ?>|7', 637, 'message_show');"  class="bb_vquote file_icon"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS Answered 1</a>
            <a href="javascript:void(0);" onclick="send_data('<?php echo $review_id; ?>|8', 637, 'message_show');" class="bb_vquote file_icon"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS Not Answered 1</a>
            <a href="javascript:void(0);" onclick="send_data('<?php echo $review_id; ?>|9', 637, 'message_show');"  class="bb_vquote file_icon"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS Answered 2</a>
            <a href="javascript:void(0);" onclick="send_data('<?php echo $review_id; ?>|10', 637, 'message_show');" class="bb_vquote file_icon"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS Not Answered 2</a>
	    	<a href="javascript:void(0);" class="bb_vquote file_icon"><i class="fa fa-envelope-o"aria-hidden="true"></i> Send Invoice</a>
    </div>
   
<h4>Review Notes</h4>
</div>

<div id="quote_notes_comments_div">
	<?php  include('review_notes.php'); ?>
</div>


