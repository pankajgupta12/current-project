<?  
session_start(); 
include("../functions/functions.php");
include("../functions/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SETUP</title>
</head>
<body><br />
<? include("header.php"); ?>
<? if ($_POST['step']==1){ 

//$fields_name=array("country","currid","abv");
//echo $_POST['module_id'] . "- " .$_POST['table'];
$fields1 = array("module_id","table","folder","title","image_folder","listname","listheading");
$dtype1 = array("0","1","1","1","1","1","1");
$dadd1 = array("1","1","1","1","1","1","1");
$fields2 = "f_name,f_heading,f_type,f_type_value,valid,jvalid,dtype,dadd,javascript,maxnum";
$field_type2 = array("0","0","0","0","1","1","1","1","0","0");


//echo $_POST['no_rows'] ."<br>";
//$ins1 = "insert into module_field_details($fields1)";
//$ins1.=" values(".$_POST['module_id'].",'".$_POST['table']."";
$no_row = $_POST['no_rows'];

$insert=insert_form($fields1,$dtype1,"admin_module_details",$dadd1);
$last_id = mysql_insert_id();

	$j=0;
	$fields2_arr = split(",",$fields2);
	foreach($fields2_arr as $fname){
		//echo "fieldname : ".$fname."";
		for($i=0;$i<$no_row;$i++){
			//echo " : ".$_POST[$fname."_".$i] ."<br>";
			//echo "adding".$_POST['adding_'.$i]."<br>";
			if ($_POST['adding_'.$i]=="on"){
				$values[$fname] .= $_POST[$fname."_".$i]."|";
			}
		}
		$xx = $values[$fname];
		echo "fieldname : ".$fname."".$xx."<br>";
		$values[$fname] = substr($xx,0,$xx.length-1);
		//$j=j+1;
	}


	$ins1 = "update admin_module_details set ";
	foreach($fields2_arr as $fname){
		$ins1.= "`".$fname."`='".$values[$fname]."',";
	}
	$ins1 = substr($ins1,0,$ins1.length-1);
	$ins1.=" where id=".$last_id;
	$up = mysql_query($ins1);
	echo $ins1;

}else{ 
?>

<script language="javascript">
function add_listing(obj,name,hname){
var new_arr="";
	if (obj.checked==true){
		var arr = document.getElementById('listname').value;
		var harr = document.getElementById('listheading').value;
			
			if (arr==""){
				new_arr = name;
				new_harr = hname;
			}else{ 
				new_arr = arr + "|" + name;
				new_harr = new_harr + "|" + hname;
			}
	}else{
		var arr = document.getElementById('listname').value;
		
		if (arr.indexOf("|")>-1){ 
			var curr_arr = arr.split("|");
			
			for(i=0;i<curr_arr.length;i++){
				if (curr_arr[i]!=name){
					new_arr = curr_arr[i] + "|";
				}else{
					// this is suppose to be deleted 
				}
			}
			new_arr  = new_arr.substr(0,new_arr.length-1);
			
		}else{
			new_arr = "";
		}
		
		var harr = document.getElementById('listheading').value;
		if (harr.indexOf("|")>-1){ 
			var hcurr_arr = harr.split("|");
			
			for(i=0;i<hcurr_arr.length;i++){
				if (hcurr_arr[i]!=hname){
					new_narr = hcurr_arr[i] + "|";
				}else{
					// this is suppose to be deleted 
				}
			}
			new_narr  = new_narr.substr(0,hnew_arr.length-1);
			
		}else{
			hnew_arr = "";
		}
	}

	document.getElementById('listname').value = new_arr;
	document.getElementById('listheading').value = new_harr;
}

function type_value(obj,ftv){
//alert(obj.value);
//alert(ftv);
var ftvalue ="";
	if(obj.value=="dd"){
		ftvalue = "dropdown_name,table,id,name,cond,onchng,details";
	}else if (obj.value=="xjax_dd_div"){
		ftvalue = "dropdown_name,table,id,name,cond : field={fieldname} ie : country_id={country_id} ,onchng,details";
	}else if (obj.value=="file"){
	 	ftvalue = "img_width x img_height ";
	}else if (obj.value=="select"){
		ftvalue = "activate,deactivate";
	}
	document.getElementById(ftv).value = ftvalue;
}

function change_js(obj,obj2){
//alert(obj.checked);
document.getElementById(obj2).checked = obj.checked;
}
</script>


<form id="form1" name="form1" method="post" action="<? echo $_SERVER['../SCRIPT_NAME']; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="15%">Select Module</td>
    <td width="85%">
      <? echo create_dd("module_id", "admin_modules","id","name"," type=1 and id not in (select module_id from admin_module_details)","","");?>    </td>
  </tr>
  <tr>
    <td width="15%">Select Table</td>
    <td width="85%">
      <select name="table" id="table" onchange="document.form1.submit();">
      <option value="0">Select</option>
      <?php
		$sql = "SHOW TABLES FROM ".DB_name;
		$result = mysql_query($sql);
		
		while ($row = mysql_fetch_row($result)) {
			if ($_POST['table']==$row[0]){ $selected = "selected"; }else{ $selected=""; } 
			echo "<option value=\"$row[0]\" $selected >$row[0]</option>";
		}
		
		mysql_free_result($result);
		?>
      </select>    </td>
  </tr>
</table>

<? if ($_POST['table']!=""){ ?>
        
        <table width="100%" border="0" cellspacing="3" cellpadding="3">
        <tr>
            <td width="15%">Folder</td>
            <td width="85%"><select name="folder" id="folder">
              <option value="try" selected="selected">try</option>
              <option value="manage">manage</option>
            </select></td>
          </tr>
          <tr>
            <td width="15%">Title</td>
            <td width="85%"><input name="title" type="text" value="<? echo ucwords($_POST['table']);?>" /></td>
          </tr>
          <tr>
            <td>Image Folder</td>
            <td><input name="image_folder" type="text"  value="<? echo strtolower($_POST['table']);?>"/></td>
          </tr>
          <tr>
            <td>List Name</td>
            <td><input name="listname" type="text" id="listname" size="150" /></td>
          </tr>
          <tr>
            <td>List Heading</td>
            <td><input name="listheading" type="text" id="listheading" size="150" /></td>
          </tr>
        </table>
        
        <table width="100%" border="0" cellspacing="3" cellpadding="3">
          <tr>
            <td colspan="12">Adding Fields</td>
          </tr>
          <tr>
            <td width="5%" align="center">Add in</td>
            <td width="5%" align="center">Add list </td>
            <td width="10%" align="center">name</td>
            <td width="10%" align="center">heading</td>
            <td width="10%" align="center">type</td>
            <td width="20%" align="center">type_value<br />
              Image = wxh<br />
              DD = Create Dropdown</td>
            <td width="5%" align="center">validation</td>
            <td width="5%" align="center">javascript validation </td>
            <td width="5%" align="center">data type ( text - check ) </td>
            <td width="5%" align="center">add</td>
            <td width="10%" align="center">javascript on field</td>
            <td width="5%" align="center">max value</td>
          </tr>
          <?
        
        $arg1 = "select * from ".$_POST['table']."";

        $data1 = mysql_query($arg1);
        $i = 0;
        while ($i < mysql_num_fields($data1)) {
            
            $meta = mysql_fetch_field($data1, $i);
            if (!$meta) {
                echo "No information available<br />\n";
            }
            /*echo "<pre>
                blob:         $meta->blob
                max_length:   $meta->max_length
                multiple_key: $meta->multiple_key
                name:         $meta->name
                not_null:     $meta->not_null
                numeric:      $meta->numeric
                primary_key:  $meta->primary_key
                table:        $meta->table
                type:         $meta->type
                default:      $meta->def
                unique_key:   $meta->unique_key
                unsigned:     $meta->unsigned
                zerofill:     $meta->zerofill
                </pre>";*/
                $name = $meta->name;
                $heading = str_replace("_"," ",$name);
                $heading = ucwords($heading);
                $dtype=$meta->numeric; // 
                if ($dtype != 1){ $dtype=0; $dtype_sel=""; }else{  $dtype_sel="checked"; }
                if ($name!="id"){ $dadd_sel = "checked"; }else{ $dadd_sel = ""; }
                
                $len = mysql_field_len($data1, $i);
                $details['type'] = "text";
            
        ?>
          <tr>
            <td align="center"><input name="adding_<? echo $i ?>" type="checkbox" id="adding_<? echo $i ?>" checked="<? echo $dadd_sel?>"/></td>
            <td align="center"><input name="add_list" type="checkbox" id="add_list" onchange="javascript:add_listing(this,'<? echo $name; ?>','<? echo $heading;?>')"/></td>
            <td align="center"><input name="f_name_<? echo $i ?>" type="text" id="f_name_<? echo $i ?>" value="<? echo $name; ?>"/></td>
            <td align="center"><input name="f_heading_<? echo $i ?>" type="text" id="f_heading_<? echo $i ?>"  value="<? echo $heading; ?>"/></td>
            <td align="center"><? echo create_dd("f_type_".$i."", "module_field_type","name","name"," 1 ","onchange=\"javascript:type_value(this,'f_type_value_".$i."');\"",$details['type']);?></td>
            <td align="center"><input name="f_type_value_<? echo $i ?>" type="text" id="f_type_value_<? echo $i ?>" size="55"/></td>
            <td align="center"><input name="valid_<? echo $i ?>" type="checkbox" id="valid_<? echo $i ?>" checked="checked" onchange="javascript:change_js(this,'jvalid_<? echo $i ?>');"/></td>
            <td align="center"><input name="jvalid_<? echo $i ?>" type="checkbox" id="jvalid_<? echo $i ?>" checked="checked"/></td>
            <td align="center"><input name="dtype_<? echo $i ?>" type="checkbox" id="dtype_<? echo $i ?>" checked="<? echo $dtype_sel ?>"/></td>
            <td align="center"><input name="dadd_<? echo $i ?>" type="checkbox" id="dadd_<? echo $i ?>" checked="checked"/></td>
            <td align="center"><input name="javascript_<? echo $i ?>" type="text"  /></td>
            <td align="center"><input name="maxnum_<? echo $i ?>" type="text" value="<? echo $len; ?>" size="10" /></td>
          </tr>
          <?
          $i++;
        }
        mysql_free_result($data1);
          
          ?>
          <tr>
            <td colspan="12" align="center"><input type="submit" name="submit" id="submit" value="Save the Values" />
            <input type="hidden" name="step" value="1" />
            <input type="hidden" name="no_rows" value="<? echo $i;?>" />
            </td>
          </tr>
          <tr>
        </table>
        
</form>
<? } 
 } 
?>
</body>
</html>
