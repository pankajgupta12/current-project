	function chkMap()
	{
		
		var map_checked = document.getElementById("map_view").checked;
			
		if(map_checked == true)
		{
			document.getElementById("map").style.display = "block"; 
			
			if( document.getElementById('lat_long').value != "" )
			{
				/* document.getElementById("map").style.width = "250px"; 
				document.getElementById("map").style.height = "250px"; 
				
				//get lat and language
				var strAddress = document.getElementById('lat_long').value;
				var latlang = strAddress.split("__");
				var mesg = document.getElementById('address').value;
				
				var latitude = latlang[0];
				var longitude = latlang[1]; 
				
				initMap(latitude , longitude , mesg); */
				
			}
		}
		else
		{
			document.getElementById("map").style.display = "none"; 
			document.getElementById("map").style.width = ""; 
			document.getElementById("map").style.height = ""; 
			
		}
		
	}
	
	
	var options = {
		componentRestrictions: {country: 'au'}
	};	
   google.maps.event.addDomListener(window, 'load', function () {
		var places = new google.maps.places.Autocomplete(document.getElementById('address') , options);
		google.maps.event.addListener(places, 'place_changed', function () {						//
			place = places.getPlace();
			address = place.formatted_address;			address_details = place.formatted_address;
			latitude = place.geometry.location.lat();
			longitude = place.geometry.location.lng();
			
			var mesg = "Address: " + address;
			mesg += "\nLatitude: " + latitude;
			mesg += "\nLongitude: " + longitude;
			
			
			//check id is available or not
			onkeyUpbyComp( address_details, latitude,  longitude );
			
			//set map into small area			
			initMap(latitude , longitude , mesg , address_details);
				
		});	
	}); 
	
	function onkeyUpbyComp( address_details , latitude,  longitude  )
	{
		
		var el = document.getElementById("address"); 
		var quote_id = el.getAttribute("for"); 
		
		if(el.getAttribute("for") != undefined) {
		 edit_field(el,'quote_new.address',quote_id);
		 var lat_long1 = latitude +'__'+ longitude;
		 str = lat_long1 +'|'+quote_id;
		 send_data(str,206,'lat_long');
		}
	}
	
	function initMap(latitude,longitude, mesg, address_details)
	{	
		var myLatLng = {lat: latitude, lng: longitude};
		document.getElementById('lat_long').value = latitude + '__' + longitude;	
		
           		
		//alert(address_details);		//send_data();		
		
		var map_checked = false; //document.getElementById("map_view").checked;
		
		if(map_checked)
		{
			
			document.getElementById("map").style.width = "250px"; 
			document.getElementById("map").style.height = "250px"; 
			
			// Create a map object and specify the DOM element for display.
			var map = new google.maps.Map(document.getElementById('map'), {
			  center: {lat: latitude, lng: longitude},
			  zoom: 8,
			  panControl:false,
				zoomControl:false,
				mapTypeControl:false,
				scaleControl:false,
				streetViewControl:false,
				overviewMapControl:false,
				rotateControl:false,
				fullscreenControl: false		
			});
			
			var marker = new google.maps.Marker({
			  position: myLatLng,
			  map: map,
			  title: mesg
			});
			
			var infowindow = new google.maps.InfoWindow({
			  content: mesg
			});
			
			marker.addListener('click', function() {
			  //infowindow.open(map, marker);
			  
			});
			
		}
		
   }	