<style>
.offset {margin-top:30px;}
.btnNew {min-width: 100px;}
.jumbotrons { background: #f8f8f8;
    margin-bottom: 15px;
    padding: 15px;
}
.jumbotronss {
   background: #ffffff;
    padding: 15px;
    border: 1px solid #DDD;
    margin-top: 15px;
    position: relative;
    border-radius: 3px;
}
.jumbotronss .form-group { margin:0px;}
.jumbotronss .badge-secondary {
    color: #6c757d;
    background-color: #FFF;
    padding: 10px;
    font-size: 11px;
    font-weight: bold;
    margin: 0;
    border: 2px solid #6c757d;
    margin-right: 5px;
    position: relative;
    margin-bottom: 12px; 
}

.jumbotronss .badge-secondary:last-child {
    margin-right: 0;
}

.cloze {
    position: absolute;
    top: -10px;
    cursor: pointer;
    right: -7px;
    background: #333;
    padding: 4px;
    text-align: center;
    line-height: 8px;
    color: #FFF;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    font-size: 17px;
    font-style: normal;
}

.jumbotronss label {
    display: inline-block;
    white-space: nowrap;
    margin: 5px 10px 5px 0;
}

.jumbotronss .col-md-3 {
  border-right: 1px solid #DDD;
  margin-top: -15px;
  padding-top: 15px;
  text-align: center;
  border-bottom: 1px solid #DDD;
  margin-bottom: 0;
}

.jumbotronss .col-md-3:last-child {
  border-right:0px solid #DDD;
}

.jumbotronss .form-group textarea { text-align:left!important;}
.br_details {
    list-style: none;
}
.br_details li {
    font-size: 16px;
}

.details_left {
	width: 50%;
	float: left;
}

.details_right {
	width: 50%;
	float: right;
}



.searchListing .post_list {
    margin: 0;
    background: #f7f7f7;
    border: 1px solid #e2e2e2;
    border-width: 0 1px 1px 1px;
    box-shadow: 3px 3px 8px -5px rgba(0,0,0,0.5);
    border-radius: 0px 0px 5px 5px;
    padding: 0;
    max-height: 150px;
    overflow-x: hidden;
}

.searchListing .post_list li {
    text-align: left;
    margin: 0;
    padding: 7px 0;
	font-size: 13px;
    background: transparent;
    border-bottom: 1px solid #e8e8e8;
    display: flex;
    flex-direction: column;
}
.searchListing .post_list li a {
    padding: 0 7px;
	cursor: pointer;
}
.br_heading{
	text-align:center;
}
</style>

<div class="body_container">
	<div class="body_back">
		    <div class="wrapper">
					<div class="formAreaNew">
					
					    <?php 
//echo  md5(uniqid(rand(1,10), true));
  $qid = ($_GET['quote_id']);
$quotedetails = mysql_fetch_assoc(mysql_query("select * from quote_new where id ='".mysql_real_escape_string($qid)."'"));

$quotedetails_data = mysql_fetch_assoc(mysql_query("select * from quote_details where quote_id ='".mysql_real_escape_string($qid)."' AND job_type_id = 11"));

