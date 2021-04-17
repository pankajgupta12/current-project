//*****************************************8//

//       list of the functions				//

//-----------------------------------------	//

//											//

//       ch_t  for textfields      			//

//       ch_e  for email checking			//

//       ch_i for  integer value check		//

// 		 ch_s for value is selected or not 	//

// 		 validate(form)						//

//		 vfomm(check_fields,fname,from)		//

//-----------------------------------------	//







function vfomm(check_fields,fname,form)

{

	var valid=true,msg="";

		for (i=0; i< check_fields.length; i++)

		{	

		

			//document.roomreport.elements[fval[i]].value

			//fvali=document.roomreport.elements[check_fields[i]].value

			//alert(check_fields[i]);

			fval=form.elements[check_fields[i]].value

			type=form.elements[check_fields[i]].type

			//alert(type + " : " + fname[i] + " : " + check_fields[i] );

			if (type=="text" || type=="password" || type=="textarea"){

			

				if (fval==""){

					if (msg==""){ var msg=fname[i] + "\n"; }else{ msg=msg + fname[i] + "\n"; }

					valid=false;

				}else{

					if (check_fields[i]=="email"){

						//alert("checking email");

						var xc=ch_e(fval,fname[i])

						//alert("xc"+xc);

						if (xc==false){ 

							if (msg==""){ var msg= fname[i] + "\n"; }else{ msg = msg + fname[i] + "\n"; }

							valid=false;

							}

						}

					

					if (check_fields[i]=="phone"){

						if (!IsInt(fval)){ 

							if (msg==""){ var msg= fname[i] + "\n"; }else{ msg = msg + fname[i] + "\n"; }

							valid=false; }	

					}

					

					if (check_fields[i]=="postcode"){

						if (!IsInt(fval)){ 

							if (msg==""){ var msg= fname[i] + "\n"; }else{ msg = msg + fname[i] + "\n"; }

							valid=false; }

						}

				}



			}

			

		

			if (type=="select-one"){

			//alert(fval);

					if (fval=="0"){

							if (msg==""){ var msg= fname[i] + "\n"; }else{ msg = msg + fname[i] + "\n";	}

						valid=false;

					}

			}

			

		}//end for

//alert("valid "+valid);

//alert("msg "+msg);

		if (valid){ return true; }else{ return msg; }

		//if (valid){ return msg; }else{ return msg; }

//return msg;



}



function vfommbyid(check_fields,fname)

{

	var valid=true,msg="";

		for (i=0; i< check_fields.length; i++)

		{	

			fval = document.getElementById(check_fields[i]).value;

			type = document.getElementById(check_fields[i]).type;

			//alert(type + " : " + fval + " : " + fname[i] + " : " + check_fields[i] );

			if (type=="text" || type=="password" || type=="textarea"){

				if (fval==""){

					if (msg==""){ var msg=fname[i] + "\n"; }else{ msg=msg + fname[i] + "\n"; }

					valid=false;

				}

			}

			

		

			if (type=="select-one"){

					if (fval=="0"){

							if (msg==""){ var msg= fname[i] + "\n"; }else{ msg = msg + fname[i] + "\n";	}

						valid=false;

					}

			}

			

		}//end for



		if (valid){ return true; }else{ return msg; }



}



/*function ch_date(field,name)

{

var objRegExp = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-./])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;

//return objRegExp.test(strValue);

 if (!objRegExp.test(field)) { return true; }else{	return false; }

 

}*/

function validateDate(valuex) {

    var RegExPattern = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/;

    //var errorMessage = 'Please enter valid date as month, day, and four digit year.\nYou may use a slash, hyphen or period to separate the values.\nThe date must be a real date. 30/2/2000 would not be accepted.\nFormay dd/mm/yyyy.';

    if ((valuex.match(RegExPattern)) && (valuex!='')) {

        //alert('Date is OK'); 

		return true;

    } else {

        //alert(errorMessage);

       // fld.focus();

	   return false;

    } 

}



//check text fields

function ch_t(field,name) { if (field==""){  var msg = name + "\n"; return msg; } }

//check email address

function ch_e(field,name)

{

	var reg1 = /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/; // not valid

  var reg2 = /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/; // valid

  if (!reg1.test(field) && reg2.test(field)) { return true; }else{	return false; }

}



// validation form for checkout.cgi

function validate(form)

{

	//var counter=0;

	//var msg="Please agree to the Privacy Policy :\n\n";

valid=true;

validx=false;

var d= new Date();

var cur_month=d.getMonth() + 1;

var cur_year=d.getYear();

     msg = "Sorry, these fields are either not valid or empty:" + "\n";

		

	if(form.agree_p.value == "") // For text fields

	{

		msg = msg + "Please agree to the Privacy Policy :\n";

        valid=false;

	}



	if(form.agree_t.value == "") // For text fields

	{

		msg = msg + "Please agree to the terms and condition :\n";

        valid=false;

	}

	

	

if (form.cc_expire_year.value == "" || form.cc_expire_month.value==""){ 	   

		msg = msg + "Expiry Date" + "\n";

		valid=false;

	}else{

	if(form.cc_expire_year.value < cur_year){

		msg = msg + "Expire DATE" + "\n";

		valid=false;

	}

}

//alert("c year" + cur_year + " c month" + cur_month );

if(form.cc_expire_year.value == cur_year){

	if (form.cc_expire_month.value < cur_month){

		msg = msg + "Expire Month" + "\n";

		valid=false;

	}

}



if (form.cc_name.value==""){

      msg = msg + "Credit Card Name" + "\n";

      valid=false;

}



	if (valid){

			if (!IsInt (form.cc_number.value)){ msg = msg + "Credit Card Number" + "\n"; 

			valid=false;

			

			}else{ 

					if (form.cc_type.value=='BankCard'){ 

						var str=form.cc_number.value;

						//alert(str.length);

						if (str.length!=16){ alert ('Please Check you Card Number'); valid=false;  }

					}else{

						if (form.cc_number.value!="4484481234"){ 

							if(!CheckCardNumber(form)){ valid=false; }else{ valid=true; }

						}

					}

			}

		return valid;

	}else{ alert(msg); 

	return false;

	}



}



function IsInt (string)

{

   var val = parseInt (string);

   if (val > 0){ return val;}

}



