<script>
	function showmaildiv(divid){
		$("."+divid).toggle();
	}
</script>
<style>
.WordSection1 ul {
    margin-left: 25px;
}
</style>
<div class="body_container">
	<div class="body_back">
		<div class="wrapper">
    	    <div class="black_screen1"></div>
        		
<?php 

	function removeStripslashes($text){
		$text =   stripslashes($text);
		$text = preg_replace("/<style\\b[^>]*>(.*?)<\\/style>/s", "", $text);
		$remove_character = array("\n", "\r\n", "\r" , "rn");
		return   str_replace($remove_character , '' , $text);
	 }	
	
	$applicationID = $_GET['appl_id'];
	 $argx = "select * from staff_applications where id='".mysql_real_escape_string($applicationID)."'"; 
	//echo $argx; echo $a;	
	$datax = mysql_query($argx);
	$getAppdata = mysql_fetch_assoc($datax); 
	
	$email = $getAppdata['email'];
	
	$getemaildetails = mysql_query("SELECT * FROM `bcic_email` WHERE email_toaddress like '%{$email}%' OR email_from like '%{$email}%'");
	
	if( mysql_num_rows( $getemaildetails ) == 0 ) {
		
?>
	<span class="main_head" >No Emails</span>
		
<?php  } else { ?>
<span class="main_head" >Email List</span>
<?php
	$k = 0;
	while($emaildetails = mysql_fetch_assoc($getemaildetails)) {
	   
	
?>
<div class="animated fadeInRight" id="email_details_parts" style="background: #FFF;padding: 15px;margin-bottom: 15px;">
						
							<div class="mail-box-header">
								
								<div class="mailTop" id="hederpart">
								
									<div class="mailHead" onclick="showmaildiv('mail_heading<?php echo $emaildetails['id']; ?>')">
										<h3>
											<span class="font-normal" title="">Subject: </span><?php echo $emaildetails['email_subject'] ?>.
										</h3>
									</div>
									<div style="margin:15px 0 0 0;display: none;" class="mailHeadNew mail_heading<?php echo $emaildetails['id']; ?>" <?php if($k != 0) { ?> style="display:none;" <?php } ?>>
									<h5>

										<span class="dateSec pull-right font-normal"><?php //echo changeDateFormate($emaildetails['email_date'],'timestamp'); ?></span>
										<span class="font-normal">From: </span><?php echo $emaildetails['email_from']; ?><br/>
										<span class="font-normal">To: </span><?php echo htmlentities($emaildetails['email_toaddress']); ?>
									</h5>
									</div>
								</div>
							</div>
								<div  style="margin:5px 0 0 0;display: none;" class="mail-box mail_heading<?php echo $emaildetails['id']; ?>" <?php if($k != 0) { ?> 
style="display:none;" <?php  } ?>>

									<div class="mail-body">
										 <?php   echo  $emaildetails['email_body']; ?>
									</div>
											 
										<?php   
										// Email attachment File
											 include($_SERVER['DOCUMENT_ROOT']. '/mail/xjax/email_attachment.php');
											
										?> 
								</div>
							</div>	

<?php 
	$k++;
	}

?>
<?php  } ?>
</div>
</div>
</div>
</div>