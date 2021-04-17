
<?php 
if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
?>
<script language="JavaScript" src="/admin/jscripts/validate.js"></script>


<script language="JavaScript">
function intial(){
<? if ($step==1 && $_SESSION['query[error]']){ 
		$jks=0;


		foreach($fields_type as $xftype){
			if ($xftype=="dd"){
				// 'onchange="javascript:get_chapters2()"'
				$xdd_values = explode(",",$f_type_value[$jks]);
				
				//print_r($xdd_values);
				
				if ($xdd_values[5]!=""){
					$cond= $xdd_values[5];
					$pos1= strpos($cond,":");
					$pos2 = strpos($cond,")");
					$word_length = ($pos2+1) - ($pos1+1);
					//echo $pos1."-".$pos2."-".$cond;
					$cond_field = substr($cond,$pos1+1,$word_length);
					echo $cond_field.";";
					
					//$new_cond = substr($js_str,0,$pos1).$details[$cond_field];
					//echo "<br>".$new_cond."<br>";
					//$dd_values[4] = $new_cond;
				}
			}
			$jks++;
		}

	}
?>
 
}

function vform()
{
	 //
var testresults
<? 
	for ($i=0;$i<count($fields_name);$i++) { if ($fields_jvalidation[$i]==1){ $str_cf.="'".$fields_name[$i]."',"; $str_fname.="'".$fields_heading[$i]."',"; } }
	$str_cf=substr($str_cf,0,strlen($srt_cf)-1);
	$str_fname=substr($str_fname,0,strlen($str_fname)-1);	
?>
var check_fields = new Array(<? print $str_cf?>);
var fname = new Array(<? print $str_fname?>);
//alert(check_fields);
var msg=vfomm(check_fields,fname,document.form1);
	if (msg==true){
		//alert('ok');
		return true;
	}else{
		//alert('not');
		alert("Sorry, these fields are either not valid or empty:" + "\n\n" + msg +"\n")
		return false;
	}
	return true;
}


</script>
<?php 
 /* if($_REQUEST['id'] != '') {
	 $url = $_SERVER['SCRIPT_NAME']."?task=edit_staff&id=".$_REQUEST['id'];
    }else {
	  $url = $_SERVER['SCRIPT_NAME'];
    } */

?>

