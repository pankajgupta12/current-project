<!--<script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>-->
<style type="text/css">
	.cke_chrome { margin-top:20px!important;}


</style>

<script type="text/javascript" src="./js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
		tinymce.init({
			selector: 'textarea',
			height: 250,
			menubar: false,
			plugins: [
			'advlist lists charmap print preview',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code'
			],
			toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | code',
			content_css: '//www.tinymce.com/css/codepen.min.css'
			});
	</script>
	
<!--<script language="JavaScript" src="/admin/jscripts/ckeditor.js"></script>-->
<div id="daily_view">
	<?php  
		if(isset($_POST['submit'])) {
			
		   $notes = mysql_real_escape_string($_POST['editor1']);
		   $q_id = mysql_real_escape_string($_POST['q_id']);
		   
		   //echo "Update quote_email_notes set notes = '".$notes."' , createdOn=".date('Y-m-d H:i:s')." where id = ".$q_id."";
		   $bool = mysql_query("Update quote_email_notes set notes = '".$notes."' , createdOn='".date('Y-m-d H:i:s')."' where id = ".$q_id."");
		   if(isset($bool)) {
			   $message =  "1";
		   }else{
			   $message =  "2";
		   }
		}
		
		if(isset($_GET['id'])) {
		  $getData =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE id = ".$_GET['id'].""));
	    }
		
	?>

	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">
			<div class="job_wrapper">
				<div class="job_back_box">
						<span class="add_jobs_text" style="width: 50% !important;">Update <?php echo (str_replace('_', ' ' ,$getData['emal_type'])); ?> For (<?php echo get_rs_value('quote_for_option' , 'name' , $getData['quote_for_type_id']); ?> )</span>
						
						
						<span style="float: right;width: 50%;text-align: right;padding-top: 15px;"><a href="<?php printf( '%s' , $site_name ); ?>/admin/index.php?task=quote_email_notes_list">View List</a></span>
						<?php  if(isset($message) && $message == 1) { ?><span style="float: right;color: green;">Notes Updated successfully.</span> <?php } ?>
						<?php  if(isset($message) && $message == 2) { ?><span style="float: right;color: red;">Somthing Going wrong Please check.</span> <?php } ?>
						
					   <label><strong>Notes</strong></label><br/>
					  <textarea class="ckeditor" name="editor1"><?php echo $getData['notes']; ?></textarea>
					  <input type="hidden" id="q_id" name="q_id" value="<?php echo $_GET['id']; ?>">
					<span class="job_submit_main"><input type="submit" name="submit" class="job_submit" value="submit"></span>
				</div>
			</div>
	    </form>
</div>