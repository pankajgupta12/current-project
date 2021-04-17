<?php 
// include('functions/config.php');                     

   //die;
?>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="source/js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<!-- production -->
<script type="text/javascript" src="source/js/plupload.full.min.js"></script>
<script type="text/javascript" src="source/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>

<!--LightBox--------->
	<link rel="stylesheet" href="source/popup/colorbox.css" />
	<script src="source/popup/jquery.colorbox.js"></script>
<!--LightBox--------->		
    
	
	
	<div id="tab-5" class="loader">
	
		<form name="form1" method="post" action="">
			<div class="tab5_main">
			  <span class="main_head" style="margin-bottom: -33px;">Application Upload Document</span>
			</br></br>
				  <div id="uploader" class="uploadimage">
					<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
				  </div>
				</br>
				<input type="hidden" name="step" id="step" value="1">
				<input type="hidden" name="task" id="task" value="<?php echo $_REQUEST['task'];?>">
				<input type="hidden" name="appl_id" id="appl_id" value="<?php echo $_REQUEST['appl_id'];?>">
			</div>
		</form>
	</div>
	
	
		<script type="text/javascript">
		// Initialize the widget when the DOM is ready
		$(function() {
			
			var appl_id = '<?php echo $_REQUEST['appl_id'];?>';
			var  page = 'admin_doc_file';
			//getuploadimage(jobid);
			$("#uploader").plupload({
				// General settings
				
				runtimes : 'html5,flash,silverlight,html4',
				url : '../../application/source/document_upload.php?applicant_id='+appl_id+'&page='+page,

				// User can upload no more then 20 files in one go (sets multiple_queues to false)
				max_file_count: 10,
				
				chunk_size: '1mb',

				// Resize images on clientside if we can
				resize : {
					width : 800, 
					height : 800, 
					quality : 90,
					crop: false // crop to exact dimensions
				},
				
				filters : {
					// Maximum file size
					max_file_size : '50mb',
					// Specify what files to browse for
					mime_types: [
								{title : "Image files", extensions : "jpg,gif,jpeg,JPEG,png,PNG,JPG,png,doc,pdf,docx"}
						//{title : "Zip files", extensions : "zip"}
					]
				},

				// Rename files by clicking on their titles
				rename: true,
				
				// Sort files
				sortable: true,

				// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
				dragdrop: true,

				// Views to activate
				views: {
					list: true,
					thumbs: true, // Show thumbs
					active: 'thumbs'
				},

				// Flash settings
				flash_swf_url : 'source/js/Moxie.swf',

				// Silverlight settings
				silverlight_xap_url : 'source/js/Moxie.xap'
				
			});
	
		});
		
		</script>
		