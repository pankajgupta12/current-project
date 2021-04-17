
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
         $message = '';
	    if(isset($_POST['submit'])) {
			$terms_agreement = mysql_real_escape_string($_POST['editor1']);
			$version = mysql_real_escape_string($_POST['version']);
			$adminID = $_SESSION['admin'];
			$quote_type = mysql_real_escape_string($_POST['quote_type']);
			
			$insertQuery = mysql_query("INSERT INTO `terms_agreement` (`version`, `quote_type`, `terms_agreement`, `login_id`, `createdOn`, `updatedOn`) VALUES ('".$version."', '".$quote_type."',  '".$terms_agreement."', '".$adminID."',  '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
			
			if(isset($insertQuery)) {
				 $message = "<span class='successmessagetag' >One row insert successfully</span>";
			}else{
				$message = "<span class='errormessagetag'>Something going wrong</span>";
			}
			 echo "<script>window.location = '../admin/index.php?task=terms_agreement_list&quote_type=".$quote_type."'</script>";
		}
	 
	 
	
		if(isset($_POST['update'])) {

		   $terms_agreement = mysql_real_escape_string($_POST['editor1']);
		   $version = mysql_real_escape_string($_POST['version']);
		   $id = mysql_real_escape_string($_POST['id']);
		   $quotetype = $_GET['quote_type']; 

		     $bool = mysql_query("Update terms_agreement set terms_agreement = '".$terms_agreement."' , version = '".($version)."' , updatedOn='".date('Y-m-d H:i:s')."' where id = ".$id."");
		   
		  // echo "UPDATE `staff` SET `electronic_consent` = '1'  where better_franchisee = ".$quotetype."";
		   
		  $bool1 = mysql_query("UPDATE `staff` SET `electronic_consent` = '1'  where better_franchisee = ".$quotetype."");

		   if(isset($bool)) {
			   $message =  "<span class='successmessagetag'>One row Updated successfully</span>";
		   }else{
			   $message =  "<span class='errormessagetag'>Something going wrong</span>";
		   }
		}
		
		
	
     if(isset($_GET) && $_GET['id'] != '') {
	    $id = ($_GET['id']);
		$sql  = "SELECT *  FROM `terms_agreement` WHERE id = ".$id."";
	    $query =   mysql_query($sql);
	    $getTermsAgree =   mysql_fetch_assoc($query);
		
		 //print_r($getTermsAgree);
    }

	?>

<style>
   .version_class{
		width: 50%;
		height: 31px;
		margin-bottom: 13px;
   }
   .list_class{
		float: right;
		color: #00b8d4;
		margin-top: -62px;
    }
	.successmessagetag {
		color:green;
		position:  absolute;
		right: 238px;
	}
   
   .errormessagetag {
		color:green;
		position:  absolute;
		right: 238px;
	}
</style>

	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">

			<div class="job_wrapper">

				<div class="job_back_box">
				    <div    style="display: flex;">
					
					 
						<span class="add_jobs_text">
							  <?php  if($getTermsAgree['quote_type'] != '') { ?>
							   Update Terms of agreement  For (<?php echo get_rs_value('quote_for_option' , 'name' , $getTermsAgree['quote_type']); ?> )
						       <?php  } ?>	   
						   </span>
					
					 
						<?php 
                         if($_GET['quote_type'] != '') {
							 $quotetype = $_GET['quote_type'];
						 }else{
							 $quotetype = 1;
						 }
						?>
						
						<span style="float: right;width: 50%;text-align: right;"><a href="../admin/index.php?task=terms_agreement_list&quote_type=<?php echo $quotetype; ?>">View List</a></span>
					</div>	

					   
					   <label><strong>New Version</strong></label><br/>
                       <input type="text" name="version" class="version_class"  value="<?php  if($getTermsAgree['version'] != '') { echo  ($getTermsAgree['version']); } ?>">	
					    <br/>
						 
					    <label><strong>Agreement For</strong></label><br/>
                        <?php  if(isset($message) && $message != '') { echo  $message; } 
						 
						 $sql = mysql_query("SELECT * FROM `quote_for_option`"); ?>
						    <select <?php    if($_GET['quote_type'] != '') { ?> disabled="disabled"  <?php  } ?> name="quote_type" style="height:28px; width:220px;">
								<?php while($data = mysql_fetch_assoc($sql)) {?>
									<option value="<?php echo $data['id']; ?>" <?php if($data['id'] == $getTermsAgree['quote_type']) { echo 'selected'; } ?>><?php echo $data['name']; ?></option>
								<?php  } ?>
						    </select>
					    <br/>	 <br/>	
						 
					   <label><strong>Terms of agreement</strong></label><br/>

					  <textarea class="ckeditor" name="editor1"><?php  if($getTermsAgree['terms_agreement'] != '') { echo $getTermsAgree['terms_agreement']; } ?></textarea>
					  
					<?php if(isset($_GET['id']) && $_GET['id'] != '') {  ?>
                         <input type="hidden" id="id" name="id" value="<?php if($_GET['id'] != '') { echo $_GET['id']; }  ?>">
					     <span class="job_submit_main"><input type="submit" name="update" class="job_submit" value="Update"></span>
					<?php  }else { ?>
					  <span class="job_submit_main"><input type="submit" name="submit" class="job_submit" value="submit"></span>
					<?php  } ?>

				</div>

			</div>

	   </form>

</div>