if(!empty($quotedetails_data)) {
	
	
	$getQuotetype =  mysql_fetch_assoc(mysql_query("SELECT company_logo FROM `quote_for_option` where id = ".$quotedetails['quote_for'].""));

	$siteDetails = mysql_fetch_array(mysql_query("Select * from sites where id = ".$quotedetails['site_id'].""));
	
	if($quotedetails_data['job_type_id'] == 11) {
		 $site_logo =   $siteDetails['br_logo'];
	}else {
	   $site_logo =   $siteDetails['logo'];	
	}
	$bcic_amount = check_cubic_meter_amount($quotedetails_data['cubic_meter']);
?>

<div class="container">

  <div class="row" style="margin-top: -26px;">

    <div class="col-md-12">

    <div class="jumbotrons">

		<div class="row">
      
	            <div class="col-md-12"> 
			     <strong>Quote id : <?php echo $quotedetails['id']; ?> /  Job id : <?php echo $quotedetails['booking_id']; ?></strong>
				  <p style="float:right;margin-top: -27px;"><img src="<?php echo $site_logo; ?>" style="height:35px;margin-top: 35px;"> <br/>
				  (<?php echo $quotedetails['suburb']; ?>)</P>
				 
			     <h5 class="br_heading" style="color: #00b8d4;margin-left: 192px;"><?php echo ucfirst($quotedetails['name']); ?> Quote Details</h5>
				 
				</div>
				<div class="col-md-6">
					<ul class="br_details">
					  <li><strong>Moving From: </strong><?php echo $quotedetails['moving_from']; ?></li>
					  <li><strong>Moving To: </strong><?php echo $quotedetails['moving_to']; ?></li>
					</ul>  
					
					 <ul class="br_details details_left">
					  <li><strong>On Level From: </strong><?php echo getbrSystemvalueByID($quotedetails['is_flour_from'] ,1); ?></li>
					  <li><strong>Has Lift/Elevator From: </strong><?php echo getbrSystemvalueByID($quotedetails['is_lift_from'] ,2); ?></li>
					  <li><strong>Home Type From: </strong><?php echo getbrSystemvalueByID($quotedetails['house_type_from'],3); ?></li>
					  <li><strong>Door Distance From: </strong><?php echo getbrSystemvalueByID($quotedetails['door_distance_from'] ,4); ?></li>
					  </li>
					  <li><strong>Day time : </strong><?php echo ucfirst(getbrSystemvalueByID($quotedetails_data['travel_time'] , 5)); ?></li>
					  
					</ul>  
					
					 <ul class="br_details details_right">
					  <li><strong>On Level To: </strong><?php echo getbrSystemvalueByID($quotedetails['is_flour_to'] ,1); ?></li>
					  <li><strong>Has Lift/Elevator To: </strong><?php echo getbrSystemvalueByID($quotedetails['is_lift_to'] ,2); ?></li>
					  <li><strong>Home Type To: </strong><?php echo getbrSystemvalueByID($quotedetails['house_type_to'] ,3); ?></li>
					  <li><strong>Door Distance To: </strong><?php echo getbrSystemvalueByID($quotedetails['door_distance_to'] ,4); ?></li>
					  
					</ul>  
				</div>
			
				<div class="col-md-4 offset-1">
					<ul class="br_details">
					  <li style="white-space: nowrap;"><strong>Email  : </strong><a href="mailto:<?php echo $quotedetails['email']; ?>"><?php echo $quotedetails['email']; ?></a></li>
					  <li><strong>Phone  : </strong><a href="tel:<? echo $siteDetails['area_code'].$quotedetails['quote_for'].$quotedetails['phone'];?>"><?php echo $quotedetails['phone']; ?></a></li>
					  <li><strong>Issue Date : </strong><?php echo changeDateFormate($quotedetails['date'],'datetime'); ?></li>
					  <li><strong>Job Date : </strong><?php echo changeDateFormate($quotedetails['booking_date'],'datetime'); ?></li>
					  <li><strong>Total Cubic : </strong><?php echo $quotedetails_data['cubic_meter']; ?> m3</li>
					  <li><strong>Travling Time : </strong><?php echo $quotedetails_data['travelling_hr']; ?> hr</li>
					  <li><strong>Total Working : </strong><?php echo $quotedetails_data['hours']; ?> hr * $<?php echo $bcic_amount; ?> </li>
					   <li><strong>Amount : $</strong><?php echo $quotedetails_data['amount']; ?></li>
					</ul>  
				</div>
		</div>	
        <div class="row">		
		    <div class="col-md-12"><h5 class="br_heading" style="color: #00b8d4;"><?php echo ucfirst($quotedetails['name']); ?> Inventory Details</h5></div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="usr"><strong>Add New Room Type:</strong></label>
							<select class="form-control" id="inventory_type_id" name="inventory_type_id">
								<?php  echo create_inventory_dd("inventory_type_id","br_inventory_type","id","name","status=1","",'');?>  
							</select>
					</div>
				</div>

				<div class="col-md-3">
				  <button style="margin-top:50px;" type="submit" class="btn offset btnNew btn-primary" onClick="return add_new_room_type('<?php echo $qid; ?>', '<?php echo get_rs_value('admin' ,'name' , $_SESSION['admin']); ?>');">Add Room Type</button>
				</div>
				
		</div>			
		


    <div  id="add_new_room">

			  <?php  $getinventorysql = mysql_query("SELECT inventory_type_id , type  FROM `quote_details_inventory` WHERE quote_id = ".$quotedetails['id']." GROUP by inventory_type_id , type "); 
			  
			  while($getData = mysql_fetch_assoc($getinventorysql)) {
			  ?>
  
				<div class="col-md-12">
					<div class="row">
					 <?php  if($getData['type'] != 1) {?>
					  <h5>Kitchen</h5>
					 <?php  }else{ ?>
					  <h5><?php echo get_rs_value('br_inventory_type' ,'name' , $getData['inventory_type_id']); ?></h5>
					 <?php  } ?>
					</div>
				</div>
			<?php  
			 $getSql = mysql_query("SELECT  DISTINCT(item_pos) as itemposition   FROM `quote_details_inventory` WHERE inventory_type_id = ".$getData['inventory_type_id']." AND type = ".$getData['type']." AND quote_id = ".$quotedetails['id']." order by item_pos asc"); 
			 
			   while($getitemPosition = mysql_fetch_assoc($getSql)) {
			?>
				<div class="jumbotronss"  id="item_position_<?php echo $quotedetails['id']; ?>_<?php echo $getData['inventory_type_id']; ?>_<?php echo $getData['type']; ?>_<?php echo $getitemPosition['itemposition']; ?>">

					<i class="cloze" onclick="remove_item('<?php echo $quotedetails['id']; ?>' , '<?php echo $getData['inventory_type_id']; ?>' , '<?php echo $getData['type']; ?>' , '<?php echo $getitemPosition['itemposition']; ?>', '<?php echo get_rs_value('admin' ,'name' , $_SESSION['admin']); ?>');">x</i>

					<div class="row">

					<div class="col-md-12">

					<div class="row">

					  <div class="col-md-3 text-left">            
                        
						<label for="usr">
						   <?php  if($getData['type'] != 1) { ?>
						    <?php  echo  $getitemPosition['itemposition'].ordinal_suffix($getitemPosition['itemposition']); ?> Kitchen 
						   <?php  }else{ ?>
						      <?php  echo  $getitemPosition['itemposition'].ordinal_suffix($getitemPosition['itemposition']); ?> <?php echo get_rs_value('br_inventory_type' ,'name' , $getData['inventory_type_id']); ?>
						   <?php  } ?>
  						</label>

					  </div>

					  <div class="col-md-3">

						<div class="form-group d-flex flex-column">

						 
						   <input type="text" placeholder="Enter item name"  style="text-align: left;" id="item_name_<?php echo $quotedetails['id']; ?>_<?php echo $getData['inventory_type_id']; ?>_<?php echo $getData['type']; ?>_<?php echo $getitemPosition['itemposition']; ?>"  value="" class="form-control" onkeyup="search_inventory(this.value , '<?php echo $getData['inventory_type_id']; ?>' , '<?php echo $quotedetails['id']; ?>_<?php echo $getData['inventory_type_id']; ?>_<?php echo $getData['type']; ?>_<?php echo $getitemPosition['itemposition']; ?>');" /> 
							 
							 <div class="searchListing" id="show_item_name_<?php echo $quotedetails['id']; ?>_<?php echo $getData['inventory_type_id']; ?>_<?php echo $getData['type']; ?>_<?php echo $getitemPosition['itemposition']; ?>" style="display:none;"></div> 

						</div>

					  </div>

					  <div class="col-md-3">

						<button type="submit" class="btn btnNew btn-primary"  onclick="return check_item_value('<?php echo $quotedetails['id']; ?>' , '<?php echo $getData['inventory_type_id']; ?>' , '<?php echo $getData['type']; ?>' , '<?php echo $getitemPosition['itemposition']; ?>' , '<?php echo get_rs_value('admin' ,'name' , $_SESSION['admin']); ?>');">Add</button>

					  </div>    

					  <div class="col-md-3">

						<span class="badge badge-secondary" id="cubic_meter_<?php echo $quotedetails['id']; ?>_<?php echo $getData['inventory_type_id']; ?>_<?php echo $getData['type']; ?>_<?php echo $getitemPosition['itemposition']; ?>">Cubic Meter : <?php echo get_cubic_meter_by_position($getData['inventory_type_id'] ,$getData['type'] ,$quotedetails['id'] , $getitemPosition['itemposition']); ?></span>

					  </div>

					</div>
					
							<div class="jumbotronss" id="item_position_<?php echo $getData['inventory_type_id']; ?>_<?php  echo  $getitemPosition['itemposition']; ?>">

								<div class="row">

								  <div class="col-md-12">

									<div class="row">    

									  <div class="col-md-12" id="all_item_<?php echo $quotedetails['id']; ?>_<?php echo $getData['inventory_type_id']; ?>_<?php echo $getData['type']; ?>_<?php echo $getitemPosition['itemposition']; ?>">
										<?php

											$itemNameSql = mysql_query("SELECT  *   FROM `quote_details_inventory` WHERE inventory_type_id = ".$getData['inventory_type_id']." AND type = ".$getData['type']." AND quote_id = ".$quotedetails['id']." AND item_pos = ".$getitemPosition['itemposition'].""); 

											while($getItemName = mysql_fetch_assoc($itemNameSql)) {
										?> 

										<span class="badge badge-secondary" id="inventory_item_name_<?php echo $getItemName['id']; ?>"><?php echo $getItemName['inventory_item_name']; ?> <i class="cloze" onclick="return remove_item_name('<?php echo $getItemName['id']; ?>','<?php echo $quotedetails['id']; ?>' , '<?php echo $getData['inventory_type_id']; ?>' , '<?php echo $getData['type']; ?>' , '<?php echo $getitemPosition['itemposition']; ?>' , '<?php echo get_rs_value('admin' ,'name' , $_SESSION['admin']); ?>');">x</i></span>

										<?php  } ?>

									  </div>

									</div>

								  </div>

								 </div>

							</div>
					</div>

				  </div>

				</div>
	     <?php } } ?> 
		 
		   <div class="col-md-8">
					            <div class="row">
					 					  <h5>Others</h5>
					 			</div>
				</div>
				<div class="jumbotronss">
				
                <?php   $other_item = $quotedetails_data['other_item']; ?>
						<div class="form-group">
							<textarea class="form-control rounded-0" id="other_item" rows="3"><?php  if($other_item != '') { echo $other_item ; } ?></textarea>
						</div>
					<button style="margin-top:20px;" type="submit" class="btn btn-primary" onClick="save_other_items('<?php echo $qid; ?>' , '<?php echo get_rs_value('admin' ,'name' , $_SESSION['admin']); ?>');">Other Save</button>	
				</div>
		 
        </div>

     </div>
    </div>
   </div>
</div>
 
					
					</div>
				
					
			</div>
   </div>
</div>
<?php }else{ ?>
No Records
<?php  } ?>