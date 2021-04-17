<?php
         if($_REQUEST['id'] != '') {
              $staff_id = mysql_real_escape_string($_REQUEST['id']);
         }else{
               $staff_id = $staff_id;
         }
		 
	 //print_r($_REQUEST);	 
		 
	//$staff_id = mysql_real_escape_string($_POST['id']);
	$date = mysql_real_escape_string($_POST['date']);
	
	
    if($_SESSION['staff_location']['staff_location_date'] == "") { echo 'check1';
      $_SESSION['staff_location']['staff_location_date'] = date('Y-m-d',strtotime('yesterday'));
    } 
	$arg =  "select id, latitute as lat , longitude as lng, address as title, create_time from staff_location WHERE 1";
	if($_REQUEST['stafftype'] == 1) {
		 $arg .= " AND sub_staff_id = '".$staff_id."' ";
	}else {
	   $arg .= " AND  staff_id = '".$staff_id."' ";
	}
	
	//$arg =  "select id, latitute as lat , longitude as lng, address as title, create_time from staff_location WHERE staff_id = '162'";	

	 if(isset($_SESSION['staff_location']['staff_location_date']) && $_SESSION['staff_location']['staff_location_date'] != NULL )
	{
		$arg .= " AND createdOn = '".$_SESSION['staff_location']['staff_location_date']."'";
		//$arg .= " AND createdOn = '2018-01-02'";
	}
	
	 $queryselect = $arg . " ORDER BY ID DESC ";
	 
	 $arg .= " GROUP by address ORDER BY `id` DESC";
	
	//echo $arg;
	
    $qry =   mysql_query($arg);
	$ctr = mysql_num_rows($qry);
	$json_array = array();
	
	if( $ctr > 0 )
	{ 
		while( $row = mysql_fetch_assoc($qry) )
		{
			//$jp['address'] = $row;
			$json_array[] = $row;
		}    
		
		$json_array = json_encode($json_array);
		
		$_SESSION['geo_json'] = $json_array;
		
	


 //print_r($_SESSION['geo_json']);

?>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
<!--<script src="https://maps.google.com/maps/api/js?key=AIzaSyATI4bxxh1DZB4TvZsyfIzJB3nw8vkWg-8&libraries=geometry&sensor=true" type="text/javascript"></script>-->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCv5vccl4KbWqhSkA-fBEsX9fWu1htpjEs&libraries=geometry&sensor=true" type="text/javascript"></script>

 
 <script type="text/javascript">
	 
     //location cordinates
    var markers = JSON.parse( '<?php echo $_SESSION["geo_json"] ?>' );  
    
    //get address from this
    var geocoder;
    var rst;	
    
    //this function will execute this below script and set the pins according to cordinates
    function init()
    {		
		
        var mapOptions = {
            center: new google.maps.LatLng(markers[0].lat, markers[0].lng),     
            zoom: 4,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
        var infoWindow = new google.maps.InfoWindow();
        var lat_lng = new Array();
        var latlngbounds = new google.maps.LatLngBounds();
        for (i = 0; i < markers.length; i++) {
            var data = markers[i];
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            lat_lng.push(myLatlng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: data.title
            });
            latlngbounds.extend(marker.position);
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
					
					//invoke codeLatLng(lat, lng)
                    infoWindow.setContent(data.title);
                    infoWindow.open(map, marker);
                });
            })(marker, data);            
        }
            
        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);
 
        //  ***********ROUTING*************** 
 
        //Initialize the Path Array
        var path = new google.maps.MVCArray();
 
        //Initialize the Direction Service
        var service = new google.maps.DirectionsService();
 
        //Set the Path Stroke Color
        var poly = new google.maps.Polyline({ map: map, strokeColor: '#4986E7' });
 
        //Loop and Draw Path Route between the Points on MAP
        for (var i = 0; i < lat_lng.length; i++) {
            if ((i + 1) < lat_lng.length) {
                var src = lat_lng[i];
                var des = lat_lng[i + 1];
                path.push(src);
                poly.setPath(path);
                service.route({
                    origin: src,
                    destination: des,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                }, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                            path.push(result.routes[0].overview_path[i]);  
                        }
                    }
                });
            }
        }
    }
    google.maps.event.addDomListener(window, 'load', init);  
</script>
<!--LightBox--------->		

	<div id="tab-5" style="width:100%;">
			<div class="myNewMapArea tab5_main_new tab5_main">

          <div class="myNewMap" id="dvMap"></div>
		    </div>
	</div>
	
	
<?php  }else { ?>	

	<div id="tab-5" style="text-align: center;font-size: 18px;padding: 20px 0;">
		 No staff location.
	</div>
	
<?php  } ?>

<div class="location-list" id="" style="overflow:auto;width:100%;">
	<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table staff-loc-list">	 
		<thead style="text-align:center;">
			<tr class="table_cells" style="height:50px;">
				  <td><strong>Date Time</strong></td>
				  <td><strong>Address</strong></td>
				  <td><strong>Quardinate (latitute / longitude)</strong></td>
			</tr>
		</thead>
		<tbody class="table_scrol_location">
			<?php 
				$query = mysql_query($queryselect);
			mysql_data_seek($query,1);
		
			if(mysql_num_rows($query) > 0) { 
			while($row_staff_loaction = mysql_fetch_assoc($query) ) { ?>
			<tr class="table_cells">
			   <td><?php echo date('Y-m-d h:i:s A', strtotime($row_staff_loaction['create_time']));?></td>
			   <td><?php echo $row_staff_loaction['title'];?></td>
			   <td><?php echo $row_staff_loaction['lat'];?> / <?php echo $row_staff_loaction['lng'];?></td>
			</tr>
			<?php } } else {  ?>
			<tr class="table_cells">
				   <td colspan="3">No result</td>
				   
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
	
	
	
	