<!--<script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>-->
<!--<script language="JavaScript" src="/admin/jscripts/ckeditor.js"></script>-->

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
	
<div id="daily_view">
	<?php  
	 
	
	  
		if(isset($_POST['submit'])) {
		   
		   $term_condition = mysql_real_escape_string($_POST['editor1']);
		   
		   $bool = mysql_query("Update siteprefs set inclusion_exlusion = '".$term_condition."' , inclusion_update_time='".date('Y-m-d H:i:s')."' where id = 1");
		   if(isset($bool)) {
			   $message =  "1";
		   }else{
			   $message =  "2";
		   }
		}
		
		
		  $getData =   mysql_fetch_assoc( mysql_query("SELECT inclusion_exlusion FROM `siteprefs` WHERE id = 1"));
		
		
	  
	?>

	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">
			<div class="job_wrapper">
				<div class="job_back_box">
						<span class="add_jobs_text">Update Inclusion & Exclusion </span>
						  <?php  if(isset($message) && $message == 1) { ?><span style="float: right;color: green;margin-top: -35px;">Inclusion & Exclusion Updated successfully.</span> <?php } ?>
						  <?php  if(isset($message) && $message == 2) { ?><span style="float: right;color: red;margin-top: -35px;">Something Going wrong Please check.</span> <?php } ?>
						  
					   <label><strong>Inclusion & Exclusion</strong></label><br/>
					  <textarea class="ckeditor" name="editor1"><?php echo $getData['inclusion_exlusion']; ?></textarea>
					<span class="job_submit_main"><input type="submit" name="submit" class="job_submit" value="submit"></span>
				</div>
			</div>
	   </form>
</div>