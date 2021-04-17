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
		   
		   $bool = mysql_query("Update sites_term_condition set term_condition = '".$term_condition."' , updatedOn='".date('Y-m-d H:i:s')."' where id = ".$_GET['id']."");
		   if(isset($bool)) {
			   $message =  "1";
		   }else{
			   $message =  "2";
		   }
		}
		
		if(isset($_GET['id']) && $_GET['id'] !='') {
		  $getData =   mysql_fetch_assoc( mysql_query("SELECT term_condition , quote_type FROM `sites_term_condition` WHERE id = ".$_GET['id'].""));
		}
		
		
	  
	?>

	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">
			<div class="job_wrapper">
				<div class="job_back_box">
						<span class="add_jobs_text">Update Term & Condition For (<?php echo get_rs_value('quote_for_option' , 'name' , $getData['quote_type']); ?> )
							
						<span style="float: right;width: 50%;text-align: right;padding-top: 15px;"><a href="<?php printf( '%s' , $site_name ); ?>/admin/index.php?task=term_condition_list">View List</a></span>
						
						</span>
						
						
						
						  <?php  if(isset($message) && $message == 1) { ?><span style="float: right;color: green;margin-top: -35px;">Term & Condition Updated successfully.</span> <?php } ?>
						  <?php  if(isset($message) && $message == 2) { ?><span style="float: right;color: red;margin-top: -35px;">Somthing Going wrong Please check.</span> <?php } ?>
						  
					   <label><strong>Term & Condition</strong></label><br/>
					  <textarea class="ckeditor" name="editor1"><?php echo $getData['term_condition']; ?></textarea>
					<span class="job_submit_main"><input type="submit" name="submit" class="job_submit" value="submit"></span>
				</div>
			</div>
	   </form>
</div>