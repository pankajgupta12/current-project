                
                
                   
                   <table style="width:100%"  border="1px">
                                <tr>
                                     <th>Total Calls</th> 
                                    <th>Work Time (<?php echo date('h:i A' , strtotime($getCallAllInfo['logintime'])); ?>)</th>
                                    <th>Talk Time</th> 
                                    <th>AFK</th> 
                                    <th>Email Time</th> 
                                </tr>
                            <tr>
                                    <td>In - <?php echo $getCallAllInfo['callin']; ?> &nbsp; &nbsp;  Out - <?php echo $getCallAllInfo['callout']; ?></td>
                                    <td><?php echo $getCallAllInfo['totalworktime']; ?></td>
                                    <td><?php echo $getCallAllInfo['callduration']; ?></td>
                                    <td>AFK - <?php echo $getCallAllInfo['totalafktime']; ?> &nbsp; &nbsp; Lunch - <?php echo $getCallAllInfo['totallunchtime']; ?></td>
                                    <td><?php  echo $getCallAllInfo['emailtime']; ?></td>
                           </tr>            
                        </table>        
                 
                    <br/>
                    <h3 style="text-align: center;">Today Total Activity <?php echo count($getCallAllInfo['callinfo']); ?></h3>
                    <br/>
                       
                            
                            <table style="width:100%"  border="1px">
                                <tr>
                                     <th>ID</th> 
                                     <th>Time</th>
                                     <th>Time diff</th>
                                    <!--<th>From</th> 
                                    <th>To</th> -->
                                     <th>Role</th> 
                                    <th>Action</th> 
                                    <th style="width: 50%;">Comments</th> 
                                    <th>Duration</th>
                                    <th>Quote Id</th> 
                                    <th>Job Id</th>
                                </tr>
                              <?php      if(count($getCallAllInfo['callinfo']) > 0) {
                                  $i= 1;
                                  $k = 1;
                                  $l = 0;
                                  $totaltime = '';
                                foreach($getCallAllInfo['callinfo'] as $key=>$data) {
                                    
                                     //$k = $i;
                                    
    
                                    //background: #eae65e;   #9fb3d2
                                    //0:0:33
                                    $caltime =  explode(':',$totaltime);
                                    
                                    $calltime = $caltime[1];
                                    $bgcolor = '';
                                    if($calltime >= 5 && $calltime <= 9) {
                                        $bgcolor = '#c58ff7';
                                    }else  if($calltime >= 10 && $calltime <= 15){
                                        $bgcolor = '#eae65e';
                                    }else  if($calltime >= 15){
                                        $bgcolor = '#e09595';
                                    }
                                    
                                $gettime[] = $totaltime;    
                              ?>    
                                <tr <?php  if($data['type'] == 1) { ?>style="background: #b1c8f1;" <?php  } ?> >
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo date('h:i:s A', strtotime($data['call_time'])); ?></td>
                                    <td style="background:<?php echo $bgcolor; ?>"><?php echo $totaltime; // . ' ----- ' .$starttime .'=='. $endtime .' == '.$k .'==='.$l; ?></td>
                                    <!---<td><?php echo $data['from_type']; ?></td>
                                    <td><?php echo $data['to_type']; ?></td>--->
                                    <td><?php echo $data['role']; ?></td>
                                    <td><?php echo $data['action']; ?></td>
                                    <td><?php echo $data['comments']; ?></td>
                                    <td><?php echo $data['duration']; ?></td>
                                    <td><?php echo $data['quote_id']; ?></td>
                                    <td><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $data['job_id']; ?>','1200','850')"><?php echo $data['job_id']; ?></a></td>
                                </tr>
                            <?php  
                                    $starttime = $getCallAllInfo['callinfo'][$l]['call_time'];
                                    $endtime = $getCallAllInfo['callinfo'][$k]['call_time'];
                                    
                                    unset($totaltime); $totaltime = '' ;
                                    $totaltime = CalculateTime($starttime , $endtime);     
                            
                            
                            $l++; $k++; $i++; } }else { ?>
                              <tr>
                                    <td colspan="15">No records</td>
                                    
                                </tr>
                            <?php }  
                             //echo getArrayTime($gettime);
                             ?>    
                            </table>