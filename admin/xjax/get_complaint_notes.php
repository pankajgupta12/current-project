<style>
.all_notes {
    border-bottom: solid 1px #ccc;
    display: inline-block;
    padding: 10px 0px;
}
.left_c_notes {
    width: 45%;
    float: left;
}

.right_c_notes {
    width: 45%;
    float: right;
}
#quote_notes_div {
    display: inline-block;
    width: 100%;
}
#quote_notes_div textarea.form-control {
    height: auto;
    font-family: "OpenSans";
    width: 100%;
    text-align: left;
	margin: 15px 40.7617px 0px 0px;
    
}

select#notes_type {
    width: 500px;
    height: 30px;
    /* border: 1px solid black; */
	float: left;
    margin-bottom: 14px;
    margin-top: 12px;
}



</style>
<span style="text-align:left;">
<? 
 
     //echo "Select name , id from job_complaint where job_id = ".$jobid.""; 
    $typeNotes = mysql_fetch_array(mysql_query("Select * from job_complaint where job_id = ".$jobid.""));
	
    $quotedetails = mysql_fetch_array(mysql_query("Select id ,booking_id, email,phone,name from quote_new where booking_id = ".$jobid.""));
	
	$staffDetailssql = mysql_query("SELECT DISTINCT(staff_id) as staffid, job_type_id from job_details where job_id = ".$jobid." AND staff_id != 0");
  
   //print_r($typeNotes);
  
  ?>
	 <h3 style="text-align: center;padding: 10px;">Complaint Notes</h3>
	
	<div class="all_notes">
	 <div class="left_c_notes">
		Quote id: <?php echo $quotedetails['id']; ?>
		Job id: <?php echo $quotedetails['booking_id']; ?>
		 <?php echo $quotedetails['name']; ?>
		 
		<a href="mailto:'<?php echo $quotedetails['email']; ?>"><?php echo $quotedetails['email']; ?></a><br />
		<a href="mailto:'<?php echo $quotedetails['phone']; ?>"><?php echo $quotedetails['phone']; ?></a><br />
	</div>
	<div class="right_c_notes">
	<?php  
	
	$count = mysql_num_rows($staffDetailssql);
	if(!empty($count)) {
		$jobtype =  jobIcone();
		 echo 'Staff Details:<br />';
		    while($data= mysql_fetch_assoc($staffDetailssql)) 
			{
			 
			    $staffDetails = mysql_fetch_array(mysql_query("Select name , email , mobile from staff where id = ".$data['staffid'].""));
				$icondata = $jobtype[$data['job_type_id']];
				 
				 echo '<img class="image_icone" src="icones/job_type32/'.$icondata.'"> '.$staffDetails['name'].' ( '.$staffDetails['mobile'].')';
				 echo '<br/>';
			
		    	/*   <a href="mailto:'.$data['email'].'">'.$data['email'].'</a><br />
				<a href="tel:'.$data['mobile'].'">'.$data['mobile'].'</a><br />';   */ 
			}
	}
?>
</div>
</div>
</span>
<div class="modal-content">


<div id="q_notes_content">
<? include("add_notes_complaint_notes.php");  ?>
<style>
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
</div>
</div>