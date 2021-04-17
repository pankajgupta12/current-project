<?php  
    include("../source/functions/functions.php");
    include("../source/functions/config.php");
	
    if($_POST['id'] != '' && $_POST['name'] != '') {
	  $roster_type = 1;
	   // $sql = 	mysql_query("SELECT A.id as aid, A.admin_id as adminid, A.start_time_au as starttime, A.roster_type as rostertype, A.end_time_au as endtime, A.lunch_time_au as lunchtime , A.lunch_end_time_au as lunchendtime, (SELECT start_time_au FROM `admin_time_shift` WHERE id = A.start_time_au ) as startau, (SELECT end_time_au FROM `admin_time_shift` WHERE id = A.end_time_au ) as endau, (SELECT lunch_time_au FROM `admin_time_shift` WHERE id = A.lunch_time_au ) as lunchstart, (SELECT lunch_end_time_au FROM `admin_time_shift` WHERE id = A.lunch_time_au ) as lunchend, date  FROM `admin_roster` as A WHERE id = ".$_POST['id']."");
	   
	   $sql =  mysql_query("SELECT * FROM `admin_roster` WHERE id = ".$_POST['id']."");
		 
		$count = mysql_num_rows($sql);
        $data = mysql_fetch_assoc($sql);
		
  
    $roster_type = $data['roster_type'];
    
    if($roster_type == 2) {
        $data['start_time_au'] = $data['start_time_au'];
        $data['lunch_time_au'] = $data['lunch_time_au'];
        $data['lunch_end_time_au'] = $data['lunch_end_time_au'];
        $data['end_time_au'] = $data['end_time_au'];
        $data['id'] = $data['id'];
        $data['adminid'] = $data['admin_id'];
        $data['date'] = $data['date'];
        $leave_type = $data['leave_type'];
        
    }else if($roster_type == 2) {
        
        $sql1 = 	mysql_query("SELECT A.id as aid, A.leave_type as leave_type,  A.admin_id as adminid, A.start_time_au as starttime, A.roster_type as rostertype, A.end_time_au as endtime, A.lunch_time_au as lunchtime , A.lunch_end_time_au as lunchendtime, (SELECT start_time_au FROM `admin_time_shift` WHERE id = A.start_time_au ) as startau, (SELECT end_time_au FROM `admin_time_shift` WHERE id = A.end_time_au ) as endau, (SELECT lunch_time_au FROM `admin_time_shift` WHERE id = A.lunch_time_au ) as lunchstart, (SELECT lunch_end_time_au FROM `admin_time_shift` WHERE id = A.lunch_time_au ) as lunchend, date  FROM `admin_roster` as A WHERE id = ".$data['id']."");
        
        $data1 = mysql_fetch_assoc($sql1);
        
        $data['start_time_au'] = $data1['starttime'];
        $data['lunch_time_au'] = $data1['lunchtime'];
        $data['lunch_end_time_au'] = $data1['lunchendtime'];
        $data['end_time_au'] = $data1['endtime'];
        $data['id'] = $data1['aid'];
        $data['date'] = $data1['date'];
        $roster_type = $data1['roster_type'];
         $leave_type = $data['leave_type'];
    }
    
    
	
?>
            <div>
			   <p style="display: none;color: #6c9e6c;font-size: 18px;text-align: center;padding: 8px;" id="update_roster">Shift time updated successfully</p>
				<h4 id="head"><?php echo ucfirst($_POST['name']); ?> Shift Time On<?php echo date('dS M Y (l)', strtotime($data['date'])); ?></h4>
				<a class="close" href="#" >&times;</a>
				
				
				<select id="updateroster" style="margin-left: 110px;margin-top: 31px;" name="updateroster" onChange="changeRoster()";>
				    <option value="1" <?php if($roster_type == 1) {echo 'selected';}  ?>>Auto</option>
				    <option value="2" <?php if($roster_type == 2) {echo 'selected';}  ?>>Custom</option>
				</select>   
				
				<select id="leave_type" style="margin-left: 110px;margin-top: 31px;" onChange="leaveCheck(this.value)"; name="leave_type">
				    <option value="0" <?php if($leave_type == 0) {echo 'selected';}  ?>>Select</option>
				     <option value="1" <?php if($leave_type == 1) {echo 'selected';}  ?>>Week Off</option>
				    <option value="2" <?php if($leave_type == 2) {echo 'selected';}  ?>>Annual Leave</option>
				    <option value="3" <?php if($leave_type == 3) {echo 'selected';}  ?>>NO Show</option>
				</select>   

				<div class="content_1" id="auto_shifttime" style="display:<?php if($roster_type == 2) {echo 'none';}else{ echo 'Block';}  ?>" >
				   <span style="font-size: 16px;">Start Time <?php echo create_dd('start_time_au',"admin_time_shift","id",'start_time_au','',"",$data); ?></span> <br/>
				   <span style="font-size: 16px;">Lunch Start <?php echo create_dd('lunch_time_au',"admin_time_shift","id",'lunch_time_au','',"",$data); ?></span><br/>
				   <span style="font-size: 16px;">Lunch End <?php echo create_dd('lunch_end_time_au',"admin_time_shift","id",'lunch_end_time_au','',"",$data); ?></span><br/>
				   <span style="font-size: 16px;">End Time <?php echo create_dd('end_time_au',"admin_time_shift","id",'end_time_au','',"",$data); ?></span><br/>
				   
			     	<input type="submit" class="individual_roster_update" onCLick="updateRoster('<?php echo $data['id']; ?>','<?php echo $data['date']; ?>','<?php echo $data['adminid']; ?>')" name="submit" value="update">
				</div>
				
				<div class="content_2" id="custom_shifttime" style="display:<?php if($roster_type == 1) {echo 'none';}else{ echo 'Block';}  ?>">
				   <span style="font-size: 16px;">Start Time <input type="text" id="start_time_au" value="<?php  if($data['start_time_au'] != '') { echo $data['start_time_au']; } ?>"></span> <br/>
				   <span style="font-size: 16px;">Lunch Start <input type="text" id="lunch_time_au" value="<?php  if($data['lunch_time_au'] != '') { echo $data['lunch_time_au']; } ?>"></span><br/>
				   <span style="font-size: 16px;">Lunch End <input type="text" id="lunch_end_time_au" value="<?php  if($data['lunch_end_time_au'] != '') { echo $data['lunch_end_time_au']; } ?>"></span><br/>
				   <span style="font-size: 16px;">End Time  <input type="text" id="end_time_au" value="<?php  if($data['end_time_au'] != '') { echo $data['end_time_au']; } ?>"></span><br/>
				   <input type="submit" class="individual_roster_update" onCLick="updateRoster('<?php echo $data['id']; ?>','<?php echo $data['date']; ?>','<?php echo $data['adminid']; ?>')" name="submit" value="update">
				</div>
				
			</div>

<?php } ?> 