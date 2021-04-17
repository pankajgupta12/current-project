<?php 
$head_text = ($quote_type == 3 ? 'Booking': 'Quote');

$rs_save_quote_questions = mysql_query("SELECT * FROM save_quote_questions WHERE quote_id=".$quote_id." AND quote_type='".$quote_type."' AND status=1 ORDER BY date DESC");

$tr_save_quote_questions = mysql_num_rows($rs_save_quote_questions);

$heading = $tr_save_quote_questions.' '.$head_text.' questions attempted';

if($tr_save_quote_questions > 0) { 

	echo ' <div class="bci_jobs_files" id="quote_notes_comments_div" style="height:150px;">
			<div class="bci_points">
			<p class="bci_jdetail"><strong>'.$heading.'</strong><br/><br/></p>';

	$i=1;
	while($row_save_quote_questions = mysql_fetch_assoc($rs_save_quote_questions)){ 		
		
		$date = date("h:i a dS M Y",strtotime($row_save_quote_questions['date']));
		$admin = $row_save_quote_questions['admin'];
		
		echo ' 	<p class="bci_jdetail"><strong>'.$i.')</strong>. '.$row_save_quote_questions['quote_question'].'</p>
				
			';        
	$i++;}
	echo '	<span class="bci_jname">By '.$admin.'</span>
			<span class="bci_jdate">'.$date.'</span>
		  </div></div>';
}
else{ 
	echo '<span style="color:red;">'.$head_text.' Questions Not Attempted</span>';
}
?>
</div>