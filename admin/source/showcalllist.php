<?php 
	
	include("functions/functions.php");
	include("functions/config.php");

   if(!isset($_POST['checkListType'])){ $chekilistvalue =  '1,2,3,4,5,6,7'; }else{  $chekilistvalue =  ($_POST['checkListType']); }

    if($_POST) {
        
       // print_r($_POST);
        
        if($_POST['page'] == 'call') 
        {
          if($_POST['adminid'] > 0 && $_POST['adminid'] != '') {
              
              $role = $_POST['role'];
              $calldate = $_POST['calldate'];
               $adminname = $_POST['adminname'];
              $loggadminid = $_POST['loggadminid'];
              if($adminname == 'Payal Panda') {
                  $adminname = 'Grace';
              }
            if($adminname == 'Ilene') {
                  $adminname = 'Rachel';
            }
              
            
               $getCallAllInfo =  getCallAllInfo($_POST['adminid'] , $adminname, $loggadminid, $calldate, $chekilistvalue);
           
               $chekilistvalue =  explode(',', $chekilistvalue);
               
               // print_r($chekilistvalue);
              $filename =  str_replace(' ','_', $adminname).'_'.str_replace('-','_', $calldate);
              ?>
              
              
    <script>
     function printDiv(filename) 
   {  
       var divContents = document.getElementById("show_details").innerHTML;  
       var printWindow = window.open('', '', 'height=1000,width=800');  
       printWindow.document.write('<html><head><title>'+filename+'</title>');  
       printWindow.document.write('</head><body >');  
       printWindow.document.write(divContents);  
       printWindow.document.write('</body></html>');  
       printWindow.document.close();  
       printWindow.print();  
    }  
    </script>
              
    <span>
                <ul class="checklist_data">
                    <!--<li><input type="checkbox" name="chekilistvalue"   class="chekilistvalue" value="1">All</li>-->
                    <li><input type="checkbox" name="chekilistvalue" class="chekilistvalue" value="2"  <?php if(in_array(2, $chekilistvalue)) {echo 'checked';}  ?>> Logged</li>
                    <li><input type="checkbox" name="chekilistvalue" class="chekilistvalue" value="3" <?php if(in_array(3, $chekilistvalue)) {echo 'checked';}  ?>> Calls</li>
                    <li><input type="checkbox" name="chekilistvalue" class="chekilistvalue" value="4" <?php if(in_array(4, $chekilistvalue)) {echo 'checked';}  ?>> Notes</li>
                    <li><input type="checkbox" name="chekilistvalue" class="chekilistvalue" value="5" <?php if(in_array(5, $chekilistvalue)) {echo 'checked';}  ?>> SMS</li>
                    <li><input type="checkbox" name="chekilistvalue" class="chekilistvalue" value="6" <?php if(in_array(6, $chekilistvalue)) {echo 'checked';}  ?>> Chat</li>
                    <li><input type="checkbox" name="chekilistvalue" class="chekilistvalue" value="7" <?php if(in_array(7, $chekilistvalue)) {echo 'checked';}  ?>> Email</li>  
                    
                    <li style="border: 1px solid #a3cdd4;background: #a3cdd4;"><a style="color:#000;" onclick="showpopupDetails('<?php echo $_POST['adminid']; ?>', '<?php echo $adminname; ?>' ,'<?php echo $role; ?>' ,1 , '<?php  echo  $loggadminid; ?>');" href="javascript:void();" >GetInfo</a></li>
                    <input class="datepicker"  type="text" name="datepicker"  onChange="showpopupDetails('<?php echo $_POST['adminid']; ?>', '<?php echo $adminname; ?>' ,'<?php echo $role; ?>' ,1 , '<?php  echo  $loggadminid; ?>');" id="datepicker" style="margin-left: 100px;height: 34px;width: 117px;border: 2px solid;margin-top: 5px;margin-bottom: 20px;text-align: center;font-weight: 600;" value="<?php  echo $calldate; ?>" />
                
               <input type="button" onclick="printDiv('<?php echo $filename; ?>')" value="Print" style="border-radius: 7px;cursor: pointer;float: right;border: 1px solid #00b8d4;padding: 3px;width: 78px;font-size: 22px;background: #00b8d4;" />
                </ul> 
                
        </span>        
                    
              
                <div id="show_details">
                     <?php  include('view_call_info.php');  ?>
                </div>       
                  <?php  
              
            }
        
        } 
        
        if($_POST['page'] == 'logg') {
         $adminname = $_POST['adminname'];
         $calldate = $_POST['calldate'];
         $adminid = $_POST['adminid'];   
        $roledetails =  dd_value('102');
        //echo  "SELECT * FROM `admin_role` WHERE login_id = ".$adminid." AND DATE(createdOn) = '".date('Y-m-d')."'  ORDER by id ASC";
        $sql =  mysql_query("SELECT * FROM `admin_role` WHERE login_id = ".$adminid." AND DATE(createdOn) = '".$calldate."'  ORDER by id ASC");
        $count = mysql_num_rows($sql);
        
         $totaltime='';
         
        
        ?>
           <table style="width:100%"  border="1px">
                                <tr>
                                     <th>No</th> 
                                    <th>Role</th>
                                    <th>Start Time</th> 
                                    <th>End Time</th> 
                                    <th>Total Time</th>
                                    <th>Assigned By</th> 
                                </tr>
                                
                    <?php      if($count > 0) {
                                  $i= 1;
                              while($data = mysql_fetch_assoc($sql)) { 
                               $endtime = '';
                                 if($data['updatedOn'] !=  '0000-00-00 00:00:00'){
                                    $endtime = date('h:i A', strtotime($data['updatedOn']));
                                    $totaltime  = CalculateTime($data['createdOn'] , $data['updatedOn']); 
                                     $getTotalTIme[] = $totaltime;
                                 }
                               
                                //getArrayTime();
                               
                               
                              ?>    
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $roledetails[$data['admin_role']]; ?></td>
                                    <td><?php echo date('h:i A', strtotime($data['createdOn'])); ?></td>
                                    <td><?php echo $endtime; ?></td>
                                    <td><?php echo $totaltime; ?></td>
                                    <td><?php if($data['assign_name'] == $adminid || $data['assign_name'] == 0) {  echo 'Self'; }else { echo get_rs_value("admin", "name", $data['assign_name']); } ?></td>
                                    
                                </tr> 
                                
                        <?php unset($endtime); unset($totaltime);  $i++; } ?>
                                <tr>
                                    <td colspan="4">Total Active Time</td>
                                    <td colspan="4"><?php echo  getArrayTime($getTotalTIme); ?></td>
                                </tr>   
                        <?php }else { ?>
                        <tr>
                                    <td colspan="8">No Role details</td>
                            </tr>        
                        <?php  } ?>
           
        <?php 
    } }
    
     ?>