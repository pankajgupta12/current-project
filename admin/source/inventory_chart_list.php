<div class="usertable-overflow usertable-overflowNew">
 <br><br>
   <h5 class="br_heading">Inventory Chart list</h5>
    <br>
    		 
			     <?php  
				// echo "SELECT * FROM `br_inventory_type`";
				 $intesql = mysql_query("SELECT * FROM `br_inventory_type`");  
				 
				  while($gettype = mysql_fetch_assoc($intesql)) {
					  
						$getitemname =   mysql_query("SELECT  *   FROM `removal_item_chart` WHERE  item_type_id in ( ".$gettype['id']." ) ");
						
						 $countresult = mysql_num_rows($getitemname);
				  if($countresult > 0) {
				 ?>
				
					
					<div class="modal-body">
					<div class="row">
					 <hr>
					<div class="col-md-3">
					  <h4 class="modal-title int_pop_item_name" ><?php echo $gettype['name']; ?></h4>
					 
					</div>
					<div class="col-md-9">
					
					<?php  while($getitemname1 = mysql_fetch_assoc($getitemname)) { ?>
					  <p><?php echo $getitemname1['item_name']; ?></p>
					 
					<?php  } ?>
					</div>
					</div>
				    <?php  } } ?>	
				  </div>
        
	
    </div>
	
	<style>
	.modal-body .col-md-9 p {
		margin-top: 0;
		display: inline-block;
		border: 1px solid #dcdcdc;
		padding: 3px;
		border-radius: 3px;
		margin-bottom: 6px;
		font-size: 15px;
	}
	</style>