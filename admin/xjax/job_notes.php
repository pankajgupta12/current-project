<ul class="list_box_img all_notes">
<? 

$job_notes_data = mysql_query("select * from job_notes where job_id=".$job_id." order by date desc");

while($jnotes = mysql_fetch_assoc($job_notes_data)){ 
	echo '<li>
	<div class="main_images_box">
	<!--<span class="popup_img"><img src="images/buttons/closed.gif"  alt=""/><img src="images/popup_img.png"></span>-->
	<div class="job_created_left">
		<span class="job_created_text">'.$jnotes['heading'].'</span>
	 <span class="manish_text">By '.$jnotes['staff_name'].'<span class="right_date">'.date("h:i a dS M Y",strtotime($jnotes['date'])).'</span></span>
	 </div> 
	 </div>
	 <span class="message_below_text">'.$jnotes['comment'].'</span>	  
	</li>';
	
}

/* $q_notes_data = mysql_query("select * from quote_notes where quote_id=".$quote['id']." order by date desc");

while($qnotes = mysql_fetch_assoc($q_notes_data)){ 
	echo '<li>
	<div class="main_images_box">
	<!--<span class="popup_img"><img src="images/buttons/closed.gif"  alt=""/><img src="images/popup_img.png"></span>-->
	<div class="job_created_left">
		<span class="job_created_text">Quote Notes : '.$qnotes['heading'].'</span>
	 <span class="manish_text">By '.$qnotes['staff_name'].'<span class="right_date">'.date("h:i a dS M Y",strtotime($qnotes['date'])).'</span></span>
	 </div> 
	 </div>
	 <span class="message_below_text">'.$qnotes['comment'].'</span>	  
	</li>';
	
} */

?>
 </ul>
 
  <ul class="list_box_img staff_details" style="display:none">
<? 

$job_notes_data = mysql_query("select * from staff_notes where job_id=".$job_id." order by date desc");
$countResult = mysql_num_rows($job_notes_data);
if($countResult > 0) {
while($jnotes = mysql_fetch_assoc($job_notes_data)){ 
	echo '<li>
	<div class="main_images_box">
	<!--<span class="popup_img"><img src="images/buttons/closed.gif"  alt=""/><img src="images/popup_img.png"></span>-->
	<div class="job_created_left">
		<span class="job_created_text">'.$jnotes['heading'].'</span>
	 <span class="manish_text">By '.$jnotes['staff_name'].'<span class="right_date">'.date("h:i a dS M Y",strtotime($jnotes['date'])).'</span></span>
	 </div> 
	 </div>
	 <span class="message_below_text">'.$jnotes['comment'].'</span>	  
	</li>';
	
}
}else {
    echo "<li>No Result Found</li>";
}


?>
 </ul>
 
 <ul class="list_box_img chat_details" style="display: none;">
<? 

	$job_chat_notes = mysql_query("SELECT * FROM `chat`  WHERE is_chat_job_id =".$job_id." order by chat_exact_time asc");
	$countResult = mysql_num_rows($job_chat_notes);
	if($countResult > 0) {
		while($chatnotes = mysql_fetch_assoc($job_chat_notes)){
			
			//print_r($chatnotes);
			//echo $chatnotes['chat_type'] .'==========='.'admin';
		 
				
			
			echo '<li>
			<div class="main_images_box">
			<!--<span class="popup_img"><img src="images/buttons/closed.gif"  alt=""/><img src="images/popup_img.png"></span>-->
			<div class="job_created_left">
				<span class="job_created_text">'.getnameByID($chatnotes['from'] , $chatnotes['chat_type']).' to '.($chatnotes['to']).'</span>
			 <span class="manish_text">Read '.$chatnotes['sender_read'].'<span class="right_date">'.date("h:i a dS M Y",strtotime($chatnotes['chat_exact_time'])).'</span></span>
			 </div> 
			 </div>
			 <span class="message_below_text">'.$chatnotes['message'].'</span>	  
			</li>';
			
			unset($chatnotes['chat_type']);
			
		}
	}else {
		echo "<li>No Result Found</li>";
	}


?>
 </ul>
 
 <!--<ul class="list_box_img booking_question_details" style="display: none;">
<?php 
$booking_notes_data = mysql_query("SELECT * FROM save_quote_questions WHERE quote_id='".$quote_id."' AND quote_type=3 AND status=1 ORDER BY date DESC");

$countResult = mysql_num_rows($booking_notes_data);

if($countResult > 0) { 

	$heading = $countResult.' Booking Question Attempted';
	
	echo '<li>
			<div class="main_images_box">
				<div class="job_created_left">
					<span class="job_created_text">'.$heading.'</span>
					';
	$i=1;	 
	while($bnotes = mysql_fetch_assoc($booking_notes_data)){
		$admin = $bnotes['admin'];
		$date = $bnotes['date'];
		echo '<p><span class="message_below_text"><strong>'.$i.').</strong> '.$bnotes['quote_question'].'</span></p>';	
		$i++;
	}
	
	echo '<br/><span class="manish_text">By '.$admin.'<span class="right_date">'.date("h:i a dS M Y",strtotime($date)).'</span></span>
				 </div>
			</div>
	
	</li>';
}
else{
	echo "<li>No Booking Question Attempted</li>";
}
?>
 </ul>-->
 
 
 <ul class="list_box_img booking_question_details" style="display: none;">
<?php 
//echo  "select * from 3pm_notes where j_id=".$job_id." order by date desc";

  $q_notes_data = mysql_query("select * from 3pm_notes where job_id=".$job_id." order by date desc");
$countResult = mysql_num_rows($q_notes_data);
if($countResult > 0) {
while($notes = mysql_fetch_assoc($q_notes_data)){ 
	echo '<li>
	<div class="main_images_box">
	<!--<span class="popup_img"><img src="images/buttons/closed.gif"  alt=""/><img src="images/popup_img.png"></span>-->
	<div class="job_created_left">
		<span class="job_created_text">'.$notes['heading'].'</span>
	 <span class="manish_text">By '.$notes['staff_name'].'<span class="right_date">'.date("h:i a dS M Y",strtotime($notes['date'])).'</span></span>
	 </div> 
	 </div>
	 <span class="message_below_text">'.$notes['comment'].'</span>	  
	</li>';
	
}
}else {
    echo "<li>No Result Found</li>";
}

?>
 </ul>



    

    