<form name="form1" method="post" action="<? echo $_SERVER['SCRIPT_NAME']; ?>" onsubmit="return vform(this)"  autocomplete="off" enctype="multipart/form-data">
 
 <div class="job_wrapper">
	<div class="job_back_box">
	    	<span class="add_jobs_text"><? if ($a=="add"){ echo "Add"; }elseif($a=="modify"){ echo "Modify";}?> <? echo $title?></span>
			
			<span class="add_jobs_text" style="margin-top: -76px;"><input onclick="javascript:window.location='../admin/index.php?task=<?php echo $t; ?>&action=list';" type="button" class="staff_button" value="List <? echo $title?>"></span>
	

	  <ul class="add_lst">
		<?
		$no_rec = count($fields_name);
		$file_i=0;
		for ($i=0;$i<$no_rec;$i++)
		{
		$f_name=$fields_name[$i].$f_filed_desc[$i];
		//echo $f_name."<br>"; 
		//echo $fields_type[$i]."--".$fname."--".$details[$f_name]."<br>";
		if($fields_type[$i]==ltrim(rtrim("hidden"))){?>
		<input type="hidden" name="<? echo $f_name ?>" value="<? echo  get_field_value($details,$_POST[$f_name]) ?>">

		<?  }else if(($fields_type[$i]=="cke") || ($fields_type[$i]=="fck")){ ?>
		<li> 
			<label><font color="<? echo $td_fontcolor;?>"><? echo $fields_heading[$i]?></font> <? if ($fields_validation[$i]=="1"){?>&nbsp;<font color="#FF0000" size="+1">*</font><? } ?><br />   </label>
			<div>
				<div class="textarea">
				<?php echo '<textarea name="'.$f_name.'"  id="'.$f_name.'" class="ckeditor add_description">'.stripslashes(get_field_value($details,$f_name)).'</textarea>'; ?>
				</div>
			</div>
		</li>
		<? }else if($fields_type[$i]=="bigtextarea"){ ?>
		<li> 
			<label><font color="<? echo $td_fontcolor;?>"><? echo $fields_heading[$i]?></font> <? if ($fields_validation[$i]=="1"){?>&nbsp;<font color="#FF0000" size="+1">*</font><? } ?></label>
			<div>
				<div class="textarea">
					<textarea name="<? echo $f_name?>"  class="add_description" ><? echo get_field_value($details,$f_name); ?></textarea> 
				</div>
			</div>
		</li>
		<? } else { ?>
		
		<li>
		  <label>
			<font color="<? echo $td_fontcolor;?>"><? echo $fields_heading[$i]?></font> 
		  <? if ($fields_validation[$i]=="1"){?>&nbsp;<font color="#FF0000" size="+1">*</font><? } ?>
		  </label>
		    <div> 
			   <? 
			  
			   // create drop down from a include file 
			   if ($fields_type[$i]=="ddd"){ 
					//echo "source/dropdowns/".$fields_name[$i].".php";
					include("source/dropdowns/".$fields_name[$i].".php"); 
			   }
			   
			   // create dd from a table with id and name 
			   if ($fields_type[$i]=="dd"){ 
					//echo $$fields_name[$i]."<br>";
					
					//print_r($f_type_value[$i]);
					
					//$dd_values = explode("|",get_field_value($details,$f_name));
					$dd_values = explode(",",$f_type_value[$i]);
					
					//print_r($dd_values);
					
					//$a = 'How are you?';
					

						
					if (strpos($dd_values[4],"{")>0){
						$cond = $dd_values[4] ; // course_id={course_id}
						$pos1= strpos($cond,"{");
						$pos2 = strpos($cond,"}");
						$word_length = $pos2 - ($pos1+1);
						//echo $pos1."-".$pos2."-".$pos3."-".$cond;
						$cond_field = substr($dd_values[4],$pos1+1,$word_length);
						//echo "<br>".$cond_field;
						$new_cond = substr($dd_values[4],0,$pos1)."'".$details[$cond_field]."'";
						echo "<br>".$new_cond."<br>";
						$dd_values[4] = $new_cond;
						
					}
					
					//echo $dd_values[4]; 
					
					echo '<span>'.create_dd($dd_values[0],$dd_values[1],$dd_values[2],$dd_values[3],$dd_values[4],$dd_values[5],$details).'</span>';
			   }
			   
			   // create date from fdate function 
				if ($fields_type[$i]=="fdate"){ 
					//$arr=explode("-",$fields_type[$i]);
					//$dp=$i;
					// to show what type of years we need 
					// 1. 0-10 
					//echo $f_type_value[$i];
					if ($f_type_value[$i]!=""){
						$fda_values = explode("-",$f_type_value[$i]);
					}else{
						$fda_values[0] = 5;
						$fda_values[1] = 5;
					}
					if ($a=="add"){
						if($_POST['dd_$i']!=""){$dd=$_POST['dd_'.$i];}else{$dd=date("d"); }
						if($_POST['mm_$i']!=""){$mm=$_POST['mm_$i'];}else{$mm=date("m"); }
						if($_POST['yy_$i']!=""){$yy=$_POST['yy_$i'];}else{$yy=date("Y"); }
						//$dd=get_field_value($details,$f_name);
					}else{
						
						$dthis = explode("-",$details[$f_name]);
						
						if($_POST['dd_'.$i]!=""){$dd=$_POST['dd_'.$i];}else{$dd=$dthis[2];}
						if($_POST['mm_'.$i]!=""){$mm=$_POST['mm_'.$i];}else{$mm=$dthis[1];}
						if($_POST['yy_'.$i]!=""){$yy=$_POST['yy_'.$i];}else{$yy=$dthis[0];}
					}
					
					echo '<div class="calendar_select">'.fdate($i,$dd,$mm,$yy,$fda_values[0],$fda_values[1]).'</div><br>';
					
				}
				
			   // create upload file for images 
				if ($fields_type[$i]=="file"){ 
					$file_i++;
				?>
			 <input name="file<? echo $file_i;?>" type="file" class="formfields" />
			<? if (get_field_value($details,$f_name)!=""){?>
			<a href="javascript:scrollWindow('details.php?img=<? echo get_field_value($details,$f_name); ?>','350','350')" class="text12"><font color="<? echo $text_color?>">[
			View Image ]</font></a></span>
			  <? }?>
			  </span>

			<? } 
			
			 if ($fields_type[$i]=="doc"){ 
				$file_i++;
			?>
			 <input name="doc<? echo $file_i;?>" type="file" class="formfields" />
			<? if (get_field_value($details,$f_name)!=""){?>
			<a href="javascript:scrollWindow('<? echo get_field_value($details,$f_name); ?>','650','650')" class="text12"><font color="<? echo $text_color?>">[
			View Document ]</font></a></span>
			  <? }?>
			  </span>

			<? }
			
			 if ($fields_type[$i]=="flv_videos"){ 
				$file_i++;
			?>
			
			 <input name="flv<? echo $file_i;?>" type="file" class="formfields" />
			<? if (get_field_value($details,$f_name)!=""){?>
			<a href="javascript:scrollWindow('video.php?id<? echo get_field_value($details,$f_name); ?>','650','650')" class="text12"><font color="<? echo $text_color?>">[
			View Video ]</font></a></span>
			  <? }?>
			  </span>
			  
			<? }
			
			 // create ajax div and dd 
			// create div for hidden stuff
			if ($fields_type[$i]=="xjax_dd_div"){ 
				if ($a=="modify"){ 
				
				$dd_values = explode(",",$f_type_value[$i]);
				//print_r($dd_values);
				echo  "<div name=\"".$f_name."_div\" id=\"".$f_name."_div\">";
				if (strpos($dd_values[4],"{")>0){
					$cond = $dd_values[4] ; // course_id={course_id}
					$pos1= strpos($cond,"{");
					$pos2 = strpos($cond,"}");
					$word_length = $pos2 - ($pos1+1);
					//echo $pos1."-".$pos2."-".$pos3."-".$cond;
					$cond_field = substr($dd_values[4],$pos1+1,$word_length);
					//echo "<br>".$cond_field;
					$new_cond = substr($dd_values[4],0,$pos1)."'".$details[$cond_field]."'";
					//echo "<br>".$new_cond."<br>";
					$dd_values[4] = $new_cond;
					
				}
				echo '<span>'.create_dropdown3($dd_values[0],$dd_values[1],$dd_values[2],$dd_values[3],$dd_values[4],$dd_values[5],$details[$f_name]).'</span>'; 
				echo "</div>"; 
				}else{
				//print_r($dd_values);
				
			?>
			<div name="<? echo $f_name?>_div" id="<? echo $f_name?>_div"></div> 
			<? }
			}
			
			
			// create div for hidden stuff
			if ($fields_type[$i]=="div"){ ?>
			<div name="<? echo $f_name?>" id="<? echo $f_name?>"></div> 
			<? }
			
			
			if ($fields_type[$i]=="ddd"){
                          
						   $gettrackdata =  dd_value(112);
                     
      // print_r($gettrackdata);
			?>
				<span>
					<select  name="<? echo $f_name?>" id="<? echo $f_name?>">
					 <?php foreach($gettrackdata as $tkey=>$tvalue) { ?>
						<optgroup label="<?php echo $tvalue; ?>">
						   <?php 
							  if($tkey == 1) {
                                  $getsubdata_all =  dd_value(113);
							  }elseif($tkey == 2) {
								 $getsubdata_all =  dd_value(116);  
							  }
							  
							 // print_r($getsubdata_all);
							 if(count($getsubdata_all) && $tkey != 3) {
                               foreach($getsubdata_all as $subkey=>$subvalue) {
						   ?>
							<option value="<?php  echo $subkey; ?>"><?php echo $subvalue; ?></option>
							 <?php  } }?>
						</optgroup>
					 <?php  } ?>
							<!--<optgroup label="Snippets">
							<option value="git">Git</option>
							<option value="java">Java</option>
						</optgroup>-->
				    </select>
				</span>
			<? }
			
			// password field
			 if ($fields_type[$i]=="password"){ ?>
			<input name="<? echo $f_name?>" type="password" id="show_hide_password" class="formfields" style="width: 350px;" value="<? echo get_field_value($details,$f_name); ?>">
            <a id="show_password" class="show_hide_buttone" Onclick="showPassword();">Show</a> 	
            <a id="hide_password" style="display:none;" class="show_hide_buttone" Onclick="hidePassword();">Hide</a> 	
			<? }
			
			if ($fields_type[$i]=="fddd"){ ?>
			<input name="<? echo $f_name?>" type="text" class="date_class_new formfields" value="<? echo get_field_value($details,$f_name); ?>" size="35" 
			<? if($field_javascript[$i]!=""){ echo " ".$field_javascript[$i]." "; }?>> 
			<? }
		
			// text field 
			if ($fields_type[$i]=="text"){ ?>
			<input name="<? echo $f_name?>" type="text" class="formfields" value="<? echo get_field_value($details,$f_name); ?>" size="35" 
			<? if($field_javascript[$i]!=""){ echo " ".$field_javascript[$i]." "; }?>> 
			<? }
			// text area field 
			if($fields_type[$i]=="textarea"){	
				if(($t==4) && ($a=="add")){ 
					$jt_data = mysql_query("select name from job_type");
					while($jt_r=mysql_fetch_assoc($jt_data)){ 
						$details['job_types'].= $jt_r['name'].", "; 
					}
					$details['job_types'] = substr($details['job_types'],0,-2);
				}			
				?>
			<textarea name="<? echo $f_name?>"  class="add_description" ><? echo get_field_value($details,$f_name); ?></textarea> 
			<? }
				
				// select us is another drop down worked through the values passed in a arrat format 
				
				if($fields_type[$i]=="select"){?>
				<span>
					<select name="<? echo $f_name?>" class="formfields">
					  <? //print array_values($fields_name[$i]);
					$kk=1;
					$select_values = split(",",$f_type_value[$i]);
					foreach ($select_values as $value) {
							//echo "Value: $newvalue<br>\n";
							if ($value==$_POST[$f_name] || $value==$details[$f_name]){
							print("<option name=\"".$value."\" Selected >".$value."</option>");
							}else{
							print("<option name=\"".$value."\">".$value."</option>");
							}
						}

					?>
					</select> 
				</span>
			   <? } ?>
			   
			   
			   
			   
			
            <?php  if ($fields_type[$i]=="bbc_checkbox_week"){ 
			
			    $week_1 = WEEK_DAYS_ARRAY; 
				
			     echo "<ul class='inlineshow'>";
			    for($z=0;$z<count($week_1); $z++) {
					//echo $f_name;
				 $fieldname = 	str_replace("[]","",$f_name);
				 
				// echo $fieldname;
			?>
			    <li style="padding: 7px;"> <input name="<? echo $f_name?>" type="checkbox" <?php echo checkedCheckBox($week_1[$z],explode(',',$details[$fieldname])); ?> value="<?php echo $week_1[$z]; ?>"> <?php echo $week_1[$z]; ?> </li>
				   
				<? } echo " </ul>"; 
		    } ?>
			

			   
			<?php  if ($fields_type[$i]=="checkbox_week"){ 
			
			    $week = WEEK_DAYS_ARRAY; 
				
			     echo "<ul class='inlineshow'>";
			    for($k=0;$k<count($week); $k++) {
				 $fieldname = 	str_replace("[]","",$f_name);
			?>
			    <li style="padding: 7px;"> <input name="<? echo $f_name?>" type="checkbox" <?php echo checkedCheckBox($week[$k],explode(',',$details[$fieldname])); ?> value="<?php echo $week[$k]; ?>"> <?php echo $week[$k]; ?> </li>
				   
				<? } echo " </ul>"; 
				echo "<input type='hidden' name='avildate' value='".$details[$fieldname]."'>";
				echo "<input type='hidden' name='avil' value='checkavil'>";
		    } ?>
		    
		    <?php  if ($fields_type[$i]=="slot_time") {   ?>
			
			   	<span>
				    <select name="<? echo $f_name?>" >
						    <option>Select</option>
						    <?php  
						        for($t = 1; $t<=23; $t++) {
									if($t <= 11) {
										 $ap_midday1 = 'AM';
										 $ap_midday2 = 'AM';
									}else{
									   $ap_midday1 = 'PM';	
									   $ap_midday2 = 'PM';	
									}
								
                                    $time = ($t+1);
									
									if($time == '12') {
										$ap_midday1 = 'AM';
										$ap_midday2 = 'PM';
									}
									
									$val = $t .' '.$ap_midday1.'-'.($time).' '.$ap_midday2;
						    ?>
						    <option value="<?php echo $t .' '.$ap_midday1; ?>-<?php echo ($time).' '.$ap_midday2; ?>"      <?php  if($details[$f_name] == $val) { echo 'selected'; } ?>>
							      <?php echo $t.' '.$ap_midday1; ?>-<?php echo ($time).' '.$ap_midday2; ?>
							</option>
						  <?php } ?>
					</select>
				</span>
					    
		   <?php } ?>
			
			
			<?php  if ($fields_type[$i]=="checkbox_document"){ 
			
			    $ducument = DOCUMENT_CHECK; 
			     echo "<ul class='inlineshow'>";
			    for($k=0;$k<count($ducument); $k++) {
				 $fieldname = 	str_replace("[]","",$f_name);
			?>
			    <li style="padding: 7px;"> <input name="<? echo $f_name?>" type="checkbox" <?php echo checkedCheckBox($ducument[$k],explode(',',$details[$fieldname])); ?> value="<?php echo $ducument[$k]; ?>"> <?php echo $ducument[$k]; ?> </li>
				   
				<? } echo " </ul>"; 
				/* echo "<input type='hidden' name='avildate' value='".$details[$fieldname]."'>";
				echo "<input type='hidden' name='avil' value='checkavil'>"; */
		    } ?>
				
			<?php  if ($fields_type[$i]=="a_site"){ 
			
			    $sitessql = mysql_query("SELECT * FROM `sites`");
				  
			     echo "<ul class='inlineshow'>";
			     
				  while($getsites = mysql_fetch_array($sitessql)) {
				 $fieldname = 	str_replace("[]","",$f_name);
			 
			  //print_r(explode(',',$details[$fieldname]));
			
			?>
			    <li style="padding: 7px;"> <input name="<? echo $f_name?>" type="checkbox" <?php  echo checkedCheckBox($getsites['id'],explode(',',$details[$fieldname])); ?> value="<?php echo $getsites['id']; ?>"> <?php echo $getsites['name']; ?> </li>
				   
				<? } echo " </ul>"; 
				/* echo "<input type='hidden' name='avildate' value='".$details[$fieldname]."'>";
				echo "<input type='hidden' name='avil' value='checkavil'>"; */
		    } ?>		
			
			
			<?php  if ($fields_type[$i]=="admin_type"){ 
			
			    $sqltype = mysql_query("SELECT * FROM `system_dd`  WHERE type = 92");
				  
			     echo "<ul class='inlineshow'>";
			     
				  while($getper = mysql_fetch_array($sqltype)) {
				 $fieldname = 	str_replace("[]","",$f_name);
			 
			  //print_r(explode(',',$details[$fieldname]));
			
			?>
			    <li style="padding: 7px;"> <input name="<? echo $f_name?>" type="checkbox" <?php  echo checkedCheckBox($getper['id'],explode(',',$details[$fieldname])); ?> value="<?php echo $getper['id']; ?>"> <?php echo $getper['name']; ?> </li>
				   
				<? } echo " </ul>"; 
		    } ?>		
				
		
			<?php  if ($fields_type[$i]=="role_manager"){ 
			
			    $sqltype = mysql_query("SELECT * FROM `system_dd`  WHERE type = 102 AND status = 1 ORDER by name");
				  
			     echo "<ul class='inlineshow'>";
			     
				  while($getper = mysql_fetch_array($sqltype)) {
				 $fieldname = 	str_replace("[]","",$f_name);
			 
			  //print_r(explode(',',$details[$fieldname]));
			
			?>
			    <li style="padding: 7px;"> <input name="<? echo $f_name?>" type="checkbox" <?php  echo checkedCheckBox($getper['id'],explode(',',$details[$fieldname])); ?> value="<?php echo $getper['id']; ?>"> <?php echo $getper['name']; ?> </li>
				   
				<? } echo " </ul>"; 
		    } ?>	


					<?php   if($fields_type[$i]=="get_business_qus"){ 
					
					 if(!empty($details)){
					?>
					<script>
					$(document).ready(function(){
					  get_business_qus('<?php echo $details['track_type'].'|'.$details['business_type']; ?>');
					});
					</script>
					<?php  } ?>
					
					
					  <span id="get_business_qus" style="color:red;">Please Select Track Type</span>
					<?php  } ?>			
				
			<?php  if ($fields_type[$i]=="check_permission"){ 
			
			    $sqltype = mysql_query("SELECT * FROM `system_dd`  WHERE type = 74");
				  
			     echo "<ul class='inlineshow'>";
			     
				  while($getper = mysql_fetch_array($sqltype)) {
				 $fieldname = 	str_replace("[]","",$f_name);
			 
			  //print_r(explode(',',$details[$fieldname]));
			
			?>
			    <li style="padding: 7px;"> <input name="<? echo $f_name?>" type="checkbox" <?php  echo checkedCheckBox($getper['id'],explode(',',$details[$fieldname])); ?> value="<?php echo $getper['id']; ?>"> <?php echo $getper['name']; ?> </li>
				   
				<? } echo " </ul>"; 
				/* echo "<input type='hidden' name='avildate' value='".$details[$fieldname]."'>";
				echo "<input type='hidden' name='avil' value='checkavil'>"; */
		    } ?>	
				
			<?php /* if($f_name == 'depot_address') { ?>
               <input name="moving_from_lat_long" id="moving_from_lat_long" type="hidden" class="formfields" style="width: 350px;" value="<? //echo get_field_value($details,$f_name); ?>">
            <?php  } */ ?>			
				
				
		    <?php /* if ($fields_type[$i]=="checkbox_multi_job"){ 
						
						
						$GetJobTypeSql = mysql_query("SELECT name FROM `job_type`");
						if(mysql_num_rows($GetJobTypeSql)>0)
						{
							while($JobTypeData = mysql_fetch_array($GetJobTypeSql))
							{
								$jobType[] = $JobTypeData['name'];
							}
						}
			      echo "<ul class='inlineshow'>";
				  foreach($jobType as $key=>$jobvalue) {
					$fieldname = 	str_replace("[]","",$f_name);
			?>
			    <li style="padding: 7px;"> <input name="<? echo $f_name; ?>" type="checkbox" <?php echo  checkedCheckBox($jobType[$key],explode(',',$details[$fieldname])); ?> value="<? echo $jobType[$key];?>" 
				    ><?php echo $jobType[$key]; ?> </li>
			<?  }  echo " </ul>"; 
			} */ ?>
			
			 <?php if ($fields_type[$i]=="amt_share_type"){ ?>
			    <p class="text_shear">Please enter only one share amount (%/ fixed) per job type.</p>
			 
				<table>
				    <tr>
					  <th>Select Amount</th>
					  <th>Job Type</th>
					  <th>Percentage(%)</th>
					  <th>Fixed</th>
				    </tr>  
				    <tbody>
					   <?php 

					    $GetJobTypeSql = mysql_query("SELECT id,name,amt_share_type,value FROM `job_type`");
						if(mysql_num_rows($GetJobTypeSql)>0)
						{
							while($JobTypeData = mysql_fetch_array($GetJobTypeSql))
							{
								$jobTypeid[] = $JobTypeData['id'];
								$jobType[] = $JobTypeData['name'];
								$jobTypeamtsharetype[] = $JobTypeData['amt_share_type'];
								$jobTypevalue[] = $JobTypeData['value'];
							}
						}
						    $fieldname = 	str_replace("[]","",$f_name);
							 
							$getvalue = explode(',',$details[$fieldname]);
							
							//print_r($getvalue);
							
					        foreach($jobType as $key=>$jobvalue) { 
							
							$getdetails = mysql_fetch_assoc(mysql_query("SELECT * FROM `staff_share_amount`  where staff_id = '".rw("id")."' AND job_type_id='".$jobTypeid[$key]."'"));
							
							//echo $details[$fieldname][$key];
					   ?>
						<tr>
						   <td><input  name="<? echo $f_name; ?>" data-page="<? echo $key;?>" class="check" type="checkbox" id="job_type_<?php echo $key; ?>" onclick="checkValue('<? echo $jobTypeid[$key];?>')" value="<? echo $jobTypeid[$key];?>" <?php echo  checkedCheckBox($jobTypeid[$key],explode(',',$details[$fieldname])); ?>></td>
						   
						   <td><?php echo $jobType[$key]; ?></td>
						   
						   <td>
						   <!--<input type="radio" class="check_value_<?php echo $key ?>" id="check_value_<?php echo $key ?>" disabled name="check_value[<? echo $jobTypeid[$key];?>]" <?php  if(!empty($getdetails) && $getdetails['amount_share_type'] == 1) { echo "checked = checked"; }?> >-->

						   <input style="width: 60px;" onkeypress="return isNumber(event)" Onkeydown="checkShareAmount('<? echo $key;?>',1);" class="shear_value_<?php echo $key ?>"  id="shear_value_prsen_<?php echo $key ?>" type="text" name="shear_value_per[<? echo $jobTypeid[$key];?>]" value="<?php if(!empty($getdetails) && $getdetails['amount_share_type'] == 1) { echo $getdetails['value']; } elseif($jobTypeamtsharetype[$key] == 1 && rw("id") == '') { echo $jobTypevalue[$key]; } ?>" <?php  if(in_array($jobTypeid[$key], $getvalue )) { " ";}else { ?> disabled  <?php  } ?> >
						   
						  </td>
						   
						   <td>
						   <!--<input type="radio" class="check_value_<?php echo $key ?>"  id="check_value_<?php echo $key ?>" name="check_value[<? echo $jobTypeid[$key];?>]" disabled  <?php  if(!empty($getdetails) && $getdetails['amount_share_type'] == 2) { echo "checked"; }?>>-->  
						   
						   <input style="width: 60px;" onkeypress="return isNumber(event)" class="shear_value_<?php echo $key ?>" Onkeydown="checkShareAmount('<? echo $key;?>',2);"  type="text" id="shear_value_fixed_<?php echo $key ?>" name="shear_value_fixed[<? echo $jobTypeid[$key];?>]" value="<?php if(!empty($getdetails) && $getdetails['amount_share_type'] == 2) { echo $getdetails['value']; }elseif($jobTypeamtsharetype[$key] == 2 && rw("id") == '') { echo $jobTypevalue[$key]; } ?>" <?php  if(in_array($jobTypeid[$key], $getvalue )) { " ";}else { ?> disabled  <?php  } ?>  ></td>
						</tr>  
						
					   <?php  } ?>		
				    </tbody>
				</table>
			<?php  } ?>	
			
			<?php if ($fields_type[$i]=="staff_fixed_rates"){  ?>
			   <br>
			    <!--<p class="text_shear">Staff Fixed Rates</p>-->
				<div id="staff_fixed_rates_div"><p style="color:red;">(Please Select Site id)</p></div>
			<?php  } ?>	
			
			   
		    </div>
		</li>
		<? } 
		
	}?>
		<li> 
		<div> 
			<br>
			<input type="hidden" name="step" value="1">
			<input type="hidden" name="id" value="<? echo rw("id");?>">
			<input type="hidden" name="task" value="<? echo "$t"; ?>">
			<input type="hidden" name="action" value="<? echo "$a"; ?>">
		</div>
		</li>

	  </ul>
       <?php  //task=4&action=modify&id=158 
	     if($_GET['task'] == 4) {
		?>
          <span class="job_submit_main"><input type="submit" id="staff_add_data" name="submit" class="job_submit" value="submit"></span>
		 <?php }else { ?> 
		<span class="job_submit_main"><input type="submit" name="submit" class="job_submit" value="submit"></span>
		<?php  } ?>
		 
	
	</div>
