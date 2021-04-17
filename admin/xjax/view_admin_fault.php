<?php  

if(!isset($_SESSION['admin_fault_data']['from_date'])){ $_SESSION['admin_fault_data']['from_date'] = date('Y-m-1'); }
if(!isset($_SESSION['admin_fault_data']['to_date'])){ $_SESSION['admin_fault_data']['to_date'] = date('Y-m-t'); }

         $sql = "SELECT * FROM `admin_fault` where 1 = 1";
	
		if($_SESSION['admin_fault_data']['from_date'] != '' && $_SESSION['admin_fault_data']['to_date'] != '') {
			$sql .= " AND date >= '".date('Y-m-d 00:00:00' ,strtotime($_SESSION['admin_fault_data']['from_date']))."' AND date <= '".date('Y-m-d 23:59:59' ,strtotime($_SESSION['admin_fault_data']['to_date']))."'";
		}
		if($_SESSION['admin_fault_data']['admin_id'] != '') {
			$sql .= " AND fault_admin_id = ".$_SESSION['admin_fault_data']['admin_id']."";
		}
	
 //echo $sql;
	
    $sql = mysql_query($sql);
    $count = mysql_num_rows($sql);
?>
		<div class="right_text_boxData right_text_box">
		  <div class="midle_staff_box"><span class="midle_text">Total Records <?php echo   $count; ?> </span></div>
		</div>

            <table class="user-table" border="1px">
					<thead>
						<tr>
							<th>Id</th>
							<th>Quote ID</th>
							<th>Job ID</th>
							<th>Comment</th>
							<th>Fault Admin Name</th>
							<th>Admin Name</th>
							<th>Created Date</th>
						</tr>
					</thead>
					  
				<tbody>
					<?php  
						if(mysql_num_rows($sql) > 0) 
						{ 
							while($data = mysql_fetch_assoc($sql)) 
							{
								 $adminname = get_rs_value('admin' , 'name' , $data['fault_admin_id']);
							?>
								<tr>
									<td> <?php echo $data['id']; ?> </td>
									<td> <?php echo $data['quote_id']; ?> </td>
									<td> <?php echo $data['job_id']; ?> </td>
									<td> <?php echo $data['comment']; ?> </td>
									<td> <?php echo $adminname; ?> </td>
									<td> <?php echo $data['staff_name']; ?> </td>
									<td> <?php echo $data['date']; ?> </td>
								</tr>
							<?php  
							} 
						}
					?>
				</tbody>
            </table>