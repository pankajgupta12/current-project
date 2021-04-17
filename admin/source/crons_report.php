
 <br/>
 <br/>
 
 <h2>Crons Report Setting</h2>
 </br>
 
 
 
 <div id="cleaning_report">
     <table class="user-table">
	     <tr>
		    <td>ID</td>
		    <td>Email Type</td>
		    <td>Name</td>
		    <td>Email From</td>
		    <td>Email To</td>
		    <td>Status</td>
		    <td>Type For</td>
		    <td>Edit</td>
	     </tr>
		 
		 
	 <?php  
	    $typeFor = array(1=>'BCIC',2=>'BBC',3=>'All');
	    $getdata = getcronsReport();
	     foreach($getdata as $key=>$valuedata) { 
	     
			if($valuedata['type'] == 1) {
				  $type = 'Daily';
			}else{
				  $type = 'Weekly';
			}
		
		
		//print_r($valuedata);
           	
		 
		 $cid = $valuedata['id'];
	 ?>	 
		 <tr>
		    <td><?php  echo  $valuedata['id']; ?></td>
		    <td><?php  echo  $type; ?></td>
		    <td><?php  echo  $valuedata['name']; ?></td>
		    <td><?php  echo  $valuedata['email_from']; ?></td>
		    <td><?php  echo  $valuedata['email_to']; ?></td>
		    <td><?php  if($valuedata['status'] == 1) {echo 'Active'; }else {echo 'Deactivate';} ?></td>
		    <td>
			    <?php 
				    $gettypefor = explode(',',$valuedata['type_for']); 
					foreach($gettypefor as $key=>$valuedata) {
						$typeFor1[] = $typeFor[$valuedata];
					}
					//print_r($typeFor1);
					echo implode(',',$typeFor1);
					//echo '<pre>'; print_r($valuedata);
				?>
			</td>
		    <td><a href="../admin/index.php?task=list_crons_report&cid=<?php echo $cid; ?>">Edit</a></td>
	     </tr>
		 <?php unset($typeFor1);  } ?>
		
     </table>  
</div>


	
	