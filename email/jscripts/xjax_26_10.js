function show_load() { 
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE 
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth; 
    myHeight = document.documentElement.clientHeight; 
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth; 
    myHeight = document.body.clientHeight;
  }
  //window.alert( 'Width = ' + myWidth );
  //window.alert( 'Height = ' + myHeight ); 
 //var lft = 0, top = 0;
 var lft = (myWidth/2)-75;
 var top = (myHeight/2)-50 ; 
 //alert(lft + " 000 " + top );
 var str = "<table border=0 cellpadding=4 cellspacing=1 width=100% height=100% align=center style=BORDER-RIGHT:#888888 2px solid; BORDER-TOP:#888888 2px solid; BORDER-LEFT:#888888 2px solid; CURSOR:default; BORDER-BOTTOM:#888888 2px solid; BACKGROUND-COLOR:#ffffff bgcolor=#cccccc><tr><td align=center class=text11><IMG src=/images/management/loading/spinner.gif>&nbsp;&nbsp;<b>Loading ...</b></td></tr></table>";
 
 document.getElementById('load_splash').style.left=lft;
 document.getElementById('load_splash').style.top=top;
 document.getElementById('load_splash').style.width="150px";
 document.getElementById('load_splash').style.height="100px";
 document.getElementById('load_splash').innerHTML= str;
 document.getElementById('load_splash').style.visibility="visible";
 
}
//---------------------------------------------------------------------------------------------------------

function hide_load(){
	document.getElementById('load_splash').style.visibility="hidden"; 
}

function GetXmlHttpObject(handler)
{ 
	var objXMLHttp=null
		if (window.XMLHttpRequest)
		{
			objXMLHttp=new XMLHttpRequest();
		}
		else if (window.ActiveXObject)
		{
			objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	return objXMLHttp;
}

var xmlHttp;
var _xt;
var _div_id;
var _str;

function show_data(param,xt,_div)
{
	//alert(param);
	//show_load();
	//loading_splash(_div_id);
	var obj = document.getElementById(param);
	var str = obj.value;
	_div_id = _div;
	_xt = xt;
	//alert(str);
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 
		//var host = getHostNameFromPc();
		var url=location.protocol + "//" + location.hostname +"/admin/xjax/xjax.php";
		url=url+"?xt="+xt;
		url=url+"&var="+str;
		url=url+"&sid="+sid;
		url=url+"&xid="+Math.random();
		//alert(url);
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
} 



function send_data(param,xt,_div)
{
   // alert(param+"=="+xt+"=="+_div);
   // return false;
//loading_splash(_div_id);
//alert(param);
//var obj = document.getElementById(param);
var str = param;
//alert(str);
_xt = xt;
_div_id = _div;
_str = str;

	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
	  // alert();
	  //alert(location.protocol + "//" + location.hostname);
		var url= location.protocol + "//" + location.hostname +"/admin/xjax/xjax.php";
		url=url+"?xt="+xt
		url=url+"&var="+str
		url=url+"&sid="+sid
		url=url+"&xid="+Math.random()
		//alert(url);
		
		xmlHttp.onreadystatechange=stateChanged
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		
}

function stateChanged() 
{  

  if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
		//hide_load();
		
		
		 
		if((_xt==11)){  
		     
		    var strid = _str.split("|");
			send_data(strid[1],107,'job_type_div');
		    //setTimeout(function(){send_data(strid[1],107,'job_type_div');},2000); 
		    setTimeout(function(){send_data('',12,'dispatch_div');},2000); 
			setTimeout(function(){send_data(strid[1],121,'job_unassinged');},2000); 
		
		}else if((_xt==21)){ 
			//document.getElementById('comments').value="";
			if(_div_id!='booking_date'){ 			
				var xx21 = xmlHttp.responseText.trim();
				document.getElementById(_div_id).value = xx21;
			}
		}else if ((_xt==14) ||(_xt==15)){
			document.getElementById(_div_id).innerHTML =xmlHttp.responseText;
			// refresh dispatch
			send_data('',12,'dispatch_div');
		}else if ((_xt==8)){
			document.getElementById(_div_id).innerHTML =xmlHttp.responseText;
			// refresh dispatch
			send_data('',20,'dispatch_side_div');
		}else if((_xt==2) || (_xt==42) || (_xt==60) || (_xt==105)){
			//alert(_div_id);
			document.getElementById(_div_id).style.display="";
			document.getElementById(_div_id).innerHTML =xmlHttp.responseText;
		}else if((_xt==26)){
			//document.getElementById(_div_id).style.display="";
			document.getElementById(_div_id).value =xmlHttp.responseText;
		}else if((_xt==49)){
			//edit _quote_field / tmep and quote
			document.getElementById('quote_div').innerHTML =xmlHttp.responseText;
			// temp id is in session 
			//send_data('temp_id',51,'total_amount_quote');
		}else if((_xt==72)){	
		    //send_data('2','74','site_notification');
			sendRequest(_str , _div_id , xmlHttp.responseText);
			
		}else if((_xt==73)){	
			sendRequestjob(_str , _div_id , xmlHttp.responseText);
			 
		}else if((_xt==74)){
		    	document.getElementById(_div_id).innerHTML =xmlHttp.responseText;
		   	  send_data('',75,'notification_icone');
		}else if((_xt==75)){
		    	document.getElementById(_div_id).innerHTML =xmlHttp.responseText;
		   	  send_data('',76,'notification_count');
		}else if((_xt==77)){
		   	sendRequeststaff(_str , _div_id , xmlHttp.responseText);
		}else if((_xt==79)){
		   	memberdetailslink(_str , _div_id , xmlHttp.responseText);
		}else if((_xt==448)){ 
		      document.getElementById(_div_id).innerHTML =xmlHttp.responseText;
		     // getstatuscheck(_str,_div_id,xmlHttp.responseText);
		}else if((_xt==445)){ 
		       send_data('',450,_div_id);
		}else if((_xt==102)){
			//document.getElementById('referesh_comments_button').click();
				deletecallImport(_str , _div_id , xmlHttp.responseText);
		}else if((_xt==111)){
			//document.getElementById('referesh_comments_button').click();
				deleteallimportfile(_str , _div_id , xmlHttp.responseText);
		}else if((_xt==113)){
			//document.getElementById('referesh_comments_button').click();
				readstaffnotification(_str , _div_id , xmlHttp.responseText);
		}else{ 
		    
			 //alert(_xt); 
			
			document.getElementById(_div_id).innerHTML = xmlHttp.responseText;
			initDatePicker();
		}
		
	}  
}  

 
function readstaffnotification ( str , div_id , resp ){
     $('#'+div_id).html(resp); 
     var string = str.split('|');
     $('#staff_job_list_'+string[0]).remove(); 
    // $('#'+div_id).html(resp); 
}

