<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT']."/admin/source/functions/functions.php");
include($_SERVER['DOCUMENT_ROOT']."/admin/source/functions/config.php");

        $str = $_POST['setData'];
        $vars =  explode('__' , $str);
		
		//print_r($vars);
		
		$quote_id = $vars[0];
		$depot_address = $vars[1];
		$get_makedata = $vars[2];
		$get_staff = $vars[3];
		$get_truck_id = $vars[4];
		$quote_type = $vars[5];
		
		if($quote_type == 1) {
		    $sql1 =  ("SELECT *  FROM `temp_quote`  WHERE id = ".$quote_id."");
		}else{
		   $sql1 =  ("SELECT *  FROM `quote_new`  WHERE id = ".$quote_id."");	
		}
		//echo $sql1; 
		 $movingdetails =  mysql_fetch_assoc(mysql_query($sql1));
		// print_r($movingdetails); 
				
				/* echo  $depot_address;
				echo '<br/>'; */
				$depot_addresslatland = getLatLong($depot_address);
				
				//print_r($depot_addresslatland); die;
				
					$dept_latitude = $depot_addresslatland['latitude'];
					$dept_longitude = $depot_addresslatland['longitude'];

					$lat_from = $movingdetails['lat_from'];
					$long_from = $movingdetails['long_from'];
					
					$lat_to = $movingdetails['lat_to'];
					$long_to = $movingdetails['long_to'];
					
					
			    $d_to_f = GetDrivingDistance($dept_latitude, $lat_from, $dept_longitude, $long_from);	
			    $t_to_d = GetDrivingDistance($lat_to, $dept_latitude, $long_to, $dept_longitude);

                  //print_r($d_to_f);		 die;		
				
				$totaltime = $d_to_f['time'] + $t_to_d['time'];
				
				 $get_string = $quote_id.'__'.$depot_address.'__'.$get_makedata.'__'.$get_staff.'__'.$get_truck_id.'__'.$quote_type;
				 $div_id = 'show_travell_time_'.$get_makedata.'_'.$get_staff.'_'.$get_truck_id.'__'.$quote_type;
				
				$onclick_travel_time  = "onClick=\"javascript:send_data('".$get_string."','407','".$div_id."');\"";
				
				//$str = '';
				
				 $str =  '<table border="1" >
					    <tr>
					 	  <td>D=>F</td>
						  <td>T=>D</td>
						  <td>Total</td>
					    </tr>
				        <tr>
						  <td>'.$d_to_f['time'].' h</td>
						  <td>'.$t_to_d['time'].' h</td>
						  <td>'.$totaltime.' h</td>
					    </tr>
				    </table>';
				$str.= '<a style="cursor: pointer;" '.$onclick_travel_time.'> Calculate</a>'; 
				echo $str;
?>