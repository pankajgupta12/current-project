

<span class="staff_text" style="margin-bottom:25px;margin-left: 19px;">Terms of Agreement List</span>
<p class="add_termsagree"><a href="../admin/index.php?task=terms_agreement">Add Terms of Agreement</a></p>
	<?php  
	  
	    if(isset($_GET['quote_type'])  && $_GET['quote_type'] != '') 
		{
	       $id = mysql_real_escape_string($_GET['quote_type']);		   
		   $getsql =    mysql_query("SELECT * FROM `terms_agreement` where is_deleted  = 1 AND quote_type = ".$id." Order by id desc");
		   $countresult = mysql_num_rows($getsql);
		}
	?>
<p class="delete_message" id="deletemsg" style="display:none;">One Row Remove</p>
     <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
        <thead>
          <tr>
				<th style="text-align: center;">Id</th>
				<th style="text-align: center;">Agreement Type</th>
				<th style="text-align: center;">Version</th>
				<th style="text-align: center;">Admin Name</th>
				<th style="text-align: center;">Status</th>
				<th style="text-align: center;">CreatedOn</th>
				<th style="text-align: center;">UpdadetOn</th>
				<th style="text-align: center;">View Terms of Agreement</th>
				<th style="text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
		  <?php  
		  
		   if($countresult > 0) {
		  
		    while($getData = mysql_fetch_array($getsql)) {   ?>
					<tr id="list_<?php echo $getData['id']; ?>"  <?php  if($getData['status'] == '0') { ?>  class = "alert_danger_tr " <?php  } ?> > 
						<td><?php  echo $getData['id'];?></td>
						<td><?php echo  get_rs_value("quote_for_option","name",$getData['quote_type']); ?></td>
						<td><?php  echo $getData['version'];?></td>
						<td><?php  echo  get_rs_value("admin","name",$getData['login_id']);?></td>
						<td id="trm_agree_status_<?php echo $getData['id']; ?>"><?php   echo create_dd("status","system_dd","id","name","type=1","Onchange=\"terms_agreement_status(this.value,".$getData['id']." , ".$getData['quote_type']." );\"",$getData);?></td>
						<td><?php  echo changeDateFormate($getData['createdOn'],'timestamp');?></td>
						<td><?php  echo changeDateFormate($getData['updatedOn'],'timestamp');?></td>
						<td><a href="javascript:showdiv('ediv<?php echo $getData['id']; ?>');">View</a></td>
						<td><a style="color:blue;" href="../admin/index.php?task=terms_agreement&id=<?php echo $getData['id']; ?>&quote_type=<?php echo $id; ?>">Modify</a></td>
					</tr>
					<tr id="ediv<?php echo $getData['id']; ?>" style="display:none;">
					   <td colspan="10" style="text-align:  justify;padding: 17px;"><?php echo $getData['terms_agreement']; ?></td>
					</tr>
					
		  <?php } }else { ?>
		         <tr colspan="10" >
		 			   <td colspan="10">No Record Found</td>
					</tr>
		  
		  <?php  } ?>
		  </tbody>
      </table>
	    
	<style>
		.add_termsagree{
			cursor: pointer;
			float: right;
			position: relative;
			margin-top: -55px;
			margin-right: 37px;
			font-size: 22px;
		}
		.delete_message{
			float: right;
			margin-right: 101px;
			margin-top: -17px;
			color: red;
	    }	
    </style>	
		
</div>