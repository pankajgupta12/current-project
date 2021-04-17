function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);


function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}


function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}


function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}


function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}


function MM_checkBrowser(NSvers,NSpass,NSnoPass,IEvers,IEpass,IEnoPass,OBpass,URL,altURL) { //v4.0
  var newURL='', verStr=navigator.appVersion, app=navigator.appName, version = parseFloat(verStr);
  if (app.indexOf('Netscape') != -1) {
    if (version >= NSvers) {if (NSpass>0) newURL=(NSpass==1)?URL:altURL;}
    else {if (NSnoPass>0) newURL=(NSnoPass==1)?URL:altURL;}
  } else if (app.indexOf('Microsoft') != -1) {
    if (version >= IEvers || verStr.indexOf(IEvers) != -1)
     {if (IEpass>0) newURL=(IEpass==1)?URL:altURL;}
    else {if (IEnoPass>0) newURL=(IEnoPass==1)?URL:altURL;}
  } else if (OBpass>0) newURL=(OBpass==1)?URL:altURL;
  if (newURL) { window.location=unescape(newURL); document.MM_returnValue=false; }
}


function MM_checkPlugin(plgIn, theURL, altURL, autoGo) { //v4.0
  var ok=false; document.MM_returnValue = false;
  with (navigator) if (appName.indexOf('Microsoft')==-1 || (plugins && plugins.length)) {
    ok=(plugins && plugins[plgIn]);
  } else if (appVersion.indexOf('3.1')==-1) { //not Netscape or Win3.1
    if (plgIn.indexOf("Flash")!=-1 && window.MM_flash!=null) ok=window.MM_flash;
    else if (plgIn.indexOf("Director")!=-1 && window.MM_dir!=null) ok=window.MM_dir;
    else ok=autoGo; }
  if (!ok) theURL=altURL; if (theURL) window.location=theURL;
}