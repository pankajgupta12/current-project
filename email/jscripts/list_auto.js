// JavaScript Document

function valid_form(){
	if (confirm("Are1 you sure you wish to delete these records")){
		return true;
	}else{
		return false;
	}
}

function valid_email_form(){
	if (confirm("Are you sure you wish to sent email these records")){
		document.form1.action.value="sendemail";
		document.form1.submit();
		return true;
	}else{
		return false;
	}
}

function check_new_all(val){
	for (i=0;i<form1.elements.length;i++){
	type=form1.elements[i].type
		if (type=="checkbox"){
			var dbox="d"+val;		
			if(form1.elements[i].id==dbox){
				
				if(document.getElementById("c"+val).checked==true){
					document.form1.elements[i].checked=true;
				}else{
					document.form1.elements[i].checked=false;
				}
			}
		}
	}
}



function newcheckall(ch){
	for (i=0;i<form1.elements.length;i++){
		type=form1.elements[i].type
		if (type=="checkbox"){ document.form1.elements[i].checked=ch; }
	}
}

function clickcheck(){
if (document.form1.checkall.checked){ newcheckall(true) }else{newcheckall(false)}
}
