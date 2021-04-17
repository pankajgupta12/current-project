
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
			$email_value = mysql_real_escape_string($_POST['editor1']);
			$adminID = $_SESSION['admin'];
			$email_type = mysql_real_escape_string($_POST['email_type']);
			
			$insertQuery = mysql_query("INSERT INTO `bcic_email_template` (`email_type`, `email_value`, `login_id`, `createdOn`, `updatedOn`) VALUES ('".$email_type."', '".$email_value."', '".$adminID."',  '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
			
			if(isset($insertQuery)) {
				 $message = "<span class='successmessagetag' >One row insert successfully</span>";
			}else{
				$message = "<span class='errormessagetag'>Something going wrong</span>";
			}
			 echo "<script>window.location = '../admin/index.php?task=email_template_list'</script>";
		}
	 
	 
	
		 if(isset($_POST['update'])) {

		    $email_value = mysql_real_escape_string($_POST['editor1']);
		    $id = mysql_real_escape_string($_POST['id']);
 
		    $bool = mysql_query("Update bcic_email_template set email_value = '".$email_value."' ,  updatedOn='".date('Y-m-d H:i:s')."' where id = ".$id."");

		   if(isset($bool)) {
			   $message =  "<span class='successmessagetag'>One row Updated successfully</span>";
		   }else{
			   $message =  "<span class='errormessagetag'>Something going wrong</span>";
		   }
		}
		 
		
	
      if(isset($_GET) && $_GET['id'] != '') {
	    $id = ($_GET['id']);
		$sql  = "SELECT *  FROM `bcic_email_template` WHERE id = ".$id."";
	    $query =   mysql_query($sql);
	    $getemailsdata =   mysql_fetch_assoc($query);
		
		 //print_r($getTermsAgree);
    } 

	?>

<style>
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
		.email_template_label {
	       list-style-type: none;
	    }
	   .email_template_label li {
		       padding: 14px;
	   }
</style>

	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">

			<div class="job_wrapper">

				<div class="job_back_box">
				    <div    style="display: flex;">
					
					 
						<span class="add_jobs_text">
							 <?php  if($message != '') {echo $message; } ?>	   
						   </span>
						
						<span style="float: right;width: 50%;text-align: right;"><a href="../admin/index.php?task=email_template_list">View List</a></span>
					</div>	

					   
				<ul class="email_template_label">		
                    				
					    <li>
						  <label><strong>Email Type</strong></label><br/>
							<span>
							 <?php echo create_dd("email_type","system_dd","id","name","type=72","",$getemailsdata);?>    
							</span>	
					</li> 
				
				    <li>
						 
					   <label><strong>Email </strong></label><br/>

					  <textarea class="ckeditor" name="editor1"><?php  if($getemailsdata['email_value'] != '') { echo $getemailsdata['email_value']; } ?></textarea>
					</li>  
					<li>  
					  
					<?php  if(isset($_GET['id']) && $_GET['id'] != '') {  ?>
                         <input type="hidden" id="id" name="id" value="<?php if($_GET['id'] != '') { echo $_GET['id']; }  ?>">
					     <span class="job_submit_main"><input type="submit" name="update" class="job_submit" value="Update"></span>
					<?php  }else { ?>
					  <span class="job_submit_main"><input type="submit" name="submit" class="job_submit" value="submit"></span>
					<?php  }  ?>
                     </li>  
				</ul> 
				</div>

			</div>

	   </form>

</div>