<span class="staff_text" style="margin-bottom:25px;margin-left: 19px;">Inclusion & Exlusion List</span>
<?php
		$getsql =    mysql_query("SELECT * FROM `sites_term_condition` Order by id desc");
		$countresult = mysql_num_rows($getsql);
?>
	
<p class="delete_message" id="deletemsg" style="display:none;">One Row Remove</p>
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
        <thead>
          <tr>
				<th style="text-align: center;">Id</th>
				<th style="text-align: center;">Quote type</th>
				<th style="text-align: center;">Admin Name</th>
				<th style="text-align: center;">UpdadetOn</th>
				<th style="text-align: center;">Inclusion & Exlusion</th>
				<th style="text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
		  <?php  
		  
		   if($countresult > 0) {
		  
		    while($getData = mysql_fetch_array($getsql)) {   ?>
					<tr id="list_<?php echo $getData['id']; ?>"> 
						<td><?php  echo $getData['id'];?></td>
						<td><?php echo  get_rs_value("quote_for_option","name",$getData['quote_type']); ?></td>
						<td><?php  echo  get_rs_value("admin","name",$getData['login_id']);?></td>
						<td><?php  echo changeDateFormate($getData['inclu_updateedon'],'timestamp');?></td>
						<td><a href="javascript:showdiv('ediv<?php echo $getData['id']; ?>');">View</a></td>
						<td><a style="color:blue;" href="../admin/index.php?task=inclusion&id=<?php echo $getData['id']; ?>">Modify</a> </td>
					</tr>
					<tr id="ediv<?php echo $getData['id']; ?>" style="display:none;">
					   <td colspan="10" style="text-align:  justify;padding: 17px;"><?php echo $getData['inclusion_exlusion']; ?></td>
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