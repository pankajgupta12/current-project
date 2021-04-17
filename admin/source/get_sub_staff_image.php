<?php 
include("functions/functions.php");
include("functions/config.php");
		

		$id = mysql_real_escape_string($_GET['id']);
		$page = $_GET['page'];
		
		//if($id != '' && $page == 'sub_staff_doc') {
			
	      $imageupload = mysql_query("SELECT * FROM `sub_staff_files` where sub_staff_id = ".$id);
		     if(mysql_num_rows($imageupload) > 0) {
			  echo "<ul id='uploadimageshow' style='margin: 14px;'>";
			  $i=1;
				while($imagedata = mysql_fetch_assoc($imageupload)){  
				$path =  getcwd();
				
				$getexte = end(explode('.',$imagedata['image']));
			 
			        if($getexte == 'pdf') {
                      $img =  "source/popup/pdf.jpg";
					  $class = '';
				    }elseif($getexte == 'docx' || $getexte == 'doc'){
                       $img =  "source/popup/Word-icon.png";
					   $class = '';
					}else {
						$img = './img/sub_staff_file/'.$id.'/'.$imagedata['image'];
						$class = 'group1';
                 	}
				
				?>
				
				   <li id="imagefile_<?php echo $i; ?>"><a href="<?php   echo './img/sub_staff_file/'.$id.'/'.$imagedata['image']; ?>" class="<?php echo $class; ?>"><img src="<?php echo $img;// echo 'source/upload/stafffile_'.$id.'/'.$imagedata['image']; ?>" width="50px" alt="<?php echo $imagedata['image']; ?>"></a><span class="imagedelete" Onclick=" return sub_staffimageDelete('<?php echo $i; ?>','<?php echo $imagedata['id']; ?>','<?php echo $imagedata['image'] ?>')"><img src='source/popup/delete.png' style="height:22px;"></span></li>
				
			 <?php  $i++; } 
			  echo "</ul>";
			 }else{
				  echo "No result found";
			 }
			 ?>
		<?php  //} ?> 
		<script>
	 		$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				
			});
		</script>