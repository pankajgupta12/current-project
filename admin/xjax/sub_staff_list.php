<?
$resultsPerPage = resultsPerPage;
//$resultsPerPage = 2;
$arg = "select * from sub_staff where 1=1 ";

  //echo $_SESSION['sub_staff']; 
 if(isset($_SESSION['sub_staff']))
	{ 
        if($_SESSION['sub_staff']=="1")
    	{    		
           $arg .= ' AND  is_deleted=1 ';  
        }
    	else if($_SESSION['sub_staff'] =="2")
    	{
    	  $arg .= ' AND  is_deleted=1 AND approva_status = 0';  
    	 
    	}elseif($_SESSION['sub_staff'] =="3")
		{
			
			$arg .= ' AND  is_deleted=1 AND approva_status = 1';  
			
		}elseif($_SESSION['sub_staff'] =="4")
		{
			
			$arg .= ' AND  is_deleted=0';  
		}
	}
	
	 
	if($_SESSION['search_sub_staff']['staff_id'] != '') {
		
		$arg .= " AND  staff_id= ".$_SESSION['search_sub_staff']['staff_id']."";  
	} 
	
	if($_SESSION['search_sub_staff']['sub_staff_name'] != '') {
		
		$arg .= " AND  name= '".$_SESSION['search_sub_staff']['sub_staff_name']."'";  
	} 
	
	$query = $arg;
	
    $arg.=" order by id desc limit 0,$resultsPerPage";
	
	$cond = $arg;
	
 $data = mysql_query($arg);
 //$countResult1 = mysql_num_rows(mysql_query($query));
 $countResult = mysql_num_rows(mysql_query($query));
 //$countResult = mysql_num_rows($data);
?>

	<style>
	 .textfields{
		 border:1px solid #ddd !important;
		width: 89% !important;
		height: 43px;
		border-radius: 5px;
	 }
	</style>

    <div class="right_text_box" style="margin-top: -71px;">
       <div class="midle_staff_box"> <span class="midle_text">Total Records <?php echo  $countResult; ?> </span></div>
    </div>

	<div class="usertable-overflow">
		<table class="user-table">
		  <thead>
		  <tr>
			<th>ID</th>
			<th>Staff Team</th>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Password</th>
			<th>Active/Deactive</th>
			<th>Approve Status</th>
			<th>Created date</th>
			<th>Deleted</th>
			<th>Location</th>
		
		  </tr>
		  </thead>
			<tbody id="get_loadmoredata">			 
				  <?php 
					if($countResult > 0) {
						  while($getResult = mysql_fetch_assoc($data)) {?>
								<tr id="sub_staff_<?php echo $getResult['id']; ?>"  class ="parent_tr <?php  if($getResult['is_deleted'] == 0) {echo 'alert_danger_tr';} ?>">
								    <td><a href="javascript:scrollWindow('sub_staff_popup.php?task=sub_staff&sub_staff_id=<?php echo $getResult['id']; ?>','800','700')"><?php echo $getResult['id']; ?></a></td>
									<td><? echo get_rs_value("staff","name",$getResult['staff_id']);?></td>
									<td><?php echo $getResult['name']; ?></td>
									<td><?php echo $getResult['email']; ?></td>
									<td><?php echo $getResult['mobile']; ?></td>
									<td><?php echo $getResult['password']; ?></td>
									
									<td><?php echo create_dd("status","system_dd","id","name","type=60","onchange=\"javascript:edit_fields_applications(this,'sub_staff.status',".$getResult['id'].");\"",$getResult);?></td>
									
									<td ><?php echo create_dd("approva_status","system_dd","id","name","type=59","onchange=\"javascript:edit_fields_applications(this,'sub_staff.approva_status',".$getResult['id'].");\"",$getResult);?></td>
									
									<td><?php echo changeDateFormate($getResult['created_at'],'datetime'); ?></td>
									<td> 
									   <a title="DELETE" href="javascript:delete_sub_staff('<?=$getResult['id']?>','sub_staff_<?php echo $getResult['id']; ?>');" class="file_icon"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</td>
									
									<td><a href="JavaScript:Void(0);" onclick="javascript:scrollWindow('staff_details.php?task=staff_location&stafftype=1&id=<?php echo $getResult['id']; ?>','1200','850')"><?php //echo changeDateFormate($getResult['created_at'],'datetime'); ?>Location</a></td>
								</tr>
								
					<?php   }   if($countResult >= $resultsPerPage) { ?>
					
						<tr class="load_more">
						    <td colspan="25"><button class="loadmore" data-page="2" >Load More</button></td>
						</tr>
						
					<?php } ?>  
					<?php }else { ?>
							<td colspan="10">No record found</td>
					<?php  } ?>
			</tbody>	
		</table>
	</div>
	
	<script>
  $(document).on('click','.loadmore',function () {
  $(this).text('Loading...');
 //   var ele = $(this).parent('td');
   // alert(ele);
        $.ajax({
      url: 'xjax/ajax/loadmore_sub_staff_list.php',
      type: 'POST',
      datatype: 'html',
      data: {
              page:$(this).data('page'),
            },
        success: function(response){
            if(response){
                $('.load_more').remove();
                $( "tr.parent_tr:last" ).after( response );
             }
            } 
             
   }); 
});
</script>
