<?php 
//print_r($_GET);
		include("functions/functions.php");
		include("functions/config.php");
		//print_r($_GET);
		$id = mysql_real_escape_string($_GET['id']);
		$page = $_GET['page'];
		
          if($page == 'stafffile') {
	   
			$imageupload = mysql_query("select * from staff_files where staff_id = ".$id);
	   echo "<ul id='uploadimageshow' style='margin: 14px;'>";
			$i = 1;
			while($imagedata = mysql_fetch_assoc($imageupload)){  
			$path =  getcwd();
			//print_r($imagedata);
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
			 
			        if($getexte == 'pdf') {
                      $img =  "source/popup/pdf.jpg";
					  $class = '';
				    }elseif($getexte == 'docx' || $getexte == 'doc'){
                       $img =  "source/popup/Word-icon.png";
					   $class = '';
					}else {
						$img = './img/staff_file/'.$id.'/'.$imagedata['image'];
						$class = 'group1';
                 	}
        // echo 	$img;				
		/*  if($imagedata['image_url'] != ''){
					    $url =  $imagedata['image_url'];
					 }else{
						 $url =  $imagedata['image_url'];
					 } */
		?>
		
		<li id="imagefile_<?php echo $i; ?>"><a href="<?php   echo './img/staff_file/'.$id.'/'.$imagedata['image']; ?>" class="<?php echo $class; ?>"><img src="<?php echo $img; ?>" width="50px" alt="<?php echo $imagedata['image']; ?>"></a><span class="imagedelete" Onclick=" return imageDelete('<?php echo $i; ?>','<?php echo $imagedata['id']; ?>','<?php echo $imagedata['image'] ?>')"><img src='source/popup/delete.png' style="height:22px;"></span></li>
			
			   <!--<li id="imagefile_<?php echo $i; ?>"><a href="<?php   echo './img/staff_file/'.$id.'/'.$imagedata['image']; ?>" class="<?php echo $class; ?>"><img src="<?php echo $img;// echo 'source/upload/stafffile_'.$id.'/'.$imagedata['image']; ?>" width="50px" alt="<?php echo $imagedata['image']; ?>"></a><span class="imagedelete" Onclick=" return imageDelete('<?php echo $i; ?>','<?php echo $imagedata['id']; ?>','<?php echo $imagedata['image'] ?>')"><img src='source/popup/delete.png' style="height:22px;"></span></li>-->
			   
			   
			 <?php $i++; }  ?>
			</ul>
  
   
    <?php  } if($page == 'dispatch') {
          $imageupload = mysql_query("select * from job_images where job_id = ".$id);
		    echo "<ul id='uploadimageshow' style='margin: 14px;'>";
			$i = 1;
            while($imagedata = mysql_fetch_assoc($imageupload)){  
			$path =  getcwd();
			
			$getexte = end(explode('.',$imagedata['image']));
				if($getexte == 'pdf') {
				   $img =  "source/popup/pdf.jpg";
				   $class = '';
				   $target = "target = '_blank'";
				}elseif($getexte == 'docx' || $getexte == 'doc'){
				  $img =  "source/popup/Word-icon.png";
				  $class = '';
				   $target = "target = '_blank'";
				}else {
				  $img = './img/job_file/'.$id.'/'.$imagedata['image'];
				  $class = 'group1';
				 $target = '';
				}
			
	?>
			
			<li id="imagefile_<?php echo $i; ?>"><a href="<?php echo './img/job_file/'.$id.'/'.$imagedata['image']; ?>" <?php echo $target; ?> class="<?php echo $class; ?>"><img src="<?php echo $img; //echo './img/job_file/'.$id.'/'.$imagedata['image']; ?>" width="50px" alt="<?php echo $imagedata['image']; ?>"></a><span class="imagedelete" Onclick="imageDelete('<?php echo $i; ?>','<?php echo $imagedata['id']; ?>','<?php echo $imagedata['image'] ?>')"><img src='source/popup/delete.png' style="height:20px;"></span></li>
			
	<?php $i++; }   ?>
		 <?php  } if($page == 'application') {
			 
			   if($id != '') {
				    $folderid = $_GET['folderid'];
				    $imagepath =  "../../application/files/".$folderid;
				    @unlink($imagepath);
			        mysql_query("Delete from applications_doc where id=".$id."");	
					echo "1";
				}else{
					echo "2";
				}
			 
            }?>
					
					
         <script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				
			});
		</script>