<div class="body_container">
	<div class="body_back">
		<div class="container">  
		 <span class="main_head" style="margin-bottom: 6px;">Application Document File</span>
			<ul id='application_image_list'>
				<?php 
					$getfiles = "SELECT * FROM `applications_doc` WHERE applications_id =".$_GET['appl_id'];
					$getfilesquery  = mysql_query($getfiles);
					$countfiles = mysql_num_rows($getfilesquery);
			
				if($countfiles > 0) {
					$i=1;
					while($getappdoc = mysql_fetch_object($getfilesquery)){
						$aplli_id = $getappdoc->id;
					$getexte = end(explode('.',$getappdoc->doc_file)); 
				if(strtolower($getexte) == 'pdf') {
					$img =  "<img src='../../application/images/pdf.jpg' class='imageshow' />";
				}elseif(strtolower($getexte) == 'docx'){
					 $img =  "<img src='../../application/images/Word-icon.png' class='imageshow' />";
				}else {
					$id = $getappdoc->applications_id;
					$doc = $getappdoc->doc_file;
					$img = "<img src='../../application/files/$id/$doc'   class='imageshow' />";
				}	
				$docfile[] = "../../application/files/".$_SESSION['applicant_id']."/".$getappdoc->doc_file;
				
				$fileid = $getappdoc->applications_id;
				$file_name = $getappdoc->doc_file;
				
				$folder_name = $fileid.'/'.$file_name;
				
				?>
					<li id="imagefile_<?php echo $i; ?>">
						<a href="../../application/files/<?php echo $getappdoc->applications_id; ?>/<?php echo $getappdoc->doc_file; ?>" target="_blank" class="group1"><?php echo $img; ?></a>
						<span class="imagedelete" Onclick=" return applicationDelete('<?php echo $i; ?>','<?php echo $aplli_id; ?>','<?php echo $folder_name; ?>')"><img src='source/popup/delete.png' style="height:22px;">
					</li>
					
					<?php $i++; } }else {  ?>
					   <li style="width: 100%;border: 0;">No document found </li>
					<?php    } ?>
			</ul>
		</div>			
	</div>			
	
	 <style>
	     .imagedelete{
			border-radius: 50%;
			color: #fff;
			cursor: pointer;
			font-size: -12px;
			position: absolute;
			top: 105px;
			/*margin-left: 79px;*/
	    }
	 </style>
</div>	
		
<script>
 function applicationDelete(divID,id,folderid){
       //imagefile_
	      if (confirm('Do you want delete this image')) {
				$('#loaderimage').show();
			    $('.loader').attr('id','bodydisabled');
			  var  page = 'application';
	            $.ajax({
					  url: 'source/getimage.php',
					  type: 'get',
					  data: {'div_id': divID,'id':id,'folderid':folderid,'page':page},
					  success: function(data) {
						$('#loaderimage').hide();
						$('.loader').attr('id','');
						$('#imagefile_'+divID).remove();
					  }
		        });
		       return true;
		    }else{
              return false;
		    }		 
		}		 
</script>
