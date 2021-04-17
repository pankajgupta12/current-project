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

	<div id="tab-5" class="loaderimage12">
		<form name="form1" method="post" action="">
			<div class="tab5_main">
			</br></br>
				  <div id="uploader" class="uploadimage">
					<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
				  </div>
				</br>
				<input type="hidden" name="step" id="step" value="1">
				<input type="hidden" name="task" id="task" value="<?php echo $_REQUEST['task'];?>">
				<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id'];?>">
				<!--<input type="submit" class="job_submit" value="Upload Image">-->
			</div>
		</form>
	</div>
	
	<div id="tab-5">
	   <img src="xjax/image/loading1.gif" id="loaderimage" style="height:100px"/>
		<h2>Your Image File</h2>
			<div id="uploadImagedata1">
			 <?php  $imageupload = mysql_query("select * from staff_files where staff_id = ".$_REQUEST['id']);
			  echo "<ul id='uploadimageshow' style='margin: 14px;'>";
			  $i=1;
				while($imagedata = mysql_fetch_assoc($imageupload))
				{  
				    $path =  getcwd();
				
			        $url1 =  $imagedata['image_url'];
			        $img_status = $imagedata['doc_copy_status'];
			        
    				if($url1 != '') 
    				{
                        $url = explode('/', $url1);
                        $fileName = $url[count($url) - 1]; 
    					
    					if( $img_status == 0 )
    					{
                            if(@copy( $url1 ,  '/home/bciccom/public_html/admin/img/staff_file/'.$_REQUEST['id'].'/'.$fileName)) {
                                // update status to 1
                                $qry = mysql_query("UPDATE staff_files SET doc_copy_status = 1 WHERE image_url = '".$url1."' AND staff_id = '".$_REQUEST['id']."'  ");
                            }
    					}
    				}
				
				 $getexte = end(explode('.',$imagedata['image']));
				 //print_r($getexte);
				 if($getexte == 'pdf'){
                      $img =  "source/popup/pdf.jpg";
					  $class = '';
				    }else if($getexte == 'docx' || $getexte == 'doc'){
                       $img =  "source/popup/Word-icon.png";
					   $class = '';
					}else {
						$img = 'source/upload/stafffile_'.$_REQUEST['id'].'/'.$imagedata['image'];
						$class = 'group1';
					}	 			
				?>
				
				  <li id="imagefile_<?php echo $i; ?>"><a href="<?php echo  'source/upload/stafffile_'.$_REQUEST['id'].'/'.$imagedata['image']; ?>" class="<?php echo $class;  ?>"><img src="<?php  $img; //echo 'source/upload/stafffile_'.$_REQUEST['id'].'/'.$imagedata['image']; ?>" width="50px" alt="<?php //echo $imagedata['image']; ?>"><span class="imagedelete" Onclick=" return imageDelete('<?php echo $i; ?>','<?php echo $imagedata['id']; ?>','<?php echo $imagedata['image'] ?>')"><img src='source/popup/delete.png' style="height:22px;"></span></a></li>
				
			 <?php  $i++; } 
			  echo "</ul>"; 
			 ?>
			</div> 
	</div>

	<style>
		#uploadimageshow li {
			border: 1px solid;
			display: inline-block;
			padding: 4px;
			margin: 5px;
			position:relative;
		}
	  
	   .imagedelete{
				border-radius: 50%;
			/* color: #fff; */
			cursor: pointer;
			font-size: 13px;
			padding: 1px 6px;
			position: absolute;
			right: -19px;
			top: -10px;
	    }
		#loaderimage{
			margin-left: 446px;
			height: 100px;
			 margin-top: -98px;
			display:none;
		}
		#bodydisabled{
			opacity: 0.5;
		   pointer-events: none;
		}
	</style>
	
		<script type="text/javascript">
		// Initialize the widget when the DOM is ready
		$(function() {
			
			var id = '<?php echo $_REQUEST['id'];?>';
			var  page = 'stafffile';
			//getuploadimage(jobid);
			$("#uploader").plupload({
				// General settings
				
				runtimes : 'html5,flash,silverlight,html4',
				url : 'source/upload.php?job_id='+id+'&page='+page,

				// User can upload no more then 20 files in one go (sets multiple_queues to false)
				max_file_count: 10,
				
				chunk_size: '10mb',

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
						{title : "Image files", extensions : "jpg,jpeg, JPEG, PNG, gif,png,pdf,docx,doc"},
						{title : "Zip files", extensions : "zip"}
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
		
		   $(".uploadimage").click(function(){
			   var id = '<?php echo $_REQUEST['id'];?>';
			   var  page = 'stafffile';
			   // $('#loaderimage').show();
			  // $('.loaderimage12').attr('id','bodydisabled');
			// alert(id11);
		        $.ajax({
					  url: 'source/getimage.php',
					  type: 'get',
					  data: {'id': id,'page':page},
					  success: function(data) {
						//alert(data);
						$("#uploadImagedata1").html(data);
						// $('#loaderimage').hide();
					//	$('.loaderimage12').attr('id','');
					  }
		        });
		  });  	
		  
		 function imageDelete(divID,imageID,image){
       //imagefile_
	      if (confirm('Do you want delete this image')) {
			   $('.loaderimage12').attr('id','bodydisabled');
			    $('#loaderimage').show();
			   var id = '<?php echo $_REQUEST['id'];?>';
			   
			   var  page = 'stafffile';
	            $.ajax({
					  url: 'source/dispatchimagedelete.php',
					  type: 'get',
					  data: {'imageID': imageID,'id':id,'image':image,'page':page},
					  success: function(data) {
						$("#uploadImagedata1").html(data);
						$('.loaderimage12').attr('id','');
						$('#loaderimage').hide();
						//$('#imagefile_'+divID).remove();
					  }
		        });
		       return true;
		    }else{
              return false;
		    }		 
		}	
		</script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				
			});
		</script>