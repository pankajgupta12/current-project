
 
<ul class="list_box_img all_notes">
<? 
	/* if($job_id != '') {
	  $job_id = $job_id;
	}else {
	  $job_id = $_GET['job_id'];
	} */

$job_notes_data = mysql_query("select * from reclean_notes where job_id=".$job_id." order by date desc");
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
 
 
  <ul class="list_box_img staff_details" style="display:none">
<? 

$job_notes_data = mysql_query("select * from reclean_notes where job_id=".$job_id." and specific_re_notes_staff = 1 order by date desc");
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



    

    