</div>
</form>
<style>
			.inlineshow li{
			list-style-type: none;
			float: left;
			display: inline;
			}
			table, td, th {
			border: 1px solid black;
			}

			table {
			 border-collapse: collapse;
			 width: 100%;
			}

			th {
			 height: 30px;
			 text-align: center;
			}
			td {
			 height: 30px;
			 text-align: center;
			}
			.text_shear{
				color: red;
				margin-bottom: 7px;
				font-size: 17px;
			}
			.show_hide_buttone{
				padding: 4px;
				border: 1px solid;
				cursor: pointer;
				text-decoration: none !important;
				margin: 5px;
				background: gray;
				color: white;
			}
			
	
		</style> 
 <script>
    $(document).ready(function(){
		
		
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
				var id = $($(this)).attr('data-page');
               // $(".check_value_"+id).removeAttr("disabled");
                $(".shear_value_"+id).removeAttr("disabled");
               // $(".check_value_"+id).focus();
                $(".shear_value_"+id).focus();
				
            }
            else if($(this).prop("checked") == false){
				var  id = $($(this)).attr('data-page');
              // $(".check_value_"+id).attr("disabled", "disabled");
               $(".shear_value_"+id).attr("disabled", "disabled");
            }
        });
    });
	
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
    }
	
	/* $(document).ready(function(){ 
		
		$('.check').each(function(i,v){
			if($('#job_type_'+i).prop("checked") == true){
				var fix = $("#shear_value_fixed_"+i).val();
				var per = $("#shear_value_prsen_"+i).val();
				//alert(per);
				 if(fix == '' &&  per == '') {
					$('#job_type_'+i).removeAttr("checked");
					$("#shear_value_fixed_"+i).attr("disabled", "disabled");
					$("#shear_value_prsen_"+i).attr("disabled", "disabled");
					$("#staff_add_data").attr("disabled", "disabled");
					$("#staff_add_data").css("style", "cursor:not-allowed");
					//    cursor: not-allowed;
				} 
			   
			}
        });
	}); */
	
	function checkShareAmount(id,tt){
		
		if( tt == 1 )
		{
			$('#shear_value_fixed_'+id).val('');
		}
		else if ( tt == 2 )
		{
			$('#shear_value_prsen_'+id).val('');			
		}
		
	}
	 function showPassword(){
				   $('#show_hide_password').attr('type','text');
				   $('#show_password').hide();
				   $('#hide_password').show();
			    }
	function hidePassword(){
	   $('#show_hide_password').attr('type','password');
	   $('#show_password').show();
	   $('#hide_password').hide();
	}
	
	$(document).ready(function(){
		$('span .mce-txt').attr('style', 'background:#fff !important');
	});
	
	function get_business_qus(id){

		send_data(id , 602 , 'get_business_qus');
		// alert(id);
	}
	
 </script>
</body>
</html>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo&amp;libraries=places" type="text/javascript"></script>
  <script language="JavaScript" src="jscripts/depot_aaddress.js"></script>