function deleteallimportfile( str , div_id , resp ){
   // alert(resp);
    $('#'+div_id).remove();
}
function deletecallImport(str , div_id , resp ){
	//alert(div_id);
	if(resp == 1){
	  $('#'+_div_id).remove();
	}else{
		alert('Something went wrong, please contact to support!');
	}
}

function getstatuscheck(str , _div_id , resp ){
	
	var respdata = resp.split("_");
	var strid = str.split("|");
	if(parseInt(respdata[1]) == 0){
		alert('Error, some thing went wrong with your selection!');
			$("#step_"+strid[1]).val(parseInt(respdata[0]));
	     	return false;
	}else{
		alert('Job status has been changed.');
	}
}

function sendRequest( str , _div_id , resp )
{
	
	if( parseInt(resp) == 1 )
	{
	     var strid = str.split("|");
		$('#'+_div_id).remove();
		window.location.href = location.protocol + "//" + location.hostname +"/admin/index.php?task=edit_quote&quote_id="+strid[1];
	}
	else
	{
		alert( "Something went wrong, please contact to support!" );
		return false;
	}
}

function memberdetailslink( str , _div_id , resp )
{
	
	if( parseInt(resp) == 1 )
	{
	    // var strid = str.split("|");
		$('#'+_div_id).remove();
		window.location.href = location.protocol + "//" + location.hostname +"/admin/index.php?task=view_quote";
	}
	else
	{
		alert( "Something went wrong, please contact to support!" );
		return false;
	}
}

function sendRequeststaff( str , _div_id , resp )
{
	
	if( parseInt(resp) == 1 )
	{
	     var strid = str.split("|");
		$('#'+_div_id).remove();
	//	show_data(strid[1],17,'dispatch_div');
		window.location.href = location.protocol + "//" + location.hostname +"/admin/index.php?task=dispatch";
		//strid[1]
	
	}
	else
	{
		alert( "Something went wrong, please contact to support!" );
		return false;
	}
}

function sendRequestjob( str , _div_id , resp )
{
	
	if( parseInt(resp) == 1 )
	{
	    var strid = str.split("|");
	   $('#'+_div_id).remove();
       var url  = location.protocol + "//" + location.hostname +"/admin/popup.php?task=jobs&job_id="+strid[1];
       var height = '1200';
       var width = '850';
       scrollWindow(url,height,width);
       	send_data('',75,'notification_icone');
	}
	else
	{
		alert( "Something went wrong, please contact to support!" );
		return false;
	}
}

function initDatePicker()
{
 if( $( "table.find_datepicker tr td" ).find( "input.staff_paid_datepicker" ).length > 0 )
 {
  var getAllDatepicker = $( "table.find_datepicker tr td" ).find( "input.staff_paid_datepicker" ).length;
  $(".staff_paid_datepicker").datepicker({dateFormat:'yy-mm-dd'}); 
  $(".payment_check_date_datepicker").datepicker({dateFormat:'yy-mm-dd'}); 
 }
}

function loading_splash(e) {
   // var t = "<table border=0 cellpadding=0 cellspacing=0 style=WIDTH:100%;HEIGHT:100% align=center><tr><td align=center valign=middle><table border=0 cellpadding=4 cellspacing=0 width=150 height=40 style=BORDER-RIGHT:#888888 2px solid; BORDER-TOP:#888888 2px solid; BORDER-LEFT:#888888 2px solid; CURSOR:default; BORDER-BOTTOM:#888888 2px solid; BACKGROUND-COLOR:#ffffff><tr><td align=center class=text11><IMG src=/images/bar_loader.gif>&nbsp;&nbsp;<b>Loading ...</b></td></tr></table></td></tr></table>";
	  var t = "...";
    document.getElementById(_div_id).innerHTML = t;
}


	
