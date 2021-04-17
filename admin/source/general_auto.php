<?php

	function change_checkbox($val){
		$fv = str_replace("||","|0|",$val);
		$fv1 = str_replace("on","1",$fv);
		return $fv1;
	}


	//$argx = "select * from module_details where module_id=".$t;
	//echo $argx;
	//$datax = mysql_query($argx);
	$md= mysql_fetch_array($datax);
   // print_r($md);
    $_SESSION['list_current_auto'] = $md;
	$folder=$md['folder'];
	$table=$md['table'];
	$title=$md['title'];
	$img_folder = $md['image_folder'];
	//$table = "395x350";
	//-----------add and modify -----------
	$_POST['date_added']=$cur_date_mysql;
	//$_POST['status']=1;
	$fields_name = explode("|",$md['f_name']);
	$fields_heading = explode("|",$md['f_heading']);
	$fields_type = explode("|",$md['f_type']);
	
	
	$fields_validation=explode("|",change_checkbox($md['valid']));

	$fields_jvalidation=explode("|",change_checkbox($md['jvalid']));
	$fields_dtype=explode("|",change_checkbox($md['dtype']));
	$fields_add=explode("|",change_checkbox($md['dadd']));
	$field_javascript= explode("|",$md['javascript']);
	$field_maxnum = explode("|",$md['maxnum']);
	$f_type_value = explode("|",$md['f_type_value']);
	$f_filed_desc = explode("|",$md['f_filed_desc']);
	
	
	
	/////---------- listing fields--------------
	$listname = explode("|",$md['listname']);
	$listheading = explode("|", $md['listheading']);
	$listopt = $md['listopt'];
	foreach ($listname as $lfname){
		$j=0;
		$lcheck = false;
		foreach ($fields_name as $fname){
			if ($fname ==$lfname){
				$lheading .= $fields_heading[$j] ."|";
				$lftype .= $fields_type[$j]."|";
				$lftvalue .=$f_type_value[$j]."|";
				$lcheck=true;
			}
			$j=$j+1;
		}
		// if i didnt find in the fields as ID is not added in form , but may need to display in list 
		if(!$lcheck){
			if($lfname=="id"){
				$lheading .= "Id|";
				$lftype .= "text|";
				$lftvalue .= "|";
				$lcheck=false;
			}else{
				$lheading .= $lfname."|";
				$lftype .= "|";
				$lftvalue .= "|";
				$lcheck=false;
			}
		}
	}
	$lheading = substr($lheading,0,strlen($lheading)-1);
	$lftype = substr($lftype,0,strlen($lftype)-1);
	$lftvalue = substr($lftvalue,0,strlen($lftvalue)-1);
	
	$listheading = explode("|",$lheading);
	$listtype = explode("|",$lftype);
	$listtypevalue = explode("|",$lftvalue);
	
	//print_r($listname)."<br>".print_r($listheading)."<br>".print_r($listtype)."<br>".print_r($listtypevalue);
	
	

	if ($a=="delete")
	{
		/* echo $table;
     print_r($_POST); die; */
     $rights=1;
		if ($rights)
		{ 
	     
		//include("source/modules/adminstrators/delete.php"); 
		  $ccnew=delete_fields($table);		
		  include("source/modules/$folder/list.php");
		}
		else
		{ 
		include("source/access_denied.php"); 
		}
    }
	else if($a=="sendemail")
	{
		$ccnew=send_email_fields($table);		
		include("source/modules/$folder/list.php");
	}else{

		$rights=1;
			/*if (($a=="add") && ($_POST['step']==1)){
				if ($_POST['username']!=""){
					$chk1 = "select * from $table where username ='".$_POST['username']."'";
					$data1= mysql_query($chk1);
					if (mysql_num_rows($data1)>0){
						$_SESSION['query[error]'] = 1;
						$_SESSION['query[txt]'] = "Username Already Exist<br>";
					}else{
						$_SESSION['query[error]']=0;
						$_SESSION['query[txt]'] = "";
					}
				}
			
			}else if (($a=="modify") && ($_POST['step']==1)){
				if ($_POST['username']!=""){
					$chk1 = "select * from $table where username ='".$_POST['username']."' and id!=".rw("id");
					$data1= mysql_query($chk1);
					if (mysql_num_rows($data1)>0){
						$_SESSION['query[error]'] = 1;
						$_SESSION['query[txt]'] = "Username Already Exist<br>";
					}else{
						$_SESSION['query[error]']=0;
						$_SESSION['query[txt]'] = "";
					}
				}
			}*/
			
		//echo "source/modules/$folder/$a.php"; 
	//	echo "source/modules/$folder/$a.php"; die;
		if ($rights){ include("source/modules/$folder/$a.php"); } else{ include("source/access_denied.php"); }
	}

?>
