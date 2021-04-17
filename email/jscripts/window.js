

function newWindow(url,mywidth,myheight) {
	var iMyWidth;
	var iMyHeight;
	//gets top and left positions based on user's resolution so hint window is centered.
	iMyWidth = (window.screen.width/2) - ((mywidth/2) + 10); //half the screen width minus half the new window width (plus 5 pixel borders).
	iMyHeight = (window.screen.height/2) - ((myheight/2) + 50); //half the screen height minus half the new window height (plus title and status bars).
	var win2 = window.open(url,"Window3","status=0,height=" + myheight + ",width=" + mywidth + ",resizable=yes,left=" + iMyWidth + ",top=" + iMyHeight + ",screenX=" + iMyWidth + ",screenY=" + iMyHeight + ",scrollbars=yes");
	win2.focus();
}
// Centred Window, Scrolling and Resizeable


function scrollWindow(url,mywidth,myheight) {
	var iMyWidth;
	var iMyHeight;
	//gets top and left positions based on user's resolution so hint window is centered.
	iMyWidth = (window.screen.width/2) - ((mywidth/2) + 10); //half the screen width minus half the new window width (plus 5 pixel borders).
	iMyHeight = (window.screen.height/2) - ((myheight/2) + 50); //half the screen height minus half the new window height (plus title and status bars).
	var win2 = window.open(url,"Window3","status=0,height=" + myheight + ",width=" + mywidth + ",resizable=no,left=" + iMyWidth + ",top=" + iMyHeight + ",screenX=" + iMyWidth + ",screenY=" + iMyHeight + ",scrollbars=yes");
	win2.focus();
}
// Centred Window, Scrolling and Not Resizeable



function deadWindow(url,mywidth,myheight) {
	var iMyWidth;
	var iMyHeight;
	//gets top and left positions based on user's resolution so hint window is centered.
	iMyWidth = (window.screen.width/2) - ((mywidth/2) + 10); //half the screen width minus half the new window width (plus 5 pixel borders).
	iMyHeight = (window.screen.height/2) - ((myheight/2) + 50); //half the screen height minus half the new window height (plus title and status bars).
	var win2 = window.open(url,"Window3","status=0,height=" + myheight + ",width=" + mywidth + ",resizable=no,left=" + iMyWidth + ",top=" + iMyHeight + ",screenX=" + iMyWidth + ",screenY=" + iMyHeight + ",scrollbars=no,titlebar=no");
	win2.focus();
}
//Centred Window, No Scrolling and Not Resizeable


// The next script opens up a new window in full screen mode in EI
function fullWindow(url) 
{

 	var resize = '';							// Set the defaults
  	var titlebar = '';
	var wvalue = screen.width - 7;
  	var hvalue = screen.height - 75;
   
  	if (navigator.appName == 'Netscape') 
  	{	           
		if (screen.height >= 600) // 800 x 600 or greater
		{			           
			wvalue = 798;
			hvalue = 572;
		} 
			
		else // 640 x 480
		{							               
			hvalue = hvalue - 2;
		}		
		  
		titlebar = ',titlebar=0';
		resize = ',resizable';
	} 
		
	else 
	{								               
		resize = ',resizable';
	}

		window.open(url,'websearch','top=0,toolbar=yes,left=0,scrollbars=yes,status=yes,width=' + wvalue + ',height=' + hvalue + resize + titlebar + ',hotkeys=0');
  
	
	 																							//set variables and open logon window and splash page for red sheriff survey
	if (navigator.appName == 'Netscape') // Netscape
	{	           
		if (screen.height >= 600) // 800 x 600 or greater
		{			           
			wvalue = 798;
			hvalue = 572;
		} 
			
		else 
		{
			hvalue = hvalue - 2;
		}		
		  
		titlebar = ',titlebar=0';
		resize = ',resizable';
	 } 
	
	  
	 else // MS Internet Explorer.
	  	{								               
	  		resize = ',resizable';
	  	}                 
}
