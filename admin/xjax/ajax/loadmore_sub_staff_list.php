<?php 
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

if(isset($_POST['page'])) {
	$pageid = $_POST['page'];
	
//$arg = "select * from quote_new where deleted=0 and status=0 ";
  $arg = "select * from sub_staff where 1=1  ";
  
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
	
	$arg.=" order by id desc";
$resultsPerPage = resultsPerPage;
//$resultsPerPage = 2;
 if($pageid>0){
     //   echo 'test'; die;
          // $page_limit=$resultsPerPage*($pageid-1);
           $page_limit=$resultsPerPage*($pageid - 1);
           $arg.=" LIMIT  $page_limit , $resultsPerPage";
           }else{
        //  echo 'test11'; die;
        $arg.=" LIMIT 0 , $resultsPerPage";
     }
     
//echo $arg;  

$data = mysql_query($arg);	
if (mysql_num_rows($data)>0){ 

	  while($getResult = mysql_fetch_assoc($data)) {
	  
	  ?>
	  
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
			<? } ?>
	       <tr>
	         <td colspan="25" class="load_more"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
	      </tr>
    <?php } else{ ?> 
 	  <tr><td colspan="25" >No review Found</td></tr>
	<?php } } ?>	