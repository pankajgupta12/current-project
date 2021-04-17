<div class="body_container">
	<div class="body_back">
		<span class="main_head">Staff Activity</span>
		
		<?php  
		    
			$id = $_GET['id'];
			$sql = "Select * from staff_activity_latest  where staff_id = ".$id." ORDER BY `udatedOn` DESC";
			$query = mysql_query($sql);
			
				$i = 0;
					while($data = mysql_fetch_assoc($query)) {  
						$i++;
						$allData = unserialize($data['all_data']);
						
						$getAllData[] = array('allData'=>$allData, 'admin_id'=>$data['admin_id'],'udatedOn'=>$data['udatedOn']);
					
					}
			
			
			// echo '<pre>'; print_r($getAllData);
			
		    
		 ?>
		
		   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table staff-loc-list">	 
            		<thead style="text-align:center;">
            			<tr class="table_cells" style="height:50px;">
							<td><strong>Id</strong></td>
							<td><strong>Adminid</strong></td>
							<td><strong>New Updated data </strong></td>
							<td><strong>Updated On</strong></td>
            			</tr>
            		</thead>
            		
            		<?php  
					$i= 0;
					
					$j= 0;
					 foreach($getAllData as $key=>$value) {
					$j++;
					     
					     $getData = array_diff($getAllData[$i]['allData'],$getAllData[$i+1]['allData']);
						
                        //echo  count($getData);		
						// array_keys($getData);
                  //if(count($getData) > 1) {						
						 unset($getData['updatedDate']);
						 
						 if(!empty($getData)) {
					?>
            		
                    		   <tr>
                				  <td><?php echo $j; ?></td>
                				  <td><?php echo get_rs_value('admin', 'name', $value['admin_id']); ?></td>
                				  <td><?php 
								  foreach($getData as $colname=>$valuename) {
									  
									  
									  
								    echo '<b>'.ucfirst(str_replace('_',' ', $colname)) . '</b> : '.$valuename.'<br/>';

								  }
								  ?></td>
                				  <td><?php echo $value['udatedOn']; ?></td>
                    			</tr>
					 <?php unset($value); $i++; } } ?>		
								
                        
            				
         	</table>

		</div>
		
    </div>
</div>

<?php  


 ?>