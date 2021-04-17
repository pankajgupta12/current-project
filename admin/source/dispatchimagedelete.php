<?php 
	include("functions/functions.php");
	include("functions/config.php");

      
	if($_GET['page'] == 'dispatch') {
		$imageID1 = $_GET['imageID'];
		$id1 = mysql_real_escape_string($_GET['id']);
		$image1 = $_GET['image'];
		$page = mysql_real_escape_string($_GET['page']);
        //$job_id = explode("_",$id1);		
		
       $path =  getcwd();
	  // echo './img/job_file/'.$id1.'/'.$image1; 
	    @unlink('../img/job_file/'.$id1.'/'.$image1);
	    $query = mysql_query('delete from job_images where id='.$imageID1);

        $imageupload = mysql_query("select * from job_images where job_id =".$id1);
		echo "<ul id='uploadimageshow' style='margin: 14px;'>";
			$j = 1;
            while($imagedata = mysql_fetch_assoc($imageupload)){
				
			?>
			  <li id="imagefile_<?php echo $j; ?>"><a href="<?php echo './img/job_file/'.$id1.'/'.$imagedata['image']; ?>" class="group1"><img src="<?php echo './img/job_file/'.$id1.'/'.$imagedata['image']; ?>" width="50px" alt="<?php echo $imagedata['image']; ?>"></a><span class="imagedelete" Onclick="imageDelete('<?php echo $j; ?>','<?php echo $imagedata['id']; ?>','<?php echo $imagedata['image'] ?>')"><img src='source/popup/delete.png' style="height:22px;"></span></li>
			  
        <?php $j++; }  ?>
        </ul>
		
	<?php  } 	if($_GET['page'] == 'stafffile') {
		$imageID1 = $_GET['imageID'];
		$id1 = mysql_real_escape_string($_GET['id']);
		$image1 = $_GET['image'];
		$page = mysql_real_escape_string($_GET['page']);
	   //echo $imageID1;
	   // $staffID = explode("_",$id1);
	   // print_r($staffID);
		$path1 =  getcwd();
	    @unlink('../img/staff_file/'.$id1.'/'.$image1);
	    $query = mysql_query('delete from staff_files where id='.$imageID1);

         $imageupload1 = mysql_query("select * from staff_files where staff_id=".$id1); 
		echo "<ul id='uploadimageshow' style='margin: 14px;'>";
			$i = 1;
            while($imagedata1 = mysql_fetch_assoc($imageupload1)){  
			
			 $getexte = end(explode('.',$imagedata1['image']));
			    //echo $getexte[1]; 
		            if($getexte == 'pdf'){
                      $img =  "source/popup/pdf.jpg";
					  $class = '';
				    }elseif($getexte == 'docx' || $getexte == 'doc'){
                       $img =  "source/popup/Word-icon.png";
					   $class = '';
					}else {
						$img = './img/staff_file/'.$id1.'/'.$imagedata1['image'];
						$class = 'group1';
                 	}
			
			?>
			  <li id="imagefile_<?php echo $i; ?>"><a href="<?php echo './img/staff_file/'.$id1.'/'.$imagedata1['image']; ?>" class="<?php echo $class; ?>"><img src="<?php echo $img; // echo  'source/upload/'.$id1.'/'.$imagedata1['image']; ?>" width="50px" alt="<?php echo $imagedata1['image']; ?>"></a><span class="imagedelete" Onclick="imageDelete('<?php echo $i; ?>','<?php echo $imagedata1['id']; ?>','<?php echo $imagedata1['image'] ?>')"><img src='source/popup/delete.png' style="height:20px;"></span></li>
			  
        <?php $i++; }  ?>
        </ul>
	<?php  }elseif($_GET['page'] == 'sub_staff') {
	
	     $imageID1 = $_GET['imageID'];
		$id1 = mysql_real_escape_string($_GET['id']);
		$image1 = $_GET['image'];
		$page = mysql_real_escape_string($_GET['page']);
	   //echo $imageID1;
	   // $staffID = explode("_",$id1);
	   // print_r($staffID);
		$path1 =  getcwd();
	    @unlink('../img/sub_staff_file/'.$id1.'/'.$image1);
	    $query = mysql_query('delete from sub_staff_files where id='.$imageID1);

         $imageupload1 = mysql_query("select * from sub_staff_files where sub_staff_id=".$id1); 
		echo "<ul id='uploadimageshow' style='margin: 14px;'>";
			$i = 1;
            while($imagedata1 = mysql_fetch_assoc($imageupload1)){  
			
			 $getexte = end(explode('.',$imagedata1['image']));
			    //echo $getexte[1]; 
		            if($getexte == 'pdf'){
                      $img =  "source/popup/pdf.jpg";
					  $class = '';
				    }elseif($getexte == 'docx' || $getexte == 'doc'){
                       $img =  "source/popup/Word-icon.png";
					   $class = '';
					}else {
						$img = './img/sub_staff_file/'.$id1.'/'.$imagedata1['image'];
						$class = 'group1';
                 	}
			
			?>
			  <li id="imagefile_<?php echo $i; ?>"><a href="<?php echo './img/sub_staff_file/'.$id1.'/'.$imagedata1['image']; ?>" class="<?php echo $class; ?>"><img src="<?php echo $img; // echo  'source/upload/'.$id1.'/'.$imagedata1['image']; ?>" width="50px" alt="<?php echo $imagedata1['image']; ?>"></a><span class="imagedelete" Onclick="imageDelete('<?php echo $i; ?>','<?php echo $imagedata1['id']; ?>','<?php echo $imagedata1['image'] ?>')"><img src='source/popup/delete.png' style="height:20px;"></span></li>
			  
        <?php $i++; }  ?>
        </ul>
	
	<?php  }elseif($_GET['page'] == 'real_estate_page') {
	
	     $imageID1 = $_GET['imageID'];
		$id1 = mysql_real_escape_string($_GET['id']);
		$image1 = $_GET['image'];
		$page = mysql_real_escape_string($_GET['page']);
	   //echo $imageID1;
	   // $staffID = explode("_",$id1);
	   // print_r($staffID);
		$path1 =  getcwd();
	    @unlink('../img/real_estate_file/'.$id1.'/'.$image1);
	    $query = mysql_query('delete from real_estate_docs_file where id='.$imageID1);

         $imageupload1 = mysql_query("select * from real_estate_docs_file where real_estate_agent_id=".$id1); 
		echo "<ul id='uploadimageshow' style='margin: 14px;'>";
			$z = 1;
            while($imagedata1 = mysql_fetch_assoc($imageupload1)){  
			
			 $getexte = end(explode('.',$imagedata1['image']));
			    //echo $getexte[1]; 
		            if($getexte == 'pdf'){
                      $img =  "source/popup/pdf.jpg";
					  $class = '';
				    }elseif($getexte == 'docx' || $getexte == 'doc'){
                       $img =  "source/popup/Word-icon.png";
					   $class = '';
					}else {
						$img = './img/real_estate_file/'.$id1.'/'.$imagedata1['image'];
						$class = 'group1';
                 	}
			
			?>
			  <li id="imagefile_<?php echo $z; ?>"><a href="<?php echo './img/real_estate_file/'.$id1.'/'.$imagedata1['image']; ?>" class="<?php echo $class; ?>"><img src="<?php echo $img;  ?>" width="50px" alt="<?php echo $imagedata1['image']; ?>"></a><span class="imagedelete" Onclick="imageDelete('<?php echo $z; ?>','<?php echo $imagedata1['id']; ?>','<?php echo $imagedata1['image'] ?>')"><img src='source/popup/delete.png' style="height:20px;"></span></li>
			  
        <?php $z++; }  ?>
        </ul>
	
	<?php  } ?>
	    <script>
	 		$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				
			});
		</script>