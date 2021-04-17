

<span class="staff_text" style="margin-bottom:25px;margin-left: 19px;">Email Template</span>
<p class="add_termsagree"><a href="../admin/index.php?task=email_template">Add Email Template</a></p>
	<?php  
	  
	    $getsql =    mysql_query("SELECT * FROM `bcic_email_template` Order by id desc");
		 $countresult = mysql_num_rows($getsql);
	?>
<p class="delete_message" id="deletemsg" style="display:none;">One Row Remove</p>
     <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
        <thead>
          <tr>
				<th style="text-align: center;">Id</th>
				<th style="text-align: center;">Email Type</th>
				<th style="text-align: center;">Admin Name</th>
				<th style="text-align: center;">CreatedOn</th>
				<th style="text-align: center;">UpdadetOn</th>
				<th style="text-align: center;">Email</th>
				<th style="text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
		  <?php  
		  
		   if($countresult > 0) {
		  
		    while($getData = mysql_fetch_array($getsql)) {   ?>
					<tr id="list_<?php echo $getData['id']; ?>"  > 
						<td><?php  echo $getData['id'];?></td>
						<td><?php  echo get_sql("system_dd","name"," where type='72' AND id='".$getData['email_type']."'") ;?></td>
						<td><?php  echo  get_rs_value("admin","name",$getData['login_id']);?></td>
						<td><?php  echo changeDateFormate($getData['createdOn'],'timestamp');?></td>
						<td><?php  echo changeDateFormate($getData['updatedOn'],'timestamp');?></td>
						<td><a href="javascript:showdiv('ediv<?php echo $getData['id']; ?>');">View</a></td>
						<td><a style="color:blue;" href="../admin/index.php?task=email_template&id=<?php echo $getData['id']; ?>">Modify</a></td>
					</tr>
					<tr id="ediv<?php echo $getData['id']; ?>" style="display:none;">
					   <td colspan="10" style="text-align:  justify;padding: 17px;"><?php echo $getData['email_value']; ?></td>
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