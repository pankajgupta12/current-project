<ul class="list_box_img all_notes">
<? 

$job_notes_data = mysql_query("select * from admin_fault where quote_id=".$quote_id." order by date desc");

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
 ?>

</ul>