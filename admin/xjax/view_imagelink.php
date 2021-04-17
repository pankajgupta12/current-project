<?php 
if(!isset($_SESSION['imagelink']['jobdate_from'])){ $_SESSION['imagelink']['jobdate_from'] = date("Y-m-1"); }
if(!isset($_SESSION['imagelink']['jobdate_to'])){ $_SESSION['imagelink']['jobdate_to'] = date('Y-m-d' , strtotime(' + 2 days')); }



        $sql = "Select J.total_before_img as t_befor_img ,J.imagelink as imgLink ,  J.total_after_img as t_after_img ,  JD.job_id as jobid , JD.job_date as jdate from job_details  JD , jobs J where J.id = JD.job_id AND JD.status != 2 AND JD.start_time != '0000-00-00 00:00:00' AND JD.end_time != '0000-00-00 00:00:00'";
 
     //print_r($_SESSION['imagelink']);
 
		  if($_SESSION['imagelink']['site_id'] != 0 && $_SESSION['imagelink']['site_id']  != '') {
			 $sql.= " AND JD.site_id = '".$_SESSION['imagelink']['site_id']."'";
		  }
 
		if($_SESSION['imagelink']['jobdate_from'] != Null && $_SESSION['imagelink']['jobdate_to']  != '') {
			 $sql.= "  AND  JD.job_date  >= '".date('Y-m-d' , strtotime($_SESSION['imagelink']['jobdate_from']))."' and JD.job_date  <= '".$_SESSION['imagelink']['jobdate_to']."'";
		}
		
		$sql .= " group by JD.job_id order by JD.job_date , JD.job_id asc";  
		
		//echo $sql; 
         $query = mysql_query($sql);

?>


 <span class="payment_required">Image Link Details</span>
 <div class="tab3_table1">
      <table class="start_table_tabe3">
        <thead>
          <tr>
            <th>Job id</th>
            <th>Job Date</th>
            <th>Total Before Image</th>
            <th>Total After Image</th>
			<th>ImageLink</th>
          </tr>
        </thead>
		
        <tbody>	
		<?php   
		  while($getdata = mysql_fetch_assoc($query)) {
                  $jobid = $getdata['jobid'];
                  $jdate = $getdata['jdate'];
         
		   if($getdata['imgLink'] != '')    { $imgdataLink =  $getdata['imgLink']; }else  { $imgdataLink = CreateImageLink($jobid); } 
		   if($getdata['t_befor_img'] != 0) { $beforimg =  $getdata['t_befor_img']; }else { $beforimg =  getTotalImage($jobid , 1); }
		   if($getdata['t_after_img'] != 0) { $afterimg = $getdata['t_after_img']; }else  { $afterimg = getTotalImage($jobid , 2); }
		 
		?>
		  <tr class=<?php  if($beforimg <= 10 || $afterimg <= 10) { echo 'alert_danger_tr '; } ?>>
		    <td><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $jobid; ?>','1200','850')"><?php echo $jobid; ?></a></td>
		    <td><?php  echo $jdate; ?></td>
		    <td><?php  echo $beforimg; ?></td>
		    <td><?php  echo  $afterimg; ?></td>
		    <td><a href="<?php echo $imgdataLink; ?>" target="_blank"><?php  echo $imgdataLink; ?></a></td>
		  </tr>
		<?php  }  ?>
        </tbody>
      </table>
     </div>	 